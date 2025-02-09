<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = Permohonan::where('kategori_berbayar', 'Berbayar')->paginate(15);
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
