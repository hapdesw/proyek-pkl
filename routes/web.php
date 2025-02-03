<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Kapokja\KapokjaController;
use App\Http\Controllers\Petugas\PermohonanController;
use App\Http\Controllers\Petugas\JenisLayananController;
use App\Http\Controllers\Petugas\PemohonController;
use App\Http\Controllers\Bendahara\TagihanController;
use App\Http\Controllers\Bendahara\KuitansiController;
use App\Http\Controllers\Kapokja\DisposisiController;
use App\Http\Controllers\Kapokja\PegawaiController;
use App\Http\Controllers\Analis\HasilLayananController;
use App\Http\Controllers\TransisiController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'Petugas_1000'])->group(function () {
    Route::get('/petugas-layanan/beranda', [PetugasController::class, 'index'])->name('petugas.beranda'); 
    Route::get('/petugas-layanan/kelola-layanan', [JenisLayananController::class, 'index'])->name('petugas.kelola-layanan');
    Route::get('/petugas-layanan/kelola-layanan/create', [JenisLayananController::class, 'create'])->name('petugas.kelola-layanan.create');
    Route::post('/petugas-layanan/kelola-layanan/store', [JenisLayananController::class, 'store'])->name('petugas.kelola-layanan.store'); 
    Route::put('/petugas-layanan/kelola-layanan/update/{id}', [JenisLayananController::class, 'update'])->name('petugas.kelola-layanan.update'); 
    Route::delete('/petugas-layanan/kelola-layanan/destroy/{id}', [JenisLayananController::class, 'destroy'])->name('petugas.kelola-layanan.destroy'); 
    Route::get('/permohonan/filter', [PermohonanController::class, 'filter']);
    Route::get('/petugas-layanan/permohonan', [PermohonanController::class, 'index'])->name('petugas.permohonan'); 
    Route::get('/petugas-layanan/permohonan/create', [PermohonanController::class, 'create'])->name('petugas.permohonan.create'); 
    Route::get('/petugas-layanan/permohonan/edit/{id}', [PermohonanController::class, 'edit'])->name('petugas.permohonan.edit'); 
    Route::put('/petugas-layanan/permohonan/update/{id}', [PermohonanController::class, 'update'])->name('petugas.permohonan.update'); 
    Route::post('/petugas-layanan/permohonan/store', [PermohonanController::class, 'store'])->name('petugas.permohonan.store'); 
    Route::delete('/petugas-layanan/permohonan/destroy/{id}', [PermohonanController::class, 'destroy'])->name('petugas.permohonan.destroy');
    Route::post('/petugas-layanan/permohonan/update-status/{id}', [PermohonanController::class, 'updateStatus'])->name('petugas.permohonan.update-status');
    Route::get('/petugas-layanan/pemohon', [PemohonController::class, 'index'])->name('petugas.kelola-pemohon'); 
}); 

Route::middleware(['auth', 'Kapokja_0100'])->group(function () {
    Route::get('/kapokja/beranda', [KapokjaController::class, 'index'])->name('kapokja.beranda'); 
    Route::get('/kapokja/disposisi', [DisposisiController::class, 'index'])->name('kapokja.disposisi'); 
    Route::get('/kapokja/disposisi/create/{id}', [DisposisiController::class, 'create'])->name('kapokja.disposisi.create'); 
    Route::post('/kapokja/disposisi/store/{id}', [DisposisiController::class, 'store'])->name('kapokja.disposisi.store'); 
    Route::get('/kapokja/disposisi/edit/{id}', [DisposisiController::class, 'edit'])->name('kapokja.disposisi.edit'); 
    Route::post('/kapokja/disposisi/update/{id}', [DisposisiController::class, 'update'])->name('kapokja.disposisi.update'); 
    Route::delete('/kapokja/disposisi/destroy/{id}', [DisposisiController::class, 'destroy'])->name('kapokja.disposisi.destroy'); 
    Route::get('/kapokja/kelola-pegawai', [PegawaiController::class, 'index'])->name('kapokja.kelola-pegawai');
    Route::get('/kapokja/kelola-pegawai/create', [PegawaiController::class, 'create'])->name('kapokja.kelola-pegawai.create');
    Route::post('/kapokja/kelola-pegawai/store', [PegawaiController::class, 'store'])->name('kapokja.kelola-pegawai.store');
    Route::get('/kapokja/kelola-pegawai/edit/{nip}', [PegawaiController::class, 'edit'])->name('kapokja.kelola-pegawai.edit');
    Route::put('/kapokja/kelola-pegawai/update/{nip}', [PegawaiController::class, 'update'])->name('kapokja.kelola-pegawai.update');
    Route::delete('/kapokja/kelola-pegawai/destroy/{nip}', [PegawaiController::class, 'destroy'])->name('kapokja.kelola-pegawai.destroy');
}); 

Route::middleware(['auth', 'Analis_0010'])->group(function () {
    Route::get('/analis/hasil-layanan', [HasilLayananController::class, 'index'])->name('analis.hasil-layanan'); 
    Route::get('/analis/hasil-layanan/create/{id}', [HasilLayananController::class, 'create'])->name('analis.hasil-layanan.create');
    Route::post('/analis/hasil-layanan/store/{id}', [HasilLayananController::class, 'store'])->name('analis.hasil-layanan.store');  
}); 

Route::middleware(['auth', 'Bendahara_0001'])->group(function () {
    Route::get('/bendahara/tagihan', [TagihanController::class, 'index'])->name('bendahara.tagihan'); 
    Route::get('/bendahara/kuitansi', [KuitansiController::class, 'index'])->name('bendahara.kuitansi'); 
    Route::get('/bendahara/tagihan/create/{id}', [TagihanController::class, 'create'])->name('bendahara.tagihan.create');
    Route::post('/bendahara/tagihan/store/{id}', [TagihanController::class, 'store'])->name('bendahara.tagihan.store');  
    Route::get('/bendahara/kuitansi/create/{id}', [KuitansiController::class, 'create'])->name('bendahara.kuitansi.create');
    Route::post('/bendahara/kuitansi/store/{id}', [KuitansiController::class, 'store'])->name('bendahara.kuitansi.store');  
}); 

Route::middleware(['auth', 'PetugasKapokja_1100'])->group(function () {
    Route::get('/PK/petugas-kapokja/transisi', [TransisiController::class, 'transisiPetugasKapokja'])->name('transisi.petugas-kapokja'); 
    Route::get('/PK/kapokja/beranda', [KapokjaController::class, 'index'])->name('PK.kapokja.beranda');
    Route::get('/PK/petugas-layanan/beranda', [PetugasController::class, 'index'])->name('PK.petugas.beranda'); 
}); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
