<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;

    protected $table = 'rumah';

    protected $fillable = [
        'nomor_rumah',
        'alamat_lengkap',
        'id_status_rumah',
        'gambar',
        'latitude',
        'longitude',
        'id_cluster',
        'id_warga', // Tetap ada untuk backward compatibility
    ];

    /**
     * Relasi ke Cluster
     */
    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'id_cluster');
    }

    /**
     * Relasi ke Warga (OLD - untuk backward compatibility)
     * Sebaiknya pakai penghuni() sekarang
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    /**
     * Relasi ke Status Rumah
     */
    public function statusRumah()
    {
        return $this->belongsTo(StatusRumah::class, 'id_status_rumah');
    }

    /**
     * ⭐ NEW: Relasi ke Penghuni (One-to-Many)
     */
    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'id_rumah');
    }

    /**
     * ⭐ Relasi ke Penghuni Aktif saja
     */
    public function penghuniAktif()
    {
        return $this->hasMany(Penghuni::class, 'id_rumah')->where('is_active', true);
    }

    /**
     * ⭐ Helper: Cek apakah rumah punya penghuni aktif
     */
    public function hasPenghuniAktif()
    {
        return $this->penghuniAktif()->exists();
    }

    /**
     * ⭐ Helper: Dapatkan Kepala Keluarga
     */
    public function kepalaKeluarga()
    {
        return $this->penghuniAktif()
            ->where('status_penghuni', 'Kepala Keluarga')
            ->first();
    }
}