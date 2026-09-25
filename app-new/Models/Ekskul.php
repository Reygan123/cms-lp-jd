<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'image','logo', 'description'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/ekskuls/' . $value),
        );
    }
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/ekskuls/' . $value),
        );
    }
}
