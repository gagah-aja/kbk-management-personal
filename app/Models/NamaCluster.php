<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaCluster extends Model
{
    use HasFactory;

    // Nama tabel (opsional, Laravel otomatis mendeteksi plural "nama_clusters")
    protected $table = 'nama_cluster';

    // Kolom yang bisa diisi secara mass assignment
    protected $fillable = [
        'nama_cluster',
    ];

    /**
     * Relasi ke Cluster
     * Satu nama_cluster bisa punya banyak cluster
     */
    public function cluster()
    {
        return $this->hasMany(Cluster::class, 'id_nama_cluster');
    }
}
