@extends('layouts.app')
@section('content')
<div class="container py-5">

    <div class="row align-items-center">
        <!-- TEXT / LEFT -->
        <div class="col-lg-6">

            <span class="badge rounded-pill bg-light text-primary border mb-3">
                Transformasi Digital Layanan Publik
            </span>

            <h2 class="fw-bold">
                Sistem Informasi Manajemen <br>
                <span class="text-primary">Arsip Daerah Kabupaten Serang</span>
            </h2>

            <p class="text-muted">
                Mewujudkan tata kelola arsip daerah yang modern, efisien, dan akuntabel melalui
                digitalisasi dan sistem manajemen arsip elektronik yang terintegrasi.
            </p>

            <!-- BUTTONS -->
            <div class="d-flex gap-2 mt-4">
                <a href="#" class="btn btn-primary px-4">Akses Sistem →</a>
                <a href="#" class="btn btn-outline-primary px-4">Panduan Penggunaan</a>
            </div>

            <!-- STAT BOXES -->
            <div class="row text-center mt-4">
                <div class="col-4">
                    <div class="shadow-sm rounded p-3 bg-white">
                        <h5 class="fw-bold mb-0">15K+</h5>
                        <small class="text-muted">Dokumen Digital</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="shadow-sm rounded p-3 bg-white">
                        <h5 class="fw-bold mb-0">100%</h5>
                        <small class="text-muted">Aman & Terenkripsi</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="shadow-sm rounded p-3 bg-white">
                        <h5 class="fw-bold mb-0">24/7</h5>
                        <small class="text-muted">Akses Online</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- IMAGE / RIGHT -->
        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{asset('images/brangkas arsip.jpg')}}" class="w-100" alt="Foto Gedung">

                <!-- STATUS BOX -->
                <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                    <span class="text-success fw-bold">● Aktif dan Berjalan</span>
                    <span class="fw-semibold">99.9%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FITUR SECTION -->
<div class="container text-center mt-5">

    <span class="badge bg-light text-primary border mb-3">Fitur Unggulan</span>

    <h3 class="fw-bold">
        Fitur Sistem yang Lengkap dan <span class="text-primary">Terintegrasi</span>
    </h3>

    <p class="text-muted w-75 mx-auto">
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