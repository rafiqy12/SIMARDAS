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
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formName">Nama Lengkap Pengguna</label>
                        <input type="text" id="formName" name="nama" class="form-control" required autofocus />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formRole">Role</label>
                        <select name="role" id="formRole" class="form-select">
                            <option value="Admin">Admin</option>
                            <option value="Petugas">Petugas</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formEmail">Email Address</label>
                        <input type="email" id="formEmail" name="email" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formPassword">Password</label>
                        <input type="password" id="formPassword" name="password" class="form-control" required />
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
