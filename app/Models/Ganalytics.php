<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ganalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'ganalytics_code'
    ];
}
