<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JenisLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $jenislayanan = JenisLayanan::paginate(15); 
        return view('admin.kelola-jenis-layanan', compact('jenislayanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenislayanan = JenisLayanan::all();
        return view('admin.kelola-jenis-layanan', compact('jenislayanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_layanan' => 'required|string',
        ]);

        JenisLayanan::create([
            'nama_jenis_layanan' => $request->nama_jenis_layanan,
        ]);
        // route ke halaman index-nya 
        return redirect()->route('admin.kelola-layanan')->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisLayanan $jenisLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisLayanan $jenisLayanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validasi data
        $request -> validate([
        'nama_jenis_layanan' => 'required|string',
        ]);

        //update data
        JenisLayanan::find($id)->update([
            'nama_jenis_layanan' => $request->nama_jenis_layanan,
        ]);

        //route ke halaman index-nya
        return redirect()->route('admin.kelola-layanan')->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $jenislayanan = JenisLayanan::findOrFail($id);
            $jenislayanan->delete();
            return redirect()->route('admin.kelola-layanan')->with('success', 'Layanan berhasil dihapus!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.kelola-layanan')->with('error', 'Layanan tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.kelola-layanan')->with('error', 'Terjadi kesalahan saat menghapus layanan.');
        }
    }

}
