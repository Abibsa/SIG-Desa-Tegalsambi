<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;
    protected $table = 'agamas';
    protected $fillable = ['wilayah_id', 'agama', 'jumlah'];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
