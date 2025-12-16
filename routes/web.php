<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\Home;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Register;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('/', [LoginController::class, 'showLoginPage'])
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

// Dokumen management (gunakan DokumenController)
Route::controller(DokumenController::class)->group(function () {
    // Public routes
    Route::get('search', 'search')->name('search.page');
    Route::get('dokumen/{id}', 'show')->name('dokumen.detail');
    Route::get('dokumen/{id}/download', 'download')->name('dokumen.download');
    Route::get('dokumen_isi', 'isi')->name('dokumen_isi.page');
    Route::get('scan_dokumen', 'scanPage')->name('scan_dokumen.page');
    Route::post('scan_dokumen', 'scanStore')->name('scan_dokumen.store');

    // Admin routes
    Route::get('dokumen_upload', 'uploadPage')->name('dokumen_upload.page');
    Route::post('dokumen/upload', 'uploadStore')->name('dokumen_upload.store');
    Route::get('manajemen_arsip', 'index')->name('dokumen.index');
    Route::get('arsip/{id}/edit', 'edit')->name('dokumen.edit');
    Route::put('arsip/{id}', 'update')->name('dokumen.update');
    Route::delete('arsip/{id}', 'destroy')->name('dokumen.destroy');
});

// User management (resourceful, gunakan UserController)
Route::middleware('auth')->group(function () {
    Route::get('manajemen_user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});
