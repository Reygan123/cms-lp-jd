<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name','title','slug','program_id','description','yt_link','home', 'image'
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
