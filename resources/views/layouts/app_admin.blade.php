<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    .sidebar-item {
    height: 52px;              /* SEMUA SAMA */
    padding: 0 14px;
    border-color: #adb5bd !important;
    font-weight: 500;
    }

    .menu-icon {
        width: 28px;               /* ICON FIX */
        min-width: 28px;
        text-align: center;
        font-size: 1.1rem;
    }

    .menu-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    }

</style>
<body class="bg-light">
    {{-- MAIN CONTENT --}}
    <div class="container-fluid p-0">
        @yield('content')
    </div>
</body>
</html>