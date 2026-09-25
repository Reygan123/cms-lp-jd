<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelatihan_id',
        'code',
        'partner_name',
        'discount_type',
        'discount_value',
        'max_usage',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function participants()
    {
        return $this->hasMany(PelatihanParticipant::class, 'referral_id');
    }

    public function calculateDiscount(float $originalPrice): float
    {
        if ($this->discount_type === 'percent') {
            return round($originalPrice * ($this->discount_value / 100));
        }
        return min((float) $this->discount_value, $originalPrice);
    }

    public function isAvailable(): bool
    {
        if (!$this->is_active) {
            return false;
        }
        if ($this->max_usage !== null && $this->used_count >= $this->max_usage) {
            return false;
        }
        return true;
    }
}
