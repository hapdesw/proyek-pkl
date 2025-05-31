<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Superadmin\SuperadminController;
use App\Http\Controllers\PIC_LDI\PIC_LDIController;
use App\Http\Controllers\Admin\PermohonanController;
use App\Http\Controllers\Admin\JenisLayananController;
use App\Http\Controllers\Pemohon\PemohonController;
use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\Bendahara\TagihanController;
use App\Http\Controllers\Bendahara\KuitansiController;
use App\Http\Controllers\PIC_LDI\DisposisiController;
use App\Http\Controllers\PIC_LDI\PegawaiController;
use App\Http\Controllers\Analis\HasilLayananController;
use App\Http\Controllers\TransisiController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ExportDisposisiController; 

Route::get('/', function () {
    return view('auth.login');
});

// Route::group(['middleware' => 'auth:web'], function(){
//     // logout
//     Route::post('/logout', [CustomAuthController::class,'logout'])-> name('logout');
// });

Route::group(['prefix' => 'daftar'], function() {
    Route::get('/-akun/create', [RegisteredUserController::class, 'create']) ->name('daftar-akun');
    Route::post('/-akun/store', [RegisteredUserController::class, 'store']) ->name('daftar-akun.store');
});


Route::post('/pilih-role', [AuthenticatedSessionController::class, 'pilihRole'])->name('pilih-role');

Route::middleware(['auth', 'Superadmin_1111'])->group(function () {
    Route::get('/superadmin/beranda', [SuperadminController::class, 'index'])->name('superadmin.beranda');   

}); 

Route::middleware(['auth', 'PIC_LDIAnalis_0110'])->group(function () {
    Route::get('/KA/pic-ldi-analis/transisi', [TransisiController::class, 'transisiPIC_LDIAnalis'])->name('transisi.pic-ldi-analis'); 
}); 

Route::middleware(['auth', 'AnalisBendahara_0011'])->group(function () {
    Route::get('/AB/analis-bendahara/transisi', [TransisiController::class, 'transisiAnalisBendahara'])->name('transisi.analis-bendahara'); 
}); 
Route::middleware(['auth', 'PIC_LDIBendahara_0101'])->group(function () {
    Route::get('/KB/pic-ldi-bendahara/transisi', [TransisiController::class, 'transisiPIC_LDIBendahara'])->name('transisi.pic-ldi-bendahara'); 
}); 

Route::group(['prefix' => 'pemohon'], function() {
    Route::get('/beranda', [PemohonController::class, 'berandaPemohon'])->name('pemohon.beranda');
    Route::get('/permohonan/create', [PemohonController::class, 'create'])->name('pemohon.permohonan.create'); 
    Route::post('/permohonan/store', [PemohonController::class, 'store'])->name('pemohon.permohonan.store');
});

Route::middleware(['auth', 'Admin_1000'])->group(function () {
    Route::get('/admin-layanan/beranda', [AdminController::class, 'index'])->name('admin.beranda'); 
    Route::get('/admin-layanan/beranda/export', [ExportDisposisiController::class, 'export'])->name('admin.beranda.export'); 
    Route::get('/admin-layanan/kelola-layanan', [JenisLayananController::class, 'index'])->name('admin.kelola-layanan');
    Route::get('/admin-layanan/kelola-layanan/create', [JenisLayananController::class, 'create'])->name('admin.kelola-layanan.create');
    Route::post('/admin-layanan/kelola-layanan/store', [JenisLayananController::class, 'store'])->name('admin.kelola-layanan.store'); 
    Route::put('/admin-layanan/kelola-layanan/update/{id}', [JenisLayananController::class, 'update'])->name('admin.kelola-layanan.update'); 
    Route::delete('/admin-layanan/kelola-layanan/destroy/{id}', [JenisLayananController::class, 'destroy'])->name('admin.kelola-layanan.destroy'); 
    Route::get('/permohonan/filter', [PermohonanController::class, 'filter']);
    Route::get('/permohonan/count', [PermohonanController::class, 'getFilteredCount'])->name('permohonan.count');
    Route::get('/admin-layanan/permohonan/export', [ExportController::class, 'export'])->name('admin.permohonan.export');
    Route::get('/admin-layanan/permohonan/available-years', [PermohonanController::class, 'getAvailableYears']);
    Route::get('/admin-layanan/beranda/available-years', [AdminController::class, 'getAvailableYears']);
    Route::get('/admin-layanan/permohonan', [PermohonanController::class, 'index'])->name('admin.permohonan'); 
    Route::get('/admin-layanan/permohonan/create', [PermohonanController::class, 'create'])->name('admin.permohonan.create'); 
    Route::get('/admin-layanan/permohonan/edit/{id}', [PermohonanController::class, 'edit'])->name('admin.permohonan.edit'); 
    Route::put('/admin-layanan/permohonan/update/{id}', [PermohonanController::class, 'update'])->name('admin.permohonan.update'); 
    Route::post('/admin-layanan/permohonan/store', [PermohonanController::class, 'store'])->name('admin.permohonan.store'); 
    Route::delete('/admin-layanan/permohonan/destroy/{id}', [PermohonanController::class, 'destroy'])->name('admin.permohonan.destroy');
    Route::post('/admin-layanan/permohonan/update-status/{id}', [PermohonanController::class, 'updateStatus'])->name('admin.permohonan.update-status');
    Route::get('/admin-layanan/pemohon', [PemohonController::class, 'index'])->name('admin.kelola-pemohon'); 
    Route::get('/admin-layanan/pemohon/detail/{id}', [PemohonController::class, 'detail'])->name('admin.kelola-pemohon.detail');
    Route::get('/admin/permohonan/available-years', [PermohonanController::class, 'getAvailableYears']);
    
}); 

Route::middleware(['auth', 'PIC_LDI_0100'])->group(function () {
    Route::get('/pic-ldi/beranda', [PIC_LDIController::class, 'index'])->name('pic-ldi.beranda'); 
    Route::get('/pic-ldi/beranda/export', [ExportDisposisiController::class, 'export'])->name('pic-ldi.beranda.export');
    Route::get('/pic-ldi/disposisi', [DisposisiController::class, 'index'])->name('pic-ldi.disposisi'); 
    Route::get('/pic-ldi/disposisi/create/{id}', [DisposisiController::class, 'create'])->name('pic-ldi.disposisi.create'); 
    Route::post('/pic-ldi/disposisi/store/{id}', [DisposisiController::class, 'store'])->name('pic-ldi.disposisi.store'); 
    Route::get('/pic-ldi/disposisi/edit/{id}', [DisposisiController::class, 'edit'])->name('pic-ldi.disposisi.edit'); 
    Route::post('/pic-ldi/disposisi/update/{id}', [DisposisiController::class, 'update'])->name('pic-ldi.disposisi.update'); 
    Route::delete('/pic-ldi/disposisi/destroy/{id}', [DisposisiController::class, 'destroy'])->name('pic-ldi.disposisi.destroy'); 
    Route::get('/pic-ldi/kelola-pegawai', [PegawaiController::class, 'index'])->name('pic-ldi.kelola-pegawai');
    Route::get('/pic-ldi/kelola-pegawai/create', [PegawaiController::class, 'create'])->name('pic-ldi.kelola-pegawai.create');
    Route::post('/pic-ldi/kelola-pegawai/store', [PegawaiController::class, 'store'])->name('pic-ldi.kelola-pegawai.store');
    Route::get('/pic-ldi/kelola-pegawai/edit/{nip}', [PegawaiController::class, 'edit'])->name('pic-ldi.kelola-pegawai.edit');
    Route::put('/pic-ldi/kelola-pegawai/update/{nip}', [PegawaiController::class, 'update'])->name('pic-ldi.kelola-pegawai.update');
    Route::delete('/pic-ldi/kelola-pegawai/destroy/{nip}', [PegawaiController::class, 'destroy'])->name('pic-ldi.kelola-pegawai.destroy');
    Route::get('/pic-ldi/hasil-layanan', [HasilLayananController::class, 'indexPIC_LDI'])->name('pic-ldi.hasil-layanan');
    Route::get('/pic-ldi/hasil-layanan/create/{id}', [HasilLayananController::class, 'createStatusPIC_LDI'])->name('pic-ldi.hasil-layanan.create');
    Route::post('/pic-ldi/hasil-layanan/store/{id}', [HasilLayananController::class, 'storeStatusPIC_LDI'])->name('pic-ldi.hasil-layanan.store');
    Route::get('/pic-ldi/hasil-layanan/edit/{id}', [HasilLayananController::class, 'editStatusPIC_LDI'])->name('pic-ldi.hasil-layanan.edit');
    Route::put('/pic-ldi/hasil-layanan/update/{id}', [HasilLayananController::class, 'updateStatusPIC_LDI'])->name('pic-ldi.hasil-layanan.update');
    Route::delete('/pic-ldi/hasil-layanan/destroy/{id}', [HasilLayananController::class, 'destroyStatusPIC_LDI'])->name('pic-ldi.hasil-layanan.destroy');

    Route::get('/pic-ldi/disposisi/available-years', [DisposisiController::class, 'getAvailableYears']);
    Route::get('/pic-ldi/hasil-layanan/available-years', [HasilLayananController::class, 'getAvailableYearsPIC_LDI']);
}); 

