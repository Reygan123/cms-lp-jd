<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Identity extends Model
{
    use HasFactory;

     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'logo','favicon','day_service','time_service','year','name', 'description','address','gmap','phone','email','fb','ig','tt','yt'
    ];
 


} 
