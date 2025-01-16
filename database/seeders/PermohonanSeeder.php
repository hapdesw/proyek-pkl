<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JenisLayanan;
use App\Models\Pemohon;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisLayanan = JenisLayanan::where('nama_jenis_layanan', 'SKC')->first();
        $pemohon = Pemohon::where('nama_pemohon', 'Denise')->first();
        DB::table('permohonan')->insert([
            [
                 
                'tanggal_diajukan'=> '2025-01-15', 
                'kategori_berbayar'=> 'berbayar', 
                'id_jenis_layanan' => $jenisLayanan->id, 
                'deskripsi_keperluan' => 'Kebutuhan cuaca yang isinya rinci yaitu tentang keadaan cuaca, dan jenis-nya', 
                'tanggal_awal' => '2018-01-01', 
                'tanggal_akhir'=>'2022-04-30', 
                'jam_awal'=>'06:00:00', 
                'jam_akhir'=>'00:00:00', 
                'id_pemohon'=> $pemohon->id,
                'created_at' => now(),
                'updated_at' => now(), 
                

            ]
        ]);
    }
}
