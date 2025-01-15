<?php

namespace App\Http\Controllers\Analis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AnalisController extends Controller
{
    public function index()
    {
        return view('analis.hasil-layanan');
    }
}
