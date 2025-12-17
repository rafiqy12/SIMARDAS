
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
                background: linear-gradient(135deg, #0d6efd 60%, #6a11cb 100%);
                min-height: 100vh;
            }
            .register-card {
                border-radius: 1rem;
            }
            .logo-img {
                height: 60px;
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
												<span class="fw-bold register-title" style="font-size: 1.4rem; color: #222;">SIMARDAS</span>
												<span class="small" style="font-weight: 500; color: #222;">Pemerintah Kabupaten Serang</span>
											</div>
										</div>
									</div>

									<!-- JUDUL REGISTER CENTER -->
									<h5 class="fw-normal mb-4 text-center" style="letter-spacing: 1px;">
										Create your account
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
                                        <label class="form-label small fw-semibold" for="formName">Full Name</label>
                                        <input type="text" id="formName" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus />
                                    </div>

                                    <!-- INPUT EMAIL -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formEmail">Email Address</label>
                                        <input type="email" id="formEmail" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                                    </div>

                                    <!-- INPUT PASSWORD -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold" for="formPassword">Password</label>
                                        <input type="password" id="formPassword" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required />
										<input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control form-control-lg" required />
									</div>

									<div class="pt-1 mb-4 text-center">
										<button class="btn btn-dark btn-lg w-100" type="submit">
											Register
										</button>
									</div>

									<div class="text-center">
										<p class="mt-3 small" style="color: #393f81;">
											Already have an account?
											<a href="{{ route('login.page') }}" style="color: #393f81;">Login di sini</a>
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
