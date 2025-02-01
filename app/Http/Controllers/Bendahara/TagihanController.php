<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = Permohonan::where('kategori_berbayar', 'Berbayar')->get();
        return view('bendahara.tagihan', compact('permohonan'));
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

            return redirect()->route('bendahara.tagihan')->with('success', 'File berhasil diunggah!');
        }
        return redirect()->back()->with('error', 'File gagal diunggah. Pastikan file valid.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $tagihan)
    {
        //
    }
}
