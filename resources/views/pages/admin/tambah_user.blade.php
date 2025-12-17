@extends('layouts.app_admin')

@section('title', 'Tambah Pengguna - SIMARDAS')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
                    <h5 class="fw-bold m-0 fs-6">Tambah Akun Pengguna</h5>
                    <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-arrow-bar-left"></i> Kembali</a>
                </div>
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formName">Nama Lengkap Pengguna</label>
                        <input type="text" id="formName" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required autofocus />
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formRole">Role</label>
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
                        <label class="form-label small fw-semibold" for="formEmail">Email Address</label>
                        <input type="email" id="formEmail" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formPassword">Password</label>
                        <input type="password" id="formPassword" name="password" class="form-control @error('password') is-invalid @enderror" required />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formPasswordConfirm">Confirm Password</label>
                        <input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control" required />
                    </div>

                    <div class="pt-1 text-center">
                        <button class="btn btn-primary w-100" type="submit">
                            Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
