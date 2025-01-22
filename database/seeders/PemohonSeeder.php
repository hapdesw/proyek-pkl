<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemohonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pemohon')->insert([
            [
                'nama_pemohon'=>'Denise', 
                'instansi'=>'PT Arga Putra', 
                'no_kontak'=>'0987867777556', 
                'email'=>'kantorandara@gmail.com', 
               
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pemohon'=>'Hexos', 
                'instansi'=>'PT Mencari Cinta', 
                'no_kontak'=>'087156249587', 
                'email'=>'hexoshexos@gmail.com', 
               
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
