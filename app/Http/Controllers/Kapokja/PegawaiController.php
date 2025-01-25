<?php

namespace App\Http\Controllers\Kapokja;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::all();

        foreach ($pegawai as $p) {
            if ($p->peran_pegawai == '1000') {
                $p->peran_pegawai = 'Petugas Layanan';
            } elseif ($p->peran_pegawai == '0100') {
                $p->peran_pegawai = 'Kapokja';
            } elseif ($p->peran_pegawai == '0010') {
                $p->peran_pegawai = 'Analis';
            } elseif ($p->peran_pegawai == '0001') {
                $p->peran_pegawai = 'Bendahara';
            } elseif ($p->peran_pegawai == '0110') {
                $p->peran_pegawai = 'Kapokja dan Analis';
            } elseif ($p->peran_pegawai == '0011') {
                $p->peran_pegawai = 'Analis dan Bendahara';
            } else {
                $p->peran_pegawai = 'Tidak Diketahui';
            }
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        //
    }
}
