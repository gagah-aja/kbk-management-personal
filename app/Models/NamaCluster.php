<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaCluster extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'nama_cluster';

    // Primary key
    protected $primaryKey = 'id';

    // Jika kolom id auto increment
    public $incrementing = true;

    // Tipe data primary key
    protected $keyType = 'int';

    // Kolom yang dapat diisi
    protected $fillable = [
        'id',
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
