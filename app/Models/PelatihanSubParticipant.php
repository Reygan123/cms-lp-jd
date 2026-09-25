<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanSubParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'full_name',
        'name_for_certificate',
        'gender',
        'birth_place',
        'birth_date',
        'age',
        'email',
        'whatsapp',
        'domicile',
        'institution_name',
        'institution_level',
        'institution_city',
        'role_in_institution',
        'skill_to_improve',
        'had_previous_training',
        'certificate_file',
        'certificate_sent_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'age' => 'integer',
        'had_previous_training' => 'boolean',
        'certificate_sent_at' => 'datetime',
    ];

    public function setInstitutionLevelAttribute($value)
    {
        $this->attributes['institution_level'] = is_array($value) ? implode(', ', $value) : $value;
    }

    public function participant()
    {
        return $this->belongsTo(PelatihanParticipant::class, 'participant_id');
    }
}
