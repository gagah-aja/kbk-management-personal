<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;

    // Nama tabel (opsional, Laravel otomatis mendeteksi plural "rts")
    protected $table = 'rt';

    // Kolom yang bisa diisi secara mass assignment
    protected $fillable = [
        'nomor_rt',
        'id_warga',
        'id_rw',
    ];

    /**
     * Relasi ke RW
     */
    public function rw()
    {
        return $this->belongsTo(Rw::class, 'id_rw');
    }

    /**
     * Relasi ke Warga (ketua RT)
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    /**
     * Relasi ke Cluster
     * Satu RT bisa punya banyak cluster
     */
    public function cluster()
    {
        return $this->hasMany(Cluster::class, 'id_rt');
    }
}
