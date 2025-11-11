<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rumah');
            $table->unsignedBigInteger('id_warga');
            $table->enum('status_penghuni', [
                'Kepala Keluarga',
                'Istri/Suami', 
                'Anak',
                'Orang Tua',
                'Keluarga Lainnya'
            ])->default('Anak');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->boolean('is_active')->default(true); // Masih tinggal atau tidak
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Foreign key (opsional, bisa dihapus jika tidak pakai constraint)
            $table->foreign('id_rumah')->references('id')->on('rumah')->onDelete('cascade');
            $table->foreign('id_warga')->references('id')->on('warga')->onDelete('cascade');
            
            // Index untuk performa
            $table->index(['id_rumah', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};