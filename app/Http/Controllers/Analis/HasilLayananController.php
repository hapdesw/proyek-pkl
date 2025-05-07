<?php

namespace App\Http\Controllers\Analis;

use App\Models\HasilLayanan;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class HasilLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil NIP analis dari pengguna yang login
        $nip_analis = Auth::user()->pegawai->nip;

        // Query dasar dengan filter 
        $query = Permohonan::whereHas('disposisi', function($query) use ($nip_analis) {
            $query->where('nip_pegawai1', $nip_analis)
                ->orWhere('nip_pegawai2', $nip_analis)
                ->orWhere('nip_pegawai3', $nip_analis)
                ->orWhere('nip_pegawai4', $nip_analis);
        })->with(['jenisLayanan', 'pemohon', 'hasilLayanan', 'disposisi']);

        // Pencarian berdasarkan input search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Cari berdasarkan kolom di tabel permohonan
                $q->where('id', 'like', '%' . $searchTerm . '%')
                  ->orWhere('kode_permohonan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tanggal_diajukan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi_keperluan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('kategori_berbayar', 'like', '%' . $searchTerm . '%')
                  ->orWhere('status_permohonan', 'like', '%' . $searchTerm . '%')
                  
                  // Cari berdasarkan data pemohon
                  ->orWhereHas('pemohon', function($query) use ($searchTerm) {
                      $query->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                            ->orWhere('instansi', 'like', '%' . $searchTerm . '%')
                            ->orWhere('no_kontak', 'like', '%' . $searchTerm . '%');
                  })
                  
                  // Cari berdasarkan jenis layanan
                  ->orWhereHas('jenisLayanan', function($query) use ($searchTerm) {
                      $query->where('nama_jenis_layanan', 'like', '%' . $searchTerm . '%');
                  })
                  
                  // Cari berdasarkan hasil layanan
                  ->orWhereHas('hasilLayanan', function($query) use ($searchTerm) {
                    $query->where('status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('koreksi', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('pegawai', function($q) use ($searchTerm) {
                            $q->where('nama', 'like', '%' . $searchTerm . '%');
                        });
                  });
            });
        }

        // Filter berdasarkan bulan jika ada
        if ($request->has('months') && !empty($request->query('months'))) {
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
        if ($request->has('year') && !empty($request->query('year'))) {
            $query->whereYear('tanggal_diajukan', $request->query('year'));
        }

        // Filter berdasarkan status hasil layanan
        if ($request->has('status') && !empty($request->query('status'))) {
            $statusFilter = $request->query('status');

            // Filter berdasarkan status di tabel hasil_layanan
            $query->whereHas('hasilLayanan', function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            });
        }

        // Paginate hasil query
        $permohonan = $query->paginate(15);

        return view('analis.hasil-layanan', compact('permohonan'));
    }

    public function indexPIC_LDI(Request $request)
    {
        // Query dasar dengan filter 
        $query = Permohonan::whereHas('disposisi')
            ->with(['jenisLayanan', 'pemohon', 'hasilLayanan', 'disposisi']);

        // Pencarian berdasarkan input search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Cari berdasarkan kolom di tabel permohonan
                $q->where('id', 'like', '%' . $searchTerm . '%')
                ->orWhere('kode_permohonan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('tanggal_diajukan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi_keperluan', 'like', '%' . $searchTerm . '%')
                  ->orWhere('kategori_berbayar', 'like', '%' . $searchTerm . '%')
                  ->orWhere('status_permohonan', 'like', '%' . $searchTerm . '%')
                  
                  // Cari berdasarkan data pemohon
                  ->orWhereHas('pemohon', function($query) use ($searchTerm) {
                      $query->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                            ->orWhere('instansi', 'like', '%' . $searchTerm . '%')
                            ->orWhere('no_kontak', 'like', '%' . $searchTerm . '%');
                  })
                  
                  // Cari berdasarkan jenis layanan
                  ->orWhereHas('jenisLayanan', function($query) use ($searchTerm) {
                      $query->where('nama_jenis_layanan', 'like', '%' . $searchTerm . '%');
                  })
                  
                  // Cari berdasarkan hasil layanan
                  ->orWhereHas('hasilLayanan', function($query) use ($searchTerm) {
                    $query->where('status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('koreksi', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('pegawai', function($q) use ($searchTerm) {
                            $q->where('nama', 'like', '%' . $searchTerm . '%');
                        });
                  });
            });
        }

        // Filter berdasarkan bulan jika ada
        if ($request->has('months') && !empty($request->query('months'))) {
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
        if ($request->has('year') && !empty($request->query('year'))) {
            $query->whereYear('tanggal_diajukan', $request->query('year'));
        }

        // Filter berdasarkan status hasil layanan
        if ($request->has('status') && !empty($request->query('status'))) {
            $statusFilter = $request->query('status');

            // Filter berdasarkan status di tabel hasil_layanan
            $query->whereHas('hasilLayanan', function ($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            });
        }

        // Paginate hasil query
        $permohonan = $query->paginate(15);

        return view('pic-ldi.hasil-layanan', compact('permohonan'));
    }

    public function getAvailableYears()
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return response()->json([]); 
        }

        // Ambil NIP analis dari pengguna yang login
        $nip_analis = Auth::user()->pegawai->nip;

        // Query untuk mengambil tahun yang unik dari permohonan yang terkait dengan nip_analis
        $years = Permohonan::whereHas('disposisi', function($query) use ($nip_analis) {
            $query->where('nip_pegawai1', $nip_analis)
                ->orWhere('nip_pegawai2', $nip_analis)
                ->orWhere('nip_pegawai3', $nip_analis)
                ->orWhere('nip_pegawai4', $nip_analis);
        })
        ->selectRaw('DISTINCT YEAR(tanggal_diajukan) AS year')
        ->orderBy('year', 'DESC')
        ->pluck('year') 
        ->toArray();

        Log::info('Data tahun yang ditemukan untuk nip_analis ' . $nip_analis . ':', $years);

        return response()->json($years);
    }

    public function getAvailableYearsPIC_LDI()
    {
        // Query untuk mengambil tahun yang unik dari permohonan 
        $years = Permohonan::whereHas('disposisi')
        ->selectRaw('DISTINCT YEAR(tanggal_diajukan) AS year')
        ->orderBy('year', 'DESC')
        ->pluck('year') 
        ->toArray();

        Log::info('Data tahun yang ditemukan' . ':', $years);

        return response()->json($years);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('analis.create-hasil-layanan', compact('permohonan'));
    }

    public function createStatusPIC_LDI($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('pic-ldi.atur-status-hasil', compact('permohonan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_hasil' => 'required|mimes:pdf|max:10240', 
        ]);

        DB::beginTransaction();

        try{
            if ($request->hasFile('file_hasil') && $request->file('file_hasil')->isValid()) {
                $file = $request->file('file_hasil');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('hasil_layanan', $filename, 'public');
    
                DB::table('hasil_layanan')->insert([
                    'id_permohonan' => $request->id_permohonan,
                    'nama_file_hasil' => $filename,
                    'path_file_hasil' => $path,
                    'pengunggah' => Auth::user()->pegawai->nip,
                    'created_at' => now(),
                    'updated_at' => null 
                ]);                
                
                DB::commit();

                return redirect()->route('analis.hasil-layanan')->with('success', 'File berhasil diunggah!');
            }
        } catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'File gagal diunggah. ' . $e->getMessage()]);
        }
    }

    public function storeStatusPIC_LDI(Request $request)
    {
        $request->validate([
            'id_permohonan' => 'required|exists:permohonan,id',
            'status' => 'required|in:revisi,disetujui',
            'koreksi' => 'nullable|required_if:status,revisi|max:500',
        ]);
        
        DB::beginTransaction();

        try{
            $hasilLayanan = HasilLayanan::where('id_permohonan', $request->id_permohonan)->first();
    
            if (!$hasilLayanan) {
                return redirect()->back()->with('error', 'Data hasil layanan tidak ditemukan.');
            }
    
            DB::table('hasil_layanan')
            ->where('id_permohonan', $request->id_permohonan)
            ->update([
                'status' => $request->status,
                'koreksi' => $request->status == 'revisi' ? $request->koreksi : null,
                'updated_at' => null
            ]);
            
            DB::commit();

            return redirect()->route('pic-ldi.hasil-layanan')->with('success', 'Status berhasil diperbarui!');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal mengatur status. ' . $e->getMessage()]);
        }
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('analis.edit-hasil-layanan', compact('permohonan'));
    }

    public function editStatusPIC_LDI($id)
    {
        $permohonan = Permohonan::with('hasilLayanan')->findOrFail($id);
        return view('pic-ldi.edit-status-hasil', compact('permohonan'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_hasil' => 'required|mimes:pdf|max:10240', 
        ]);

        DB::beginTransaction();

        try{
            $hasilLayanan = HasilLayanan::where('id_permohonan', $id)->firstOrFail();
    
            if ($request->hasFile('file_hasil') && $request->file('file_hasil')->isValid()) {
                if ($hasilLayanan->path_file_hasil && Storage::disk('public')->exists($hasilLayanan->path_file_hasil)) {
                    Storage::disk('public')->delete($hasilLayanan->path_file_hasil);
                }
    
                $file = $request->file('file_hasil');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('hasil_layanan', $filename, 'public');
    
                $hasilLayanan->update([
                    'nama_file_hasil' => $filename,
                    'path_file_hasil' => $path,
                    'pengunggah' => Auth::user()->pegawai->nip,
                    'updated_at' => now()
                ]);

                DB::commit();

                return redirect()->route('analis.hasil-layanan')->with('success', 'File berhasil diperbarui!');
            }
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'File gagal diperbarui. ' . $e->getMessage()]);
        }
    }

    public function updateStatusPIC_LDI(Request $request)
    {
        $request->validate([
            'id_permohonan' => 'required|exists:permohonan,id',
            'status' => 'required|in:revisi,disetujui',
            'koreksi' => 'nullable|required_if:status,revisi|max:500',
        ]);
        
        DB::beginTransaction();

        try{
            $hasilLayanan = HasilLayanan::where('id_permohonan', $request->id_permohonan)->first();
    
            if (!$hasilLayanan) {
                return redirect()->back()->with('error', 'Data hasil layanan tidak ditemukan.');
            }
    
            DB::table('hasil_layanan')
            ->where('id_permohonan', $request->id_permohonan)
            ->update([
                'status' => $request->status,
                'koreksi' => $request->status == 'revisi' ? $request->koreksi : null,
            ]);
            
            DB::commit();

            return redirect()->route('pic-ldi.hasil-layanan')->with('success', 'Status berhasil diperbarui!');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal mengatur status. ' . $e->getMessage()]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $hasilLayanan = HasilLayanan::where('id_permohonan', $id)->firstOrFail();

            if ($hasilLayanan->path_file_hasil && Storage::disk('public')->exists($hasilLayanan->path_file_hasil)) {
                Storage::disk('public')->delete($hasilLayanan->path_file_hasil);
            }

            $hasilLayanan->delete();

            DB::commit();

            return redirect()->route('analis.hasil-layanan')->with('success', 'Hasil layanan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus hasil layanan. ' . $e->getMessage()]);
        }
    }

    public function destroyStatusPIC_LDI($id)
    {
        DB::beginTransaction();
        try {
            $hasilLayanan = DB::table('hasil_layanan')->where('id_permohonan', $id)->first();

            if (!$hasilLayanan) {
                return redirect()->back()->withErrors(['error' => 'Data hasil layanan tidak ditemukan.']);
            }

            DB::table('hasil_layanan')
                ->where('id_permohonan', $id)
                ->update([
                    'status' => 'pending',
                    'koreksi' => null,
                ]);

            DB::commit();

            return redirect()->route('pic-ldi.hasil-layanan')->with('success', 'Status dan koreksi berhasil direset!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal mereset status dan koreksi. ' . $e->getMessage()]);
        }
    }

}
