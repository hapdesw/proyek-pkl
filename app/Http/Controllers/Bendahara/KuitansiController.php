<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Kuitansi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        DB::beginTransaction();

        try{
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
            'file_kuitansi' => 'required|mimes:pdf|max:10240',
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
