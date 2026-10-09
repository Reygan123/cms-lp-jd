<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Partner extends Model
{
    use HasFactory;

    /**
     * Daftar Kategori Partner
     */
    public const CATEGORIES = [
        'sekolah'    => 'Sekolah',
        'corporate'  => 'Corporate / Perusahaan',
        'kampus'     => 'Perguruan Tinggi / Universitas',
        'komunitas'  => 'Komunitas / Organisasi',
        'pemerintah' => 'Instansi Pemerintah',
        'lainnya'    => 'Lainnya',
    ];

    /**
     * Daftar Jenjang / Level Sekolah
     */
    public const SCHOOL_LEVELS = [
        'SMK' => 'SMK (Sekolah Menengah Kejuruan)',
        'SMA' => 'SMA (Sekolah Menengah Atas)',
        'MA'  => 'MA (Madrasah Aliyah)',
        'SMP' => 'SMP (Sekolah Menengah Pertama)',
        'MTs' => 'MTs (Madrasah Tsanawiyah)',
        'SD'  => 'SD / MI',
    ];

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'category',
        'level',
        'description',
        'program_desc',
        'web',
        'image'
    ];

    /**
     * Scope filter category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope filter level
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('/storage/partners/' . $value) : null,
        );
    }
}
