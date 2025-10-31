<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'cluster';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_nama_cluster',
        'id_rt',
        'id_blok',
    ];

    // =====================================================
    // 🔹 RELASI MODEL
    // =====================================================

    // Relasi ke NamaCluster (setiap cluster punya 1 nama cluster)
    public function namaCluster()
    {
        return $this->belongsTo(NamaCluster::class, 'id_nama_cluster');
    }

    // Relasi ke RT (setiap cluster punya 1 RT)
    public function rt()
    {
        return $this->belongsTo(Rt::class, 'id_rt');
    }

    // Relasi ke Blok (setiap cluster punya 1 blok)
    public function blok()
    {
        return $this->belongsTo(Blok::class, 'id_blok');
    }

    // Relasi ke Rumah (1 cluster bisa punya banyak rumah)
    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'id_cluster');
    }
}
