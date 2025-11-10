<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRumah extends Model
{
    use HasFactory;

    protected $table = 'status_rumah'; // <- wajib, karena bukan jamak
    protected $fillable = ['nama_status'];

    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'id_status_rumah');
    }
}
