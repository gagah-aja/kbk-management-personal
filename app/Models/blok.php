<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blok extends Model
{
    use HasFactory;
    protected $table = 'blok';
    protected $fillable = [
        'nama_blok',
    ];
}

