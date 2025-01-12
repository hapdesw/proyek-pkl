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
            'username' => 'Ani',
            'password' => bcrypt('ani123'),
            'peran' => '1000'
        ]);
        User::create([
            'username' => 'Budi',
            'password' => bcrypt('budi123'),
            'peran' => '0100'
        ]);
        User::create([
            'username' => 'Citra',
            'password' => bcrypt('citra123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'Dian',
            'password' => bcrypt('dian123'),
            'peran' => '0001'
        ]);
        User::create([
            'username' => 'Edo',
            'password' => bcrypt('edo123'),
            'peran' => '1100'
        ]);
        User::create([
            'username' => 'Fadhil',
            'password' => bcrypt('fadhil123'),
            'peran' => '0110'
        ]);
    }

}
