<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cluster', function (Blueprint $table) {
            $table->id(); // id otomatis
            $table->string('id_nama_cluster')->unique(); // nama atau kode cluster
            $table->foreignId('id_rt')->constrained('rt')->onDelete('cascade'); // relasi ke tabel RT
            $table->foreignId('id_blok')->constrained('blok')->onDelete('cascade'); // relasi ke tabel Blok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cluster');
    }
};
