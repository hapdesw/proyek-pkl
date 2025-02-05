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
                'nip' => '196703041990031001',
                'id_user' => '2',
                'nama' => 'Sukasno, S.T.P, M.M.',
                'peran_pegawai' => '0110',
            ],
            [
                'nip' => '196912111993021001',
                'id_user' => null,
                'nama' => 'Nur Fitriyanto',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197801221998031001',
                'id_user' => '3',
                'nama' => 'Iis Widya Harmoko, S.Kom.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197001281992022001',
                'id_user' => '4',
                'nama' => 'Sulistyowati, S.P.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197607222006041003',
                'id_user' => '5',
                'nama' => 'Abdul Latif, S.Kom.',
                'peran_pegawai' => '0110',
            ],
            [
                'nip' => '197211131995031002',
                'id_user' => '6',
                'nama' => 'Tris Adi Sukoco, S.Hut.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197602231999031001',
                'id_user' => '7',
                'nama' => 'Rudi Setyo Prihatin, S.P.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197706282000121002',
                'id_user' => '8',
                'nama' => 'Zauyik Nana Ruslana, S.T.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197209051995032001',
                'id_user' => '9',
                'nama' => 'Septima Ernawati, M.Si.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '197604192008012015',
                'id_user' => '10',
                'nama' => 'Sri Endah ANA, S.Si.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '198112052006042002',
                'id_user' => '11',
                'nama' => 'Restu Tresnawati, S.Si.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '198408112006042002',
                'id_user' => '12',
                'nama' => 'Umaroh, S.Si.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '198503082007012003',
                'id_user' => '13',
                'nama' => 'Rosyidah, S.Kom.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '198510052009112001',
                'id_user' => '14',
                'nama' => 'Rini Eksawati, S.Si.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '198910102010122001',
                'id_user' => '15',
                'nama' => 'Stefani Putri, S.Kom.',
                'peran_pegawai' => '0010',
            ],
            [
                'nip' => '199310132013122000',
                'id_user' => '16',
                'nama' => 'Hana Amalia, S.Tr.',
                'peran_pegawai' => '0011',
            ],
        ];

        foreach ($pegawaiData as $data) {
                Pegawai::create([
                    'nip' => $data['nip'],
                    'id_user' => $data['id_user'],
                    'nama' => $data['nama'],
                    'peran_pegawai' => $data['peran_pegawai'],
                ]);
        }
    }
}
