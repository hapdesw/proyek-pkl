<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

        $request->session()->put('active_role', $request->user()->peran);

        if($request->user()->peran === '1000')
        {
            return redirect('/admin-layanan/beranda'); 
        }
        elseif($request->user()->peran === '0100')
        {
            return redirect('/pic-ldi/beranda');
        }
        elseif($request->user()->peran === '0010')
        {
            return redirect('/analis/hasil-layanan');
        }
        elseif($request->user()->peran === '0001')
        {
            return redirect('/bendahara/tagihan');
        }
        elseif($request->user()->peran === '0110')
        {
            return redirect('/KA/pic-ldi-analis/transisi');
        }
        elseif($request->user()->peran === '0011')
        {
            return redirect('/AB/analis-bendahara/transisi');
        }
        elseif($request->user()->peran === '0101')
        {
            return redirect('/KB/pic-ldi-bendahara/transisi');
        }
        elseif($request->user()->peran === '1111')
        {
            return redirect('/superadmin/beranda');
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

    public function pilihRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:1000,0100,0010,0001',
        ]);

        $request->session()->put('active_role', $request->role);
        
        DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->update([
                'active_role' => $request->role,
                'last_activity' => time()
            ]);

        $routes = [
            '1000' => 'admin.beranda',
            '0100' => 'pic-ldi.beranda',
            '0010' => 'analis.hasil-layanan',
            '0001' => 'bendahara.tagihan',
        ];

        return redirect()->route($routes[$request->role]);
    }
    
}
