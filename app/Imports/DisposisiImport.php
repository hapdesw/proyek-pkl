<?php

namespace App\Imports;

use App\Models\Disposisi;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;

class DisposisiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info('Baris pegawai:', $row); // Log semua baris
        return new Disposisi([
            'id_permohonan' =>$row[0],
            'nip_pegawai1' => $row[1],
            'nip_pegawai2' => $row[2],
            'nip_pegawai3' => $row[3],
            'nip_pegawai4' => $row[4],
            'tanggal_disposisi' => !empty($row[5]) ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])) : null,
        ]);
    }
}
