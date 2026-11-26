<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\FrontendTranslationController;
use App\Http\Controllers\Controller;
use App\Support\ContentTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContentTranslationController extends Controller
{
    public function index(Request $request)
    {
        $resources = config('content_translations');
        $table = $request->query('resource', 'posts');
        abort_unless(is_string($table) && isset($resources[$table]), 404);
        [$class, $fields] = $resources[$table];
        $ready = Schema::hasColumn($table, 'translations');
        $query = (new $class)->newQuery();
        if ($request->filled('q')) {
            $search = $request->validate(['q' => 'string|max:200'])['q'];
            $query->where(function ($query) use ($fields, $table, $search) {
                foreach ($fields as $field) {
                    if (Schema::hasColumn($table, $field)) $query->orWhere($field, 'like', '%'.$search.'%');
                }
            });
        }
        $records = Schema::hasTable($table) ? $query->latest('id')->paginate(20)->withQueryString()
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        return view('admin.translations.index', compact('resources', 'table', 'fields', 'records', 'ready'));
    }

    public function edit(string $resource, string $id)
    {
        [$class, $fields] = $this->resource($resource);
        $record = $class::findOrFail($id);
        $source = ContentTranslation::source($record, $fields);
        $english = ContentTranslation::stored($record)['en'] ?? [];
        $status = ContentTranslation::metadata($record, $fields);
        $ready = Schema::hasColumn($resource, 'translations');
        return view('admin.translations.edit', compact('resource', 'record', 'fields', 'source', 'english', 'status', 'ready'));
    }

    public function update(Request $request, string $resource, string $id)
    {
        [$class, $fields] = $this->resource($resource);
        abort_unless(Schema::hasColumn($resource, 'translations'), 409, 'Migrasi bilingual belum diterapkan.');
        $rules = ['source_hash' => 'required|string|size:64'];
        foreach ($fields as $field) {
            $list = in_array($field, ['features', 'options'], true);
            $rules['english.'.$field] = $list ? 'nullable|array' : 'nullable|string|max:2000000';
            if ($list) $rules['english.'.$field.'.*'] = 'nullable|string|max:10000';
        }
        $data = $request->validate($rules);
        DB::transaction(function () use ($class, $id, $fields, $data) {
            $record = $class::lockForUpdate()->findOrFail($id);
            $hash = ContentTranslation::hash(ContentTranslation::source($record, $fields));
            abort_unless(hash_equals($hash, $data['source_hash']), 409, 'Konten Indonesia berubah. Muat ulang editor sebelum menyimpan.');
            $translations = ContentTranslation::stored($record);
            $translations['en'] = array_intersect_key($data['english'] ?? [], array_flip($fields));
            foreach ($translations['en'] as &$value) {
                if (is_array($value)) $value = array_map(fn ($item) => ContentTranslation::hasText($item) ? $item : null, $value);
                elseif (!ContentTranslation::hasText($value)) $value = null;
            }
            unset($value);
            $translations['en']['_source_hash'] = $hash;
            $translations['en']['_updated_at'] = now()->toIso8601String();
            $record->setAttribute('translations', json_encode($translations, JSON_UNESCAPED_UNICODE));
            $record->save();
        });
        FrontendTranslationController::clearCache();
        return redirect()->route('admin.translations.edit', [$resource, $id])->with('success', 'Terjemahan Inggris berhasil disimpan.');
    }

    private function resource(string $resource): array
    {
        $definition = config('content_translations')[$resource] ?? null;
        abort_unless($definition, 404);
        return $definition;
    }
}
