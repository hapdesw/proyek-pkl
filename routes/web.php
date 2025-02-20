<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Kapokja\KapokjaController;
use App\Http\Controllers\Admin\PermohonanController;
use App\Http\Controllers\Admin\JenisLayananController;
use App\Http\Controllers\Pemohon\PemohonController;
use App\Http\Controllers\Bendahara\TagihanController;
use App\Http\Controllers\Bendahara\KuitansiController;
use App\Http\Controllers\Kapokja\DisposisiController;
use App\Http\Controllers\Kapokja\PegawaiController;
use App\Http\Controllers\Analis\HasilLayananController;
use App\Http\Controllers\TransisiController;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'pemohon'], function() {
    Route::get('/beranda', [PemohonController::class, 'berandaPemohon'])->name('pemohon.beranda');
    Route::get('/permohonan/create', [PemohonController::class, 'create'])->name('pemohon.permohonan.create'); 
    Route::post('/permohonan/store', [PemohonController::class, 'store'])->name('pemohon.permohonan.store');
});

Route::middleware(['auth', 'Admin_1000'])->group(function () {
    Route::get('/admin-layanan/beranda', [AdminController::class, 'index'])->name('admin.beranda'); 
    Route::get('/admin-layanan/kelola-layanan', [JenisLayananController::class, 'index'])->name('admin.kelola-layanan');
    Route::get('/admin-layanan/kelola-layanan/create', [JenisLayananController::class, 'create'])->name('admin.kelola-layanan.create');
    Route::post('/admin-layanan/kelola-layanan/store', [JenisLayananController::class, 'store'])->name('admin.kelola-layanan.store'); 
    Route::put('/admin-layanan/kelola-layanan/update/{id}', [JenisLayananController::class, 'update'])->name('admin.kelola-layanan.update'); 
    Route::delete('/admin-layanan/kelola-layanan/destroy/{id}', [JenisLayananController::class, 'destroy'])->name('admin.kelola-layanan.destroy'); 
    Route::get('/permohonan/filter', [PermohonanController::class, 'filter']);
    Route::get('/permohonan/available-years', [PermohonanController::class, 'getAvailableYears']);
    Route::get('/admin-layanan/permohonan', [PermohonanController::class, 'index'])->name('admin.permohonan'); 
    Route::get('/admin-layanan/permohonan/create', [PermohonanController::class, 'create'])->name('admin.permohonan.create'); 
    Route::get('/admin-layanan/permohonan/edit/{id}', [PermohonanController::class, 'edit'])->name('admin.permohonan.edit'); 
    Route::put('/admin-layanan/permohonan/update/{id}', [PermohonanController::class, 'update'])->name('admin.permohonan.update'); 
    Route::post('/admin-layanan/permohonan/store', [PermohonanController::class, 'store'])->name('admin.permohonan.store'); 
    Route::delete('/admin-layanan/permohonan/destroy/{id}', [PermohonanController::class, 'destroy'])->name('admin.permohonan.destroy');
    Route::post('/admin-layanan/permohonan/update-status/{id}', [PermohonanController::class, 'updateStatus'])->name('admin.permohonan.update-status');
    Route::get('/admin-layanan/pemohon', [PemohonController::class, 'index'])->name('admin.kelola-pemohon'); 
    Route::get('/admin/permohonan/available-years', [PermohonanController::class, 'getAvailableYears']);
    
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
    Route::get('/kapokja/hasil-layanan', [HasilLayananController::class, 'indexKapokja'])->name('kapokja.hasil-layanan');
    Route::get('/kapokja/hasil-layanan/create/{id}', [HasilLayananController::class, 'createStatusKapokja'])->name('kapokja.hasil-layanan.create');
    Route::post('/kapokja/hasil-layanan/store/{id}', [HasilLayananController::class, 'storeStatusKapokja'])->name('kapokja.hasil-layanan.store');
    Route::get('/kapokja/hasil-layanan/edit/{id}', [HasilLayananController::class, 'editStatusKapokja'])->name('kapokja.hasil-layanan.edit');
    Route::put('/kapokja/hasil-layanan/update/{id}', [HasilLayananController::class, 'updateStatusKapokja'])->name('kapokja.hasil-layanan.update');
    Route::delete('/kapokja/hasil-layanan/destroy/{id}', [HasilLayananController::class, 'destroyStatusKapokja'])->name('kapokja.hasil-layanan.destroy'); 
}); 

Route::middleware(['auth', 'Analis_0010'])->group(function () {
    Route::get('/analis/hasil-layanan', [HasilLayananController::class, 'index'])->name('analis.hasil-layanan'); 
    Route::get('/analis/hasil-layanan/create/{id}', [HasilLayananController::class, 'create'])->name('analis.hasil-layanan.create');
    Route::post('/analis/hasil-layanan/store/{id}', [HasilLayananController::class, 'store'])->name('analis.hasil-layanan.store');  
    Route::get('/analis/hasil-layanan/edit/{id}', [HasilLayananController::class, 'edit'])->name('analis.hasil-layanan.edit');
    Route::put('/analis/hasil-layanan/update/{id}', [HasilLayananController::class, 'update'])->name('analis.hasil-layanan.update');
    Route::delete('/analis/hasil-layanan/destroy/{id}', [HasilLayananController::class, 'destroy'])->name('analis.hasil-layanan.destroy');
}); 

Route::middleware(['auth', 'Bendahara_0001'])->group(function () {
    Route::get('/bendahara/tagihan', [TagihanController::class, 'index'])->name('bendahara.tagihan'); 
    Route::get('/bendahara/kuitansi', [KuitansiController::class, 'index'])->name('bendahara.kuitansi'); 
    Route::get('/bendahara/tagihan/create/{id}', [TagihanController::class, 'create'])->name('bendahara.tagihan.create');
    Route::post('/bendahara/tagihan/store/{id}', [TagihanController::class, 'store'])->name('bendahara.tagihan.store');
    Route::get('/bendahara/tagihan/edit/{id}', [TagihanController::class, 'edit'])->name('bendahara.tagihan.edit');
    Route::put('/bendahara/tagihan/update/{id}', [TagihanController::class, 'update'])->name('bendahara.tagihan.update');
    Route::delete('/bendahara/tagihan/destroy/{id}', [TagihanController::class, 'destroy'])->name('bendahara.tagihan.destroy');

    Route::get('/bendahara/kuitansi/create/{id}', [KuitansiController::class, 'create'])->name('bendahara.kuitansi.create');
    Route::post('/bendahara/kuitansi/store/{id}', [KuitansiController::class, 'store'])->name('bendahara.kuitansi.store');
    Route::get('/bendahara/kuitansi/edit/{id}', [KuitansiController::class, 'edit'])->name('bendahara.kuitansi.edit');
    Route::put('/bendahara/kuitansi/update/{id}', [KuitansiController::class, 'update'])->name('bendahara.kuitansi.update');
    Route::delete('/bendahara/kuitansi/destroy/{id}', [KuitansiController::class, 'destroy'])->name('bendahara.kuitansi.destroy'); 
}); 

Route::middleware(['auth', 'PetugasKapokja_1100'])->group(function () {
    Route::get('/PK/petugas-kapokja/transisi', [TransisiController::class, 'transisiPetugasKapokja'])->name('transisi.petugas-kapokja'); 
    Route::get('/PK/kapokja/beranda', [KapokjaController::class, 'index'])->name('PK.kapokja.beranda');
    Route::get('/PK/petugas-layanan/beranda', [AdminController::class, 'index'])->name('PK.petugas.beranda'); 
}); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
