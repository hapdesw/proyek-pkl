<?php

namespace App\Http\Controllers;

use App\Models\HasilLayanan;
use Illuminate\Http\Request;

class HasilLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function index_kapokja()
    {
        return view('kapokja.hasil-layanan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(HasilLayanan $hasilLayanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilLayanan $hasilLayanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HasilLayanan $hasilLayanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilLayanan $hasilLayanan)
    {
        //
    }
}
