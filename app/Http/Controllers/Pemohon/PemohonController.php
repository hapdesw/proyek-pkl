<?php

namespace App\Http\Controllers\Pemohon;
use App\Http\Controllers\Controller;
use App\Models\Pemohon;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JenisLayanan;
use Illuminate\Support\Facades\Log;


class PemohonController extends Controller
{
    public function index()
    {
        $pemohon = Pemohon::select(
            'nama_pemohon',
            'instansi',
            DB::raw('ANY_VALUE(no_kontak) as no_kontak'),
            DB::raw('ANY_VALUE(email) as email')
        )
        ->groupBy('nama_pemohon', 'instansi')
        ->paginate(15);
    
        $pemohon->getCollection()->transform(function ($item) {
            // Ambil semua ID pemohon dengan nama & instansi yang sama
            $pemohonIDs = Pemohon::where('nama_pemohon', $item->nama_pemohon)
                        ->where('instansi', $item->instansi)
                        ->pluck('id'); // Mengambil semua id_pemohon
    
            // Hitung total permohonan berdasarkan semua id_pemohon yang sesuai
            $total_permohonan = Permohonan::whereIn('id_pemohon', $pemohonIDs)->count();
    
            return (object) [ // Pastikan dikembalikan sebagai object, bukan array
                'id' => $pemohonIDs->first(),
                'nama_pemohon' => $item->nama_pemohon,
                'instansi' => $item->instansi,
                'no_kontak' => $item->no_kontak,
                'email' => $item->email,
                'total_permohonan' => $total_permohonan,
            ];
        });
        $totalPemohon = Pemohon::distinct()->count('nama_pemohon');
    
        return view('admin.data-pemohon', compact('pemohon', 'totalPemohon'));
    }

    public function detail(Request $request, $id){
        // Ambil tahun terbaru dari tabel permohonan
        Log::info('Ini masuk fungsi detail pemohon');

        $pemohon = Pemohon::findOrFail($id);

        // Ambil semua ID pemohon dengan nama & instansi yang sama
        $pemohonIDs = Pemohon::where('nama_pemohon', $pemohon->nama_pemohon)
                    ->where('instansi', $pemohon->instansi)
                    ->pluck('id');

        // Ambil tahun terbaru dari permohonan ini
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
        
        // Ambil daftar tahun yang tersedia untuk dropdown filter
        // $tahunTersedia = Permohonan::selectRaw('YEAR(tanggal_diajukan) as tahun')
        //                 ->distinct()
        //                 ->orderBy('tahun', 'desc')
        //                 ->pluck('tahun');

        $tahunTersedia = Permohonan::whereIn('id_pemohon', $pemohonIDs)
                        ->selectRaw('YEAR(tanggal_diajukan) as tahun')
                        ->distinct()
                        ->orderBy('tahun', 'desc')
                        ->pluck('tahun');

         Log::info('Ini buat rekap pemohon');    
        // Menyiapkan array untuk menyimpan data rekap pemohon
        $rekapPerBulan = array_fill(0, 12, 0);

        Log::info('Ini hitung rekap looping');
        // Hitung Permohonan per bulan untuk Pemohon ini
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $rekapPerBulan['pemohon'][$bulan - 1] = Permohonan::whereIn('id_pemohon', $pemohonIDs)
                    ->whereYear('tanggal_diajukan', $tahun)    
                    ->whereMonth('tanggal_diajukan', $bulan)
                    ->count();
        }
        Log::info('Ini selesai hitung rekap looping');
        return view('admin.detail-pemohon', compact('tahunTersedia', 'tahun', 'pemohon', 'rekapPerBulan'));
    }

    public function berandaPemohon(){
        return view('pemohon.beranda-pemohon');
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $permohonanIDLast = Permohonan::latest('id')->value('id') ?? 0; //ini kalau belum ada data maka default 0 
        $nextID = $permohonanIDLast + 1;
        $jenisLayanan = JenisLayanan::all();
        return view('pemohon.create-permohonan', compact('nextID', 'jenisLayanan'));
    }

    /**
     * Store a wly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Mulai proses store');
        Log::info('Data request:', $request->all());
    
        try {
            $request->validate([
                'tgl_diajukan' => 'required|date',
                'kategori' => 'required|string',
                'jenis_layanan' => 'required|integer',
                'deskripsi' => 'required|string',
                'tgl_selesai' => 'nullable|date',
                'tgl_diambil' => 'nullable|date',
                'tgl_rencana' => 'nullable|date',
                'tgl_pengumpulan' => 'nullable|date',
                'nama_pemohon' => 'required|string',
                'instansi' => 'required|string',
                'no_hp' => 'required|string',
                'email' => 'nullable|email',
            ]);
            Log::info('Validasi berhasil');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal:', ['errors' => $e->errors()]);
            // Flash error message to session
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal membuat permohonan. ' . $e->getMessage()]);
        }
    
        // Proses data setelah validasi
        try {
            $pemohon = Pemohon::firstOrCreate([
                'nama_pemohon' => $request->nama_pemohon,
                'instansi' => $request->instansi,
                'no_kontak' => $request->no_hp,
                'email' => $request->email,
            ]);
    
            $permohonan = Permohonan::create([
                'tanggal_diajukan' => $request->tgl_diajukan,
                'kategori_berbayar' => $request->kategori,
                'id_jenis_layanan' => $request->jenis_layanan,
                'deskripsi_keperluan' => $request->deskripsi,
                'tanggal_selesai' => $request->tgl_selesai,
                'tanggal_diambil' => $request->tgl_diambil,
                'tanggal_rencana' => $request->tgl_rencana,
                'tanggal_pengumpulan' => $request->tgl_pengumpulan,
                'id_pemohon' => $pemohon->id,
            ]);
    
            session()->flash('success', 'Permohonan berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Gagal membuat permohonan: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat permohonan. ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
         // Ubah redirect berdasarkan asal route
        
        // if (str_contains($request->route()->getName(), 'pemohon')) {
        //     Log::info('Masuk sebagai Pemohon: Berhasil buat permohonan');
        //     return redirect()->route('pemohon.beranda')->with('success', 'Permohonan berhasil dibuat!');
        // }
        
        return redirect()->route('pemohon.beranda');
        
       
    }
}
