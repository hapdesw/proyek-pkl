<?php

namespace App\Http\Controllers\Analis;

use App\Models\HasilLayanan;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HasilLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $nip_analis = Auth::user()->pegawai->nip;
        } else {
            return redirect('/login');
        }
        
        $permohonan = Permohonan::whereHas('disposisi', function($query) use ($nip_analis) {
            $query->where('nip_pegawai1', $nip_analis)
                ->orWhere('nip_pegawai2', $nip_analis)
                ->orWhere('nip_pegawai3', $nip_analis)
                ->orWhere('nip_pegawai4', $nip_analis);
        })->with(['jenisLayanan', 'pemohon', 'hasilLayanan', 'disposisi'])->paginate(15);

        return view('analis.hasil-layanan', compact('permohonan'));
    }

    public function indexKapokja(Request $request)
    {
        $permohonan = Permohonan::whereHas('disposisi')
            ->with(['jenisLayanan', 'pemohon', 'hasilLayanan', 'disposisi'])
            ->paginate(15);
        return view('kapokja.hasil-layanan', compact('permohonan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('analis.create-hasil-layanan', compact('permohonan'));
    }

    public function createStatusKapokja($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('kapokja.atur-status-hasil', compact('permohonan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_hasil' => 'required|mimes:pdf|max:10240', 
        ]);

        if ($request->hasFile('file_hasil') && $request->file('file_hasil')->isValid()) {
            $file = $request->file('file_hasil');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $path = $file->storeAs('hasil_layanan', $filename, 'public');

            HasilLayanan::create([
                'id_permohonan' => $request->id_permohonan,
                'nama_file_hasil' => $filename,
                'path_file_hasil' => $path,
                'pengunggah' => Auth::user()->pegawai->nip,
                'created_at' => now()
            ]);

            return redirect()->route('analis.hasil-layanan')->with('success', 'File berhasil diunggah!');
        }
        return redirect()->back()->with('error', 'File gagal diunggah. Pastikan file valid.');
    }

    public function storeStatusKapokja(Request $request)
    {
        $request->validate([
            'id_permohonan' => 'required|exists:permohonan,id',
            'status' => 'required|in:revisi,disetujui',
            'koreksi' => 'nullable|required_if:status,revisi|max:500',
        ]);
        
        $hasilLayanan = HasilLayanan::where('id_permohonan', $request->id_permohonan)->first();

        if (!$hasilLayanan) {
            return redirect()->back()->with('error', 'Data hasil layanan tidak ditemukan.');
        }

        $hasilLayanan->update([
            'status' => $request->status,
            'koreksi' => $request->status == 'revisi' ? $request->koreksi : null,
        ]);

        return redirect()->route('kapokja.hasil-layanan')->with('success', 'Status berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HasilLayanan $hasilLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilLayanan $hasilLayanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HasilLayanan $hasilLayanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilLayanan $hasilLayanan)
    {
        //
    }
}
