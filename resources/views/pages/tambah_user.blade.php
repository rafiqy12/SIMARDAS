@extends('layouts.app_admin')
@section('content')

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
            <a href="{{ route("login.page") }}" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
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
        <!-- Konten -->
        <div class="p-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold m-0">Tambah Akun Pengguna</h5>
                        <a href="{{ route("manajemen_user.page") }}" class="btn btn-primary btn-sm"><i class="bi bi-arrow-bar-left"></i>  Kembali</a>
                    </div>
                    <form method="POST" action="/home">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="formName">Nama Lengkap Pengguna</label>
                            <input type="text" id="formName" name="name" class="form-control form-control-lg" required autofocus />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formRole">Role</label>
                            <select name="role" id="formRole" class="form-select form-control-lg">
                                <option value="admin">Admin</option>
                                <option value="user">Petugas Arsip</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formEmail">Email Address</label>
                            <input type="email" id="formEmail" name="email" class="form-control form-control-lg" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formPassword">Password</label>
                            <input type="password" id="formPassword" name="password" class="form-control form-control-lg" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formPasswordConfirm">Confirm Password</label>
                            <input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control form-control-lg" required />
                        </div>

                        <div class="pt-1 mb-4 text-center">
                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                Register
                            </button>
                        </div>
                    </form>
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
