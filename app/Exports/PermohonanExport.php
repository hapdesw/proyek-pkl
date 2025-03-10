<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermohonanExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
        Log::info('PermohonanExport Constructor Filters:', $filters);
    }

    /**
     * Mengembalikan array sheet yang akan diekspor.
     *
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $data = $this->getFilteredData();

        // Kelompokkan data berdasarkan tahun
        $groupedData = $data->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_diajukan)->format('Y');
        })->sortKeys();

        // Buat sheet untuk setiap tahun
        foreach ($groupedData as $year => $yearData) {
            $sheets[] = new PermohonanSheet($yearData, $this->filters, $year);
        }

        return $sheets;
    }
    /**
     * Mengambil data permohonan berdasarkan filter.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFilteredData()
    {
        $query = Permohonan::query();

        // Filter bulan
        if (isset($this->filters['months']) && $this->filters['months'] !== null && $this->filters['months'] !== '') {
            $months = explode(',', $this->filters['months']);
            $monthNumbers = [
                'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
            ];
            $selectedMonths = array_map(fn($m) => $monthNumbers[strtolower($m)] ?? null, $months);
            $query->whereIn(DB::raw('MONTH(tanggal_diajukan)'), $selectedMonths);
            Log::info('Export class applying months filter:', ['months' => $this->filters['months'], 'selected_numbers' => $selectedMonths]);
        }

        // Filter tahun
        if (isset($this->filters['year']) && $this->filters['year'] !== null && $this->filters['year'] !== '') {
            $query->whereYear('tanggal_diajukan', $this->filters['year']);
            Log::info('Export class applying year filter: ' . $this->filters['year']);
        }

        // Filter status permohonan
        if (isset($this->filters['status_permohonan']) && $this->filters['status_permohonan'] !== null && $this->filters['status_permohonan'] !== '') {
            $query->where('status_permohonan', $this->filters['status_permohonan']);
            Log::info('Export class applying status filter: ' . $this->filters['status_permohonan']);
        }

        // Debugging: Tampilkan query SQL final
        Log::info('PermohonanExport Final Query:', [
            'query' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        // Load relasi yang diperlukan
        return $query->with([
            'pemohon',
            'jenisLayanan',
            'disposisi.pegawai1',
            'disposisi.pegawai2',
            'disposisi.pegawai3',
            'disposisi.pegawai4'
        ])->orderBy('tanggal_diajukan')->get();
    }
}