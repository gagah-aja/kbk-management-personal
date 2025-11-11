<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: ubah kolom nomor_rw dari integer menjadi string
     */
    public function up(): void
    {
        Schema::table('rw', function (Blueprint $table) {
            // Ubah tipe kolom menjadi string
            $table->string('nomor_rw', 10)->change();
        });
    }

    /**
     * Kembalikan perubahan (rollback)
     */
    public function down(): void
    {
        Schema::table('rw', function (Blueprint $table) {
            // Kembalikan ke integer seperti semula
            $table->integer('nomor_rw')->change();
        });
    }
};
