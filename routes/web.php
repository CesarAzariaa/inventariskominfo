<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\DataAsetController;
use App\Http\Controllers\AsetUserController;
use App\Http\Controllers\AsetKeluarController;
use App\Http\Controllers\DataPeminjamanController;
use App\Http\Controllers\CetakAsetController;
use App\Http\Controllers\CetakQrController;
use App\Http\Controllers\PeminjamanAdminController;

//Landing Page & Dashboard
Route::get('/', [HomeController::class, 'index'])->name('landingpage');
Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('auth');
Route::get('/homeUser', [HomeUserController::class, 'homeUser'])->name('homeUser')->middleware('auth');

//Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login-proses', [LoginController::class,'loginProses'])->name('login.proses');
Route::get('/logout', [LoginController::class, 'logoutProses'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register-proses', [LoginController::class, 'registerProses'])->name('register.proses');
    
//Data User
Route::get('/datauser', [DataUserController::class, 'datauser'])->name('datauser')->middleware('auth');
Route::post('/datauser/store', [DataUserController::class, 'store'])->name('datauser.store')->middleware('auth');
Route::post('/datauser/update{id}', [DataUserController::class, 'update'])->name('datauser.update')->middleware('auth');
Route::get('/datauser/destroy{id}', [DataUserController::class, 'destroy'])->name('datauser.destroy')->middleware('auth');

//Data Kategori
Route::get('/kategori', [KategoriController::class, 'kategori'])->name('kategori')->middleware('auth');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store')->middleware('auth');
Route::post('/kategori/update{id}', [KategoriController::class, 'update'])->name('kategori.update')->middleware('auth');
Route::get('/kategori/destroy{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy')->middleware('auth');

//Data Aset
Route::get('/data_aset', [DataAsetController::class, 'data_aset'])->name('data_aset')->middleware('auth');
Route::post('/aset/store', [DataAsetController::class, 'store'])->name('aset.store')->middleware('auth');
Route::put('/aset/update/{id}', [DataAsetController::class, 'update'])->name('aset.update')->middleware('auth');
Route::delete('/aset/destroy{id}', [DataAsetController::class, 'destroy'])->name('aset.destroy')->middleware('auth');

//Data Aset User
Route::get('/aset_user', [AsetUserController::class, 'aset_user'])->name('aset_user')->middleware('auth');

//Data Peminjaman

Route::get('/data_peminjaman', [DataPeminjamanController::class, 'index'])->name('data_peminjaman.index')->middleware('auth');
Route::post('/data_peminjaman/store', [DataPeminjamanController::class, 'store'])->name('data_peminjaman.store')->middleware('auth');

//Peminjaman Admin
Route::get('/peminjaman-admin', [PeminjamanAdminController::class, 'peminjaman_admin'])->name('peminjaman-admin')->middleware('auth');
Route::put('/peminjaman/update/{id}', [PeminjamanAdminController::class, 'update'])->name('peminjaman.update')->middleware('auth');
Route::delete('/peminjaman/destroy/{id}', [PeminjamanAdminController::class, 'destroy'])->name('peminjaman.destroy')->middleware('auth');
Route::put('/peminjaman-admin/update/{id}', [PeminjamanAdminController::class, 'update'])->name('peminjaman-admin.update')->middleware('auth');
// Route::post('/peminjaman/terima', [PeminjamanAdminController::class, 'terimaPeminjaman'])->name('peminjaman.terima');

// Route::get('peminjaman-admin', [PeminjamanAdminController::class, 'peminjaman_admin']);
Route::post('peminjaman-admin/terima', [PeminjamanAdminController::class, 'terimaPeminjaman'])->name('peminjaman-admin.terima');

//Data Aset Keluar
Route::get('/aset_keluar', [AsetKeluarController::class, 'aset_keluar'])->name('aset_keluar')->middleware('auth');
Route::post('/aset_keluar/store', [AsetKeluarController::class, 'store'])->name('aset_keluar.store')->middleware('auth');
Route::put('/aset_keluar/update/{id}', [AsetKeluarController::class, 'update'])->name('aset_keluar.update')->middleware('auth');
Route::delete('/aset_keluar/destroy/{id}', [AsetKeluarController::class, 'destroy'])->name('aset_keluar.destroy')->middleware('auth');

//Cetak Data Aset
Route::get('/cetak-data-aset', [CetakAsetController::class, 'cetak'])->name('cetak-data-aset')->middleware('auth');
Route::post('/data-aset/pdf', [CetakAsetController::class, 'dataAsetPdf'])->name('data-aset.pdf')->middleware('auth');

//Cetak Data Qr Code
Route::get('/cetak-qr-code', [CetakQrController::class, 'cetak_qr'])->name('cetak-qr-code')->middleware('auth');
Route::get('/qr-code-pdf', [CetakQrController::class, 'cetak_qr_pdf'])->name('qr-code-pdf')->middleware('auth');

//Detail Qr Code
Route::get('/data-aset/{id}', [DataAsetController::class, 'show'])->name('detail.data_aset');