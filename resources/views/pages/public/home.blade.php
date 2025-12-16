@extends('layouts.app')
@section('content')
<div class="container py-4 py-lg-5">

    <div class="row align-items-center">
        <!-- TEXT / LEFT -->
        <div class="col-lg-6 mb-4 mb-lg-0">

            <span class="badge rounded-pill bg-light text-primary border mb-3">
                Transformasi Digital Layanan Publik
            </span>

            <h2 class="fw-bold fs-3 fs-md-2">
                Sistem Informasi Manajemen <br class="d-none d-lg-block">
                <span class="text-primary">Arsip Daerah Kabupaten Serang</span>
            </h2>

            <p class="text-muted">
                Mewujudkan tata kelola arsip daerah yang modern, efisien, dan akuntabel melalui
                digitalisasi dan sistem manajemen arsip elektronik yang terintegrasi.
            </p>

            <!-- BUTTONS -->
            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                <a href="{{ route('search.page') }}" class="btn btn-primary px-4">Akses Sistem →</a>
                <a href="#" class="btn btn-outline-primary px-4">Panduan Penggunaan</a>
            </div>

            <!-- STAT BOXES -->
            <div class="row text-center mt-4 g-2">
                <div class="col-4">
                    <div class="shadow-sm rounded p-2 p-md-3 bg-white">
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">15K+</h5>
                        <small class="text-muted" style="font-size: 0.7rem;">Dokumen Digital</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="shadow-sm rounded p-2 p-md-3 bg-white">
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">100%</h5>
                        <small class="text-muted" style="font-size: 0.7rem;">Aman & Terenkripsi</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="shadow-sm rounded p-2 p-md-3 bg-white">
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">24/7</h5>
                        <small class="text-muted" style="font-size: 0.7rem;">Akses Online</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- IMAGE / RIGHT -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{asset('images/brangkas arsip.jpg')}}" class="w-100" alt="Foto Gedung" style="max-height: 350px; object-fit: cover;">

                <!-- STATUS BOX -->
                <div class="p-2 p-md-3 bg-white d-flex justify-content-between align-items-center">
                    <span class="text-success fw-bold small">● Aktif dan Berjalan</span>
                    <span class="fw-semibold small">99.9%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FITUR SECTION -->
<div class="container text-center mt-4 mt-lg-5 px-3">

    <span class="badge bg-light text-primary border mb-3">Fitur Unggulan</span>

    <h3 class="fw-bold fs-4 fs-lg-3">
        Fitur Sistem yang Lengkap dan <span class="text-primary">Terintegrasi</span>
    </h3>

    <p class="text-muted mx-auto" style="max-width: 600px;">
        Berbagai fitur canggih untuk mendukung pengelolaan arsip daerah 
        yang modern, efisien, dan sesuai dengan standar kearsipan nasional.
    </p>

    <!-- FITUR CARDS -->
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fs-3 mb-3">📤</div>
                    <h5 class="fw-bold">Upload Dokumen Arsip</h5>
                    <p class="text-muted small">
                        Unggah dan digitalisasi dokumen fisik menjadi format digital dengan mudah dan terstruktur.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fs-3 mb-3">🔍</div>
                    <h5 class="fw-bold">Pencarian Arsip</h5>
                    <p class="text-muted small">
                        Sistem pencarian canggih untuk menemukan dokumen dengan cepat berdasarkan berbagai kriteria.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fs-3 mb-3">📥</div>
                    <h5 class="fw-bold">Akses & Unduh Arsip</h5>
                    <p class="text-muted small">
                        Akses dan unduh dokumen arsip dengan mudah sesuai dengan hak akses yang dimiliki.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection