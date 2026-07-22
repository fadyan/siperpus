<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\PenerbitController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\Kelas_GroupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\Rak_BukuController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AIChatController;



Route::get('/login', [LoginController::class, 'index'])->name("login");
Route::post('/logout', [LoginController::class, 'logout'])->name("logout");
Route::post('/login', [LoginController::class, 'authenticate'])->name("login-proses");


Route::middleware('auth')->group(function () {
    Route::post('/chat', [AIChatController::class, 'chat']);
    Route::get('/', [DashboardController::class,'index'])->name("dashboard");
    Route::get('/dashboard/search', [DashboardController::class, 'search'])
    ->name('dashboard.search');
    // Route::post('/peminjaman/store',[PeminjamanController::class,'store'])->name('peminjaman.store');

    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/store', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/delete/{id}', [KelasController::class, 'destroy'])->name('kelas.delete');
    });
    Route::prefix('buku')->group(function () {
        Route::get('/', [BukuController::class, 'index'])->name('buku');
        Route::get('/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/store', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/update/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/delete/{id}', [BukuController::class, 'destroy'])->name('buku.delete');
        Route::get('/buku/{id}/detail', [BukuController::class, 'detail'])->name('buku.detail');
    });
    Route::prefix('kelas-group')->group(function () {
        Route::get('/', [Kelas_GroupController::class, 'index'])->name('kelas_group');
        Route::get('/create', [Kelas_GroupController::class, 'create'])->name('kelas_group.create');
        Route::post('/store', [Kelas_GroupController::class, 'store'])->name('kelas_group.store');
        Route::get('/edit/{id}', [Kelas_GroupController::class, 'edit'])->name('kelas_group.edit');
        Route::put('/update/{id}', [Kelas_GroupController::class, 'update'])->name('kelas_group.update');
        Route::delete('/delete/{id}', [Kelas_GroupController::class, 'destroy'])->name('kelas_group.delete');
    });
    Route::prefix('siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/store', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.delete');
    });
    Route::prefix('pegawai')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('pegawai');
        Route::get('/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/store', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/delete/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
    });
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::post('/store',[PeminjamanController::class,'store'])->name('peminjaman.store');
        Route::get('/kembali/{id}', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
        Route::put('/update/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        // Route::delete('/delete/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.delete');
    });

     Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::get('/lis_data', [UserController::class, 'list_data'])->name('user.list_data');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });
    Route::prefix('rak_buku')->group(function () {
        Route::get('/', [Rak_BukuController::class, 'index'])->name('rak_buku');
        Route::get('/create', [Rak_BukuController::class, 'create'])->name('rak_buku.create');
        Route::post('/store', [Rak_BukuController::class, 'store'])->name('rak_buku.store');
        Route::get('/edit/{id}', [Rak_BukuController::class, 'edit'])->name('rak_buku.edit');
        Route::put('/update/{id}', [Rak_BukuController::class, 'update'])->name('rak_buku.update');
        Route::delete('/delete/{id}', [Rak_BukuController::class, 'destroy'])->name('rak_buku.delete');
    });
    Route::prefix('penerbit')->group(function () {
        Route::get('/', [PenerbitController::class, 'index'])->name('penerbit');
        Route::get('/create', [PenerbitController::class, 'create'])->name('penerbit.create');
        Route::post('/store', [PenerbitController::class, 'store'])->name('penerbit.store');
        Route::get('/edit/{id}', [PenerbitController::class, 'edit'])->name('penerbit.edit');
        Route::put('/update/{id}', [PenerbitController::class, 'update'])->name('penerbit.update');
        Route::delete('/delete/{id}', [PenerbitController::class, 'destroy'])->name('penerbit.delete');
    });

    // Route::resource('buku', BukuController::class);
    // Route::resource('pegawai', PegawaiController::class);
    // Route::resource('siswa', SiswaController::class);

});