<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🏠 Buat tabel status_rumah
        Schema::create('status_rumah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status');
            $table->timestamps();
        });

        // 🔗 Tambah kolom id_status di tabel rumah
        // Schema::table('rumah', function (Blueprint $table) {
        //     $table->unsignedBigInteger('id_status')->nullable()->after('id');
        //     $table->foreign('id_status')->references('id')->on('status_rumah')->onDelete('set null');
        // });
    }

    public function down(): void
    {
        // Hapus relasi dan kolom di tabel rumah
        Schema::table('rumah', function (Blueprint $table) {
            $table->dropForeign(['id_status']);
            $table->dropColumn('id_status');
        });

        // Hapus tabel status_rumah
        Schema::dropIfExists('status_rumah');
    }
};
