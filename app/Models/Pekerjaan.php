<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;
    protected $table = 'pekerjaans';
    protected $fillable = ['wilayah_id', 'jenis_pekerjaan', 'jumlah'];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
