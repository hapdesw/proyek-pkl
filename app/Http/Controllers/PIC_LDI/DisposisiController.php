<?php

namespace App\Http\Controllers\PIC_LDI;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DisposisiController extends Controller
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
            'pemohon',
            'jenisLayanan' 
        ]);
        
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
                  })
                  
                  // Cari berdasarkan disposisi (pegawai1, pegawai2, pegawai3, pegawai4)
                  ->orWhereHas('disposisi', function($query) use ($searchTerm) {
                      $query->whereHas('pegawai1', function($q) use ($searchTerm) {
                          $q->where('nama', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('pegawai2', function($q) use ($searchTerm) {
                          $q->where('nama', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('pegawai3', function($q) use ($searchTerm) {
                          $q->where('nama', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('pegawai4', function($q) use ($searchTerm) {
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

        // Filter berdasarkan disposisi
        if ($request->has('disposisi') && !empty($request->query('disposisi'))) {
            $disposisiFilter = $request->query('disposisi');

            if ($disposisiFilter === 'sudah') {
                // Hanya tampilkan permohonan yang sudah memiliki disposisi
                $query->whereHas('disposisi', function ($q) {
                    $q->whereNotNull('nip_pegawai1')
                    ->orWhereNotNull('nip_pegawai2')
                    ->orWhereNotNull('nip_pegawai3')
                    ->orWhereNotNull('nip_pegawai4');
                });
            } elseif ($disposisiFilter === 'belum') {
                // Hanya tampilkan permohonan yang belum memiliki disposisi
                $query->whereDoesntHave('disposisi');
            }
        }

        $permohonan = $query->paginate(15);
        return view('pic-ldi.disposisi', compact('permohonan'));
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
        $pegawai = Pegawai::all();
        return view('pic-ldi.atur-disposisi', compact('permohonan', 'pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'nip_pegawai.0' => 'required|distinct|exists:pegawai,nip',
            'nip_pegawai.*' => 'nullable|distinct|exists:pegawai,nip',
            'tanggal_disposisi' => 'required|date',
        ], [
            'nip_pegawai.0.required' => 'Pegawai 1 harus diisi.',
            'nip_pegawai.*.distinct' => 'Setiap pegawai harus berbeda.',
        ]);
        DB::beginTransaction();
    
        try {
            Disposisi::create([
                'id_permohonan' => $id,
                'nip_pegawai1' => $request->nip_pegawai[0],
                'nip_pegawai2' => $request->nip_pegawai[1] ?? null,
                'nip_pegawai3' => $request->nip_pegawai[2] ?? null,
                'nip_pegawai4' => $request->nip_pegawai[3] ?? null,
                'tanggal_disposisi' => $request->tanggal_disposisi,
                'created_at' => now()
            ]);

            DB::commit();
    
            return redirect()->route('pic-ldi.disposisi')->with('success', 'Disposisi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() === "23000") {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'Disposisi untuk permohonan ini sudah dibuat.']);
            }
            Log::error('Error saat menyimpan disposisi: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan disposisi. ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $pegawai = Pegawai::all();
        $disposisi = Disposisi::where('id_permohonan', $id)->first();
        return view('pic-ldi.edit-disposisi', compact('permohonan', 'pegawai', 'disposisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip_pegawai.0' => 'required|distinct|exists:pegawai,nip',
            'nip_pegawai.*' => 'nullable|distinct|exists:pegawai,nip',
            'tanggal_disposisi' => 'required|date',
        ], [
            'nip_pegawai.0.required' => 'Pegawai 1 harus diisi.',
            'nip_pegawai.*.distinct' => 'Setiap pegawai harus berbeda.',
        ]);

        DB::beginTransaction();
    
        try {
            $disposisi = Disposisi::where('id_permohonan', $id)->firstOrFail();
            $disposisi->update([
                'nip_pegawai1' => $request->nip_pegawai[0],
                'nip_pegawai2' => $request->nip_pegawai[1] ?? null,
                'nip_pegawai3' => $request->nip_pegawai[2] ?? null,
                'nip_pegawai4' => $request->nip_pegawai[3] ?? null,
                'tanggal_disposisi' => $request->tanggal_disposisi,
                'updated_at' => now()
            ]);

            DB::commit();
    
            return redirect()->route('pic-ldi.disposisi')->with('success', 'Disposisi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan disposisi: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui disposisi. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $disposisi = Disposisi::where('id_permohonan', $id)->first();
            $disposisi->delete(); 
            
            DB::commit();
            
            return redirect()->route('pic-ldi.disposisi')->with('success', 'Disposisi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus disposisi. ' . $e->getMessage()]);
        }
    }
}
