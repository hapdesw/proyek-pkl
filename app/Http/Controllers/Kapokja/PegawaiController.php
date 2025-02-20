<?php

namespace App\Http\Controllers\Kapokja;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::paginate(15);
        return view('kapokja.kelola-pegawai', compact('pegawai'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kapokja.create-pegawai');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip_pegawai' => 'required|digits:18|unique:pegawai,nip',
            'nama' => 'required|string|max:255',
            'peran' => 'required|array|max:2',
            'peran.*' => 'in:0100,0010,0001',
        ]);

        DB::beginTransaction(); 
    
        try {
            Pegawai::create([
                'nip' => $request->nip_pegawai,
                'nama' => $request->nama,
                'peran_pegawai' => str_pad(decbin(array_reduce($request->peran, function($carry, $item) {
                    $decimal = bindec($item);
                    Log::info('Conversion', [
                        'item' => $item, 
                        'decimal' => $decimal, 
                        'carry' => $carry
                    ]);
                    return $carry | bindec($item); 
                }, 0)), 4, '0', STR_PAD_LEFT), 
                'id_user' => null,
                'created_at' => now()
            ]);

            DB::commit();
    
            return redirect()->route('kapokja.kelola-pegawai')->with('success', 'Pegawai berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan pegawai: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan pegawai. ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nip)
    {
        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();
        return view('kapokja.edit-pegawai', compact('pegawai'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nip)
    {
        $pegawai = Pegawai::where('nip', $nip)->firstOrFail();
        
        $request->validate([
            'nip_pegawai' => 'required|digits:18|unique:pegawai,nip,' . $nip . ',nip',
            'nama' => 'required|string|max:255',
            'peran' => 'required|array|max:2',
            'peran.*' => 'in:0100,0010,0001',
        ]);

        DB::beginTransaction();
        try {
            $pegawai->update([
                'nip' => $request->nip_pegawai,
                'nama' => $request->nama,
                'peran_pegawai' => str_pad(decbin(array_reduce($request->peran, function($carry, $item) {
                    return $carry | bindec($item);
                }, 0)), 4, '0', STR_PAD_LEFT),
                'updated_at' => now()
            ]);

            DB::commit();
            return redirect()->route('kapokja.kelola-pegawai')->with('success', 'Data pegawai berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat memperbarui pegawai: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui data pegawai. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nip)
    {
        DB::beginTransaction();

        try {
            $pegawai = Pegawai::findOrFail($nip);
            $pegawai->delete();

            DB::commit();

            return redirect()->route('kapokja.kelola-pegawai')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus pegawai. ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }


}
