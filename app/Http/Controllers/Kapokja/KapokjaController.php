<?php

namespace App\Http\Controllers\Kapokja;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\Pegawai;
use App\Models\JenisLayanan;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KapokjaController extends Controller
{
    public function index(Request $request)
    {
       // Ambil tahun terbaru dari tabel permohonan
        $tahunTerbaru = DB::table('permohonan')
        ->select(DB::raw('YEAR(tanggal_diajukan) as tahun'))
        ->orderBy('tanggal_diajukan', 'desc')
        ->value('tahun');

        // Jika tidak ada data permohonan, gunakan tahun sekarang sebagai fallback
        if (!$tahunTerbaru) {
        $tahunTerbaru = date('Y');
        }

        // Ambil tahun dari request, default ke tahun terbaru dari permohonan
        $tahun = $request->input('tahun', $tahunTerbaru);

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

        // Menghitung permohonan dengan filter tahun
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['permohonan'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->count();
        }

        // Hitung Rekap Pemohon dengan filter tahun
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['pemohon'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->count();
        }

        // Hitung jenis layanan dengan filter tahun
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['jenis_layanan_berbayar'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->where('kategori_berbayar', 'Berbayar')
                ->count();
            
            $rekapPerBulan['jenis_layanan_nol'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->where('kategori_berbayar', 'Nolrupiah')
                ->count();
        }

         // Hitung disposisi dengan filter tahun (berdasarkan tanggal_diajukan di permohonan)
         $pegawaiList = Pegawai::all();
         foreach ($pegawaiList as $pegawai) {
             $disposisiPerPegawai = [];
             for ($bulan = 1; $bulan <= 12; $bulan++) {
                 $disposisiPerPegawai[$bulan - 1] = Disposisi::join('permohonan', 'disposisi.id_permohonan', '=', 'permohonan.id')
                     ->whereYear('permohonan.tanggal_diajukan', $tahun)
                     ->whereMonth('permohonan.tanggal_diajukan', $bulan)
                     ->where(function($query) use ($pegawai) {
                         $query->where('nip_pegawai1', $pegawai->nip)
                               ->orWhere('nip_pegawai2', $pegawai->nip)
                               ->orWhere('nip_pegawai3', $pegawai->nip);
                     })
                     ->count();
             }
             $rekapPerBulan['disposisi_per_pegawai'][$pegawai->nama] = $disposisiPerPegawai;
         }

        // Hitung jenis layanan dengan filter tahun
        $namaLayanan = JenisLayanan::all();
        foreach ($namaLayanan as $layanan) {
            $namaPerLayanan = [];
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $namaPerLayanan[$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                    ->whereMonth('tanggal_diajukan', $bulan)
                    ->where('id_jenis_layanan', $layanan->id)
                    ->count();
            }
            $rekapPerBulan['jenis_layanan_nama'][$layanan->nama_jenis_layanan] = $namaPerLayanan;
        }

        // Hitung status permohonan dengan filter tahun
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['status_diproses'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Diproses')
                ->count();
            
            $rekapPerBulan['status_selesai_dibuat'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Selesai Dibuat')
                ->count();
            
            $rekapPerBulan['status_selesai_diambil'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Selesai Diambil')
                ->count();

            $rekapPerBulan['status_batal'][$bulan - 1] = Permohonan::whereYear('tanggal_diajukan', $tahun)
                ->whereMonth('tanggal_diajukan', $bulan)
                ->where('status_permohonan', 'Batal')
                ->count();
        }

        // Ambil daftar tahun yang tersedia untuk dropdown filter
        $tahunTersedia = Permohonan::selectRaw('YEAR(tanggal_diajukan) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('kapokja.beranda-kapokja', compact('rekapPerBulan', 'tahun', 'tahunTersedia'));
    }

    public function getAvailableYears()
    {
        Log::info('getAvailableYears dipanggil'); // Log saat method ini dipanggil
        // dd('Controller getAvailableYears dipanggil');

        $years = Permohonan::selectRaw('DISTINCT YEAR(tanggal_diajukan) AS year')
            ->orderBy('year', 'DESC')
            ->pluck('year')
            ->toArray();

        Log::info('Data tahun yang ditemukan:', $years); // Log hasil query

        return response()->json($years);
    }
}