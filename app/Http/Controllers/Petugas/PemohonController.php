<?php

namespace App\Http\Controllers\Petugas;
use App\Http\Controllers\Controller;
use App\Models\Pemohon;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PemohonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemohon = Pemohon::select(
            'nama_pemohon',
            'instansi',
            DB::raw('ANY_VALUE(no_kontak) as no_kontak'),
            DB::raw('ANY_VALUE(email) as email')
        )
        ->groupBy('nama_pemohon', 'instansi')
        ->paginate(15);
    
        $pemohon->getCollection()->transform(function ($item) {
            // Ambil semua ID pemohon dengan nama & instansi yang sama
            $pemohonIDs = Pemohon::where('nama_pemohon', $item->nama_pemohon)
                ->where('instansi', $item->instansi)
                ->pluck('id'); // Mengambil semua id_pemohon
    
            // Hitung total permohonan berdasarkan semua id_pemohon yang sesuai
            $total_permohonan = Permohonan::whereIn('id_pemohon', $pemohonIDs)->count();
    
            return (object) [ // Pastikan dikembalikan sebagai object, bukan array
                'nama_pemohon' => $item->nama_pemohon,
                'instansi' => $item->instansi,
                'no_kontak' => $item->no_kontak,
                'email' => $item->email,
                'total_permohonan' => $total_permohonan,
            ];
        });
    
        return view('petugas.data-pemohon', compact('pemohon'));
    }
    
    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a wly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemohon $pemohon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemohon $pemohon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemohon $pemohon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemohon $pemohon)
    {
        //
    }
}
