<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin12345'),
            'peran' => '1000'
        ]);
        User::create([
            'username' => 'sukasno123',
            'password' => bcrypt('sukasno123'),
            'peran' => '0110'
        ]);
        User::create([
            'username' => 'iis123',
            'password' => bcrypt('iis123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'sulis123',
            'password' => bcrypt('sulis123'), 
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'latif123',
            'password' => bcrypt('latif123'),
            'peran' => '0110'
        ]);
        User::create([
            'username' => 'tris123',
            'password' => bcrypt('tris123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'rudi123',
            'password' => bcrypt('rudi123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'zauyik123',
            'password' => bcrypt('zauyik123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'septima123',
            'password' => bcrypt('septima123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'endah123',
            'password' => bcrypt('endah123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'restu123',
            'password' => bcrypt('restu123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'umaroh123',
            'password' => bcrypt('umaroh123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'rosyidah123',
            'password' => bcrypt('rosyidah123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'rini123',
            'password' => bcrypt('rini123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'fani123',
            'password' => bcrypt('fani123'),
            'peran' => '0010'
        ]);
        User::create([
            'username' => 'hana123',
            'password' => bcrypt('hana123'),
            'peran' => '0011'
        ]);
        User::create([
            'username' => 'budi123',
            'password' => bcrypt('budi123'),
            'peran' => '0100'
        ]);
        User::create([
            'username' => 'dian123',
            'password' => bcrypt('dian123'),
            'peran' => '0001'
        ]);

        $this->call([
            PegawaiSeeder::class,
            JenisLayananSeeder::class,
            ImportSeeder::class,
        ]);
    }
}
