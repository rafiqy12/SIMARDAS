<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMARDAS</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ============================================
           SIMARDAS - BLUE THEME STYLING
           Primary: #2563eb, #3b82f6, #1d4ed8
        ============================================ */
        
        :root {
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --primary-800: #1e40af;
            --primary-900: #1e3a8a;
        }
        
        body {
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Animated gradient background for header */
        .header-gradient {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 50%, var(--primary-800) 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Navbar styling */
        .navbar-custom {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 2px solid var(--primary-100);
        }
        
        .navbar-custom .nav-link {
            color: #475569;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--primary-600);
        }
        
        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-500);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar-custom .nav-link:hover::after {
            width: 80%;
        }
        
        /* Dropdown styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 8px;
            background-color: #ffffff;
            animation: fadeInDown 0.3s ease;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            transition: all 0.2s ease;
            color: #334155;
            background-color: transparent;
        }
        
        .dropdown-item:hover, .dropdown-item:focus {
            background: var(--primary-50);
            color: var(--primary-700);
            transform: translateX(5px);
        }
        
        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
            color: #fff !important;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            transform: translateY(-2px);
            color: #fff !important;
        }
        
        .btn-primary:focus, .btn-primary:active {
            color: #fff !important;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-500);
            color: var(--primary-600);
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-500);
            border-color: var(--primary-500);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        /* Card hover effects */
        .card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .card:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }
        
        /* Stat boxes on home page */
        .stat-box {
            background: linear-gradient(135deg, #ffffff 0%, var(--primary-50) 100%);
            border: 1px solid var(--primary-100);
            transition: all 0.3s ease;
        }
        
        .stat-box:hover {
            border-color: var(--primary-300);
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.15);
        }
        
        .stat-box h5 {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Badge styling */
        .badge-primary-soft {
            background: var(--primary-100);
            color: var(--primary-700);
            font-weight: 500;
        }
        
        /* Footer styling */
        .footer-gradient {
            background: linear-gradient(180deg, var(--primary-700) 0%, var(--primary-900) 100%);
        }
        
        .footer-gradient a {
            transition: all 0.3s ease;
        }
        
        .footer-gradient a:hover {
            color: var(--primary-200) !important;
            transform: translateX(3px);
        }
        
        /* Social buttons */
        .social-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .social-btn:hover {
            background: white;
            color: var(--primary-600);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Feature cards */
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        
        .feature-card:hover {
            border-color: var(--primary-300);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.1);
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            background: var(--primary-100);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: var(--primary-50);
            font-size: 1.5rem;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }
        
        /* Pulse animation for status indicators */
        .status-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Floating animation */
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* Shimmer effect for loading states */
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
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

        /* Custom container width */
        .container {
            max-width: 1400px;
        }

        @media (min-width: 1200px) {
            .container {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        /* Mobile responsive improvements */
        @media (max-width: 767.98px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            /* Header top bar mobile - fixed */
            .header-gradient {
                padding: 0.5rem 0;
            }
            
            .header-gradient .container {
                flex-wrap: nowrap;
            }

            .header-title {
                min-width: 0;
                flex: 1;
            }
            
            .header-title h5 {
                font-size: 0.95rem;
                white-space: nowrap;
            }

            .header-title small {
                font-size: 0.65rem;
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Navbar mobile spacing */
            .navbar-custom {
                padding: 0.25rem 0;
            }
            
            .navbar-toggler {
                padding: 0.25rem 0.5rem;
                font-size: 1rem;
                border: 1px solid rgba(0,0,0,0.1);
            }
            
            .navbar-collapse {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
                background: white;
                margin-top: 0.5rem;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            
            /* Ensure navbar collapse shows properly on mobile */
            .navbar-collapse.show,
            .navbar-collapse.collapsing {
                display: block !important;
            }

            .navbar-nav {
                gap: 0 !important;
            }

            .navbar-nav .nav-link {
                padding: 0.65rem 1rem !important;
                border-bottom: 1px solid #f1f5f9;
                font-size: 0.875rem;
            }
            
            .navbar-nav .nav-link:last-child {
                border-bottom: none;
            }
            
            .navbar-nav .nav-link::after {
                display: none;
            }
            
            .dropdown-menu {
                border: none;
                box-shadow: none;
                background: #f8fafc;
                margin: 0;
                padding-left: 1rem;
                position: static !important;
                transform: none !important;
                display: none;
            }
            
            .dropdown-menu.show {
                display: block;
            }
            
            .dropdown-toggle::after {
                transition: transform 0.3s ease;
            }
            
            .dropdown.show .dropdown-toggle::after {
                transform: rotate(180deg);
            }
            
            .dropdown-item {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                color: #334155;
                background-color: transparent;
            }
            .dropdown-item:hover, .dropdown-item:focus {
                background: var(--primary-50);
                color: var(--primary-700);
            }

            /* User greeting mobile */
            .user-greeting-section {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.5rem !important;
                margin-top: 0.75rem;
                padding-top: 0.75rem;
                border-top: 1px solid #e2e8f0;
            }
            
            .user-greeting-section span {
                text-align: center;
                padding: 0.5rem;
                background: var(--primary-50);
                border-radius: 8px;
            }
            
            .user-greeting-section form {
                width: 100%;
            }
            
            .user-greeting-section .btn {
                width: 100%;
                justify-content: center;
            }

            /* Footer mobile */
            footer .col-md-3 {
                text-align: center;
            }

            footer .d-flex.gap-2 {
                justify-content: center;
            }
            
            .footer-gradient {
                padding-top: 2rem !important;
            }
        }
        
        /* Small mobile devices */
        @media (max-width: 375px) {
            .header-title h5 {
                font-size: 0.85rem;
            }
            
            .header-title small {
                font-size: 0.6rem;
            }
            
            .header-gradient img {
                width: 30px !important;
            }
        }

        /* Tablet responsive */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        
        /* Text gradient effect */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-700) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Page transition */
        .page-content {
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-light">
    <header>
        <!-- BAGIAN ATAS (biru gradient, elegan) -->
        <div class="header-gradient py-2 border-bottom shadow-sm">
            <div class="container d-flex align-items-center">
                <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" alt="Logo" width="45" class="me-2 d-none d-sm-block">
                <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" alt="Logo" width="35" class="me-2 d-sm-none">

            <div class="d-flex flex-column lh-1 header-title">
                <h5 class="m-0 fw-bold text-white">SIMARDAS</h5>
                <small class="text-white-50 d-none d-md-block" style="margin-top:-2px;">
                    Sistem Informasi Manajemen Arsip Daerah Serang
                </small>
                <small class="text-white-50 d-md-none" style="margin-top:-2px; font-size: 0.65rem;">
                    Manajemen Arsip Daerah
                </small>
            </div>
            </div>
        </div>

        <!-- BAGIAN BAWAH (putih dengan subtle gradient) -->
        <nav class="navbar navbar-expand-lg navbar-custom py-1">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMenu">

                    <!-- MENU KIRI -->
                    <ul class="navbar-nav me-auto mb-1 mb-lg-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link small active py-2 px-2" href="{{ route('home.page') }}">Beranda</a>
                        </li>
                        @if(Auth::check() && Auth::user()->role === 'Admin')
                        <li class="nav-item">
                            <a class="nav-link small py-2 px-2" href="{{ route('dashboard.page') }}">Dashboard</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link small py-2 px-2" href="#">Profil</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link small py-2 px-2 dropdown-toggle" href="#" id="fiturDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Fitur Sistem
                            </a>
                        <ul class="dropdown-menu" aria-labelledby="fiturDropdown">
                            <li><a class="dropdown-item" href="{{ route('search.page') }}">Search</a></li>
                            @if(Auth::check() && in_array(Auth::user()->role, ['Admin', 'Petugas']))
                            <li><a class="dropdown-item" href="{{ route('scan_dokumen.page') }}">Scan</a></li>
                            <li><a class="dropdown-item" href="{{ route('dokumen_upload.page') }}">Upload</a></li>
                            @endif
                            @if(Auth::check() && Auth::user()->role === 'Petugas')
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('arsip.public') }}">Manajemen Arsip</a></li>
                            @endif
                        </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link small py-2 px-2" href="#">Kontak</a>
                        </li>
                    </ul>

                    <!-- USER GREETING & LOGOUT -->
                    <div class="d-flex align-items-center gap-2 user-greeting-section">
                        @auth
                        <span class="text-muted small me-1">
                            Halo, <strong>{{ Auth::user()->nama }}</strong>
                        </span>
                        @endauth
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="page-content">
        @yield('content')
    </main>

    <footer class="footer-gradient text-white pt-5 mt-5">
        <div class="container pb-4">
            <div class="row gy-4">

                <!-- Profil Instansi -->
                <div class="col-md-3">
                    <div class="d-flex mb-3">
                        <img src="{{asset('images/Logo_kabupaten_serang.png')}}" width="60" class="me-2" alt="Logo">
                        <div>
                            <h6 class="fw-bold mb-0">PEMKAB SERANG</h6>
                            <small class="opacity-75">Sistem Informasi Manajemen Arsip Daerah Serang</small>
                        </div>
                    </div>
                    <p class="small opacity-75">
                    Sistem Digitalisasi dan Manajemen Arsip Daerah Kabupaten Serang –
                    Mewujudkan tata kelola arsip yang modern dan efisien.
                </p>
            </div>

            <!-- Tautan Cepat -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-link-45deg me-1"></i>Tautan Cepat
                </h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home.page') }}" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Beranda</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Profil</a></li>
                    <li><a href="{{ route('search.page') }}" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Fitur Sistem</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Layanan</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-gear me-1"></i>Layanan
                </h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Upload Arsip</a></li>
                    <li><a href="{{ route('search.page') }}" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Pencarian Dokumen</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-2 opacity-75"><i class="bi bi-chevron-right me-1"></i>Bantuan & Panduan</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-envelope me-1"></i>Kontak Kami
                </h6>

                <p class="small mb-2 opacity-75">
                    <i class="bi bi-geo-alt-fill me-2 text-info"></i>
                    Jl. Raya Serang-Jakarta KM 5, Serang, Banten 42116
                </p>

                <p class="small mb-2 opacity-75">
                    <i class="bi bi-telephone-fill me-2 text-info"></i>
                    (0254) 200-100
                </p>

                <p class="small mb-3 opacity-75">
                    <i class="bi bi-envelope-fill me-2 text-info"></i>
                    arsip@serangkab.go.id
                </p>

                <h6 class="fw-bold mb-2">Media Sosial</h6>

                <div class="d-flex gap-2">
                    <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- Garis pemisah -->
    <div class="border-top" style="border-color: rgba(255,255,255,0.1) !important;"></div>

    <!-- Bagian bawah -->
    <div class="container text-center text-md-start py-3 small">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0 opacity-75">
                <i class="bi bi-c-circle me-1"></i>2025 Pemerintah Kabupaten Serang. Hak Cipta Dilindungi.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white text-decoration-none me-3 opacity-75">Kebijakan Privasi</a>
                <a href="#" class="text-white text-decoration-none me-3 opacity-75">Syarat & Ketentuan</a>
                <a href="#" class="text-white text-decoration-none opacity-75">Peta Situs</a>
            </div>
            </div>
        </div>

    </footer>

    @stack('scripts')
    
    <!-- Bootstrap JS (wajib untuk dropdown dan navbar toggle) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6DQD1Cj6kHkRb114F8C26EwAOH8WgZl5F49z6Q4b6B7x" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fallback: Manual toggle for navbar if Bootstrap JS doesn't work
            var toggler = document.querySelector('.navbar-toggler');
            var navbarCollapse = document.getElementById('navbarMenu');
            
            if (toggler && navbarCollapse) {
                toggler.addEventListener('click', function(e) {
                    e.preventDefault();
                    navbarCollapse.classList.toggle('show');
                    
                    // Update aria-expanded
                    var isExpanded = navbarCollapse.classList.contains('show');
                    toggler.setAttribute('aria-expanded', isExpanded);
                });
            }
            
            // Mobile: handle dropdown toggle on click
            if (window.innerWidth < 992) {
                var dropdownToggles = document.querySelectorAll('.navbar .dropdown-toggle');
                dropdownToggles.forEach(function(toggle) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var parent = this.closest('.dropdown');
                        var menu = parent.querySelector('.dropdown-menu');
                        
                        // Close other dropdowns first
                        document.querySelectorAll('.navbar .dropdown').forEach(function(other) {
                            if (other !== parent) {
                                other.classList.remove('show');
                                var otherMenu = other.querySelector('.dropdown-menu');
                                if (otherMenu) otherMenu.classList.remove('show');
                            }
                        });
                        
                        // Toggle current dropdown
                        parent.classList.toggle('show');
                        if (menu) menu.classList.toggle('show');
                    });
                });
            }
            
            // Desktop: keep dropdown open on hover
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

    <!-- SweetAlert2 Delete Confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const itemName = this.getAttribute('data-name') || 'data ini';
                    
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `
                            <div style="margin: 1rem 0;">
                                <p style="color: #475569; margin-bottom: 0.5rem;">Apakah Anda yakin ingin menghapus:</p>
                                <p style="font-weight: 600; color: #1e293b; font-size: 1.1rem; margin: 0.5rem 0; padding: 0.5rem; background: #fee2e2; border-radius: 8px; border-left: 4px solid #dc2626;">"${itemName}"</p>
                                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 1rem;"><i class="bi bi-exclamation-circle me-1"></i>Tindakan ini tidak dapat dibatalkan</p>
                            </div>
                        `,
                        icon: 'warning',
                        iconColor: '#f59e0b',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#3b82f6',
                        confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus',
                        cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
                        reverseButtons: true,
                        focusCancel: true,
                        customClass: {
                            popup: 'swal-popup-custom',
                            title: 'swal-title-custom',
                            confirmButton: 'swal-confirm-btn',
                            cancelButton: 'swal-cancel-btn'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>

    <style>
        /* SweetAlert2 Custom Theme */
        .swal-popup-custom {
            border-radius: 20px !important;
            padding: 1.5rem !important;
            border-top: 4px solid #3b82f6 !important;
        }
        .swal-title-custom {
            color: #1e293b !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }
        .swal-confirm-btn {
            border-radius: 10px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3) !important;
        }
        .swal-cancel-btn {
            border-radius: 10px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
        }

        /* Reusable Button Styles */
        .btn-back {
            border-radius: 8px;
            background: #64748b;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-back:hover {
            transform: translateX(-3px);
            background: #475569;
        }
        .btn-download {
            border-radius: 8px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            transition: all 0.2s ease;
        }
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }

        /* Reusable Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
        }
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }
        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        /* Reusable Page Header */
        .page-header {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #bfdbfe;
        }

        /* Reusable Form Styles */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
    </style>
</body>
</html>