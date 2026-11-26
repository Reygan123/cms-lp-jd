<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    use \App\Models\Concerns\HasContentTranslations;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'image','description','button','link','align','program_id','home','yt_id'
    ];

    /**
     * program
     *
     * @return void
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    
}
