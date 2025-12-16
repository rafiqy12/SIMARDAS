@extends('layouts.app_admin')

@section('title', 'Edit Pengguna - SIMARDAS')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
                    <h5 class="fw-bold m-0 fs-6">Edit Akun Pengguna</h5>
                    <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-arrow-bar-left"></i> Kembali</a>
                </div>
                <form method="POST" action="{{ route('user.update', $user->id_user) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formName">Nama Lengkap Pengguna</label>
                        <input type="text" id="formName" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required autofocus />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formRole">Role</label>
                        <select name="role" id="formRole" class="form-select">
                            <option value="Admin" {{ old('role', $user->role)==='Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Petugas" {{ old('role', $user->role)==='Petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="User" {{ old('role', $user->role)==='User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formEmail">Email Address</label>
                        <input type="email" id="formEmail" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formPassword">Password (isi jika ingin ganti)</label>
                        <input type="password" id="formPassword" name="password" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formPasswordConfirm">Confirm Password</label>
                        <input type="password" id="formPasswordConfirm" name="password_confirmation" class="form-control" />
                    </div>

                    <div class="pt-1 text-center">
                        <button class="btn btn-primary w-100" type="submit">
                            Konfirmasi Edit Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
