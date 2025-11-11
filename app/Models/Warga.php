<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;
    
    protected $table = 'warga';
    
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'email',
        'no_telp',
        'gol_darah',
        'agama',
        'pendidikan_terakhir',
        'gaji',
        'tanggal_lahir',
        'jenis_kelamin',
        'hubungan',
        'pekerjaan',
        'foto',
        'foto_ktp',
        'id_rumah', // Tetap ada untuk backward compatibility
    ];

    /**
     * Relasi ke Rumah (OLD - backward compatibility)
     */
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah', 'id');
    }

    /**
     * ⭐ NEW: Relasi ke Penghuni (One-to-Many)
     * Warga bisa jadi penghuni di banyak rumah
     */
    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'id_warga');
    }

    /**
     * ⭐ Relasi ke Penghuni Aktif saja
     */
    public function penghuniAktif()
    {
        return $this->hasMany(Penghuni::class, 'id_warga')->where('is_active', true);
    }

    /**
     * ⭐ Helper: Dapatkan semua rumah yang ditinggali warga ini (aktif)
     */
    public function rumahYangDitinggali()
    {
        return $this->belongsToMany(Rumah::class, 'penghuni', 'id_warga', 'id_rumah')
            ->wherePivot('is_active', true)
            ->withPivot('status_penghuni', 'tanggal_masuk', 'tanggal_keluar');
    }

    public function rw()
    {
        return $this->hasMany(Rw::class, 'id_warga', 'id');
    }
    
    public function rt()
    {
        return $this->hasMany(Rt::class, 'id_warga', 'id');
    }
}