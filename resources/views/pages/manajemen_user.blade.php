@extends('layouts.app_admin')
@section('content')

<style>
    .admin-flex {
        display: flex;
        min-height: 100vh;
    }
    #sidebar {
        width: 250px;
        min-height: 100vh;
        transition: margin-left 0.3s;
        background: #fff;
        z-index: 2;
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
        position: absolute;
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
            position: absolute;
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
            position: relative;
        }
    }
</style>
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
                <a href="#" class="nav-link btn btn-light text-start border" style="border-color:#adb5bd;">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="#" class="nav-link btn btn-light text-start border" style="border-color:#adb5bd;">
                    <i class="bi bi-cloud-arrow-down me-2"></i> Backup dan restore data
                </a>
                <a href="#" class="nav-link btn active-menu text-start border" style="border-color:#adb5bd;">
                    <i class="bi bi-people me-2"></i> Manajemen Pengguna
                </a>
            </nav>
        </div>
        <div class="p-3 position-relative">
            <button id="sidebarCloseBtn" class="btn btn-light border shadow-sm rounded-circle mb-2" style="display:none; position:static;" title="Tutup Sidebar"><i class="bi bi-chevron-left"></i></button>
            <a href="#" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
        </div>
    </aside>
    <!-- SIDEBAR OPEN BUTTON -->
    <button id="sidebarOpenBtn" class="btn btn-primary shadow rounded-circle" title="Buka Sidebar"><i class="bi bi-chevron-right text-white"></i></button>
    <!-- MAIN CONTENT -->
    <main class="flex-grow-1">
        <!-- HEADER BAR -->
        <div class="bg-primary text-white py-2 px-3 d-flex align-items-center position-relative">
            <h6 class="m-0">Manajemen Pengguna</h6>
        </div>
        <!-- IDENTITAS -->
        <div class="p-3 bg-white border-bottom d-flex align-items-center">
            <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" width="60" class="me-3">
            <div>
                <h5 class="m-0">PEMERINTAH KABUPATEN SERANG</h5>
                <small class="text-muted">Sistem Digitalisasi dan Manajemen Arsip Daerah</small>
            </div>
        </div>
        <!-- TABEL MANAJEMEN USER -->
        <div class="p-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0">Daftar Pengguna</h5>
                        <a href="{{ route('tambah_user.page') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Tambah User</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mika Rendang</td>
                                    <td>mika@serangkab.go.id</td>
                                    <td>Admin</td>
                                    <td><span class="badge bg-success">Aktif</span></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Kazuha</td>
                                    <td>zunazana@gmail.com</td>
                                    <td>User</td>
                                    <td><span class="badge bg-secondary">Nonaktif</span></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Kim Chaewon</td>
                                    <td>Chaechae1@serangkab.go.id</td>
                                    <td>Petugas Arsip</td>
                                    <td><span class="badge bg-secondary">Nonaktif</span></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>An Yujin</td>
                                    <td>Yujinie@serangkab.go.id</td>
                                    <td>User</td>
                                    <td><span class="badge bg-secondary">Aktif</span></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <!-- Tambahkan baris user lain di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </main>
</div>
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
@endsection
