<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
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
        'subtitle',
        'description',
        'image'
    ];

    /**
     * programs
     *
     * @return void
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    /**
     * benefit
     *
     * @return void
     */
    public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }
}
