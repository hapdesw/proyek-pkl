<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Kapokja\KapokjaController;
use App\Http\Controllers\Analis\AnalisController;
use App\Http\Controllers\Petugas\PermohonanController;
use App\Http\Controllers\Petugas\JenisLayananController;
use App\Http\Controllers\Bendahara\BendaharaController;
use App\Http\Controllers\Kapokja\DisposisiController;
use App\Http\Controllers\Kapokja\PegawaiController;
use App\Http\Controllers\HasilLayananController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'Petugas_1000'])->group(function () {
    Route::get('/petugas-layanan/beranda', [PetugasController::class, 'index'])->name('petugas.beranda'); 
    Route::get('/petugas-layanan/kelola-layanan', [JenisLayananController::class, 'index'])->name('petugas.kelola-layanan');
    Route::get('/petugas-layanan/kelola-layanan/create', [JenisLayananController::class, 'create'])->name('petugas.kelola-layanan.create');
    Route::post('/petugas-layanan/kelola-layanan/store', [JenisLayananController::class, 'store'])->name('petugas.kelola-layanan.store'); 
    Route::put('/petugas-layanan/kelola-layanan/{id}', [JenisLayananController::class, 'update'])->name('petugas.kelola-layanan.update'); 
    Route::delete('/petugas-layanan/kelola-layanan/hapus/{id}', [JenisLayananController::class, 'destroy'])->name('petugas.kelola-layanan.destroy'); 
    Route::get('/petugas-layanan/permohonan', [PermohonanController::class, 'index'])->name('petugas.permohonan'); 
    Route::get('/petugas-layanan/permohonan/create', [PermohonanController::class, 'create'])->name('petugas.permohonan.create'); 
    Route::post('/petugas-layanan/permohonan/store', [PermohonanController::class, 'store'])->name('petugas.permohonan.store'); 
    

}); 

Route::middleware(['auth', 'Kapokja_0100'])->group(function () {
    Route::get('/kapokja/beranda', [KapokjaController::class, 'index'])->name('kapokja.beranda'); 
    Route::get('/kapokja/disposisi', [DisposisiController::class, 'index'])->name('kapokja.disposisi'); 
    Route::get('/kapokja/disposisi/create', [DisposisiController::class, 'create'])->name('kapokja.disposisi.create'); 
    Route::get('/kapokja/kelola-pegawai', [PegawaiController::class, 'index'])->name('kapokja.kelola-pegawai');
}); 

Route::middleware(['auth', 'Analis_0010'])->group(function () {
    Route::get('/analis/hasil-layanan', [AnalisController::class, 'index'])->name('analis.hasil-layanan'); 
}); 

Route::middleware(['auth', 'Bendahara_0001'])->group(function () {
    Route::get('/bendahara/tagihan', [BendaharaController::class, 'index'])->name('bendahara.tagihan'); 
}); 



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
