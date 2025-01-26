<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if($request->user()->peran === '1000')
        {
            return redirect('/petugas-layanan/beranda'); 
        }
        elseif($request->user()->peran === '0100')
        {
            return redirect('/kapokja/beranda');
        }
        elseif($request->user()->peran === '0010')
        {
            return redirect('/analis/hasil-layanan');
        }
        elseif($request->user()->peran === '0001')
        {
            return redirect('/bendahara/tagihan');
        }
        elseif($request->user()->peran === '1100')
        {
            return redirect('/PK/petugas-kapokja/transisi');
        }
        

        return redirect()->intended(route('login'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
    
}
