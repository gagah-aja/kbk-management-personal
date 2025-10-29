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
        'jenis_kelamin',
        'hubungan',
        'pekerjaan',
        'foto',
        'foto_ktp',
        'id_rumah', // Kolom foreign key
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'id_rumah', 'id');
    }

    public function rw()
    {
        return $this->hasMany(Rw::class, 'id_warga', 'id');
    }
}
