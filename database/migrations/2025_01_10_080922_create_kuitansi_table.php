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
        Schema::create('kuitansi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_permohonan');
            $table->foreign('id_permohonan')->references('id')->on('permohonan')->onDelete('cascade');
            $table->string('nama_file_kuitansi');
            $table->string('path_file_kuitansi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuitansi', function (Blueprint $table) {
            $table->dropForeign(['id_permohonan']);
        });
        Schema::dropIfExists('kuitansi');
    }
};
