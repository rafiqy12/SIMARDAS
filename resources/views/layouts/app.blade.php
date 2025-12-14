<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        /* Dropdown on hover for navbar */
        @media (min-width: 992px) {
            .navbar-nav .dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
                z-index: 1051;
            }

            .navbar-nav .dropdown-menu {
                z-index: 1051;
            }
        }
    </style>
    <meta charset="UTF-8">
    <title>SIMARDAS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<header>
    <!-- BAGIAN ATAS (biru, kecil, elegan) -->
    <div class="bg-primary py-2 border-bottom shadow-sm">
        <div class="container d-flex align-items-center">
            <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" alt="Logo" width="45" class="me-2">

            <div class="d-flex flex-column lh-1">
                <h5 class="m-0 fw-bold text-white">SIMARDAS</h5>
                <small class="text-white-50" style="margin-top:-2px;">
                    Sistem Informasi Manajemen Arsip Daerah Serang
                </small>
            </div>
        </div>
    </div>

    <!-- BAGIAN BAWAH (putih, kecil, ada border) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-1">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <!-- MENU KIRI -->
                <ul class="navbar-nav me-auto mb-1 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link small active py-2 px-2" href="{{ route('home.page') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small py-2 px-2" href="#">Profil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link small py-2 px-2 dropdown-toggle" href="#" id="fiturDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Fitur Sistem
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="fiturDropdown">
                            <li><a class="dropdown-item" href="{{ route('search.page') }}">Search</a></li>
                            <li><a class="dropdown-item" href="{{ route('scan_dokumen.page') }}">Scan</a></li>
                            <li><a class="dropdown-item" href="#">Upload</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small py-2 px-2" href="#">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small py-2 px-2" href="#">Kontak</a>
                    </li>
                </ul>

                <!-- LOGOUT -->
                <a href="{{ route('login.page') }}" class="btn btn-primary btn-sm px-3 py-1">
                    Logout
                </a>

            </div>
        </div>
    </nav>
</header>

<body class="bg-light">
    {{-- MAIN CONTENT --}}
    <div class="container-fluid p-0">
        @yield('content')
    </div>
    @stack('scripts')
</body>

<footer class="bg-primary text-white pt-5 mt-5">
    <div class="container pb-4">
        <div class="row gy-4">

            <!-- Profil Instansi -->
            <div class="col-md-3">
                <div class="d-flex mb-3">
                    <img src="{{asset('images/Logo_kabupaten_serang.png')}}" width="60" class="me-2" alt="Logo">
                    <div>
                        <h6 class="fw-bold mb-0">PEMKAB SERANG</h6>
                        <small>Sistem Informasi Manajemen Arsip Daerah Serang</small>
                    </div>
                </div>
                <p class="small">
                    Sistem Digitalisasi dan Manajemen Arsip Daerah Kabupaten Serang –
                    Mewujudkan tata kelola arsip yang modern dan efisien.
                </p>
            </div>

            <!-- Tautan Cepat -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Beranda</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Profil</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Fitur Sistem</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Layanan</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Layanan</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Upload Arsip</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Pencarian Dokumen</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Bantuan & Panduan</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Kontak Kami</h6>

                <p class="small mb-1">
                    <i class="bi bi-geo-alt me-2"></i>
                    Jl. Raya Serang-Jakarta KM 5, Serang, Banten 42116
                </p>

                <p class="small mb-1">
                    <i class="bi bi-telephone me-2"></i>
                    (0254) 200-100
                </p>

                <p class="small mb-3">
                    <i class="bi bi-envelope me-2"></i>
                    arsip@serangkab.go.id
                </p>

                <h6 class="fw-bold mb-2">Media Sosial</h6>

                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- Garis pemisah -->
    <div class="border-top border-light"></div>

    <!-- Bagian bawah -->
    <div class="container text-center text-md-start py-3 small">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                © 2025 Pemerintah Kabupaten Serang. Hak Cipta Dilindungi.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white text-decoration-none me-3">Kebijakan Privasi</a>
                <a href="#" class="text-white text-decoration-none me-3">Syarat & Ketentuan</a>
                <a href="#" class="text-white text-decoration-none">Peta Situs</a>
            </div>
        </div>
    </div>

</footer>

</html>
<!-- Bootstrap JS (wajib untuk dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6DQD1Cj6kHkRb114F8C26EwAOH8WgZl5F49z6Q4b6B7x" crossorigin="anonymous"></script>
<script>
    // Bootstrap 5: keep dropdown open on hover for all dropdowns in navbar
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth >= 992) {
            var dropdowns = document.querySelectorAll('.navbar .dropdown');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('mouseenter', function() {
                    this.classList.add('show');
                    var menu = this.querySelector('.dropdown-menu');
                    if (menu) menu.classList.add('show');
                });
                dropdown.addEventListener('mouseleave', function() {
                    this.classList.remove('show');
                    var menu = this.querySelector('.dropdown-menu');
                    if (menu) menu.classList.remove('show');
                });
            });
        }
    });
</script>