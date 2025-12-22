<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SIMARDAS')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<style>
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

    /* Role Badges - Reusable */
    .badge-admin {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    .badge-petugas {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .badge-user {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    .badge-umum {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* Reusable Form Styles */
    .form-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .form-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .btn-submit {
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(37, 99, 235, 0.3);
    }
    .btn-back {
        border-radius: 8px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        transform: translateX(-3px);
    }
    .btn-action {
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }

    /* Reusable Page Header */
    .page-header {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        border: 1px solid #bfdbfe;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    .page-header h5 {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Reusable Info Box */
    .info-box {
        border-radius: 12px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
    }

    /* Reusable Card Styles */
    .card-themed {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .card-themed:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }

    /* Reusable Table Styles */
    .table-themed thead {
        background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
    }
    .table-themed thead th {
        color: #1e40af;
        font-weight: 600;
        border-bottom: 2px solid #93c5fd;
    }
    .table-themed tbody tr {
        transition: all 0.2s ease;
    }
    .table-themed tbody tr:hover {
        background: #eff6ff;
    }

    /* Reusable Mobile Card */
    .mobile-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .mobile-card:hover {
        border-color: #93c5fd;
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
    }

    /* Reusable Alert Styles */
    .alert-themed {
        border-radius: 12px;
        border: none;
    }
    .alert-themed.alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    .alert-themed.alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    /* Reusable Title Gradient */
    .title-gradient {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Reusable Button Styles */
    .btn-primary-gradient {
        border-radius: 8px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        transition: all 0.2s ease;
    }
    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
    }
    .btn-success-gradient {
        border-radius: 8px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        transition: all 0.2s ease;
    }
    .btn-success-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }
    .btn-danger-gradient {
        border-radius: 8px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        transition: all 0.2s ease;
    }
    .btn-danger-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }
    .btn-secondary-gradient {
        border-radius: 8px;
        background: #64748b;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-secondary-gradient:hover {
        transform: translateX(-3px);
        background: #475569;
    }
    
    html {
        max-width: 100vw !important;
    }
    
    body {
        max-width: 100vw !important;
        padding-right: 0 !important;
        font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .admin-flex {
        display: flex;
        min-height: 100vh;
        gap: 0;
        /* overflow-x: hidden; */
    }
    
    #sidebar {
        width: 260px;
        min-width: 260px;
        height: 100vh;
        position: sticky;
        top: 0;
        transition: all 0.3s ease;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        z-index: 2;
        overflow-y: auto;
        border-right: none;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }
    
    /* Sidebar header */
    .sidebar-header {
        background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
        position: relative;
        overflow: hidden;
        border-bottom: none;
    }
    
    .sidebar-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    /* Active menu styling */
    .btn.active-menu {
        background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
        color: #fff !important;
        border-color: var(--primary-500);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }
    
    .btn.active-menu .menu-icon,
    .btn.active-menu .menu-icon i,
    .btn.active-menu .menu-text {
        color: #fff !important;
    }
    
    .btn.active-menu:hover, .btn.active-menu:focus {
        background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%) !important;
        color: #fff !important;
        transform: translateX(5px);
    }
    
    .btn.active-menu:hover i, .btn.active-menu:focus i,
    .btn.active-menu:hover .menu-text, .btn.active-menu:focus .menu-text {
        color: #fff !important;
    }
    
    /* All blue buttons should have white text */
    .btn-primary {
        color: #fff !important;
    }
    
    .btn-primary:hover, .btn-primary:focus {
        color: #fff !important;
    }
    
    /* Sidebar items */
    .sidebar-item {
        height: 48px;
        padding: 0 16px;
        border: 1px solid #e2e8f0 !important;
        font-weight: 500;
        text-align: left;
        justify-content: flex-start !important;
        font-size: 0.875rem;
        border-radius: 12px !important;
        transition: all 0.3s ease;
        background: white;
    }
    
    .sidebar-item:hover {
        border-color: var(--primary-300) !important;
        background: var(--primary-50) !important;
        color: var(--primary-700) !important;
        transform: translateX(5px);
    }
    
    .sidebar-item:hover .menu-icon i {
        color: var(--primary-600) !important;
    }
    
    .menu-icon {
        width: 24px;
        min-width: 24px;
        text-align: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        color: #64748b;
    }

    .menu-text {
        text-align: left;
        color: #475569;
    }
    
    .sidebar-item:hover .menu-text {
        color: var(--primary-700) !important;
    }
    
    /* Sidebar buttons */
    #sidebarCloseBtn {
        display: none;
        width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px auto;
        background: rgba(255,255,255,0.2);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }
    
    #sidebarCloseBtn:hover {
        background: rgba(255,255,255,0.3);
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
        background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
        color: #fff;
        border: none;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        transition: all 0.3s ease;
    }
    
    #sidebarOpenBtn:hover {
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }
    
    #sidebarOpenBtn i {
        color: #fff !important;
    }
    
    /* Header bar */
    .header-bar {
        background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
        position: relative;
        overflow: hidden;
        margin: 0;
        border: none;
    }
    
    .header-bar::before {
        content: '';
        position: absolute;
        top: -100%;
        right: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    /* Main content area - remove gap */
    main.flex-grow-1 {
        display: flex;
        flex-direction: column;
        background: #f1f5f9;
        overflow-x: hidden;
        min-width: 0;
        width: 0;
        flex: 1 1 0%;
    }
    
    /* Ensure no visual gap between sidebar and content */
    .admin-flex > main {
        margin-left: 0;
        border-left: none;
    }
    
    /* Page content must not overflow */
    .page-content {
        overflow-x: hidden;
        overflow-y: auto;
        max-width: 100%;
        word-wrap: break-word;
        animation: fadeIn 0.5s ease;
    }
    
    .page-content > * {
        max-width: 100%;
    }
    
    /* Content wrapper */
    .content-wrapper {
        flex: 1;
        padding: 1.5rem;
    }
    
    /* Logout button */
    .btn-logout {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }
    
    .btn-logout:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 991.98px) {
        #sidebar {
            margin-left: -260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 5px 0 25px rgba(0,0,0,0.1);
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
</style>
<body class="bg-light" style="overflow-x: hidden;">
    <div class="container-fluid p-0" style="max-width: 100vw;">
        <div class="admin-flex">
            <!-- SIDEBAR -->
            <aside id="sidebar" class="d-flex flex-column justify-content-between">
                <div>
                    <div class="sidebar-header text-center py-4 position-relative">
                        <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="60" class="mb-2" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                        <h6 class="fw-bold m-0 text-white">SIMARDAS</h6>
                        <small class="text-white opacity-75" style="font-size: 0.75rem;">Sistem Manajemen Arsip</small>
                        <button id="sidebarCloseBtn" class="btn rounded-circle position-absolute" style="top: 10px; right: 10px;" title="Tutup Sidebar">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                    </div>
                    <nav class="nav flex-column p-3 gap-2">
                        @php
                            $currentRoute = Route::currentRouteName();
                            $userRole = Auth::user()->role ?? '';
                            $isAdmin = $userRole === 'Admin';
                        @endphp

                        {{-- Menu Home - untuk semua --}}
                        <a href="{{ route('home.page') }}"
                           class="nav-link btn btn-light sidebar-item d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-house"></i></span>
                            <span class="menu-text">Home</span>
                        </a>

                        {{-- Menu Dashboard - hanya untuk Admin --}}
                        @if($isAdmin)
                        <a href="{{ route('dashboard.page') }}"
                           class="nav-link btn {{ $currentRoute == 'dashboard.page' ? 'active-menu' : 'btn-light' }} sidebar-item d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-speedometer2"></i></span>
                            <span class="menu-text">Dashboard</span>
                        </a>

                        <a href="{{ route('backup.index') }}"
                           class="nav-link btn btn-light sidebar-item border d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-cloud-arrow-down"></i></span>
                            <span class="menu-text">Backup dan Restore Data</span>
                        </a>

                        <a href="{{ route('dokumen.index') }}"
                           class="nav-link btn {{ in_array($currentRoute, ['dokumen.index', 'dokumen.edit', 'dokumen_upload.page']) ? 'active-menu' : 'btn-light' }} sidebar-item d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-folder"></i></span>
                            <span class="menu-text">Manajemen Arsip</span>
                        </a>
                        @endif

                        {{-- Menu Manajemen Arsip - hanya untuk Petugas (bukan Admin, karena Admin pakai sidebar) --}}
                        @if($userRole === 'Petugas')
                        <a href="{{ route('dokumen.index') }}"
                           class="nav-link btn {{ in_array($currentRoute, ['dokumen.index', 'dokumen.edit', 'dokumen_upload.page']) ? 'active-menu' : 'btn-light' }} sidebar-item d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-folder"></i></span>
                            <span class="menu-text">Manajemen Arsip</span>
                        </a>
                        @endif

                        {{-- Menu Manajemen Pengguna - hanya untuk Admin --}}
                        @if($isAdmin)
                        <a href="{{ route('user.index') }}"
                           class="nav-link btn {{ in_array($currentRoute, ['user.index', 'user.create', 'user.edit']) ? 'active-menu' : 'btn-light' }} sidebar-item d-flex align-items-center gap-3">
                            <span class="menu-icon"><i class="bi bi-people"></i></span>
                            <span class="menu-text">Manajemen Pengguna</span>
                        </a>
                        @endif
                    </nav>
                </div>
                <div class="p-3 position-relative">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-logout w-100 text-white">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- SIDEBAR OPEN BUTTON -->
            <button id="sidebarOpenBtn" class="btn shadow rounded-circle" title="Buka Sidebar">
                <i class="bi bi-chevron-right text-white"></i>
            </button>

            <!-- MAIN CONTENT -->
            <main class="flex-grow-1">
                <!-- HEADER BAR -->
                <div class="header-bar text-white py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-semibold">
                        <i class="bi bi-grid-1x2 me-2"></i>@yield('page-title', 'Admin Panel')
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-white text-primary">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->nama ?? 'Admin' }}
                        </span>
                    </div>
                </div>

                <!-- IDENTITAS -->
                <div class="p-3 bg-white d-flex align-items-center" style="border-bottom: 1px solid #e2e8f0;">
                    <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="55" class="me-3" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                    <div>
                        <h5 class="m-0 fw-bold" style="color: #1e293b;">PEMERINTAH KABUPATEN SERANG</h5>
                        <small class="text-muted">Sistem Digitalisasi dan Manajemen Arsip Daerah</small>
                    </div>
                </div>

                <!-- PAGE CONTENT -->
                <div class="p-3 page-content">
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

    <!-- Reset any leftover styles from SweetAlert2 -->
    <script>
        // Immediately reset body styles on page load
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        document.body.classList.remove('swal2-shown', 'swal2-height-auto', 'swal2-iosfix');
        document.documentElement.classList.remove('swal2-shown', 'swal2-height-auto', 'swal2-iosfix');
    </script>

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
    @stack('scripts')

    <!-- SweetAlert2 Delete Confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach event listener to all delete forms
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
                        },
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp animate__faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reset body overflow sebelum submit
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>

    <style>
        /* Fix SweetAlert2 body overflow issue */
        body.swal2-shown {
            overflow: hidden !important;
            padding-right: 0 !important;
        }
        body.swal2-height-auto {
            height: auto !important;
        }
        
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
        .swal-confirm-btn:hover {
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4) !important;
        }
        .swal-cancel-btn {
            border-radius: 10px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
        }
        .swal-cancel-btn:hover {
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4) !important;
        }
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
        }
    </style>
</body>
</html>