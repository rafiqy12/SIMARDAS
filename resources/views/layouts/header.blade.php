<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
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
                        <a class="nav-link small py-2 px-2" href="{{ route('profile.page') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small py-2 px-2" href="{{ route('search.page') }}">Fitur Sistem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small py-2 px-2" href="{{ route('search.page') }}">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link small py-2 px-2" href="{{ route('kontak.page') }}">Kontak</a>
                    </li>
                </ul>

                <!-- LOGOUT -->
                <a href="#" class="btn btn-primary btn-sm px-3 py-1">
                    Logout
                </a>

            </div>
        </div>
    </nav>
</header>
</body>
</html>