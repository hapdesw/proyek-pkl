<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = Permohonan::all();
        $pemohon = Pemohon::all();
        return view('petugas.permohonan', compact('permohonan', 'pemohon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $permohonanIDLast = Permohonan::latest('id')->value('id') ?? 0; //ini kalau belum ada data maka default 0 
        $nextID = $permohonanIDLast + 1;
        $jenisLayanan = JenisLayanan::all();
        return view('petugas.create-permohonan', compact('nextID', 'jenisLayanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Mulai proses store');
        Log::info('Data request:', $request->all());
    
        try {
            $request->validate([
                'tgl_diajukan' => 'required|date',
                'kategori' => 'required|string',
                'jenis_layanan' => 'required|integer',
                'deskripsi' => 'required|string',
                'tgl_selesai' => 'nullable|date',
                'tgl_diambil' => 'nullable|date',
                'nama_pemohon' => 'required|string',
                'instansi' => 'required|string',
                'no_hp' => 'required|string',
                'email' => 'nullable|email',
            ]);
            Log::info('Validasi berhasil');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal:', ['errors' => $e->errors()]);
            // Flash error message to session
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal membuat permohonan. ' . $e->getMessage()]);
        }
    
        // Proses data setelah validasi
        try {
            $pemohon = Pemohon::firstOrCreate([
                'nama_pemohon' => $request->nama_pemohon,
                'instansi' => $request->instansi,
                'no_kontak' => $request->no_hp,
                'email' => $request->email,
            ]);
    
            $permohonan = Permohonan::create([
                'tanggal_diajukan' => $request->tgl_diajukan,
                'kategori_berbayar' => $request->kategori,
                'id_jenis_layanan' => $request->jenis_layanan,
                'deskripsi_keperluan' => $request->deskripsi,
                'tanggal_selesai' => $request->tgl_selesai,
                'tanggal_diambil' => $request->tgl_diambil,
                'id_pemohon' => $pemohon->id,
            ]);
    
            session()->flash('success', 'Permohonan berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Gagal membuat permohonan: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat permohonan. ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    
        return redirect()->route('petugas.permohonan');
    }
    



    /**
     * Display the specified resource.
     */
    public function show(Permohonan $permohonan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $permohonan = Permohonan::find($id); 
        $permohonanIDLast = Permohonan::latest('id')->value('id') ?? 0; //ini kalau belum ada data maka default 0 
        $nextID = $permohonanIDLast + 1;
        $jenisLayanan = JenisLayanan::all();
        $pemohon = Pemohon::all();

        return view('petugas.edit-permohonan', compact('permohonan', 'nextID', 'jenisLayanan', 'pemohon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    Log::info('Masuk ke method update');
    
    // Validasi data
    try {
        $request->validate([
            'tgl_diajukan' => 'required|date',
            'kategori' => 'required|string',
            'jenis_layanan' => 'required|integer',
            'deskripsi' => 'required|string',
            'tgl_selesai' => 'nullable|date',
            'tgl_diambil' => 'nullable|date',
            
            // Validasi data pemohon
            'nama_pemohon' => 'required|string',
            'instansi' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'nullable|email',
        ]);
        Log::info('Validasi update berhasil');
    } catch (\Exception $e) {
        Log::error('Validasi update gagal:', ['errors' => $e->getMessage()]);
        return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbaharui permohonan. ' . $e->getMessage()]);
    }

    Log::info('Validasi masuk update data pemohon dan permohonan');

    // Proses update data
    try {
        // Cari permohonan berdasarkan ID
        $permohonan = Permohonan::findOrFail($id);

        // Ambil data pemohon yang terkait melalui relasi
        $pemohon = $permohonan->pemohon;

        // Update data pemohon
        $pemohon->update([
            'nama_pemohon' => $request->nama_pemohon,
            'instansi' => $request->instansi,
            'no_kontak' => $request->no_hp,
            'email' => $request->email,
        ]);

        // Update data permohonan
        $permohonan->update([
            'tanggal_diajukan' => $request->tgl_diajukan,
            'kategori_berbayar' => $request->kategori,
            'id_jenis_layanan' => $request->jenis_layanan,
            'deskripsi_keperluan' => $request->deskripsi,
            'tanggal_selesai' => $request->tgl_selesai,
            'tanggal_diambil' => $request->tgl_diambil,
        ]);

        Log::info('Berhasil update data permohonan');
        return redirect()->route('petugas.permohonan')->with('success', 'Permohonan berhasil diperbarui!');
    } catch (\Exception $e) {
        Log::error('Gagal memperbarui data: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Gagal memperbarui permohonan. ' . $e->getMessage()]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::Info('Masuk ke method destroy');
        try {
            $permohonan = Permohonan::findOrFail($id);
            $permohonan->delete();
            Log::info('Berhasil hapus permohonan');
            Log::info('Flash message:', session()->all());

            return redirect()->route('petugas.permohonan')->with('success', 'Permohonan berhasil dihapus!');
        } catch (ModelNotFoundException $e) {
            Log::error('Tidak ditemukan permohonan. Penghapusan gagal: ' . $e->getMessage());
            Log::info('Redirecting with flash message:', session()->all());
            // return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menghapus permohonan. ' . $e->getMessage()]);
            return redirect()->route('petugas.permohonan')->with('error', 'Permohonan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus permohonan: ' . $e->getMessage());
            Log::info('Flash message:', session()->all());

            return redirect()->route('petugas.permohonan')->with('error', 'Terjadi kesalahan saat menghapus permohonan.');
        }
    }
}
