<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting'; // ⚠️ penting: pakai singular
    protected $fillable = ['key', 'value'];
}
