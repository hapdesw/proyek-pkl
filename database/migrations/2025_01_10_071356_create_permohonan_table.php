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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_diajukan');
            $table->enum('kategori_berbayar', ['Berbayar', 'Nolrupiah']);
            $table->unsignedBigInteger('id_jenis_layanan');
            $table->foreign('id_jenis_layanan')->references('id')->on('jenis_layanan')->onDelete('cascade');
            $table->text('deskripsi_keperluan');
            $table->enum('status_permohonan', ['Diproses', 'Selesai Dibuat','Selesai Diambil', 'Batal'])->default('Diproses');
            $table->date('tanggal_selesai')->nullable();
            $table->date('tanggal_diambil')->nullable();
            $table->date('tanggal_rencana')->nullable();
            $table->date('tanggal_pengumpulan')->nullable();
            $table->unsignedBigInteger('id_pemohon');
            $table->foreign('id_pemohon')->references('id')->on('pemohon')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['id_jenis_layanan']);
            $table->dropForeign(['id_pemohon']);
        });
        Schema::dropIfExists('permohonan');
    }
};