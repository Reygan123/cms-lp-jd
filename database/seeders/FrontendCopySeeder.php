<?php

namespace Database\Seeders;

use App\Http\Controllers\API\FrontendTranslationController;
use App\Models\FrontendCopy;
use App\Support\ContentTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontendCopySeeder extends Seeder
{
    public function run(): void
    {
        $rows = json_decode(file_get_contents(__DIR__.'/data/frontend_copies.json'), true, 512, JSON_THROW_ON_ERROR);
        DB::transaction(function () use ($rows): void {
            foreach ($rows as $row) {
                $record = FrontendCopy::firstOrNew(['key' => $row['key']]);
                $record->source = $row['source'];
                $record->context = $row['context'];
                $existing = ContentTranslation::stored($record)['en']['source'] ?? null;
                if ((!$record->exists || !ContentTranslation::hasText($existing)) && isset($row['en'])) {
                    $record->translations = json_encode(['en' => [
                        'source' => $row['en'],
                        '_source_hash' => ContentTranslation::hash(['source' => $row['source']]),
                    ]], JSON_UNESCAPED_UNICODE);
                }
                $record->save();
            }
        });
        FrontendTranslationController::clearCache();
    }
}
