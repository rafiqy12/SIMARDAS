@extends('layouts.app_admin')

@section('title', 'Dashboard - SIMARDAS')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-3">
        <h4 class="fw-bold fs-5 fs-md-4">Selamat datang di SIMARDAS</h4>
        <p class="text-muted small">Sistem Manajemen dan Digitalisasi Arsip Daerah</p>

        <div class="row text-center mt-4 g-2 g-md-3">
            <!-- Total Arsip -->
            <div class="col-6 col-md-3">
                <div class="card border p-2 p-md-3 shadow-sm h-100">
                    <h6 class="small mb-1">Total Arsip</h6>
                    <h3 class="fw-bold fs-4 mb-0">1076</h3>
                </div>
            </div>

            <!-- Total User -->
            <div class="col-6 col-md-3">
                <div class="card border p-2 p-md-3 shadow-sm h-100">
                    <h6 class="small mb-1">Total User</h6>
                    <h3 class="fw-bold fs-4 mb-0">165</h3>
                </div>
            </div>

            <!-- Arsip Bulan Ini -->
            <div class="col-6 col-md-3">
                <div class="card border p-2 p-md-3 shadow-sm h-100">
                    <h6 class="small mb-1">Arsip Bulan Ini</h6>
                    <h3 class="fw-bold fs-4 mb-0">21</h3>
                </div>
            </div>

            <!-- Storage -->
            <div class="col-6 col-md-3">
                <div class="card border p-2 p-md-3 shadow-sm h-100">
                    <h6 class="small mb-1">Storage</h6>
                    <h3 class="fw-bold fs-4 mb-0">50,5 GB</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ROW CONTENT -->
<div class="row mt-3 mt-md-4 g-3">
    <!-- Aktivitas Terbaru -->
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-2 small">Aktifitas Terbaru</div>
            <div class="card-body p-2 p-md-3">
                <!-- ITEM -->
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-file-earmark-text fs-5 text-primary me-2 me-md-3"></i>
                    <div>
                        <b class="small">Mika Rendang Menambahkan Arsip Baru</b>
                        <p class="text-muted small m-0">Dinas Perindag Kabupaten Serang • 1 jam lalu</p>
                    </div>
                </div>

                <hr class="my-2">

                <div class="d-flex align-items-start">
                    <i class="bi bi-file-earmark-text fs-5 text-primary me-2 me-md-3"></i>
                    <div>
                        <b class="small">Mika Rendang Menambahkan Arsip Baru</b>
                        <p class="text-muted small m-0">1 jam lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Sistem -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold py-2 small">Status Sistem</div>
            <div class="card-body p-2 p-md-3">
                <p class="m-0 small">Status Server: 
                    <span class="badge bg-success">Online</span>
                </p>

                <div class="mt-3">
                    <small>Storage Usage</small>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 10.1%"></div>
                    </div>
                </div>

                <div class="mt-3">
                    <small>Backup Status</small>
                    <p class="m-0 text-success small">Backup Terakhir: 3 November 2025</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QUICK ACTION -->
<div class="card shadow-sm mt-4">
    <div class="card-header bg-white fw-bold">Quick Action</div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <a class="btn btn-outline-primary w-100 py-3" href="{{ route('dokumen_upload.page') }}">
                    <i class="bi bi-file-earmark-arrow-up fs-3 d-block"></i> Upload Dokumen
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a class="btn btn-outline-primary w-100 py-3" href="{{ route('search.page') }}">
                    <i class="bi bi-search fs-3 d-block"></i> Cari Arsip
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a class="btn btn-outline-primary w-100 py-3" href="{{ route('home.page') }}">
                    <i class="bi bi-house fs-3 d-block"></i> Home Page
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
