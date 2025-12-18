
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name', 'Laravel') }} - Register</title>

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
            .register-bg {
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #0ea5e9 100%);
                min-height: 100vh;
                position: relative;
                overflow: hidden;
            }
            .register-bg::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
                animation: float 15s infinite linear;
            }
            .register-bg::after {
                content: '';
                position: absolute;
                bottom: -30%;
                right: -30%;
                width: 80%;
                height: 80%;
                background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%);
                animation: float 20s infinite linear reverse;
            }
            @keyframes float {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .register-card {
                border-radius: 20px;
                border: 1px solid rgba(255,255,255,0.2);
                backdrop-filter: blur(10px);
                background: rgba(255,255,255,0.98);
                position: relative;
                z-index: 10;
                box-shadow: 0 25px 50px rgba(30, 64, 175, 0.25);
                transition: all 0.3s ease;
            }
            .register-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 30px 60px rgba(30, 64, 175, 0.3);
            }
            .logo-img {
                height: 60px;
            }
            .form-control {
                border-radius: 10px;
                border: 1px solid #e2e8f0;
                transition: all 0.2s ease;
            }
            .form-control:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            }
            .btn-register {
                border-radius: 12px;
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                border: none;
                padding: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .btn-register:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            }
            .alert {
                border-radius: 10px;
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
            @media (max-width: 576px) {
                .register-card .card-body {
                    padding: 1.5rem !important;
                }
                .logo-img {
                    height: 50px;
                }
                .register-title {
                    font-size: 1.2rem !important;
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
		<section class="register-bg d-flex align-items-center justify-content-center py-4">
			<div class="container">
				<div class="row d-flex justify-content-center align-items-center">
					<div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
						<div class="card register-card shadow">
							<div class="card-body p-4 p-lg-5 text-black">
								<form method="POST" action="/home">
									@csrf

									<!-- LOGO CENTER -->
									<div class="text-center mb-4">
										<div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
											<img src="{{ asset('images/Logo_kabupaten_serang.png') }}" alt="Logo" class="logo-img">
											<div class="d-flex flex-column lh-1">
												<span class="fw-bold register-title" style="font-size: 1.4rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">SIMARDAS</span>
												<span class="small" style="font-weight: 500; color: #374151;">Pemerintah Kabupaten Serang</span>
											</div>
										</div>
									</div>

									<!-- JUDUL REGISTER CENTER -->
									<h5 class="fw-normal mb-4 text-center" style="letter-spacing: 1px; color: #374151;">
										<i class="bi bi-person-plus me-2" style="color: #3b82f6;"></i>Create your account
									</h5>

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

                                    <!-- INPUT NAME -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formName" style="color: #374151;">
                                            <i class="bi bi-person me-1" style="color: #3b82f6;"></i>Full Name
                                        </label>
                                        <input type="text" id="formName" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap" />
                                    </div>

                                    <!-- INPUT EMAIL -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formEmail" style="color: #374151;">
                                            <i class="bi bi-envelope me-1" style="color: #3b82f6;"></i>Email Address
                                        </label>
                                        <input type="email" id="formEmail" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="contoh@email.com" />
                                    </div>

                                    <!-- INPUT PASSWORD -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formPassword" style="color: #374151;">
                                            <i class="bi bi-lock me-1" style="color: #3b82f6;"></i>Password
                                        </label>
                                        <input type="password" id="formPassword" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required placeholder="Minimal 8 karakter" />
									</div>

                                    <!-- CONFIRM PASSWORD -->
                                    <div class="mb-4">
                                        <label class="form-label small fw-semibold" for="formPasswordConfirm" style="color: #374151;">
                                            <i class="bi bi-lock-fill me-1" style="color: #3b82f6;"></i>Confirm Password
                                        </label>
										<input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control form-control-lg" required placeholder="Ulangi password" />
									</div>

									<div class="pt-1 mb-4 text-center">
										<button class="btn btn-register btn-lg w-100" type="submit">
											<i class="bi bi-person-plus me-2"></i>Register
										</button>
									</div>

									<div class="text-center">
										<p class="mt-3 small" style="color: #64748b;">
											Already have an account?
											<a href="{{ route('login.page') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">Login di sini</a>
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
