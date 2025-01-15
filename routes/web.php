<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Kapokja\KapokjaController;
use App\Http\Controllers\Analis\AnalisController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\Bendahara\BendaharaController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'Petugas_1000'])->group(function () {
    Route::get('/petugas-layanan/beranda', [PetugasController::class, 'index'])->name('dashboard'); 
    Route::get('/petugas-layanan/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index'); 
}); 

Route::middleware(['auth', 'Kapokja_0100'])->group(function () {
    Route::get('/kapokja/beranda', [KapokjaController::class, 'index'])->name('dashboardcoba'); 
}); 

Route::middleware(['auth', 'Analis_0010'])->group(function () {
    Route::get('/analis/beranda', [AnalisController::class, 'index'])->name('dashboardcoba'); 
}); 



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
