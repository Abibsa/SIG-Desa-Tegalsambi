<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'jenis',
        'alamat',
        'kontak',
        'fasilitas',
        'pengelola',
        'web',
        'deskripsi',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
