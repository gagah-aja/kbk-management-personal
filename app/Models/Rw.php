<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    use HasFactory;

    protected $table = 'rw';
    protected $fillable = ['nomor_rw', 'id_warga'];

    // Relasi ke tabel warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}
