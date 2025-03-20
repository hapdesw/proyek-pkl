<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransisiController extends Controller
{
    public function transisiPIC_LDIAnalis()
    {
        return view('transisi.transisi-pic-ldi-analis');
    }

    public function transisiAnalisBendahara()
    {
        return view('transisi.transisi-analis-bendahara');
    }

    public function transisiPIC_LDIBendahara()
    {
        return view('transisi.transisi-pic-ldi-bendahara');
    }
}

