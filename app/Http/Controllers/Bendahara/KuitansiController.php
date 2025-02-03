<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Kuitansi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;

class KuitansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = Permohonan::where('kategori_berbayar', 'Berbayar')->paginate(15);
        return view('bendahara.kuitansi', compact('permohonan'));
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
            'file_kuitansi' => 'required|mimes:pdf|max:10240',
        ]);
        
        $permohonan = Permohonan::findOrFail($request->id_permohonan);

        if (!$permohonan->canUploadKuitansi()) {
            return redirect()->back()->with('error', 'Tagihan harus diunggah terlebih dahulu');
        }
        if ($request->hasFile('file_kuitansi') && $request->file('file_kuitansi')->isValid()) {
            $file = $request->file('file_kuitansi');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $path = $file->storeAs('kuitansi', $filename, 'public');

            Kuitansi::create([
                'id_permohonan' => $request->id_permohonan,
                'nama_file_kuitansi' => $filename,
                'path_file_kuitansi' => $path,
                'created_at' => now()
            ]);

            return redirect()->route('bendahara.kuitansi')->with('success', 'File berhasil diunggah!');
        }
        return redirect()->back()->with('error', 'File gagal diunggah. Pastikan file valid.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuitansi $kuitansi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuitansi $kuitansi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuitansi $kuitansi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuitansi $kuitansi)
    {
        //
    }
}
