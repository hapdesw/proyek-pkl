<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DisposisiExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithCustomStartCell, WithEvents
{
    protected $year;
    protected $totalPerBulan;
    protected $grandTotal;

    public function __construct($year = null, $totalPerBulan = [], $grandTotal = 0)
    {
        $this->year = $year;
        $this->totalPerBulan = $totalPerBulan;
        $this->grandTotal = $grandTotal;
    }

    public function collection()
    {
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $pegawai = Pegawai::all();
        
        $data = [];
        
        foreach ($pegawai as $p) {
            $rowData = [];
            $rowData['Nama Pegawai'] = $p->nama;
            $total = 0;
            
            foreach ($namaBulan as $index => $bulan) {
                $month = $index + 1;
                $count = $this->getDisposisiCount($p->nip, $month);
                $rowData[$bulan] = $count;
                $total += $count;
            }
            
            $rowData['Total'] = $total;
            $data[] = $rowData;
        }
        
        // Add summary row
        // $summaryRow = [];
        // $summaryRow['Nama Pegawai'] = 'Total';
        // foreach ($namaBulan as $bulan) {
        //     $summaryRow[$bulan] = $this->totalPerBulan[$bulan] ?? 0;
        // }
        // $summaryRow['Total'] = $this->grandTotal;
        // $data[] = $summaryRow;
        
        return collect($data);
    }

    protected function getDisposisiCount($nip, $month)
{
    return DB::table('disposisi')
        ->join('permohonan', 'disposisi.id_permohonan', '=', 'permohonan.id')
        ->where(function($query) use ($nip) {
            $query->where('nip_pegawai1', $nip)
                  ->orWhere('nip_pegawai2', $nip)
                  ->orWhere('nip_pegawai3', $nip)
                  ->orWhere('nip_pegawai4', $nip);
        })
        ->when($this->year, function($query) {
            $query->whereYear('permohonan.tanggal_diajukan', $this->year);
        })
        ->whereMonth('permohonan.tanggal_diajukan', $month)
        ->count();
}

    public function headings(): array
    {
        $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                     'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        return array_merge(['Nama Pegawai'], $namaBulan, ['Total']);
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->collection()) + 2; // +1 for header
        
        return [
            // Header style
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 
                          'startColor' => ['rgb' => 'FFFFFF']]
            ],
            
            // Total column style
            'O' => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                          'startColor' => ['rgb' => 'FFF2CC']]
            ],
            
            // // Summary row style
            // $lastRow => [
            //     'font' => ['bold' => true],
            //     'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            //               'startColor' => ['rgb' => 'E2EFDA']]
            // ]
        ];
    }

    public function title(): string
    {
        return $this->year ? 'Disposisi '.$this->year : 'Disposisi Semua Tahun';
    }

    public function startCell(): string
    {
        return 'B2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Add title
                $event->sheet->mergeCells('B1:O1');
                $event->sheet->setCellValue('B1', 'REKAP DISPOSISI PEGAWAI ' . ($this->year ? 'TAHUN '.$this->year : 'SEMUA TAHUN'));
                
                // Style for title
                $event->sheet->getStyle('B1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                
               
            },
        ];
    }
}