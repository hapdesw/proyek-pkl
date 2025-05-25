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
        $middleware->web([
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ]);
        $middleware->alias([
            'Admin_1000' => \App\Http\Middleware\Admin_1000::class,
            'PIC_LDI_0100' => \App\Http\Middleware\PIC_LDI_0100::class,
            'Analis_0010' => \App\Http\Middleware\Analis_0010::class,
            'Bendahara_0001' => \App\Http\Middleware\Bendahara_0001::class,
            'PIC_LDIAnalis_0110' => \App\Http\Middleware\PIC_LDIAnalis_0110::class,
            'AnalisBendahara_0011' => \App\Http\Middleware\AnalisBendahara_0011::class,
            'PIC_LDIBendahara_0101' => \App\Http\Middleware\PIC_LDIBendahara_0101::class,
            'Superadmin_1111' => \App\Http\Middleware\Superadmin_1111::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
