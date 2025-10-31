<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('cluster', function (Blueprint $table) {
            $table->id(); // id utama

            // Relasi ke tabel nama_cluster
            $table->foreignId('id_nama_cluster')
                  ->constrained('nama_cluster')
                  ->onDelete('cascade');

            // Relasi ke tabel rt
            $table->foreignId('id_rt')
                  ->constrained('rt')
                  ->onDelete('cascade');

            // Relasi ke tabel blok
            $table->foreignId('id_blok')
                  ->constrained('blok')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('cluster');
    }
};
