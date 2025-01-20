<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\JenisLayanan;
use App\Models\Pemohon;


class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::table('pemohon', function (Blueprint $table) {
            $table->dropForeign(['id_permohonan']);
        });

        $jenisLayanan = JenisLayanan::where('nama_jenis_layanan', 'SKC')->first();
        $pemohon = Pemohon::where('nama_pemohon', 'Denise')->first();
        $permohonan1 = DB::table('permohonan')->insertGetId([
            'tanggal_diajukan'=> '2025-01-15', 
            'kategori_berbayar'=> 'Berbayar', 
            'id_jenis_layanan' => $jenisLayanan->id, 
            'deskripsi_keperluan' => 'Kebutuhan cuaca yang isinya rinci yaitu tentang keadaan cuaca, dan jenis-nya', 
            'tanggal_awal' => '2018-01-01', 
            'tanggal_akhir'=>'2022-04-30', 
            'jam_awal'=>'06:00:00', 
            'jam_akhir'=>'00:00:00', 
            'id_pemohon'=> $pemohon->id,
            'created_at' => now(),
            'updated_at' => now(), 
        ]);

        $jenisLayanan = JenisLayanan::where('nama_jenis_layanan', 'Data Iklim')->first();
        $pemohon = Pemohon::where('nama_pemohon', 'Hexos')->first();
        $permohonan2 = DB::table('permohonan')->insertGetId([
            'tanggal_diajukan'=> '2025-01-18', 
            'kategori_berbayar'=> 'Nolrupiah', 
            'id_jenis_layanan' => $jenisLayanan->id, 
            'deskripsi_keperluan' => 'Informasi curah hujan bulanan  wilayah Ambarawa dan Bawen, Kab. Semarang', 
            'tanggal_awal' => '2023-01-01', 
            'tanggal_akhir'=>'2023-12-31', 
            'id_pemohon'=> $pemohon->id,
            'created_at' => now(),
            'updated_at' => now(), 
        ]);

        DB::table('pemohon')
            ->where('nama_pemohon', 'Denise')
            ->update(['id_permohonan' => $permohonan1]);
            
        DB::table('pemohon')
            ->where('nama_pemohon', 'Hexos')
            ->update(['id_permohonan' => $permohonan2]);

        Schema::table('pemohon', function (Blueprint $table) {
            $table->foreign('id_permohonan')
                ->references('id')
                ->on('permohonan')
                ->onDelete('cascade');
        });
    }
}
