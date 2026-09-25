<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visi extends Model
{
    protected $table = 'visis';
    protected $fillable = [
       'title','subtitle','visi','image'
    ];

    protected function image(): Visi
    {
        return Visi::make(
            get: fn ($value) => asset('/storage/identities/' . $value),
        );
    }
}
