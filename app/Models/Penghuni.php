<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';

    protected $fillable = [
        'id_rumah',
        'id_warga',
        'status_penghuni',
        'tanggal_masuk',
        'tanggal_keluar',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Rumah
     */
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah');
    }

    /**
     * Relasi ke Warga
     */
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    /**
     * Scope untuk penghuni yang masih aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk penghuni yang sudah keluar
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}