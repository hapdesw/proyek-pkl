<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\Disposisi;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Permohonan::with([
        'disposisi.pegawai1', 
        'disposisi.pegawai2', 
        'disposisi.pegawai3', 
        'disposisi.pegawai4', 
    ]);

    // Filter berdasarkan bulan jika ada
    if ($request->has('months')) {
        $months = explode(',', $request->query('months'));
        $monthNumbers = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
        ];
        $selectedMonths = array_map(fn($m) => $monthNumbers[strtolower($m)] ?? null, $months);
        $query->whereIn(DB::raw('MONTH(tanggal_diajukan)'), $selectedMonths);
    }

    // Filter berdasarkan tahun jika ada
    if ($request->has('year')) {
        $query->whereYear('tanggal_diajukan', $request->query('year'));
    }

    $permohonan = $query->paginate(15);
    $pemohon = Pemohon::all();

    return view('admin.permohonan', compact('permohonan', 'pemohon'));
}

    
    public function filter(Request $request)
    {
        Log::info('masuk fungsi filter');
        $months = explode(',', $request->query('months'));
        $year = $request->query('year');
    
        // Mapping nama bulan ke angka (1-12)
        $monthNumbers = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12
        ];
    
        // Konversi nama bulan ke angka
        $selectedMonths = array_map(fn($m) => $monthNumbers[strtolower($m)] ?? null, $months);
    
        // Query untuk filter
        $query = Permohonan::query();
    
        // Filter berdasarkan bulan jika ada
        Log::info('filter bulan masuk');
        if (!empty($selectedMonths)) {
            $query->whereIn(DB::raw('MONTH(tanggal_diajukan)'), $selectedMonths);
        }
    
        // Filter berdasarkan tahun jika ada
        if ($year) {
            
            $query->whereYear('tanggal_diajukan', $year);
        }
    
        $permohonan = $query->get();
    
        return response()->json($permohonan);
    }
    
    
    // Controller untuk mendapatkan daftar tahun yang ada di database
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $permohonanIDLast = Permohonan::latest('id')->value('id') ?? 0; //ini kalau belum ada data maka default 0 
        $nextID = $permohonanIDLast + 1;
        $jenisLayanan = JenisLayanan::all();
        return view('admin.create-permohonan', compact('nextID', 'jenisLayanan'));
    }

    /**
     * Store a newly created resource in storage.
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
    
        return redirect()->route('admin.permohonan');
    }
    



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $permohonan = Permohonan::find($id); 
        $permohonanIDLast = Permohonan::latest('id')->value('id') ?? 0; //ini kalau belum ada data maka default 0 
        $nextID = $permohonanIDLast + 1;
        // $permohonanList = Permohonan::orderBy('id')->get();
        // $nextID = $permohonanList->count() + 1; // Hitung jumlah permohonan yang ada dan tambah 1
        $jenisLayanan = JenisLayanan::all();
        $pemohon = Pemohon::all();

        return view('admin.edit-permohonan', compact('permohonan', 'nextID','jenisLayanan', 'pemohon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('Masuk ke method update');
        
        try {
           
            // Jika request tidak hanya berisi tanggal, lakukan update penuh
            Log::info('Validasi update penuh');
            $request->validate([
                'tgl_diajukan' => 'required|date',
                'kategori' => 'required|string',
                'jenis_layanan' => 'required|integer',
                'deskripsi' => 'required|string',
                'tgl_selesai_dibuat' => 'nullable|date',
                'tgl_selesai_diambil' => 'nullable|date',
                'rencana_pengumpulan' => 'nullable|date',
                'tgl_pengumpulan' => 'nullable|date',
                
                // Validasi data pemohon
                'nama_pemohon' => 'required|string',
                'instansi' => 'required|string',
                'no_hp' => 'required|string',
                'email' => 'nullable|email',
            ]);
            Log::info('Validasi update berhasil');
        } catch (\Exception $e) {
            Log::error('Validasi update gagal:', ['errors' => $e->getMessage()]);
            return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'Gagal memperbaharui permohonan. ' . $e->getMessage()]);
        }

        Log::info('Validasi masuk update data pemohon dan permohonan');

        // Proses update data
        try {
            // Cari permohonan berdasarkan ID
            $permohonan = Permohonan::findOrFail($id);

            // Ambil data pemohon yang terkait melalui relasi
            $pemohon = $permohonan->pemohon;

            // Update data pemohon
            $pemohon->update([
                'nama_pemohon' => $request->nama_pemohon,
                'instansi' => $request->instansi,
                'no_kontak' => $request->no_hp,
                'email' => $request->email,
            ]);

            // Update data permohonan
            $permohonan->update([
                'tanggal_diajukan' => $request->tgl_diajukan,
                'kategori_berbayar' => $request->kategori,
                'id_jenis_layanan' => $request->jenis_layanan,
                'deskripsi_keperluan' => $request->deskripsi,
                'tanggal_selesai' => $request->tgl_selesai_dibuat,
                'tanggal_diambil' => $request->tgl_selesai_diambil,
                'tanggal_rencana' => $request->rencana_pengumpulan,
                'tanggal_pengumpulan' => $request->tgl_pengumpulan,
            ]);

            // Tentukan status permohonan
            $status = 'Diproses'; // Default status

            // Periksa jika tanggal selesai dibuat diisi
            if ($request->has('tgl_selesai_dibuat') && $request->tgl_selesai_dibuat) {
                // Update status menjadi 'Selesai Dibuat'
                $status = 'Selesai Dibuat';
            }

            // Periksa jika tanggal selesai diambil diisi
            if ($request->has('tgl_selesai_diambil') && $request->tgl_selesai_diambil) {
                // Update status menjadi 'Selesai Diambil'
                $status = 'Selesai Diambil';
            }

            // Update status permohonan
            $permohonan->update([
                'status_permohonan' => $status,
            ]);

            Log::info('Berhasil update data permohonan');
            return redirect()->route('admin.permohonan')->with('success', 'Permohonan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui permohonan. ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    Log::Info('Masuk ke method destroy');
    try {
        $permohonan = Permohonan::findOrFail($id);
        $pemohon = $permohonan->pemohon; // Ambil pemohon yang terkait sebelum menghapus permohonan

        if ($pemohon) {
            $pemohon->delete(); // Hapus pemohon terkait
        }

        $permohonan->delete(); // Hapus permohonan

        Log::info('Berhasil hapus permohonan dan pemohon terkait.');

        return redirect()->route('admin.permohonan')->with('success', 'Permohonan dan pemohon terkait berhasil dihapus!');
    } catch (ModelNotFoundException $e) {
        Log::error('Permohonan tidak ditemukan: ' . $e->getMessage());
        return redirect()->route('admin.permohonan')->with('error', 'Permohonan tidak ditemukan.');
    } catch (\Exception $e) {
        Log::error('Gagal menghapus permohonan: ' . $e->getMessage());
        return redirect()->route('admin.permohonan')->with('error', 'Terjadi kesalahan saat menghapus permohonan.');
    }
}


    public function updateStatus(Request $request, $id)
    {
        $status = $request->status; // Ambil status dari body request
        $permohonan = Permohonan::find($id);

        if ($permohonan) {
            // Update status permohonan
            $permohonan->status_permohonan = $status;
            $permohonan->save();
            Log::info("Status permohonan dengan ID $id diperbarui menjadi '$status'.");

            // Kembalikan respons JSON
            return response()->json(['success' => true, 'message' => 'Status permohonan berhasil diperbarui']);
        }

        return response()->json(['success' => false, 'message' => 'Permohonan tidak ditemukan'], 404);
    }


    
}
