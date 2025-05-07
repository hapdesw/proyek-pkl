<?php

namespace App\Imports;

use App\Models\Pemohon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;

class PemohonImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info('Baris pemohon:', $row); // Log semua baris
        return new Pemohon([
            'nama_pemohon' => $row[0],
            'instansi' => $row[1],
            'no_kontak' => $row[2],
            'email' => $row[3],
        ]);
    }
}
