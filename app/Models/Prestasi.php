<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug','categoriprestasi_id','program_id', 'name','home','image'
    ];

    /**
     * categoriprestasi
     *
     * @return void
     */
    public function categoriprestasi()
    {
        return $this->belongsTo(Categoriprestasi::class);
    }
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
