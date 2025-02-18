<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Admin_1000' => \App\Http\Middleware\Admin_1000::class,
            'Kapokja_0100' => \App\Http\Middleware\Kapokja_0100::class,
            'Analis_0010' => \App\Http\Middleware\Analis_0010::class,
            'Bendahara_0001' => \App\Http\Middleware\Bendahara_0001::class,
            'KapokjaAnalis_0110' => \App\Http\Middleware\KapokjaAnalis_0110::class,
            'AnalisBendahara_0011' => \App\Http\Middleware\AnalisBendahara_0011::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
