<?php

namespace App\Models\Concerns;

use App\Support\ContentTranslation;

trait HasContentTranslations
{
    protected function englishContent(): ?array
    {
        if (app()->runningInConsole() || !request()->is('api/*') || request()->query('locale', 'id') !== 'en') return null;
        $fields = config('content_translations.'.$this->getTable().'.1', []);
        return ContentTranslation::resolve(ContentTranslation::source($this, $fields), ContentTranslation::stored($this)['en'] ?? [])['values'];
    }

    public function getAttribute($key)
    {
        if ($key === '_translation') {
            $metadata = ContentTranslation::metadata($this, config('content_translations.'.$this->getTable().'.1', []));
            return request()->query('locale', 'id') === 'en' ? $metadata
                : ['locale' => 'id', 'fallback_fields' => [], 'needs_review' => false, 'english_complete' => $metadata['english_complete']];
        }
        $translated = $this->englishContent();
        if ($key === 'option_labels') return $translated['options'] ?? parent::getAttribute('options');
        if ($key === 'options') return parent::getAttribute($key);
        return $translated !== null && array_key_exists($key, $translated) ? $translated[$key] : parent::getAttribute($key);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        if (request()->is('api/*')) {
            unset($attributes['translations']);
            $attributes['_translation'] = $this->getAttribute('_translation');
            if ($translated = $this->englishContent()) {
                if (array_key_exists('options', $translated)) {
                    $attributes['option_labels'] = $translated['options'];
                    unset($translated['options']);
                }
                $attributes = array_replace($attributes, $translated);
                $attributes['_translation'] = ContentTranslation::metadata($this, config('content_translations.'.$this->getTable().'.1', []));
            }
        }
        return $attributes;
    }
}
