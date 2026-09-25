<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titlebenefit extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title','slug','description','image'
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
