<?php

namespace App\Http\Controllers\Kapokja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class KapokjaController extends Controller
{
    public function index()
    {
        return view('kapokja.beranda-kapokja');
    }
}
