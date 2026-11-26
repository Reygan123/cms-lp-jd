<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;
    use \App\Models\Concerns\HasContentTranslations;

    protected $guarded = [];

    protected $casts = [
        'all_access_price' => 'float',
        'all_access_original_price' => 'float',
        'chapter_number' => 'integer',
    ];

    public function episodes()
    {
        return $this->hasMany(WebinarEpisode::class)->orderBy('sort_order', 'asc');
    }

    public function registrations()
    {
        return $this->hasMany(WebinarRegistration::class, 'chapter_id', 'code');
    }
}

