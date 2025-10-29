<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

    protected $table = 'cluster';

    protected $fillable = [
        'id_nama_cluster',
        'id_rt',
        'id_blok',
    ];

    // Relasi ke RT
    public function rt()
    {
        return $this->belongsTo(Rt::class, 'id_rt');
    }

    // Relasi ke Blok
    public function blok()
    {
        return $this->belongsTo(Blok::class, 'id_blok');
    }

    // Relasi ke Rumah
    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'id_cluster');
    }
}
