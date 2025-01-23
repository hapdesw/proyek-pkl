<?php

namespace App\Imports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Support\Facades\Log;

class PermohonanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        Log::info('Row data:', $row);
        return new Permohonan([
            'id' => $row[0],
            // Ubah format parse date sesuai format di Excel
            'tanggal_diajukan' => !empty($row[1]) ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])) : null,
            'kategori_berbayar' => $row[2],
            'id_jenis_layanan' => $row[3],
            'deskripsi_keperluan' => $row[4],
            'status_permohonan' => in_array($row[5], ['Diproses', 'Selesai']) ? $row[5] : 'Selesai',
            'tanggal_selesai' => !empty($row[6]) ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])) : null,
            'tanggal_diambil' => !empty($row[7]) ? \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7])) : null,
            'id_pemohon' => $row[8],
        ]);
    }
}

