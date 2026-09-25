<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unggulan extends Model
{
    use HasFactory;

     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'image','description','link','program_id','home'
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
