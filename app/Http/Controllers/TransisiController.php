<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransisiController extends Controller
{
    public function transisiPetugasKapokja()
    {
        return view('transisi.transisi-petugas-kapokja');
    }

    public function transisiKapokjaAnalis()
    {
        return view('transisi.transisi-kapokja-analis');
    }
}
