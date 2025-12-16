<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SIMARDAS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<style>
    .admin-flex {
        display: flex;
        min-height: 100vh;
    }
    #sidebar {
        width: 250px;
        height: 100vh;
        position: sticky;
        top: 0;
        transition: margin-left 0.3s;
        background: #fff;
        z-index: 2;
        overflow-y: auto;
    }
    /* Hover effect for active menu (biru jadi putih, teks biru) */
    .btn.active-menu {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
    .btn.active-menu:hover, .btn.active-menu:focus {
        background: #E6E6E6 !important;
        color: #0d6efd !important;
    }
    .btn.active-menu:hover i, .btn.active-menu:focus i {
        color: #0d6efd !important;
    }
    #sidebarCloseBtn {
        display: none;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px auto;
        background: #adb5bd;
        color: #fff;
        border: none;
        font-size: 1.5rem;
    }
    #sidebarCloseBtn i {
        color: #fff !important;
    }
    #sidebarOpenBtn {
        display: none;
        position: fixed;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        z-index: 3;
        background: #adb5bd;
        color: #fff;
        border: none;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    #sidebarOpenBtn i {
        color: #fff !important;
    }
    @media (max-width: 991.98px) {
        #sidebar {
            margin-left: -250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
        }
        #sidebar.active {
            margin-left: 0;
        }
        #sidebarOpenBtn {
            display: flex;
            position: fixed;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
        }
        #sidebarCloseBtn {
            display: flex;
        }
    }
    @media (min-width: 992px) {
        #sidebar {
            margin-left: 0;
            position: sticky;
            top: 0;
        }
    }

    .sidebar-item {
        height: 48px;
        padding: 0 12px;
        border-color: #adb5bd !important;
        font-weight: 500;
        text-align: left;
        justify-content: flex-start !important;
        font-size: 0.85rem;
    }

    .menu-icon {
        width: 22px;
        min-width: 22px;
        text-align: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .menu-text {
        text-align: left;
    }
</style>
<body class="bg-light">
    <div class="container-fluid p-0">
        <div class="admin-flex">
            <!-- SIDEBAR -->
            <aside id="sidebar" class="border-end d-flex flex-column justify-content-between">
                <div>
                    <div class="text-center py-4 border-bottom position-relative">
                        <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="70" class="mb-2">
                        <h6 class="fw-bold m-0">SIMARDAS</h6>
                        <small class="text-muted">Sistem Manajemen Arsip</small>
                        <button id="sidebarCloseBtn" class="btn rounded-circle position-absolute" style="top: 10px; right: 10px; background:#adb5bd; color:#fff; border:none; width:44px; height:44px; display:none;" title="Tutup Sidebar"><i class="bi bi-chevron-left"></i></button>
                    </div>
                    <nav class="nav flex-column p-3 gap-2">
                        @php
                            $currentRoute = Route::currentRouteName();
                            $userRole = Auth::user()->role ?? '';
                            $isAdmin = $userRole === 'Admin';
                        @endphp

                        {{-- Menu Home - untuk semua --}}
                        <a href="{{ route('home.page') }}"
                           class="nav-link btn btn-light sidebar-item border d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-house"></i></span>
                            <span class="menu-text">Home</span>
                        </a>

                        {{-- Menu Dashboard - hanya untuk Admin --}}
                        @if($isAdmin)
                        <a href="{{ route('dashboard.page') }}"
                           class="nav-link btn {{ $currentRoute == 'dashboard.page' ? 'active-menu' : 'btn-light' }} sidebar-item border d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-speedometer2"></i></span>
                            <span class="menu-text">Dashboard</span>
                        </a>

                        <a href="#"
                           class="nav-link btn btn-light sidebar-item border d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-cloud-arrow-down"></i></span>
                            <span class="menu-text">Backup dan Restore Data</span>
                        </a>
                        @endif

                        {{-- Menu Manajemen Arsip - untuk Admin dan Petugas Arsip --}}
                        <a href="{{ route('dokumen.index') }}"
                           class="nav-link btn {{ in_array($currentRoute, ['dokumen.index', 'dokumen.edit', 'dokumen_upload.page']) ? 'active-menu' : 'btn-light' }} sidebar-item border d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-folder"></i></span>
                            <span class="menu-text">Manajemen Arsip</span>
                        </a>

                        {{-- Menu Manajemen Pengguna - hanya untuk Admin --}}
                        @if($isAdmin)
                        <a href="{{ route('user.index') }}"
                           class="nav-link btn {{ in_array($currentRoute, ['user.index', 'user.create', 'user.edit']) ? 'active-menu' : 'btn-light' }} sidebar-item border d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-people"></i></span>
                            <span class="menu-text">Manajemen Pengguna</span>
                        </a>
                        @endif
                    </nav>
                </div>
                <div class="p-3 position-relative">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                    </form>
                </div>
            </aside>

            <!-- SIDEBAR OPEN BUTTON -->
            <button id="sidebarOpenBtn" class="btn btn-primary shadow rounded-circle" title="Buka Sidebar"><i class="bi bi-chevron-right text-white"></i></button>

            <!-- MAIN CONTENT -->
            <main class="flex-grow-1">
                <!-- HEADER BAR -->
                <div class="bg-primary text-white py-2 px-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0">@yield('page-title', 'Admin Panel')</h6>
                </div>

                <!-- IDENTITAS -->
                <div class="p-3 bg-white border-bottom d-flex align-items-center">
                    <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="60" class="me-3">
                    <div>
                        <h5 class="m-0">PEMERINTAH KABUPATEN SERANG</h5>
                        <small class="text-muted">Sistem Digitalisasi dan Manajemen Arsip Daerah</small>
                    </div>
                </div>

                <!-- PAGE CONTENT -->
                <div class="p-3">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar open/close
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebar');
            var openBtn = document.getElementById('sidebarOpenBtn');
            var closeBtn = document.getElementById('sidebarCloseBtn');
            
            function openSidebar() {
                sidebar.classList.add('active');
                if(openBtn) openBtn.style.display = 'none';
                if(closeBtn) closeBtn.style.display = 'flex';
            }
            
            function closeSidebar() {
                sidebar.classList.remove('active');
                if(openBtn) openBtn.style.display = 'flex';
                if(closeBtn) closeBtn.style.display = 'none';
            }
            
            if(openBtn) {
                openBtn.addEventListener('click', openSidebar);
            }
            if(closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            
            // Responsive: close sidebar by default on small screens
            function handleResize() {
                if(window.innerWidth < 992) {
                    closeSidebar();
                } else {
                    sidebar.classList.remove('active');
                    if(openBtn) openBtn.style.display = 'none';
                    if(closeBtn) closeBtn.style.display = 'none';
                }
            }
            window.addEventListener('resize', handleResize);
            handleResize();
        });
    </script>
</body>
</html>