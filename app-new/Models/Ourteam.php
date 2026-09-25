<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ourteam extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'ot_id','title','name', 'fb','ig','tt','phone','email','image'
    ];

   /**
     * program
     *
     * @return void
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }


}
