<?php

namespace App\Imports;

use App\Models\Permohonan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PermohonanImport implements ToModel, SkipsEmptyRows
{
    private $currentRow = 1;

    public function model(array $row)
    {
        $this->currentRow++;
        
        // Validasi manual untuk field required
        if (empty(trim($row[0] ?? ''))) {
            Log::warning("Skipping row {$this->currentRow}: kode_permohonan is empty");
            return null;
        }

        try {
            Log::info("Processing row {$this->currentRow}: " . trim($row[0]));

            return new Permohonan([
                'kode_permohonan'     => trim($row[0]),
                'tanggal_diajukan'    => $this->parseDate($row[1] ?? null),
                'kategori_berbayar'    => trim($row[2] ?? ''),
                'id_jenis_layanan'     => trim($row[3] ?? ''),
                'deskripsi_keperluan'  => trim($row[4] ?? ''),
                'status_permohonan'    => $this->parseStatus($row[5] ?? null),
                'tanggal_selesai'      => $this->parseDate($row[6] ?? null),
                'tanggal_diambil'      => $this->parseDate($row[7] ?? null),
                'id_pemohon'           => trim($row[8] ?? ''),
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to process row {$this->currentRow}: " . $e->getMessage(), [
                'exception' => $e,
                'row_data' => $row
            ]);
            return null;
        }
    }

    /**
     * Parse tanggal dari format Excel atau string biasa
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika sudah berupa string tanggal
        if (is_string($value) && preg_match('/\d{4}-\d{2}-\d{2}/', $value)) {
            return Carbon::parse($value);
        }

        // Jika numerik (format Excel)
        if (is_numeric($value)) {
            try {
                return Carbon::instance(Date::excelToDateTimeObject($value));
            } catch (\Exception $e) {
                Log::warning("Invalid date value at row {$this->currentRow}: {$value}");
                return null;
            }
        }

        return null;
    }

    /**
     * Parse status permohonan
     */
    private function parseStatus($value)
    {
        $validStatuses = ['Diproses', 'Selesai Dibuat', 'Selesai Diambil', 'Batal'];
        return in_array($value, $validStatuses) ? $value : 'Selesai Diambil';
    }
}