<?php

namespace App\Http\Controllers\Kapokja;

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
    public function index()
    {
        $permohonan = Permohonan::with(['disposisi.pegawai'])->get();
        return view('kapokja.disposisi', compact('permohonan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $pegawai = Pegawai::all();
        return view('kapokja.atur-disposisi', compact('permohonan', 'pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'nip_pegawai' => 'required|exists:pegawai,nip',
            'tanggal_disposisi' => 'required|date',
        ]);

        DB::beginTransaction();
    
        try {
            Disposisi::create([
                'id_permohonan' => $id,
                'nip_pegawai' => $request->nip_pegawai,
                'tanggal_disposisi' => $request->tanggal_disposisi,
                'created_at' => now()
            ]);

            DB::commit();
    
            return redirect()->route('kapokja.disposisi')->with('success', 'Disposisi berhasil ditambahkan.');
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
        return view('kapokja.edit-disposisi', compact('permohonan', 'pegawai', 'disposisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip_pegawai' => 'required|exists:pegawai,nip',
            'tanggal_disposisi' => 'required|date',
        ]);

        try {
            $disposisi = Disposisi::where('id_permohonan', $id)->firstOrFail();
            $disposisi->update([
                'nip_pegawai' => $request->nip_pegawai,
                'tanggal_disposisi' => $request->tanggal_disposisi,
            ]);

            return redirect()->route('kapokja.disposisi')->with('success', 'Disposisi berhasil diperbarui.');
        } catch (\Exception $e) {
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
            
            return redirect()->route('kapokja.disposisi')->with('success', 'Disposisi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus disposisi. ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Disposisi $disposisi)
    {
        //
    }
}
