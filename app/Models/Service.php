<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
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
        'image4'
    ];

    public function whyServices()
    {
        return $this->hasMany(WhyService::class);
    }

    public function alasanServices()
    {
        return $this->hasMany(WhyService::class);
    }
    public function howServices()
    {
        return $this->hasMany(WhyService::class);
    }
    public function masalahService()
    {
        return $this->hasMany(WhyService::class);
    }
    public function activity()
    {
        return $this->hasMany(WhyService::class);
    }
    public function manfaatService()
    {
        return $this->hasMany(WhyService::class);
    }
}
