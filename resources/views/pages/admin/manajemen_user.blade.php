@extends('layouts.app_admin')

@section('title', 'Manajemen Pengguna - SIMARDAS')
@section('page-title', 'Manajemen Pengguna')

@push('styles')
<style>
    /* Page-specific styles only */
    .user-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .user-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }
</style>
@endpush

@section('content')
<div class="card shadow-sm user-card">
    <div class="card-body p-2 p-md-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold m-0 fs-6 fs-md-5" style="color: #1e293b;">
                <i class="bi bi-people-fill me-2" style="color: #3b82f6;"></i>Daftar Pengguna
            </h5>
            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Tambah User</span><span class="d-sm-none">Tambah</span>
            </a>
        </div>

        {{-- Search dan Per Page --}}
        <div class="row mb-3 g-2">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ route('user.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, email..." value="{{ $search ?? '' }}" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    <input type="hidden" name="per_page" value="{{ $perPage ?? 10 }}">
                    <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                    <a href="{{ route('user.index', ['per_page' => $perPage]) }}" class="btn btn-secondary btn-sm" style="border-radius: 8px;">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </form>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <form method="GET" action="{{ route('user.index') }}" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <label class="mb-0 small text-muted">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm rounded-xl shadow-sm border border-primary-200 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all" style="width: auto;" onchange="this.form.submit()">
                        <option value="5" {{ ($perPage ?? 10) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="d-md-none">
            @forelse($users as $index => $user)
            <div class="card mb-2 mobile-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1e293b;">{{ $user->nama }}</h6>
                            <small class="text-muted"><i class="bi bi-envelope" style="color: #3b82f6;"></i> {{ $user->email }}</small>
                        </div>
                        <span class="badge badge-{{ strtolower($user->role) }}">{{ $user->role }}</span>
                    </div>
                    <div class="d-flex gap-1 mt-2">
                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning btn-sm btn-action"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="d-inline delete-form" data-name="{{ $user->nama }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-people display-4" style="color: #93c5fd;"></i>
                <p class="text-muted mt-2">Belum ada data pengguna</p>
            </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle table-sm table-themed" style="border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td><span class="badge" style="background: #dbeafe; color: #1d4ed8;">{{ $users->firstItem() + $index }}</span></td>
                        <td class="fw-semibold" style="color: #1e293b;">{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge badge-{{ strtolower($user->role) }}">{{ $user->role }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning btn-sm btn-action"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="d-inline delete-form" data-name="{{ $user->nama }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-people display-6" style="color: #93c5fd;"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada data pengguna</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info dan Links --}}
        @if($users->hasPages() || $users->total() > 0)
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 gap-2">
            <div class="text-muted small">
                <i class="bi bi-info-circle me-1" style="color: #3b82f6;"></i>
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
            </div>
            <div>
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
