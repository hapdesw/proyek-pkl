<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query dasar dengan filter 
        $query = Permohonan::where('kategori_berbayar', 'Berbayar')
            ->with(['tagihan']);

        // Pencarian berdasarkan input search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // Cari berdasarkan kolom di tabel permohonan
                $q->where('id', 'like', '%' . $searchTerm . '%')
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

        // Filter berdasarkan tagihan
        if ($request->has('tagihan') && !empty($request->query('tagihan'))) {
            $tagihanFilter = $request->query('tagihan');

            if ($tagihanFilter === 'sudah') {
                // Hanya tampilkan permohonan yang sudah memiliki tagihan
                $query->whereHas('tagihan', function ($q) {
                    $q->whereNotNull('nama_file_tagihan')
                      ->whereNotNull('path_file_tagihan');
                });
            } elseif ($tagihanFilter === 'belum') {
                // Hanya tampilkan permohonan yang belum memiliki tagihan
                $query->whereDoesntHave('tagihan');
            }
        }

        // Paginate hasil query
        $permohonan = $query->paginate(15);

        return view('bendahara.tagihan', compact('permohonan'));
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
        return view('bendahara.create-tagihan', compact('permohonan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_tagihan' => 'required|mimes:pdf|max:10240',
        ]);

        DB::beginTransaction();

        try{
            if ($request->hasFile('file_tagihan') && $request->file('file_tagihan')->isValid()) {
                $file = $request->file('file_tagihan');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('tagihan', $filename, 'public');
    
                Tagihan::create([
                    'id_permohonan' => $request->id_permohonan,
                    'nama_file_tagihan' => $filename,
                    'path_file_tagihan' => $path,
                    'created_at' => now()
                ]);

                DB::commit();
    
                return redirect()->route('bendahara.tagihan')->with('success', 'File berhasil diunggah!');
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
        return view('bendahara.edit-tagihan', compact('permohonan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'file_tagihan' => 'required|mimes:pdf|max:10240',
        ]);

        DB::beginTransaction();

        try{
            $tagihan = Tagihan::where('id_permohonan', $id)->firstOrFail();

            if ($request->hasFile('file_tagihan') && $request->file('file_tagihan')->isValid()) {
                if ($tagihan->path_file_tagihan && Storage::disk('public')->exists($tagihan->path_file_tagihan)) {
                    Storage::disk('public')->delete($tagihan->path_file_tagihan);
                }
                
                $file = $request->file('file_tagihan');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                $path = $file->storeAs('tagihan', $filename, 'public');
    
                $tagihan->update([
                    'nama_file_tagihan' => $filename,
                    'path_file_tagihan' => $path,
                    'updated_at' => now()
                ]);

                DB::commit();
    
                return redirect()->route('bendahara.tagihan')->with('success', 'File berhasil diperbarui!');
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
            $tagihan = Tagihan::where('id_permohonan', $id)->firstOrFail();

            if ($tagihan->path_file_tagihan && Storage::disk('public')->exists($tagihan->path_file_tagihan)) {
                Storage::disk('public')->delete($tagihan->path_file_tagihan);
            }

            $tagihan->delete();

            DB::commit();

            return redirect()->route('bendahara.tagihan')->with('success', 'Tagihan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus tagihan. ' . $e->getMessage()]);
        }
    }
}
