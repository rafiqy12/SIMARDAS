<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Dokumen_detail;
use App\Http\Controllers\Home;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Manajemen_user;
use App\Http\Controllers\Register;
use App\Http\Controllers\Scan_dokumen;
use App\Http\Controllers\Search;
use App\Http\Controllers\Tambah_user;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginPage')->name('login.page');
    Route::post('login', 'login')->name('login.submit');
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
    Route::get('dokumen_detail', 'ShowDokumenDetailPage')->name('dokumen_detail.page');
});

Route::controller(Dokumen_isi::class)->group(function () {
    Route::get('dokumen_isi', 'ShowDokumenisiPage')->name('dokumen_isi.page');
});

Route::controller(Scan_dokumen::class)->group(function () {
    Route::get('scan_dokumen', 'ShowScanDokumenPage')->name('scan_dokumen.page');
});

Route::controller(Manajemen_user::class)->group(function () {
    Route::get('manajemen_user', 'ShowManajemenUserPage')->name('manajemen_user.page');
});

Route::controller(Tambah_user::class)->group(function () {
    Route::get('tambah_user', 'ShowTambahUserPage')->name('tambah_user.page');
});