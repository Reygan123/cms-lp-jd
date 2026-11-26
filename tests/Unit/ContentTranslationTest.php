<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Support\ContentTranslation;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ContentTranslationTest extends TestCase
{
    protected function setUp(): void
    {
        $app = new class(realpath(__DIR__.'/../..')) extends Application {
            public function runningInConsole() { return false; }
        };
        $app->instance('config', new Repository(['content_translations' => require __DIR__.'/../../config/content_translations.php']));
        $app->useLangPath(__DIR__.'/../../lang');
        $app['config']->set('app.locale', 'en');
        $app->instance('request', Request::create('/api/post?locale=en'));
    }

    public function test_manual_translation_preserves_source_and_falls_back_per_field(): void
    {
        $post = new Post;
        $post->setRawAttributes([
            'id' => 1, 'title' => 'Judul Indonesia', 'description' => 'Deskripsi Indonesia',
            'content' => '<p>Isi</p>', 'slug' => 'judul-indonesia',
            'translations' => json_encode(['en' => ['title' => 'English title', 'description' => '']]),
        ]);
        $this->assertSame('English title', $post->title);
        $this->assertSame('Deskripsi Indonesia', $post->description);
        $this->assertSame('Judul Indonesia', $post->getAttributes()['title']);
        $serialized = $post->toArray();
        $this->assertArrayNotHasKey('translations', $serialized);
        $this->assertSame('judul-indonesia', $serialized['slug']);
        $this->assertSame(['description', 'content'], $serialized['_translation']['fallback_fields']);
        app()->instance('request', Request::create('/api/post?locale=id'));
        $this->assertSame('Judul Indonesia', $post->title);
        app()->instance('request', Request::create('/admin/post/1/edit?locale=en'));
        $this->assertSame('Judul Indonesia', $post->title);
    }

    public function test_source_changes_mark_existing_english_as_needing_review(): void
    {
        $post = new Post;
        $post->setRawAttributes(['title' => 'Judul', 'translations' => json_encode(['en' => [
            'title' => 'Title', '_source_hash' => ContentTranslation::hash(['title' => 'Judul']),
        ]])]);
        $this->assertFalse(ContentTranslation::metadata($post, ['title'])['needs_review']);
        $post->title = 'Judul berubah';
        $this->assertTrue(ContentTranslation::metadata($post, ['title'])['needs_review']);
        $this->assertSame('Title', $post->title);
    }

    public function test_translated_lists_keep_source_positions_and_partial_fallback(): void
    {
        $result = ContentTranslation::resolve(['features' => ['Satu', 'Dua']], ['features' => ['One', '']]);
        $this->assertSame(['One', 'Dua'], $result['values']['features']);
        $this->assertSame(['features.1'], $result['fallback_fields']);
    }

    public function test_content_without_a_migrated_column_still_serializes(): void
    {
        $post = new Post;
        $post->setRawAttributes(['title' => 'Judul']);
        $this->assertSame('Judul', $post->title);
        $this->assertSame(['title'], $post->toArray()['_translation']['fallback_fields']);
    }

    public function test_empty_rich_text_is_not_a_translation(): void
    {
        $result = ContentTranslation::resolve(['content' => '<p>Isi</p>'], ['content' => '<p>&nbsp;<br></p>']);
        $this->assertSame('<p>Isi</p>', $result['values']['content']);
        $this->assertSame(['content'], $result['fallback_fields']);
    }

    public function test_english_option_labels_do_not_change_submitted_values(): void
    {
        $question = new \App\Models\PelatihanQuestion;
        $question->setRawAttributes(['options' => '["Ya","Tidak"]', 'translations' => '{"en":{"options":["Yes","No"]}}']);
        $this->assertSame(['Ya', 'Tidak'], $question->options);
        $this->assertSame(['Yes', 'No'], $question->option_labels);
        $this->assertSame(['Ya', 'Tidak'], $question->toArray()['options']);
    }

    public function test_admin_templates_compile_to_valid_php(): void
    {
        $compiler = new \Illuminate\View\Compilers\BladeCompiler(new \Illuminate\Filesystem\Filesystem, sys_get_temp_dir());
        foreach (glob(__DIR__.'/../../resources/views/admin/translations/*.blade.php') as $path) {
            $compiled = $compiler->compileString(file_get_contents($path));
            $this->assertNotEmpty(token_get_all($compiled, TOKEN_PARSE));
        }
    }

    public function test_translation_registry_matches_model_table_names(): void
    {
        foreach (config('content_translations') as $table => [$class, $fields]) {
            $this->assertSame($table, (new $class)->getTable());
            $this->assertNotEmpty($fields);
        }
    }

    public function test_migrations_preserve_source_data_in_an_isolated_memory_database(): void
    {
        app('config')->set('database', [
            'default' => 'sqlite',
            'connections' => ['sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']],
        ]);
        app()->register(\Illuminate\Database\DatabaseServiceProvider::class);
        \Illuminate\Support\Facades\Facade::clearResolvedInstances();
        \Illuminate\Support\Facades\Facade::setFacadeApplication(app());
        $schema = app('db')->connection()->getSchemaBuilder();
        foreach (array_keys(config('content_translations')) as $table) {
            if ($table === 'frontend_copies') continue;
            $schema->create($table, function ($blueprint) { $blueprint->id(); $blueprint->string('title')->nullable(); });
        }
        app('db')->table('posts')->insert(['title' => 'Sumber Indonesia']);
        $content = require __DIR__.'/../../database/migrations/2026_11_23_000001_add_manual_content_translations.php';
        $frontend = require __DIR__.'/../../database/migrations/2026_11_23_000002_create_frontend_copies_table.php';
        $content->up();
        $frontend->up();
        $this->assertTrue($schema->hasColumn('posts', 'translations'));
        $this->assertTrue($schema->hasTable('frontend_copies'));
        $this->assertSame('Sumber Indonesia', app('db')->table('posts')->value('title'));
        $frontend->down();
        $content->down();
        $this->assertFalse($schema->hasColumn('posts', 'translations'));
        $this->assertSame('Sumber Indonesia', app('db')->table('posts')->value('title'));
        app('db')->disconnect();
    }

    public function test_manual_editor_saves_only_allowed_english_fields_and_rejects_stale_source(): void
    {
        app('config')->set('database', [
            'default' => 'sqlite',
            'connections' => ['sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']],
        ]);
        app('config')->set('session.driver', 'array');
        foreach ([
            \Illuminate\Database\DatabaseServiceProvider::class,
            \Illuminate\Filesystem\FilesystemServiceProvider::class,
            \Illuminate\Translation\TranslationServiceProvider::class,
            \Illuminate\Validation\ValidationServiceProvider::class,
            \Illuminate\Session\SessionServiceProvider::class,
            \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        ] as $provider) app()->register($provider);
        \Illuminate\Support\Facades\Facade::clearResolvedInstances();
        \Illuminate\Support\Facades\Facade::setFacadeApplication(app());
        \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
        app('db')->connection()->getSchemaBuilder()->create('posts', function ($table) {
            $table->id(); $table->string('title'); $table->text('description')->nullable();
            $table->text('content')->nullable(); $table->json('translations')->nullable(); $table->timestamps();
        });
        app('db')->table('posts')->insert(['title' => 'Judul Indonesia']);
        app('router')->put('/admin/translations/{resource}/{id}', fn () => null)->name('admin.translations.edit');
        app('router')->getRoutes()->refreshNameLookups();
        $record = Post::first();
        $hash = ContentTranslation::hash(ContentTranslation::source($record, ['title', 'description', 'content']));
        $request = Request::create('/admin/translations/posts/1', 'PUT', [
            'source_hash' => $hash, 'english' => ['title' => 'English title', 'description' => '<p>&nbsp;</p>', 'slug' => 'not-allowed'],
        ]);
        app()->instance('request', $request);
        $controller = new \App\Http\Controllers\Admin\ContentTranslationController;
        $this->assertSame(302, $controller->update($request, 'posts', '1')->getStatusCode());
        $saved = Post::first();
        $this->assertSame('Judul Indonesia', $saved->title);
        $english = ContentTranslation::stored($saved)['en'];
        $this->assertSame('English title', $english['title']);
        $this->assertNull($english['description']);
        $this->assertArrayNotHasKey('slug', $english);
        app('db')->table('posts')->where('id', 1)->update(['title' => 'Sumber baru']);
        try {
            $controller->update($request, 'posts', '1');
            $this->fail('Stale source must be rejected.');
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            $this->assertSame(409, $exception->getStatusCode());
            $this->assertSame('English title', ContentTranslation::stored(Post::first())['en']['title']);
        } finally {
            app('db')->disconnect();
        }
    }
}
