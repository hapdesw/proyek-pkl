<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $pemohon = Pemohon::all();
        $permohonanIDLast = Permohonan::latest('id')->value('id') ?? 0; //ini kalau belum ada data maka default 0 
        $nextID = $permohonanIDLast + 1;
        $jenisLayanan = JenisLayanan::all();
        return view('petugas.create-permohonan', compact('nextID', 'pemohon', 'jenisLayanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    Log::info('Mulai proses store');
    Log::info('Data request:', $request->all());
    // Validasi data
    $request->validate([
        // Validasi data permohonan
        'tanggal_diajukan' => 'required|date',
        'kategori_berbayar' => 'required|string',
        'id_jenis_layanan' => 'required|integer',
        'deskripsi_keperluan' => 'required|string',
        'tanggal_awal' => 'required|date',
        'tanggal_akhir' => 'nullable|date',
        'jam_awal' => 'nullable|date_format:H:i',
        'jam_akhir' => 'nullable|date_format:H:i',
        'tanggal_selesai' => 'nullable|date',
        'tanggal_diambil' => 'nullable|date',
        
        // Validasi data pemohon
        'nama_pemohon' => 'required|string',
        'instansi' => 'required|string',
        'no_kontak' => 'required|string',
        'email' => 'required|email',
    ]);
    // Setelah validasi
Log::info('Validasi berhasil');

    dd($request->all()); // Debug untuk memeriksa data yang divalidasi
    // Cari atau buat data pemohon
    $pemohon = Pemohon::firstOrCreate(
        ['email' => $request->email], // Kriteria unik, misalnya email
        [
            'nama_pemohon' => $request->nama_pemohon,
            'instansi' => $request->instansi,
            'no_kontak' => $request->no_kontak,
        ]
       
    );
    dd($pemohon);
    // Setelah Pemohon::create
Log::info('Pemohon dibuat:', $pemohon->toArray());

    // Simpan data permohonan
    $permohonan=Permohonan::create([
        'tanggal_diajukan' => $request->tanggal_diajukan,
        'kategori_berbayar' => $request->kategori_berbayar,
        'id_jenis_layanan' => $request->id_jenis_layanan,
        'deskripsi_keperluan' => $request->deskripsi_keperluan,
        'tanggal_awal' => $request->tanggal_awal,
        'tanggal_akhir' => $request->tanggal_akhir,
        'jam_awal' => $request->jam_awal,
        'jam_akhir' => $request->jam_akhir,
        'tanggal_selesai' => $request->tanggal_selesai,
        'tanggal_diambil' => $request->tanggal_diambil,
        'id_pemohon' => $pemohon->id, // ID pemohon dari data yang baru dibuat atau ditemukan
    ]);
    dd($permohonan);
    // Setelah Permohonan::create
Log::info('Permohonan dibuat:', $permohonan->toArray());


    // route ke halaman index nya
    return redirect()->route('petugas.permohonan')->with('success', 'Permohonan berhasil dibuat!');
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
    public function edit(Permohonan $permohonan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permohonan $id)
    {
        //
    }
}
