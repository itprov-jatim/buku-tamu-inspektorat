<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LookupsController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Membuka Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');
Route::get('/peminjaman/mobil', [LandingPageController::class, 'indexPeminjaman'])->name('landing.peminjaman.mobil');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Edit Profile bisa diakses semua role yang sudah login
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit')->middleware('auth');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// Report dan mengunduh laporan bisa diakses oleh semua role yang sudah login
Route::get('/report', [ReportController::class, 'index'])->name('report.index')->middleware('auth');
Route::get('/report/print', [ReportController::class, 'print'])->name('report.print')->middleware('auth');

Route::middleware(['auth', 'role:super_admin,resepsionis'])->group(function () {
    // Manajemen data lookups
    Route::resource('lookups', LookupsController::class);

    // Manajemen kartu akses tamu
    Route::get('/kartu_akses', [LookupsController::class, 'indexKartuAkses'])->name('kartu_akses.index');
    Route::get('/kartu_akses/return', [BukuTamuController::class, 'returnKartuAkses'])->name('kartu_akses.return');
    Route::post('/kartu_akses/return/submit', [BukuTamuController::class, 'submitKartuAkses'])->name('kartu_akses.submit');
    
    // Fitur pencarian untuk proses input data tamu
    Route::get('/bukutamu/cari-instansi', [BukuTamuController::class, 'cariInstansi'])->name('bukutamu.searchInstansi');
    Route::get('/bukutamu/cari-keperluan', [BukuTamuController::class, 'cariKeperluan'])->name('bukutamu.searchKeperluan');
    Route::get('/bukutamu/cari-kartuakses', [BukuTamuController::class, 'cariKartuAkses'])->name('bukutamu.searchKartuAkses');
    Route::get('/bukutamu/cari-tamu', [BukuTamuController::class, 'cariNomorIdentitasTamu'])->name('bukutamu.cari-tamu');
    
    // Manajemen buku tamu
    Route::resource('bukutamu', BukuTamuController::class)->names('bukutamu');
});

// Manajemen user hanya bisa diakses oleh role Super Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Monitor dapat melihat data buku tamu dan data lookups tanpa melakukan CRUD
Route::middleware(['auth', 'role:monitor'])->group(function () {
    Route::get('/monitor/bukutamu', [MonitorController::class, 'bukuTamu'])->name('monitor.bukutamu');
    Route::get('/monitor/lookups', [MonitorController::class, 'lookups'])->name('monitor.lookups');
});