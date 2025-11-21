<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    use HasFactory;

    protected $table = 'blok';
    protected $fillable = ['nama_blok'];

    /**
     * Relasi ke tabel Rumah.
     * Satu blok bisa punya banyak rumah.
     */
    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'id_blok');
    }
}
