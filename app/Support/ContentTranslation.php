<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;

class ContentTranslation
{
    public static function hasText($value): bool
    {
        return is_string($value) && preg_replace('/[\s\p{Z}]+/u', '', html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8')) !== '';
    }

    public static function whereLike($query, string $field, string $keyword, string $boolean = 'and')
    {
        $table = $query->getModel()->getTable();
        if (request()->query('locale') !== 'en' || !in_array($field, config('content_translations.'.$table.'.1', []), true)
            || !\Illuminate\Support\Facades\Schema::hasColumn($table, 'translations')) {
            return $query->where($field, 'like', '%'.$keyword.'%', $boolean);
        }
        return $query->whereRaw("COALESCE(NULLIF(NULLIF(JSON_UNQUOTE(JSON_EXTRACT(`{$table}`.`translations`, '$.en.{$field}')), 'null'), ''), `{$table}`.`{$field}`) LIKE ?", ['%'.$keyword.'%'], $boolean);
    }

    public static function source(Model $model, array $fields): array
    {
        $attributes = $model->getAttributes();
        $source = [];
        foreach ($fields as $field) {
            if (array_key_exists($field, $attributes)) {
                $value = $attributes[$field];
                $source[$field] = in_array($field, ['features', 'options'], true) && is_string($value) ? json_decode($value, true) : $value;
            }
        }
        return $source;
    }

    public static function hash(array $source): string
    {
        return hash('sha256', json_encode($source, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function stored(Model $model): array
    {
        $value = $model->getAttributes()['translations'] ?? null;
        return is_array($value) ? $value : (json_decode($value ?? '{}', true) ?: []);
    }

    public static function resolve(array $source, array $english): array
    {
        $values = $source;
        $fallback = [];
        foreach ($source as $field => $value) {
            $translated = $english[$field] ?? null;
            if (is_array($value)) {
                // Keep list positions stable; options and IDs must never be translated into new values.
                $values[$field] = [];
                foreach ($value as $index => $item) {
                    $candidate = is_array($translated) ? ($translated[$index] ?? null) : null;
                    $values[$field][$index] = self::hasText($candidate) ? $candidate : $item;
                    if (!self::hasText($candidate) && self::hasText($item)) $fallback[] = $field.'.'.$index;
                }
            } elseif (self::hasText($translated)) {
                $values[$field] = $translated;
            } elseif (self::hasText($value)) {
                $fallback[] = $field;
            }
        }
        return ['values' => $values, 'fallback_fields' => $fallback];
    }

    public static function metadata(Model $model, array $fields): array
    {
        $source = self::source($model, $fields);
        $english = self::stored($model)['en'] ?? [];
        $resolved = self::resolve($source, $english);
        return [
            'locale' => 'en',
            'fallback_fields' => $resolved['fallback_fields'],
            'needs_review' => ($english['_source_hash'] ?? null) !== self::hash($source),
            'english_complete' => !$resolved['fallback_fields'] && ($english['_source_hash'] ?? null) === self::hash($source),
        ];
    }
}
