<?php

namespace App\Imports;

use App\Models\Pemohon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PemohonImport implements ToModel, SkipsEmptyRows
{
    private $currentRow = 1;

    public function model(array $row)
    {
        $this->currentRow++;
        
        // Validasi manual
        if (empty(trim($row[0] ?? ''))) {
            Log::warning("Skipping row {$this->currentRow}: nama_pemohon is empty");
            return null;
        }

        try {
            Log::info("Processing row {$this->currentRow}: " . trim($row[0]));

            return new Pemohon([
                'nama_pemohon' => trim($row[0]),
                'instansi'     => trim($row[1] ?? ''),
                'no_kontak'    => trim($row[2] ?? ''),
                'email'        => trim($row[3] ?? ''),
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to process row {$this->currentRow}: " . $e->getMessage());
            return null;
        }
    }
}