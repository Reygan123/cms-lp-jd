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
