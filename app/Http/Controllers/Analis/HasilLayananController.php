<?php

namespace App\Http\Controllers\Analis;

use App\Models\HasilLayanan;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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

    public function storeStatusKapokja(Request $request)
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

            return redirect()->route('kapokja.hasil-layanan')->with('success', 'Status berhasil diperbarui!');
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

    public function editStatusKapokja($id)
    {
        $permohonan = Permohonan::with('hasilLayanan')->findOrFail($id);
        return view('kapokja.edit-status-hasil', compact('permohonan'));
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

    public function updateStatusKapokja(Request $request)
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

            return redirect()->route('kapokja.hasil-layanan')->with('success', 'Status berhasil diperbarui!');
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

    public function destroyStatusKapokja($id)
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

            return redirect()->route('kapokja.hasil-layanan')->with('success', 'Status dan koreksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus status dan koreksi. ' . $e->getMessage()]);
        }
    }

}
