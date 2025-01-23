<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\Pegawai;
use App\Models\JenisLayanan;
use App\Models\Disposisi;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        // Menyiapkan array untuk menyimpan data rekap
        $rekapPerBulan = [
            'permohonan' => array_fill(0, 12, 0),
            'pemohon' => array_fill(0, 12, 0),
            'jenis_layanan_berbayar' => array_fill(0, 12, 0),
            'jenis_layanan_nol' => array_fill(0, 12, 0),
            'disposisi_per_pegawai' => []
        ];

        // Menghitung jumlah permohonan per bulan
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['permohonan'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)->count();
        }

        // Menghitung jumlah pemohon per bulan
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['pemohon'][$bulan - 1] = Pemohon::whereHas('permohonan', function ($query) use ($bulan) {
                $query->whereMonth('tanggal_diajukan', $bulan);
            })->count();
        }

       // Menghitung jumlah jenis layanan per bulan
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['jenis_layanan_berbayar'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                ->where('kategori_berbayar', 'Berbayar')
                ->count();
            
            $rekapPerBulan['jenis_layanan_nol'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                ->where('kategori_berbayar', 'Nolrupiah')
                ->count();
        }
        // Menghitung jumlah disposisi per pegawai per bulan
        $pegawaiList = Pegawai::all(); // Ambil seluruh pegawai
        foreach ($pegawaiList as $pegawai) {
            $disposisiPerPegawai = [];
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $disposisiPerPegawai[$bulan - 1] = Disposisi::whereMonth('tanggal_disposisi', $bulan)
                    ->where('nip_pegawai', $pegawai->nip)
                    ->count();
            }
            $rekapPerBulan['disposisi_per_pegawai'][$pegawai->nama] = $disposisiPerPegawai; // Menyimpan berdasarkan nama pegawai
        }


        return view('petugas.beranda-petugas', compact('rekapPerBulan'));
    }
}
