<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'agendacat',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'content',
        'location',
        'yt_link',
        'image',
        'user_id',
        'organizer',
        'register_link',
        'contact'
    ];


    /**
     * start_date
     *
     * @return Attribute
     */
    // Accessor untuk start_date
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-M-Y');
    }

    /**
     * end_date
     *
     * @return Attribute
     */
    // Accessor untuk end_date
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-M-Y');
    }

    /**
     * start_time
     *
     * @return Attribute
     */
    // Accessor untuk start_time
    public function getStartTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i:s');
    }

    /**
     * end_time
     *
     * @return Attribute
     */
    // Accessor untuk end_time
    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i:s');
    }
}