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
        Schema::create('rumah', function (Blueprint $table) {
            $table->id(); // id otomatis
            $table->string('nomor_rumah')->unique(); // nomor rumah
            $table->text('alamat_lengkap'); // alamat lengkap
            $table->enum('status', ['tersedia', 'terisi', 'rusak'])->default('tersedia'); // status rumah
            $table->string('gambar')->nullable(); // path gambar rumah
            $table->decimal('latitude', 10, 7)->nullable(); // latitude
            $table->decimal('longitude', 10, 7)->nullable(); // longitude, biasanya berpasangan dengan latitude
            $table->foreignId('id_cluster')->constrained('cluster')->onDelete('cascade'); // relasi ke tabel clusters
            $table->foreignId('id_warga')->nullable()->constrained('warga')->onDelete('set null'); // relasi ke warga
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah');
    }
};
