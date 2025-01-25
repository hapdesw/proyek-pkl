<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'ani123',
            'password' => bcrypt('ani123'),
            'peran' => '1000'
        ]);
        User::create([
            'username' => 'budi123',
            'password' => bcrypt('budi123'),
            'peran' => '0100'
        ]);
        User::create([
            'username' => 'citra123',
            'password' => bcrypt('citra123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'dian123',
            'password' => bcrypt('dian123'), 
            'peran' => '0001'
        ]);
        User::create([
            'username' => 'edo123',
            'password' => bcrypt('edo123'),
            'peran' => '1100'
        ]);
        User::create([
            'username' => 'fadhil123',
            'password' => bcrypt('fadhil123'),
            'peran' => '0110'
        ]);

        $this->call([
            PegawaiSeeder::class,
            JenisLayananSeeder::class,
            // ImportSeeder::class,
            // PemohonSeeder::class,
            // PermohonanSeeder::class,
        ]);
    }
}
