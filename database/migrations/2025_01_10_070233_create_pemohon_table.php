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
        Schema::create('pemohon', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon', 50);
            $table->string('instansi', 100);
            $table->string('no_kontak', 25)->nullable();
            $table->string('email', 30)->nullable();
            $table->unsignedBigInteger('id_permohonan');
            $table->foreign('id_permohonan')->references('id')->on('permohonan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemohon', function (Blueprint $table) {
            $table->dropForeign(['id_permohonan']);
        });
        Schema::dropIfExists('pemohon');
    }
};
