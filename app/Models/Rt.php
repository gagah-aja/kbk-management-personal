<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;

    protected $table = 'rt';

    protected $fillable = [
        'nomor_rt',
        'id_warga',
        'id_rw',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    public function rw()
    {
        return $this->belongsTo(Rw::class, 'id_rw');
    }
}

