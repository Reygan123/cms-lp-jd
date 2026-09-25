<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    /**
     * fillable 
     *
     * @var array
     */
    protected $fillable = [
        'image', 'title', 'slug', 'description','facility_id','home'
    ];


       /**
     * facility
     *
     * @return void
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
