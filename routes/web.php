<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\Home;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Register;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// =============================================
// GUEST ROUTES (Tidak perlu login)
// =============================================
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'showLoginPage')->name('login.page');
    Route::post('/login', 'login')->name('login.process');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('register', [Register::class, 'ShowRegisterpage'])->name('register.page');

// =============================================
// AUTH ROUTES (Harus login - semua role)
// =============================================
Route::middleware('auth')->group(function () {
    // Home page untuk user yang sudah login
    Route::get('home', [Home::class, 'ShowHomePage'])->name('home.page');

    // Dokumen - akses untuk semua user yang sudah login
    Route::controller(DokumenController::class)->group(function () {
        Route::get('search', 'search')->name('search.page');
        Route::get('dokumen/{id}', 'show')->name('dokumen.detail');
        Route::get('dokumen/{id}/download', 'download')->name('dokumen.download');
        Route::get('dokumen/{id}/preview', 'preview')->name('dokumen.preview');
        Route::get('dokumen_isi', 'isi')->name('dokumen_isi.page');
        Route::get('scan_dokumen', 'scanPage')->name('scan_dokumen.page');
        Route::post('scan_dokumen', 'scanStore')->name('scan_dokumen.store');
        
        // Halaman arsip dengan tampilan public (navbar biasa) - untuk Petugas
        Route::get('arsip', 'publicIndex')->name('arsip.public');
    });
});

// =============================================
// PETUGAS ROUTES (Harus login + role Admin/Petugas)
// =============================================
Route::middleware(['auth', 'petugas'])->group(function () {
    // Manajemen Arsip/Dokumen - bisa diakses Admin dan Petugas
    Route::controller(DokumenController::class)->group(function () {
        Route::get('dokumen_upload', 'uploadPage')->name('dokumen_upload.page');
        Route::post('dokumen/upload', 'uploadStore')->name('dokumen_upload.store');
        Route::get('manajemen_arsip', 'index')->name('dokumen.index');
        Route::get('arsip/{id}/edit', 'edit')->name('dokumen.edit');
        Route::put('arsip/{id}', 'update')->name('dokumen.update');
        Route::delete('arsip/{id}', 'destroy')->name('dokumen.destroy');
    });
});

// =============================================
// ADMIN ROUTES (Harus login + role Admin saja)
// =============================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('dashboard', [Dashboard::class, 'ShowDashboardPage'])->name('dashboard.page');

    // Manajemen User - hanya Admin
    Route::controller(UserController::class)->group(function () {
        Route::get('manajemen_user', 'index')->name('user.index');
        Route::get('user/create', 'create')->name('user.create');
        Route::post('user', 'store')->name('user.store');
        Route::get('user/{user}/edit', 'edit')->name('user.edit');
        Route::put('user/{user}', 'update')->name('user.update');
        Route::delete('user/{user}', 'destroy')->name('user.destroy');
    });
});
