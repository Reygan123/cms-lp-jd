<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarEpisode extends Model
{
    use HasFactory;
    use \App\Models\Concerns\HasContentTranslations;

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'requires_ig_proof' => 'boolean',
        'assessment_voucher_included' => 'boolean',
        'features' => 'array',
        'episode_number' => 'integer',
        'sort_order' => 'integer',
        'scheduled_at' => 'datetime',
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function registrations()
    {
        return $this->hasMany(WebinarRegistration::class, 'episode_id', 'code');
    }
}

