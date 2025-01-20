<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawaiData = [
            [
                'nip' => '123456789098765432',
                'id_user' => '1',
                'nama' => 'Ani Suryani',
                'no_kontak' => '082234567652',
                'peran_pegawai' => '1000',
            ],
            [
                'nip' => '234567890987654321',
                'id_user' => '2',
                'nama' => 'Budi Bako',
                'no_kontak' => '083387649012',
                'peran_pegawai' => '0100',
            ],
            [
                'nip' => '345678909876543212',
                'id_user' => '3',
                'nama' => 'Citra Candra',
                'no_kontak' => '081209371237',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '456789098765432123',
                'id_user' => '4',
                'nama' => 'Dian Andini',
                'no_kontak' => '088709734261',
                'peran_pegawai' => '0001',
            ],
            [
                'nip' => '567890987654321234',
                'id_user' => '5',
                'nama' => 'Edo Widodo',
                'no_kontak' => '084562514352',
                'peran_pegawai' => '1100',
            ],
            [
                'nip' => '678909876543212345',
                'id_user' => '6',
                'nama' => 'Fadhil Oey',
                'no_kontak' => '087682738127',
                'peran_pegawai' => '0110',
            ],
        ];

        foreach ($pegawaiData as $data) {
                Pegawai::create([
                    'nip' => $data['nip'],
                    'id_user' => $data['id_user'],
                    'nama' => $data['nama'],
                    'no_kontak' => $data['no_kontak'],
                    'peran_pegawai' => $data['peran_pegawai']
                ]);
        }
    }
}
