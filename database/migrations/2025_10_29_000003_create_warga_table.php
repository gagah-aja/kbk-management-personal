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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string("nik");
            $table->string("nama_lengkap");
            $table->string("email")->nullable();
            $table->string("no_telp")->nullable();
            $table->string("gol_darah")->nullable();
            $table->string("agama");
            $table->string("pendidikan_terakhir")->nullable();
            $table->string("gaji")->nullable();
            $table->date("tanggal_lahir");
            $table->string("jenis_kelamin");
            $table->string("hubungan");
            $table->string("pekerjaan")->nullable();
            $table->string("foto");
            $table->string("foto_ktp");
            $table->integer('id_rumah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
