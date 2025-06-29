<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Kuitansi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KuitansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permohonan = Permohonan::where('kategori_berbayar', 'Berbayar')->paginate(15);
        
        // Query dasar dengan filter 
        $query = Permohonan::where('kategori_berbayar', 'Berbayar')
            ->with(['kuitansi']);

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

        // Filter berdasarkan kuitansi
        if ($request->has('kuitansi') && !empty($request->query('kuitansi'))) {
            $kuitansiFilter = $request->query('kuitansi');

            if ($kuitansiFilter === 'sudah') {
                // Hanya tampilkan permohonan yang sudah memiliki kuitansi
                $query->whereHas('kuitansi', function ($q) {
                    $q->whereNotNull('nama_file_kuitansi')
                      ->whereNotNull('path_file_kuitansi');
                });
            } elseif ($kuitansiFilter === 'belum') {
                // Hanya tampilkan permohonan yang belum memiliki kuitansi
                $query->whereDoesntHave('kuitansi');
            }
        }

        // Paginate hasil query
        $permohonan = $query->paginate(15);

        return view('bendahara.kuitansi', compact('permohonan'));
    }

    public function getAvailableYears()
    {
        Log::info('getAvailableYears dipanggil');

        $years = Permohonan::selectRaw('DISTINCT YEAR(tanggal_diajukan) AS year')
            ->orderBy('year', 'DESC')
            ->pluck('year')
            ->toArray();

        Log::info('Data tahun yang ditemukan:', $years);

        return response()->json($years);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('bendahara.create-kuitansi', compact('permohonan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_kuitansi' => 'required|mimes:pdf,doc,docx|max:10240',
            'kode_permohonan' => 'required|exists:permohonan,kode_permohonan' // Validasi kode permohonan
        ]);

        DB::beginTransaction();

        try{
            // Cari permohonan berdasarkan kode
            $permohonan = DB::table('permohonan')
                        ->where('kode_permohonan', $request->kode_permohonan)
                        ->first();

            if (!$permohonan) {
                throw new \Exception('Permohonan tidak ditemukan');
            }
            if ($request->hasFile('file_kuitansi') && $request->file('file_kuitansi')->isValid()) {
                $file = $request->file('file_kuitansi');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('kuitansi', $filename, 'public');
    
                Kuitansi::create([
                    'id_permohonan' => $permohonan->id,
                    'nama_file_kuitansi' => $filename,
                    'path_file_kuitansi' => $path,
                    'created_at' => now()
                ]);

                DB::commit();
    
                return redirect()->route('bendahara.kuitansi')->with('success', 'File berhasil diunggah!');
            }
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'File gagal diunggah. ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('bendahara.edit-kuitansi', compact('permohonan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_kuitansi' => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        DB::beginTransaction();

        try{
            $kuitansi = Kuitansi::where('id_permohonan', $id)->firstOrFail();

            if ($request->hasFile('file_kuitansi') && $request->file('file_kuitansi')->isValid()) {
                if ($kuitansi->path_file_kuitansi && Storage::disk('public')->exists($kuitansi->path_file_kuitansi)) {
                    Storage::disk('public')->delete($kuitansi->path_file_kuitansi);
                }
                
                $file = $request->file('file_kuitansi');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('kuitansi', $filename, 'public');
    
                $kuitansi->update([
                    'nama_file_kuitansi' => $filename,
                    'path_file_kuitansi' => $path,
                    'updated_at' => now()
                ]);

                DB::commit();
    
                return redirect()->route('bendahara.kuitansi')->with('success', 'File berhasil diperbarui!');
            }
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'File gagal diperbarui. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $kuitansi = Kuitansi::where('id_permohonan', $id)->firstOrFail();

            if ($kuitansi->path_file_kuitansi && Storage::disk('public')->exists($kuitansi->path_file_kuitansi)) {
                Storage::disk('public')->delete($kuitansi->path_file_kuitansi);
            }

            $kuitansi->delete();

            DB::commit();

            return redirect()->route('bendahara.kuitansi')->with('success', 'Kuitansi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus kuitansi. ' . $e->getMessage()]);
        }
    }
}
