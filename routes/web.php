<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Dokumen_detail;
use App\Http\Controllers\Dokumen_isi;
use App\Http\Controllers\Dokumen_upload;
use App\Http\Controllers\Edit_user;
use App\Http\Controllers\Home;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Manajemen_user;
use App\Http\Controllers\Manajemen_arsip;
use App\Http\Controllers\Register;
use App\Http\Controllers\Scan_dokumen;
use App\Http\Controllers\Search;
use App\Http\Controllers\Tambah_user;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginPage'])
    ->name('login.page');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.process');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});

Route::middleware('auth')->group(function () {

    Route::get('home', [Home::class, 'ShowHomePage'])
        ->name('home.page');

    Route::get('dashboard', [Dashboard::class, 'ShowDashboardPage'])
        ->name('dashboard.page');

});

Route::controller(Register::class)->group(function () {
    Route::get('register', 'ShowRegisterpage')->name('register.page');
});

Route::controller(Home::class)->group(function () {
    Route::get('home', 'ShowHomePage')->name('home.page');
});

Route::controller(Dashboard::class)->group(function () {
    Route::get('dashboard', 'ShowDashboardPage')->name('dashboard.page');
});

Route::controller(Search::class)->group(function () {
    Route::get('search', 'ShowSearchPage')->name('search.page');
});

Route::controller(Dokumen_detail::class)->group(function () {
    Route::get('dokumen/{id}', [Dokumen_detail::class, 'ShowDokumenDetailPage'])
        ->name('dokumen.detail');
});

Route::controller(Dokumen_isi::class)->group(function () {
    Route::get('dokumen_isi', 'ShowDokumenisiPage')->name('dokumen_isi.page');
});

Route::controller(Scan_dokumen::class)->group(function () {
    Route::get('scan_dokumen', 'ShowScanDokumenPage')
        ->name('scan_dokumen.page');

    Route::post('scan_dokumen', 'store')
        ->name('scan_dokumen.store');
});

Route::controller(Dokumen_upload::class)->group(function () {
    Route::get('dokumen_upload', 'showDokumenUploadPage')
        ->name('dokumen_upload.page');

    Route::post('/dokumen/upload', [Dokumen_upload::class, 'store'])
    ->name('dokumen_upload.store');

});

Route::controller(Manajemen_user::class)->group(function () {
    Route::get('manajemen_user', 'ShowManajemenUserPage')->name('manajemen_user.page');
});

// Manajemen Arsip
Route::controller(Manajemen_arsip::class)->group(function () {
    Route::get('manajemen_arsip', 'index')->name('manajemen_arsip.page');
    Route::get('arsip/{id}/edit', 'edit')->name('arsip.edit');
    Route::put('arsip/{id}', 'update')->name('arsip.update');
    Route::delete('arsip/{id}', 'destroy')->name('arsip.destroy');
});

Route::controller(Tambah_user::class)->group(function () {
    Route::get('tambah_user', 'ShowTambahUserPage')->name('tambah_user.page');
});


// User management (resourceful, gunakan UserController)
Route::middleware('auth')->group(function () {
    Route::get('user/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
});

Route::get('/dokumen/{id}/download', [Search::class, 'download'])
    ->name('dokumen.download');
