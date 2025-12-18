@extends('layouts.app_admin')

@section('title', 'Tambah Pengguna - SIMARDAS')
@section('page-title', 'Manajemen Pengguna')



@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm form-card">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-plus-fill" style="color: #2563eb; font-size: 1.2rem;"></i>
                        </div>
                        <h5 class="fw-bold m-0 fs-6" style="color: #1e293b;">Tambah Akun Pengguna</h5>
                    </div>
                    <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm btn-back"><i class="bi bi-arrow-bar-left"></i> Kembali</a>
                </div>
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger" style="border-radius: 10px; border: none; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formName" style="color: #374151;">
                            <i class="bi bi-person me-1" style="color: #3b82f6;"></i>Nama Lengkap Pengguna
                        </label>
                        <input type="text" id="formName" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required autofocus placeholder="Masukkan nama lengkap" />
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formRole" style="color: #374151;">
                            <i class="bi bi-shield-check me-1" style="color: #3b82f6;"></i>Role
                        </label>
                        <select name="role" id="formRole" class="form-select @error('role') is-invalid @enderror">
                            <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Petugas" {{ old('role') === 'Petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="Umum" {{ old('role', 'Umum') === 'Umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formEmail" style="color: #374151;">
                            <i class="bi bi-envelope me-1" style="color: #3b82f6;"></i>Email Address
                        </label>
                        <input type="email" id="formEmail" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="contoh@email.com" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formPassword" style="color: #374151;">
                            <i class="bi bi-lock me-1" style="color: #3b82f6;"></i>Password
                        </label>
                        <input type="password" id="formPassword" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 8 karakter" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold" for="formPasswordConfirm" style="color: #374151;">
                            <i class="bi bi-lock-fill me-1" style="color: #3b82f6;"></i>Confirm Password
                        </label>
                        <input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control" required placeholder="Ulangi password" />
                    </div>

                    <div class="pt-1 text-center">
                        <button class="btn btn-primary w-100 btn-submit" type="submit">
                            <i class="bi bi-person-plus me-2"></i>Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
