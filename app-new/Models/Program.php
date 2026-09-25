<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'category',
        'ourteam_id',
        'title1',
        'description1',
        'image1',
        'title2',
        'description2',
        'image2',
        'title3',
        'description3',
        'image3',
        'title4',
        'description4',
        'image4',
        'age',
        'weekly',
        'periode',
        'class_size',
        'content',
        'time_table',
        'time_table2',
        'cta',
        'link_program',
        'id_yt',
        'brosur'
    ];

    /**
     * ourteam
     *
     * @return void
     */
    public function ourteam()
    {
        return $this->belongsTo(Ourteam::class);
    }

    /**
     * testimony
     *
     * @return void
     */
    public function testimonies()
    {
        return $this->hasMany(Testimony::class);
    }

    

    /**
     * unggulan
     *
     * @return void
     */
    public function unggulans()
    {
        return $this->hasMany(Unggulan::class);
    }

    /**
     * slider
     *
     * @return void
     */
    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }

    /**
     * facilities
     *
     * @return void
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    /**
     * dukungan
     *
     * @return void
     */
    public function dukungans()
    {
        return $this->belongsToMany(Dukungan::class);
    }

     /**
     * pricing
     *
     * @return void
     */
    public function pricings()
    {
        return $this->belongsToMany(Pricing::class);
    }
}
