<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenislayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_layanan')->insert([
            [
                'nama_jenis_layanan'=>'SKC', 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
