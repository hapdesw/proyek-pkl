<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\DisposisiExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Log;
use App\Models\Pegawai;
use App\Models\Disposisi;

class ExportDisposisiController extends Controller
{
    public function export(Request $request)
    {
        // Debug parameter yang diterima
        Log::info('Request Parameters:', $request->all());
        
        $validated = $request->validate([
            'year' => 'nullable|integer|min:2000|max:'.(date('Y')+1),
            'format' => 'required|in:pdf,excel'
        ]);
    
        // Gunakan null jika tahun tidak diisi (tampilkan semua tahun)
        $year = $validated['year'] ?? null;
        
        Log::info('Processing export for year:', ['year' => $year]);
    
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
        // Siapkan array untuk total per bulan untuk total disposisi
        $totalPerBulan = array_fill_keys($namaBulan, 0);
        $grandTotal = 0;
    
        $data = [
            'namaBulan' => $namaBulan, 
            'pegawai' => Pegawai::all()->map(function($p) use ($year, $namaBulan, &$totalPerBulan, &$grandTotal) {
                $row = ['nama' => $p->nama];
                $total = 0;
    
                foreach ($namaBulan as $index => $bulan) {
                    $month = $index + 1;
                    $count = $this->getDisposisiCount($p->nip, $month, $year);
                    $row[$bulan] = $count;
                    $total += $count;
        
                    // Tambahkan ke total per bulan
                    $totalPerBulan[$bulan] += $count;
                }
    
                $row['total'] = $total;
                $grandTotal += $total;
                return $row;
            }),
            'year' => $year,
            'totalPerBulan' => $totalPerBulan,
            'grandTotal' => $grandTotal
        ];
        
        if ($validated['format'] === 'pdf') {
            return $this->exportPdf($data);
        } elseif ($validated['format'] === 'excel') {
            return $this->exportExcel($year, $totalPerBulan, $grandTotal);
        }
        
        return back()->with('error', 'Format tidak valid');
    }
    
    public function exportExcel($year, $totalPerBulan, $grandTotal)
    {
        $filename = 'rekap_disposisi_'.($year ? $year : 'semua_tahun').'.xlsx';
        
        return \Maatwebsite\Excel\Facades\Excel::download(new DisposisiExport($year, $totalPerBulan, $grandTotal), $filename);
    }

public function getDisposisiCount($nip, $month, $year)
{
    $query = Disposisi::where(function($q) use ($nip) {
            $q->where('nip_pegawai1', $nip)
              ->orWhere('nip_pegawai2', $nip)
              ->orWhere('nip_pegawai3', $nip)
              ->orWhere('nip_pegawai4', $nip);
        })
        ->whereHas('permohonan', function($q) use ($month, $year) {
            $q->whereMonth('tanggal_diajukan', $month);
            
            if ($year) {
                $q->whereYear('tanggal_diajukan', $year);
            }
        });
    
    Log::info('Disposisi Query:', [
        'nip' => $nip,
        'month' => $month,
        'year' => $year,
        'sql' => $query->toSql()
    ]);
    
    return $query->count();
}
    
    public function exportPdf(array $data)
    {
        $pdf = PDF::loadView('admin.disposisi-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        $filename = "rekap_disposisi_{$data['year']}.pdf";
    
        return $pdf->download($filename);
    }
    
}