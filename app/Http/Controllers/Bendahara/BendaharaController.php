<?php

namespace App\Http\Controllers\Bendahara;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BendaharaController extends Controller
{
    public function index()
    {
        return view('bendahara.tagihan');
    }
}
