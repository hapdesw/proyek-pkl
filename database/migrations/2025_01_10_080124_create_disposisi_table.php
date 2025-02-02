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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_permohonan');
            $table->foreign('id_permohonan')->references('id')->on('permohonan')->onDelete('cascade');
            $table->char('nip_pegawai1', 18);
            $table->foreign('nip_pegawai1')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->char('nip_pegawai2', 18)->nullable();
            $table->foreign('nip_pegawai2')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->char('nip_pegawai3', 18)->nullable();
            $table->foreign('nip_pegawai3')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->char('nip_pegawai4', 18)->nullable();
            $table->foreign('nip_pegawai4')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->date('tanggal_disposisi');
            $table->timestamps();
            $table->unique('id_permohonan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->dropForeign(['id_permohonan']);
            $table->dropForeign(['nip_pegawai1']);
            $table->dropForeign(['nip_pegawai2']);
            $table->dropForeign(['nip_pegawai3']);
            $table->dropForeign(['nip_pegawai4']);
        });
        Schema::dropIfExists('disposisi');
    }
};
