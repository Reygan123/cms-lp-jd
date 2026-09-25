<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelatihan_id',
        'name',
        'person_count',
        'bundle_price',
        'description',
        'is_active',
    ];

    protected $casts = [
        'bundle_price' => 'decimal:2',
        'is_active'    => 'boolean',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function getPricePerPersonAttribute(): float
    {
        if ($this->person_count <= 0) return 0;
        return round((float) $this->bundle_price / $this->person_count, 0);
    }
}
