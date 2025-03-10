<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;

class PermohonanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    private $data;
    private $filters;
    private $year;
    private $rowNumber = 1;

    public function __construct($data, $filters, $year)
    {
        $this->data = $data;
        $this->filters = $filters;
        $this->year = $year;
        $this->rowNumber = 1; // Inisialisasi rowNumber di constructor
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No.',
            'ID',
            'Tanggal Pengajuan',
            'Kategori',
            'Layanan',
            'Nama Pemohon',
            'No. Kontak',
            'Instansi',
            'Keperluan',
            'Disposisi',
            'Tanggal Selesai',
            'Tanggal Diambil',
            'Tanggal Rencana Pengumpulan Skripsi',
            'Tanggal Pengumpulan Skripsi',
            'Status',
        ];
    }

    public function map($permohonan): array
    {
        // Format disposisi pegawai
        $pegawaiList = collect([
            optional(optional($permohonan->disposisi)->pegawai1)->nama,
            optional(optional($permohonan->disposisi)->pegawai2)->nama,
            optional(optional($permohonan->disposisi)->pegawai3)->nama,
            optional(optional($permohonan->disposisi)->pegawai4)->nama,
        ])->filter()->implode(', ');
        
        // Add tanggal_disposisi if it exists
        $disposisiInfo = $pegawaiList ?: 'Belum Diatur';
        
        if (!empty($pegawaiList) && !empty($permohonan->disposisi->tanggal_disposisi)) {
            $tanggalDisposisi = Carbon::parse($permohonan->disposisi->tanggal_disposisi)->format('d/m/Y');
            $disposisiInfo = $pegawaiList . ' (' . $tanggalDisposisi . ')';
        }

        return [
            $this->rowNumber++, // Gunakan $this->rowNumber, bukan static::$rowNumber
            $permohonan->id,
            Carbon::parse($permohonan->tanggal_diajukan)->format('d/m/Y'),
            $permohonan->kategori_berbayar == 'Nolrupiah' ? 'Nol Rupiah' : $permohonan->kategori_berbayar,
            $permohonan->jenisLayanan->nama_jenis_layanan,
            $permohonan->pemohon->nama_pemohon,
            $permohonan->pemohon->no_kontak,
            $permohonan->pemohon->instansi,
            $permohonan->deskripsi_keperluan,
            $disposisiInfo,
            $permohonan->tanggal_selesai ? Carbon::parse($permohonan->tanggal_selesai)->format('d/m/Y') : 'Belum Diatur',
            $permohonan->tanggal_diambil ? Carbon::parse($permohonan->tanggal_diambil)->format('d/m/Y') : 'Belum Diatur',
            $permohonan->tanggal_rencana ? Carbon::parse($permohonan->tanggal_rencana)->format('d/m/Y') : 'Belum Diatur',
            $permohonan->tanggal_pengumpulan ? Carbon::parse($permohonan->tanggal_pengumpulan)->format('d/m/Y') : 'Belum Diatur',
            $permohonan->status_permohonan,
        ];
    }

    public function title(): string
    {
        return 'Tahun ' . $this->year;
    }
}