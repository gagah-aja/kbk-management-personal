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

        // 🔹 Hapus relasi, cukup simpan ID saja
        $table->unsignedBigInteger('id_status_rumah')->nullable();
        $table->unsignedBigInteger('id_cluster')->nullable();
        $table->unsignedBigInteger('id_warga')->nullable();

        $table->string('gambar')->nullable(); // path gambar rumah
        $table->string('latitude')->nullable(); // latitude
        $table->string('longitude')->nullable(); // longitude

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
