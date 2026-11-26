<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusService extends Model
{
    use HasFactory;
    use \App\Models\Concerns\HasContentTranslations;

    protected $fillable = [
        'image',
        'title',
        'description',
        'service_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