Route::middleware(['auth', 'Analis_0010'])->group(function () {
    Route::get('/analis/hasil-layanan', [HasilLayananController::class, 'index'])->name('analis.hasil-layanan'); 
    Route::get('/analis/hasil-layanan/create/{id}', [HasilLayananController::class, 'create'])->name('analis.hasil-layanan.create');
    Route::post('/analis/hasil-layanan/store/{id}', [HasilLayananController::class, 'store'])->name('analis.hasil-layanan.store');  
    Route::get('/analis/hasil-layanan/edit/{id}', [HasilLayananController::class, 'edit'])->name('analis.hasil-layanan.edit');
    Route::put('/analis/hasil-layanan/update/{id}', [HasilLayananController::class, 'update'])->name('analis.hasil-layanan.update');
    Route::delete('/analis/hasil-layanan/destroy/{id}', [HasilLayananController::class, 'destroy'])->name('analis.hasil-layanan.destroy');
    Route::get('/analis/hasil-layanan/available-years', [HasilLayananController::class, 'getAvailableYears']);
}); 

Route::middleware(['auth', 'Bendahara_0001'])->group(function () {
    Route::get('/bendahara/tagihan', [TagihanController::class, 'index'])->name('bendahara.tagihan'); 
    Route::get('/bendahara/kuitansi', [KuitansiController::class, 'index'])->name('bendahara.kuitansi'); 
    Route::get('/bendahara/tagihan/create/{id}', [TagihanController::class, 'create'])->name('bendahara.tagihan.create');
    Route::post('/bendahara/tagihan/store/{id}', [TagihanController::class, 'store'])->name('bendahara.tagihan.store');
    Route::get('/bendahara/tagihan/edit/{id}', [TagihanController::class, 'edit'])->name('bendahara.tagihan.edit');
    Route::put('/bendahara/tagihan/update/{id}', [TagihanController::class, 'update'])->name('bendahara.tagihan.update');
    Route::delete('/bendahara/tagihan/destroy/{id}', [TagihanController::class, 'destroy'])->name('bendahara.tagihan.destroy');
    Route::get('/bendahara/tagihan/available-years', [TagihanController::class, 'getAvailableYears']);

    Route::get('/bendahara/kuitansi/create/{id}', [KuitansiController::class, 'create'])->name('bendahara.kuitansi.create');
    Route::post('/bendahara/kuitansi/store/{id}', [KuitansiController::class, 'store'])->name('bendahara.kuitansi.store');
    Route::get('/bendahara/kuitansi/edit/{id}', [KuitansiController::class, 'edit'])->name('bendahara.kuitansi.edit');
    Route::put('/bendahara/kuitansi/update/{id}', [KuitansiController::class, 'update'])->name('bendahara.kuitansi.update');
    Route::delete('/bendahara/kuitansi/destroy/{id}', [KuitansiController::class, 'destroy'])->name('bendahara.kuitansi.destroy'); 
    Route::get('/bendahara/kuitansi/available-years', [KuitansiController::class, 'getAvailableYears']);
}); 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
