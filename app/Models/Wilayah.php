<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tingkat',
        'parent_id',
        'kk',
        'l',
        'p',
    ];
}
