<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Exports\PermohonanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    /**
     * Export data permohonan
     */
    public function export(Request $request)
    {
        // Debugging - Tampilkan semua parameter yang diterima
        Log::info('Export Request Parameters:', $request->all());
        
        // Validasi input
        $request->validate([
            'year' => 'nullable|integer',
            'months' => 'nullable|string',
            'status_permohonan' => 'nullable|string',
            'format' => 'required|in:pdf,excel'
        ]);
        
        // Dapatkan filter dari request dengan fallback ke null
        $filters = [
            'year' => $request->has('year') ? $request->input('year') : null,
            'months' => $request->has('months') ? $request->input('months') : null,
            'status_permohonan' => $request->has('status_permohonan') ? $request->input('status_permohonan') : null,
        ];
        
        // Debugging - Tampilkan filter yang telah diproses
        Log::info('Processed Export Filters:', $filters);
        
        // Tambahkan jumlah data ke session untuk ditampilkan di flash message
        $query = $this->buildExportQuery($filters);
        $count = $query->count();
        session()->flash('export_count', $count);
        
        // Generate nama file
        $fileName = 'permohonan_';
        $fileName .= $filters['year'] ?? 'semua-tahun';
        $fileName .= '_';
        $fileName .= $filters['months'] ? str_replace(',', '-', $filters['months']) : 'semua-bulan';
        $fileName .= '_';
        $fileName .= $filters['status_permohonan'] ?? 'semua-status';
        
        // Debugging - Tampilkan query SQL untuk cek filter
        Log::info('Final Export Query:', [
            'query' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);
        
        // Export berdasarkan format yang diminta
        if ($request->format === 'excel') {
            return Excel::download(new PermohonanExport($filters), $fileName . '.xlsx');
        } else {
            $permohonan = $query->get();

            // Kelompokkan data berdasarkan tahun
            $permohonanGrouped = $permohonan->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->tanggal_diajukan)->format('Y');
            });

            $pdf = PDF::loadView('admin.export-pdf', [
                'permohonanGrouped' => $permohonanGrouped, // Kirim data yang sudah dikelompokkan
                'filters' => $filters
            ]);
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download($fileName . '.pdf');
        }
    }
        
    /**
     * Membangun query untuk export sesuai filter yang diterapkan
     * PENTING: Menggunakan logika yang sama dengan method filter normal
     */
    private function buildExportQuery(array $filters)
    {
        $query = Permohonan::query();
        
        // Filter bulan - menggunakan logika yang sama dengan filter normal
        if (isset($filters['months']) && $filters['months'] !== null && $filters['months'] !== '') {
            $months = explode(',', $filters['months']);
            $monthNumbers = [
                'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
            ];
            $selectedMonths = array_map(fn($m) => $monthNumbers[strtolower($m)] ?? null, $months);
            $query->whereIn(DB::raw('MONTH(tanggal_diajukan)'), $selectedMonths);
            Log::info('Applying months filter:', ['months' => $filters['months'], 'selected_numbers' => $selectedMonths]);
        }
        
        // Filter tahun - menggunakan logika yang sama dengan filter normal
        if (isset($filters['year']) && $filters['year'] !== null && $filters['year'] !== '') {
            $query->whereYear('tanggal_diajukan', $filters['year']);
            Log::info('Applying year filter: ' . $filters['year']);
        }
        
        // Filter status permohonan - menggunakan logika yang sama dengan filter normal
        if (isset($filters['status_permohonan']) && $filters['status_permohonan'] !== null && $filters['status_permohonan'] !== '') {
            $query->where('status_permohonan', $filters['status_permohonan']);
            Log::info('Applying status filter: ' . $filters['status_permohonan']);
        }
        
        // Tambahkan relasi yang diperlukan untuk export
        $query->with([
            'pemohon', 
            'jenisLayanan', 
            'disposisi', 
            'disposisi.pegawai1', 
            'disposisi.pegawai2', 
            'disposisi.pegawai3', 
            'disposisi.pegawai4'
        ]);
        
        return $query;
    }
        
}