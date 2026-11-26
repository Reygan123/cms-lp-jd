<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebinarRegistration extends Model
{
    protected $table = 'webinar_registrations';

    protected $fillable = [
        'order_id',
        'chapter_id',
        'episode_id',
        'episode_title',
        'pricing_type',
        'full_name',
        'whatsapp',
        'email',
        'category',
        'institution',
        'biggest_challenge',
        'speaker_question',
        'ig_username',
        'ig_proof_file',
        'donation_amount',
        'total_amount',
        'payment_channel',
        'payment_status',
        'duitku_reference',
        'duitku_payment_url',
        'va_number',
        'qr_string',
        'paid_at',
        'expiry_time',
    ];

    protected $casts = [
        'donation_amount' => 'float',
        'total_amount'    => 'float',
        'paid_at'         => 'datetime',
        'expiry_time'     => 'datetime',
    ];
}

