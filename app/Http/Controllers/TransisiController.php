<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransisiController extends Controller
{
    public function transisiKapokjaAnalis()
    {
        return view('transisi.transisi-kapokja-analis');
    }
    public function transisiAnalisBendahara()
    {
        return view('transisi.transisi-analis-bendahara');
    }
}

