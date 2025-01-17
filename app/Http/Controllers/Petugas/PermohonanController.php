<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Pemohon;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permohonan = Permohonan::all();
        return view('petugas.permohonan', compact('permohonan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pemohon = Pemohon::all();
        $permohonanID = Permohonan::select('id')->get();
        $jenisLayanan = JenisLayanan::all();
        return view('petugas.create-permohonan', compact('permohonanID', 'pemohon', 'jenisLayanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pemohon' => 'required',
            'tanggal_diajukan' => 'required|date',
                
        ]);
        $request->validate([
            'tanggal_diajukan' => 'required|date',
            'kategori_berbayar' => 'required|string',
            'id_jenis_layanan' => 'required',
            'deskripsi_keperluan' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'jam_awal' => 'required|time',
            'jam_akhir' => 'required|time',
            'status_permohonan' => 'required|string',
            'tanggal_selesai' => 'nullable',
            'tanggal_diambil' => 'nullable',
            'id_pemohon' => 'required'
        ]);
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
    public function destroy(Permohonan $permohonan)
    {
        //
    }
}
