@extends('layouts.app_admin')
@section('content')

<div class="d-flex">

    <!-- SIDEBAR -->
    <aside class="bg-white border-end" style="width: 250px; min-height: 100vh;">
        <div class="text-center py-4 border-bottom">
            <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="70" class="mb-2">
            <h6 class="fw-bold m-0">SIMARDAS</h6>
            <small class="text-muted">Sistem Manajemen Arsip</small>
        </div>

        <nav class="nav flex-column p-3 gap-2">
            <a href="#" class="nav-link btn btn-primary text-white text-start">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>

            <a href="#" class="nav-link btn btn-light text-start border">
                <i class="bi bi-cloud-arrow-down me-2"></i> Backup dan restore data
            </a>

            <a href="{{ route('manajemen_user.page') }}" class="nav-link btn btn-light text-start border">
                <i class="bi bi-people me-2"></i> Manajemen Pengguna
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-grow-1">

        <!-- HEADER BAR -->
        <div class="bg-primary text-white py-2 px-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0">Dashboard Admin</h6>
            <a href="#" class="btn btn-light btn-sm">Logout</a>
        </div>

        <!-- IDENTITAS -->
        <div class="p-3 bg-white border-bottom d-flex align-items-center">
            <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="60" class="me-3">
            <div>
                <h5 class="m-0">PEMERINTAH KABUPATEN SERANG</h5>
                <small class="text-muted">Sistem Digitalisasi dan Manajemen Arsip Daerah</small>
            </div>
        </div>

        <!-- WELCOME BOX -->
        <div class="p-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">Selamat datang di SIMARDAS</h4>
                    <p class="text-muted">Sistem Manajemen dan Digitalisasi Arsip Daerah</p>

                    <div class="row text-center mt-4">

                        <!-- Total Arsip -->
                        <div class="col-md-3">
                            <div class="card border p-3 shadow-sm">
                                <h6>Total Arsip</h6>
                                <h3 class="fw-bold">1076</h3>
                            </div>
                        </div>

                        <!-- Total User -->
                        <div class="col-md-3">
                            <div class="card border p-3 shadow-sm">
                                <h6>Total User</h6>
                                <h3 class="fw-bold">165</h3>
                            </div>
                        </div>

                        <!-- Arsip Bulan Ini -->
                        <div class="col-md-3">
                            <div class="card border p-3 shadow-sm">
                                <h6>Arsip Bulan Ini</h6>
                                <h3 class="fw-bold">21</h3>
                            </div>
                        </div>

                        <!-- Storage -->
                        <div class="col-md-3">
                            <div class="card border p-3 shadow-sm">
                                <h6>Storage Digunakan</h6>
                                <h3 class="fw-bold">50,5 GB</h3>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- ROW CONTENT -->
            <div class="row mt-4">

                <!-- Aktivitas Terbaru -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white fw-bold">Aktifitas Terbaru</div>
                        <div class="card-body">

                            <!-- ITEM -->
                            <div class="d-flex align-items-start mb-3">
                                <i class="bi bi-file-earmark-text fs-4 text-primary me-3"></i>
                                <div>
                                    <b>Mika Rendang Menambahkan Arsip Baru</b>
                                    <p class="text-muted small m-0">Dinas Perindag Kabupaten Serang • 1 jam lalu</p>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex align-items-start mb-3">
                                <i class="bi bi-file-earmark-text fs-4 text-primary me-3"></i>
                                <div>
                                    <b>Mika Rendang Menambahkan Arsip Baru</b>
                                    <p class="text-muted small m-0">1 jam lalu</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Status Sistem -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white fw-bold">Status Sistem</div>

                        <div class="card-body">

                            <p class="m-0">Status Server: 
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
                            <button class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-upc-scan fs-3 d-block"></i> Scan Dokumen
                            </button>
                        </div>

                        <div class="col-md-4 mb-3">
                            <button class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-search fs-3 d-block"></i> Cari Arsip
                            </button>
                        </div>

                        <div class="col-md-4 mb-3">
                            <button class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-house fs-3 d-block"></i> Home Page
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </main>

</div>

@endsection
