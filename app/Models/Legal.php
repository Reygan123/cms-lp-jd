<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legal extends Model
{
    use HasFactory;
    use \App\Models\Concerns\HasContentTranslations;

     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title','description','image'
    ];
} 
