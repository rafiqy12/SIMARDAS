@extends('layouts.app')
@section('content')
<div class="container py-4 py-lg-5">

    <div class="row align-items-center">
        <!-- TEXT / LEFT -->
        <div class="col-lg-6 mb-4 mb-lg-0">

            <span class="badge rounded-pill badge-primary-soft border border-primary-subtle mb-3 px-3 py-2">
                <i class="bi bi-lightning-charge-fill me-1"></i>Transformasi Digital Layanan Publik
            </span>

            <h2 class="fw-bold fs-3 fs-md-2">
                Sistem Informasi Manajemen <br class="d-none d-lg-block">
                <span class="text-gradient">Arsip Daerah Kabupaten Serang</span>
            </h2>

            <p class="text-muted lead" style="font-size: 1rem;">
                Mewujudkan tata kelola arsip daerah yang modern, efisien, dan akuntabel melalui
                digitalisasi dan sistem manajemen arsip elektronik yang terintegrasi.
            </p>

            <!-- BUTTONS -->
            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                <a href="{{ route('search.page') }}" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-search me-1"></i>Akses Sistem <i class="bi bi-arrow-right ms-1"></i>
                </a>
                <a href="#" class="btn btn-outline-primary px-4 py-2">
                    <i class="bi bi-book me-1"></i>Panduan Penggunaan
                </a>
            </div>

            <!-- STAT BOXES -->
            <div class="row text-center mt-4 g-2">
                <div class="col-4">
                    <div class="stat-box shadow-sm rounded-3 p-2 p-md-3">
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">
                            <i class="bi bi-file-earmark-text me-1"></i>15K+
                        </h5>
                        <small class="text-muted" style="font-size: 0.7rem;">Dokumen Digital</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-box shadow-sm rounded-3 p-2 p-md-3">
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">
                            <i class="bi bi-shield-check me-1"></i>100%
                        </h5>
                        <small class="text-muted" style="font-size: 0.7rem;">Aman & Terenkripsi</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="stat-box shadow-sm rounded-3 p-2 p-md-3">
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">
                            <i class="bi bi-clock me-1"></i>24/7
                        </h5>
                        <small class="text-muted" style="font-size: 0.7rem;">Akses Online</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- IMAGE / RIGHT -->
        <div class="col-lg-6">
            <div class="card border-0 shadow rounded-4 overflow-hidden" style="border: 2px solid var(--primary-100) !important;">
                <img src="{{asset('images/brangkas arsip.jpg')}}" class="w-100" alt="Foto Gedung" style="max-height: 350px; object-fit: cover;">

                <!-- STATUS BOX -->
                <div class="p-2 p-md-3 bg-white d-flex justify-content-between align-items-center">
                    <span class="text-success fw-bold small">
                        <i class="bi bi-circle-fill me-1 status-pulse" style="font-size: 0.5rem;"></i>Aktif dan Berjalan
                    </span>
                    <span class="badge bg-success px-3">
                        <i class="bi bi-graph-up me-1"></i>99.9% Uptime
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FITUR SECTION -->
<div class="container text-center mt-4 mt-lg-5 px-3">

    <span class="badge badge-primary-soft border border-primary-subtle mb-3 px-3 py-2">
        <i class="bi bi-stars me-1"></i>Fitur Unggulan
    </span>

    <h3 class="fw-bold fs-4 fs-lg-3">
        Fitur Sistem yang Lengkap dan <span class="text-gradient">Terintegrasi</span>
    </h3>

    <p class="text-muted mx-auto" style="max-width: 600px;">
        Berbagai fitur canggih untuk mendukung pengelolaan arsip daerah 
        yang modern, efisien, dan sesuai dengan standar kearsipan nasional.
    </p>

    <!-- FITUR CARDS -->
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="feature-card h-100 text-center">
                <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);">
                    <i class="bi bi-cloud-arrow-up-fill text-primary"></i>
                </div>
                <h5 class="fw-bold">Upload Dokumen Arsip</h5>
                <p class="text-muted small mb-0">
                    Unggah dan digitalisasi dokumen fisik menjadi format digital dengan mudah dan terstruktur.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card h-100 text-center">
                <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                    <i class="bi bi-search text-success"></i>
                </div>
                <h5 class="fw-bold">Pencarian Arsip</h5>
                <p class="text-muted small mb-0">
                    Sistem pencarian canggih untuk menemukan dokumen dengan cepat berdasarkan berbagai kriteria.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card h-100 text-center">
                <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                    <i class="bi bi-download text-warning"></i>
                </div>
                <h5 class="fw-bold">Akses & Unduh Arsip</h5>
                <p class="text-muted small mb-0">
                    Akses dan unduh dokumen arsip dengan mudah sesuai dengan hak akses yang dimiliki.
                </p>
            </div>
        </div>
    </div>

    <!-- Additional Features Row -->
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="feature-card h-100 text-center">
                <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);">
                    <i class="bi bi-qr-code-scan text-purple" style="color: #7c3aed;"></i>
                </div>
                <h5 class="fw-bold">Scan Barcode</h5>
                <p class="text-muted small mb-0">
                    Pindai barcode dokumen untuk akses cepat ke informasi arsip secara instan.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card h-100 text-center">
                <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);">
                    <i class="bi bi-shield-lock-fill" style="color: #db2777;"></i>
                </div>
                <h5 class="fw-bold">Keamanan Data</h5>
                <p class="text-muted small mb-0">
                    Sistem keamanan berlapis untuk melindungi data arsip dari akses tidak sah.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card h-100 text-center">
                <div class="feature-icon mx-auto" style="background: linear-gradient(135deg, #ccfbf1 0%, #99f6e4 100%);">
                    <i class="bi bi-graph-up-arrow text-teal" style="color: #0d9488;"></i>
                </div>
                <h5 class="fw-bold">Laporan & Statistik</h5>
                <p class="text-muted small mb-0">
                    Dashboard lengkap dengan laporan dan statistik arsip secara real-time.
                </p>
            </div>
        </div>
    </div>

</div>

<!-- CTA Section -->
<div class="container mt-5 mb-4">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);">
        <div class="card-body p-4 p-lg-5 text-center text-white position-relative">
            <!-- Background decoration -->
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
            
            <div class="position-relative" style="z-index: 1;">
                <h3 class="fw-bold mb-3">
                    <i class="bi bi-rocket-takeoff me-2"></i>Mulai Kelola Arsip Anda Sekarang
                </h3>
                <p class="mb-4 opacity-75">
                    Bergabunglah dengan sistem manajemen arsip modern dan tingkatkan efisiensi pengelolaan dokumen.
                </p>
                <a href="{{ route('search.page') }}" class="btn btn-light btn-lg px-5 fw-semibold">
                    <i class="bi bi-arrow-right-circle me-2"></i>Mulai Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection