<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelatihan_id',
        'referral_id',
        'registration_code',
        'referral_code',
        'referral_giver_name',
        'full_name',
        'name_for_certificate',
        'email',
        'whatsapp',
        'domicile',
        'institution_level',
        'institution_name',
        'role_in_institution',
        'skill_to_improve',
        'had_previous_training',
        'registration_type',
        'collective_count',
        'collective_coordinator',
        'payment_sender_name',
        'payment_date',
        'payment_proof',
        'needs_invoice',
        'invoice_name',
        'original_price',
        'discount_amount',
        'final_price',
        'status',
        'admin_note',
        'certificate_file',
        'certificate_sent_at',
    ];

    protected $casts = [
        'had_previous_training' => 'boolean',
        'needs_invoice' => 'boolean',
        'payment_date' => 'date',
        'certificate_sent_at' => 'datetime',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function referral()
    {
        return $this->belongsTo(PelatihanReferral::class, 'referral_id');
    }

    public function answers()
    {
        return $this->hasMany(PelatihanAnswer::class, 'participant_id');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
