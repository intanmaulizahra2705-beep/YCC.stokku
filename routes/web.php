<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    Route::middleware('role:admin')->group(function () {
        Route::resource('barang', BarangController::class)->except('show');
        Route::resource('kategori', KategoriController::class)->except('show');
        Route::resource('supplier', SupplierController::class)->except('show');
        Route::resource('user', UserController::class)->except('show');
    });

    Route::middleware('role:staf')->group(function () {
        Route::get('/stok-masuk', [StokMasukController::class, 'index'])->name('stok-masuk.index');
        Route::post('/stok-masuk', [StokMasukController::class, 'store'])->name('stok-masuk.store');
        Route::get('/stok-keluar', [StokKeluarController::class, 'index'])->name('stok-keluar.index');
        Route::post('/stok-keluar', [StokKeluarController::class, 'store'])->name('stok-keluar.store');
    });
});