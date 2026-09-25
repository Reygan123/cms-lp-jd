<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelatihan_id',
        'question',
        'type',
        'options',
        'is_required',
        'sort_order',
        'conditional_on_question',
        'conditional_on_value',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
    ];

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function answers()
    {
        return $this->hasMany(PelatihanAnswer::class, 'question_id');
    }
}
