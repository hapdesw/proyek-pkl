<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function index()
    {
        return view('petugas.beranda-petugas');
    }
}
