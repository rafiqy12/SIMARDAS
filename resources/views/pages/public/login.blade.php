<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <style>
            :root {
                --primary-500: #3b82f6;
                --primary-600: #2563eb;
                --primary-700: #1d4ed8;
                --primary-800: #1e40af;
                --primary-900: #1e3a8a;
            }
            
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
            
            .login-bg {
                background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 30%, var(--primary-800) 70%, var(--primary-900) 100%);
                min-height: 100vh;
                position: relative;
                overflow: hidden;
            }
            
            /* Animated background elements */
            .login-bg::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -20%;
                width: 600px;
                height: 600px;
                background: rgba(255,255,255,0.05);
                border-radius: 50%;
                animation: float 8s ease-in-out infinite;
            }
            
            .login-bg::after {
                content: '';
                position: absolute;
                bottom: -30%;
                left: -10%;
                width: 400px;
                height: 400px;
                background: rgba(255,255,255,0.03);
                border-radius: 50%;
                animation: float 6s ease-in-out infinite reverse;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-30px) rotate(5deg); }
            }
            
            .login-card {
                border-radius: 20px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                position: relative;
                z-index: 10;
            }
            
            .logo-img {
                height: 60px;
                filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            }
            
            .form-control {
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                padding: 12px 16px;
                transition: all 0.3s ease;
            }
            
            .form-control:focus {
                border-color: var(--primary-500);
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            }
            
            .btn-login {
                background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-600) 100%);
                border: none;
                border-radius: 12px;
                padding: 14px 24px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            }
            
            .btn-login:hover {
                background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            }
            
            .login-title {
                background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .divider {
                display: flex;
                align-items: center;
                text-align: center;
                color: #94a3b8;
            }
            
            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .divider::before {
                margin-right: 1rem;
            }
            
            .divider::after {
                margin-left: 1rem;
            }
            
            @media (max-width: 576px) {
                .login-card .card-body {
                    padding: 1.5rem !important;
                }
                .logo-img {
                    height: 50px;
                }
                .login-title {
                    font-size: 1.2rem !important;
                }
                .login-subtitle {
                    font-size: 0.95rem !important;
                }
                .form-control-lg {
                    font-size: 1rem;
                    padding: 0.6rem 0.8rem;
                }
                .btn-lg {
                    font-size: 1rem;
                    padding: 0.6rem 1rem;
                }
            }
        </style>
    </head>
    <body>
        <section class="login-bg d-flex align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <div class="card login-card shadow bg-white">
                            <div class="card-body p-4 p-lg-5">
                                <form method="POST" action="{{ route('login.process') }}">
                                    @csrf
                                    <!-- LOGO CENTER -->
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center justify-content-center gap-2 gap-md-3 flex-wrap">
                                            <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" alt="Logo Dinas Kesehatan Serang" class="logo-img">
                                            <div class="d-flex flex-column lh-1 text-center text-sm-start">
                                                <span class="fw-bold login-title" style="font-size: 1.5rem;">SIMARDAS</span>
                                                <span class="login-subtitle text-muted" style="font-size: 0.9rem; font-weight: 500;">Pemerintah Kabupaten Serang</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- JUDUL SIGN IN CENTER -->
                                    <div class="text-center mb-4">
                                        <h5 class="fw-bold mb-1" style="color: #1e293b;">Selamat Datang Kembali</h5>
                                        <p class="text-muted small mb-0">Masuk ke akun Anda untuk melanjutkan</p>
                                    </div>

                                    {{-- Alert untuk pesan sukses --}}
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    {{-- Alert untuk pesan error --}}
                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    {{-- Alert untuk validation errors --}}
                                    @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <!-- INPUT EMAIL -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-dark" for="formEmail">
                                            <i class="bi bi-envelope me-1"></i>Email Address
                                        </label>
                                        <input type="email" id="formEmail" name="email" 
                                            class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                            value="{{ old('email') }}" 
                                            placeholder="nama@email.com"
                                            required>
                                    </div>

                                    <!-- INPUT PASSWORD -->
                                    <div class="mb-4">
                                        <label class="form-label small fw-semibold text-dark" for="formPassword">
                                            <i class="bi bi-lock me-1"></i>Password
                                        </label>
                                        <input type="password" id="formPassword" name="password" 
                                            class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                            placeholder="Masukkan password"
                                            required>
                                    </div>

                                    <div class="mb-4">
                                        <button class="btn btn-login btn-lg w-100 text-white" type="submit">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                        </button>
                                    </div>

                                    <div class="divider small mb-4">atau</div>

                                    <div class="text-center">
                                        <a class="small text-primary text-decoration-none" href="">
                                            <i class="bi bi-question-circle me-1"></i>Lupa password?
                                        </a>
                                        <p class="mt-3 small text-muted">
                                            Belum punya akun?
                                            <a href="{{ route('register.page') }}" class="text-primary fw-semibold text-decoration-none">Daftar di sini</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
