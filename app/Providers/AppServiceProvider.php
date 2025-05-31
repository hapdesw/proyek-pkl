<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Pegawai; 
use App\Observers\PegawaiObserver; 
// use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer untuk header-superadmin
    View::composer('layouts.header-superadmin', function ($view) {
        $daftarPegawai = Pegawai::whereRaw("SUBSTRING(peran_pegawai, 3, 1) = '1'")->get();
        $view->with('daftarPegawai', $daftarPegawai);
    });
        // Pegawai::observe(PegawaiObserver::class);
    }
}
