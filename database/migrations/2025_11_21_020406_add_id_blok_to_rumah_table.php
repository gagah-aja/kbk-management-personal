<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('rumah', function (Blueprint $table) {
        $table->unsignedBigInteger('id_blok')->nullable()->after('id'); // nullable agar rumah lama tetap bisa ada
        $table->foreign('id_blok')->references('id')->on('blok')->onDelete('restrict');
    });
}

public function down()
{
    Schema::table('rumah', function (Blueprint $table) {
        $table->dropForeign(['id_blok']);
        $table->dropColumn('id_blok');
    });
}

};
