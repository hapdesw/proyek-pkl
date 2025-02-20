<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\Pegawai;
use App\Models\JenisLayanan;
use App\Models\Disposisi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Menyiapkan array untuk menyimpan data rekap
        $rekapPerBulan = [
            'permohonan' => array_fill(0, 12, 0),
            'pemohon' => array_fill(0, 12, 0),
            'jenis_layanan_berbayar' => array_fill(0, 12, 0),
            'jenis_layanan_nol' => array_fill(0, 12, 0),
            'disposisi_per_pegawai' => [],
            'jenis_layanan_nama' => [],
            'status_diproses' => array_fill(0, 12, 0), 
            'status_selesai_dibuat' => array_fill(0, 12, 0),
            'status_selesai_diambil' => array_fill(0, 12, 0),
            'status_batal' => array_fill(0, 12, 0),
        ];

        // Menghitung jumlah permohonan per bulan
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['permohonan'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)->count();
        }

       // Menyiapkan set untuk menyimpan pemohon unik yang sudah terhitung
        $uniquePemohon = [];

        // Loop setiap bulan untuk menghitung permohonan dan pemohon unik
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Hitung jumlah permohonan di bulan ini
            $rekapPerBulan['permohonan'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)->count();

            // Ambil daftar pemohon yang mengajukan permohonan di bulan ini
            $pemohonBulanIni = Pemohon::whereHas('permohonan', function ($query) use ($bulan) {
                $query->whereMonth('tanggal_diajukan', $bulan);
            })->get();

            // Hitung hanya pemohon yang belum pernah muncul sebelumnya
            $newPemohonCount = 0;
            foreach ($pemohonBulanIni as $pemohon) {
                // Gunakan kombinasi nama & instansi sebagai identitas unik pemohon
                $identifier = strtolower(trim($pemohon->nama)) . '|' . strtolower(trim($pemohon->instansi));

                if (!in_array($identifier, $uniquePemohon)) {
                    $uniquePemohon[] = $identifier;
                    $newPemohonCount++;
                }
            }

            // Simpan jumlah pemohon baru di bulan ini
            $rekapPerBulan['pemohon'][$bulan - 1] = $newPemohonCount;
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

        // Menghitung disposisi
        $pegawaiList = Pegawai::all(); // Ambil seluruh pegawai
        foreach ($pegawaiList as $pegawai) {
            $disposisiPerPegawai = [];
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $disposisiPerPegawai[$bulan - 1] = Disposisi::whereMonth('tanggal_disposisi', $bulan)
                    ->where(function($query) use ($pegawai) {
                        $query->where('nip_pegawai1', $pegawai->nip)
                            ->orWhere('nip_pegawai2', $pegawai->nip)
                            ->orWhere('nip_pegawai3', $pegawai->nip);
                    })
                    ->count();
            }
            $rekapPerBulan['disposisi_per_pegawai'][$pegawai->nama] = $disposisiPerPegawai; // Menyimpan berdasarkan nama pegawai
        }

        // Menghitung nama jenis layanan
        $namaLayanan = JenisLayanan::all();
        foreach ($namaLayanan as $layanan) {
            $namaPerLayanan = [];
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $namaPerLayanan[$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                    ->where(function($query) use ($layanan) {
                        $query->where('id_jenis_layanan', $layanan-> id);
                           
                    })
                    ->count();
            }
            $rekapPerBulan['jenis_layanan_nama'][$layanan->nama_jenis_layanan] = $namaPerLayanan;
        }

         // Menghitung jumlah status permohonan
         for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['status_diproses'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Diproses')
                ->count();
            
            $rekapPerBulan['status_selesai_dibuat'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Selesai Dibuat')
                ->count();
            
            $rekapPerBulan['status_selesai_diambil'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Selesai Diambil')
                ->count();

            $rekapPerBulan['status_batal'][$bulan - 1] = Permohonan::whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Batal')
                ->count();
        }


        return view('admin.beranda-admin', compact('rekapPerBulan'));
    }
    
    
}
