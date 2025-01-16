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
        // User::create([
        //     'email' => 'ani@gmail.com',
        //     'password' => bcrypt('ani123'),
        //     'peran' => '1000'
        // ]);
        // User::create([
        //     'email' => 'budi@gmail.com',
        //     'password' => bcrypt('budi123'),
        //     'peran' => '0100'
        // ]);
        // User::create([
        //     'email' => 'citra@gmail.com',
        //     'password' => bcrypt('citra123'),
        //     'peran' => '0010'
        // ]);
        // User::create([
        //     'email' => 'dian@gmail.com',
        //     'password' => bcrypt('dian123'),
        //     'peran' => '0001'
        // ]);
        // User::create([
        //     'email' => 'edo@gmail.com',
        //     'password' => bcrypt('edo123'),
        //     'peran' => '1100'
        // ]);
        // User::create([
        //     'email' => 'fadhil@gmail.com',
        //     'password' => bcrypt('fadhil123'),
        //     'peran' => '0110'
        // ]);

        $this->call([
            PegawaiSeeder::class,
        ]);

        $this->call([
            JenisLayananSeeder::class,
            PemohonSeeder::class,
            PermohonanSeeder::class,
            
        ]);
    }
}
