<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Analis_0010
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     $peran = Auth::user()->peran; 

    //     if ($peran[2] === '1') {
    //         View::share('userRole', 'analis');
    //         return $next($request); 
    //     }
    //     return redirect('/');
    // }
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $roleAktif = session('active_role') ?? $user->peran;

        // Izinkan analis ('0010') dan superadmin ('1111')
        if ($roleAktif === '0010' || $roleAktif === '1111') {
            View::share('userRole', $roleAktif === '0010' ? 'analis' : 'superadmin');
            return $next($request);
        }

       return redirect('/');
    }

}
