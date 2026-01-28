@extends('layouts.app')

@section('title', 'Profil Saya - SIMARDAS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            
            {{-- Header --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="bi bi-person-fill text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">Profil Saya</h3>
                <p class="text-muted">Kelola informasi akun Anda</p>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Profile Card --}}
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4">
                    
                    {{-- Info Card --}}
                    <div class="p-3 mb-4 rounded-3" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-info-circle text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Username</div>
                                <div class="fw-semibold">{{ $user->username }}</div>
                            </div>
                            <div class="ms-auto">
                                <span class="badge" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person me-1 text-primary"></i>Nama Lengkap
                            </label>
                            <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $user->nama) }}" required style="border-radius: 10px;">
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1 text-primary"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required style="border-radius: 10px;">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-shield-lock me-1 text-primary"></i>Ubah Password
                            <small class="text-muted fw-normal">(opsional)</small>
                        </h6>

                        {{-- Password Baru --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   placeholder="Kosongkan jika tidak ingin mengubah" style="border-radius: 10px;">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" 
                                   placeholder="Ulangi password baru" style="border-radius: 10px;">
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1" 
                                    style="border-radius: 10px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                                <i class="bi bi-check2 me-1"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('home.page') }}" class="btn btn-outline-secondary btn-lg" style="border-radius: 10px;">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
