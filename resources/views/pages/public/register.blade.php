
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name', 'Laravel') }} - Register</title>

		@vite(['resources/scss/app.scss', 'resources/js/app.js'])

		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

		<!-- Styles / Scripts -->
		@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
			@vite(['resources/css/app.css', 'resources/js/app.js'])
		@else
			<style>
				body { font-family: 'Instrument Sans', sans-serif; }
			</style>
		@endif
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	</head>
	<body>
		<section class="vh-100" style="background-color: #0d6efd;">
			<div class="container py-5 h-100">
				<div class="row d-flex justify-content-center align-items-center h-100">
					<div class="col col-xl-5">
						<div class="card" style="border-radius: 1rem;">
							<div class="d-flex align-items-center">
								<div class="card-body p-4 p-lg-5 text-black">

									<form method="POST" action="/home">
										@csrf

										<!-- LOGO CENTER -->
										<div class="text-center mb-4">
											<i class="fas fa-cubes fa-3x mb-2" style="color: #ff6219;"></i>
											<h1 class="fw-bold mb-0">Logo</h1>
										</div>

										<!-- JUDUL REGISTER CENTER -->
										<h5 class="fw-normal mb-4 text-center" style="letter-spacing: 1px;">
											Create your account
										</h5>

										<!-- INPUT NAME -->
										<div class="mb-3">
											<label class="form-label" for="formName">Full Name</label>
											<input type="text" id="formName" name="name" class="form-control form-control-lg" required autofocus />
										</div>

										<!-- INPUT EMAIL -->
										<div class="mb-3">
											<label class="form-label" for="formEmail">Email Address</label>
											<input type="email" id="formEmail" name="email" class="form-control form-control-lg" required />
										</div>

										<!-- INPUT PASSWORD -->
										<div class="mb-3">
											<label class="form-label" for="formPassword">Password</label>
											<input type="password" id="formPassword" name="password" class="form-control form-control-lg" required />
										</div>

										<!-- INPUT PASSWORD CONFIRMATION -->
										<div class="mb-3">
											<label class="form-label" for="formPasswordConfirm">Confirm Password</label>
											<input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control form-control-lg" required />
										</div>

										<div class="pt-1 mb-4 text-center">
											<button class="btn btn-dark btn-lg w-100" type="submit">
												Register
											</button>
										</div>

										<div class="text-center">
											<p class="mt-3" style="color: #393f81;">
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
			</div>
		</section>
	</body>
</html>
