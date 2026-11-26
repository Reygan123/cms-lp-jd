<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FrontendCopy;
use App\Support\ContentTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class FrontendTranslationController extends Controller
{
    public static function cacheKey(bool $english): string
    {
        return 'content_translations.frontend.'.($english ? 'en' : 'id');
    }

    public static function clearCache(): void
    {
        if (!app()->bound('cache')) return;
        Cache::forget(self::cacheKey(false));
        Cache::forget(self::cacheKey(true));
    }

    public function __invoke(Request $request)
    {
        if (!Schema::hasTable('frontend_copies')) return response()->json(['messages' => (object)[], 'fallback' => true]);
        $english = $request->query('locale', 'id') === 'en';
        $build = function () use ($english) {
            $messages = [];
            $fallback = false;
            $records = FrontendCopy::all();
            if ($english && $records->isEmpty()) $fallback = true;
            $englishComplete = $records->isNotEmpty();
            foreach ($records as $record) {
                $translated = ContentTranslation::stored($record)['en']['source'] ?? null;
                if (!ContentTranslation::metadata($record, ['source'])['english_complete']) $englishComplete = false;
                if (!$english) $messages[$record->key] = $record->getAttributes()['source'];
                elseif (is_string($translated) && trim($translated) !== '') $messages[$record->key] = $translated;
                else $fallback = true;
            }
            return ['messages' => (object)$messages, 'fallback' => $fallback, 'english_complete' => $englishComplete];
        };
        $checkContent = $english && $request->boolean('check_content');
        $result = (!$checkContent && app()->bound('cache'))
            ? Cache::remember(self::cacheKey($english), 300, $build)
            : $build();
        if ($checkContent) {
            $complete = !$result['fallback'];
            foreach (config('content_translations') as $table => [$class, $fields]) {
                if ($table === 'frontend_copies') continue;
                if (!Schema::hasColumn($table, 'translations')) { $complete = false; break; }
                foreach ($class::cursor() as $record) {
                    $status = ContentTranslation::metadata($record, $fields);
                    if ($status['fallback_fields'] || $status['needs_review']) { $complete = false; break 2; }
                }
            }
            $result['content_complete'] = $complete;
        }
        return response()->json($result);
    }
}
