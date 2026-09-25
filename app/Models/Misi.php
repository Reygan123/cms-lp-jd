<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    protected $table = 'misis';
    protected $fillable = [
        'title','subtitle','misi','image'
    ];

    protected function image(): Misi
    {
        return Misi::make(
            get: fn ($value) => asset('/storage/identities/' . $value),
        );
    }

    public function getRouteKeyName()

    {
        return 'slug';
    }
}
