<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dukungan extends Model
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
        'name',
        'jabatan',
        'id_yt',
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

}
