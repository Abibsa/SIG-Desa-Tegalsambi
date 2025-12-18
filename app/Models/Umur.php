<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umur extends Model
{
    use HasFactory;
    protected $table = 'umurs';
    protected $fillable = ['wilayah_id', 'rentang_umur', 'jumlah'];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
