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
        Schema::create('rt', function (Blueprint $table) {
            $table->id(); // id otomatis
            $table->string('nomor_rt'); // nomor RT
            $table->foreignId('id_warga')->nullable()->constrained('warga')->onDelete('set null'); // ketua RT
            $table->foreignId('id_rw')->constrained('rw')->onDelete('cascade'); // relasi ke RW
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rt');
    }
};
