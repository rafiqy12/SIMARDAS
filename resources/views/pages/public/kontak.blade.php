@extends('layouts.app')

@section('title', 'Kontak - SIMARDAS')

@section('content')
<div class="container py-5">
    
    {{-- Header --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-2">Hubungi Kami</h2>
        <p class="text-muted">Informasi kontak Dinas Kesehatan Kabupaten Serang</p>
    </div>

    <div class="row g-4">
        
        {{-- Kolom Kiri: Info Kontak --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-building me-2 text-primary"></i>Dinas Kesehatan Kabupaten Serang
                    </h5>

                    {{-- Alamat --}}
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                                <i class="bi bi-geo-alt-fill text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Alamat</h6>
                            <p class="text-muted mb-0 small">
                                Jl. Veteran No. 1, Cipocok Jaya<br>
                                Kota Serang, Banten 42121<br>
                                Indonesia
                            </p>
                        </div>
                    </div>

                    {{-- Telepon --}}
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);">
                                <i class="bi bi-telephone-fill text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Telepon</h6>
                            <p class="text-muted mb-0 small">
                                <a href="tel:+62254801234" class="text-decoration-none text-muted">(0254) 80-1234</a><br>
                                <a href="tel:+62254801235" class="text-decoration-none text-muted">(0254) 80-1235</a>
                            </p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                                <i class="bi bi-envelope-fill text-warning"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Email</h6>
                            <p class="text-muted mb-0 small">
                                <a href="mailto:dinkes@serangkab.go.id" class="text-decoration-none text-muted">dinkes@serangkab.go.id</a><br>
                                <a href="mailto:arsip.dinkes@serangkab.go.id" class="text-decoration-none text-muted">arsip.dinkes@serangkab.go.id</a>
                            </p>
                        </div>
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);">
                                <i class="bi bi-clock-fill text-pink" style="color: #ec4899;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-semibold mb-1">Jam Operasional</h6>
                            <p class="text-muted mb-0 small">
                                Senin - Kamis: 08:00 - 16:00 WIB<br>
                                Jumat: 08:00 - 16:30 WIB<br>
                                <span class="text-danger">Sabtu & Minggu: Tutup</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Peta --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                <div class="card-body p-0">
                    {{-- Google Maps Embed (ganti dengan koordinat yang benar) --}}
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.8876508892576!2d106.14636!3d-6.1082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418ba3e0d8e8e1%3A0x7f5e7e8e8e8e8e8e!2sDinas%20Kesehatan%20Kabupaten%20Serang!5e0!3m2!1sid!2sid!4v1234567890"
                        width="100%" 
                        height="100%" 
                        style="border:0; min-height: 400px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

    </div>

    {{-- Social Media --}}
    <div class="text-center mt-5">
        <h6 class="fw-semibold mb-3">Ikuti Kami</h6>
        <div class="d-flex justify-content-center gap-3">
            <a href="#" class="btn btn-outline-primary rounded-circle" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="btn btn-outline-info rounded-circle" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-twitter"></i>
            </a>
            <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="btn btn-outline-success rounded-circle" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-whatsapp"></i>
            </a>
        </div>
    </div>

</div>
@endsection
