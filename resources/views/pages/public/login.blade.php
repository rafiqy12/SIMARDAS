<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
            .login-bg {
                background: linear-gradient(135deg, #0d6efd 60%, #6a11cb 100%);
                min-height: 100vh;
            }
            .login-card {
                border-radius: 1rem;
            }
            .logo-img {
                height: 60px;
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
                        <div class="card login-card shadow">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form method="POST" action="{{ route('login.process') }}">
                                    @csrf
                                    <!-- LOGO CENTER -->
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center justify-content-center gap-2 gap-md-3 flex-wrap">
                                            <img src="{{ asset('images/Logo_kabupaten_serang.png') }}" alt="Logo Dinas Kesehatan Serang" class="logo-img">
                                            <div class="d-flex flex-column lh-1 text-center text-sm-start">
                                                <span class="fw-bold login-title" style="font-size: 1.4rem; color: #222;">SIMARDAS</span>
                                                <span class="login-subtitle" style="font-size: 1rem; font-weight: 500; color: #222;">Pemerintah Kabupaten Serang</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- JUDUL SIGN IN CENTER -->
                                    <h5 class="fw-normal mb-4 text-center" style="letter-spacing: 1px;">
                                        Sign into your account
                                    </h5>

                                    <!-- INPUT EMAIL -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formEmail">Email Address</label>
                                        <input type="email" id="formEmail" name="email" class="form-control form-control-lg" required>
                                    </div>

                                    <!-- INPUT PASSWORD -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formPassword">Password</label>
                                        <input type="password" id="formPassword" name="password" class="form-control form-control-lg" required>
                                    </div>

                                    <div class="pt-1 mb-4 text-center">
                                        <button class="btn btn-dark btn-lg w-100" type="submit">
                                            Login
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <a class="small text-muted" href="">Forgot password?</a>
                                        <p class="mt-3 small" style="color: #393f81;">
                                            Belum punya akun?
                                            <a href="{{ route('register.page') }}" style="color: #393f81;">Daftar di sini</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
