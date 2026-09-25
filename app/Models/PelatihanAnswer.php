<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'question_id',
        'answer',
    ];

    public function participant()
    {
        return $this->belongsTo(PelatihanParticipant::class, 'participant_id');
    }

    public function question()
    {
        return $this->belongsTo(PelatihanQuestion::class, 'question_id');
    }
}
