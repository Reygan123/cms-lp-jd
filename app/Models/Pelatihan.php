<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'batch',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'price',
        'bank_name',
        'bank_account',
        'bank_holder',
        'quota',
        'image',
        'whatsapp_contact',
        'email_contact',
        'status',
    ];

    public function bundles()
    {
        return $this->hasMany(PelatihanBundle::class)->where('is_active', true)->orderBy('person_count');
    }

    public function getUsedQuotaAttribute(): int
    {
        return (int) $this->participants()
            ->whereIn('status', ['approved', 'pending'])
            ->with(['bundle', 'subParticipants'])
            ->get()
            ->sum(function ($p) {
                if ($p->collective_count && (int) $p->collective_count > 0) {
                    return (int) $p->collective_count;
                }
                if ($p->bundle) {
                    return (int) $p->bundle->person_count;
                }
                $subCount = $p->subParticipants ? $p->subParticipants->count() : 0;
                return $subCount > 0 ? 1 + $subCount : 1;
            });
    }

    public function getQuotaRemainingAttribute(): ?int
    {
        if ($this->quota === null) return null;
        return max(0, $this->quota - $this->used_quota);
    }

    public function questions()
    {
        return $this->hasMany(PelatihanQuestion::class)->orderBy('sort_order');
    }

    public function referrals()
    {
        return $this->hasMany(PelatihanReferral::class);
    }

    public function participants()
    {
        return $this->hasMany(PelatihanParticipant::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'active' => 'Aktif',
            'closed' => 'Ditutup',
            default => $this->status,
        };
    }
}
