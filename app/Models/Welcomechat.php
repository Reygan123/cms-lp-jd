<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Welcomechat extends Model
{
    use HasFactory;

    protected $fillable = [
        'greating'
    ];
}
