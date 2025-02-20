<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Bendahara_0001
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $peran = Auth::user()->peran; 

        if ($peran[3] === '1') 
        {
            return $next($request);
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }
}
