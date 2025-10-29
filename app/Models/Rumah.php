<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau nama tabel mengikuti konvensi Laravel, yaitu "rumahs")
    protected $table = 'rumah';

    // Kolom yang bisa diisi secara mass assignment
    protected $fillable = [
        'nomor_rumah',
        'alamat_lengkap',
        'status',
        'gambar',
        'latitude',
        'longitude',
        'id_cluster',
        'id_warga',
    ];

    /**
     * Relasi ke Cluster
     */
    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'id_cluster');
    }

    /**
     * Relasi ke Warga
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}
