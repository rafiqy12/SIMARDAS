@extends('layouts.app_admin')

@section('title', 'Manajemen Pengguna - SIMARDAS')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="card shadow-sm">
    <div class="card-body p-2 p-md-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold m-0 fs-6 fs-md-5">Daftar Pengguna</h5>
            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> <span class="d-none d-sm-inline">Tambah User</span><span class="d-sm-none">Tambah</span></a>
        </div>

        {{-- Search dan Per Page --}}
        <div class="row mb-3 g-2">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ route('user.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, email..." value="{{ $search ?? '' }}">
                    <input type="hidden" name="per_page" value="{{ $perPage ?? 10 }}">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                    @if($search)
                    <a href="{{ route('user.index', ['per_page' => $perPage]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
                    @endif
                </form>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <form method="GET" action="{{ route('user.index') }}" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <label class="mb-0 small">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
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
            <div class="card mb-2">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $user->nama }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <span class="badge bg-{{ $user->role === 'Admin' ? 'danger' : ($user->role === 'Petugas' ? 'warning' : 'primary') }}">{{ $user->role }}</span>
                    </div>
                    <div class="d-flex gap-1 mt-2">
                        <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">Belum ada data pengguna</div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover align-middle table-sm">
                <thead class="table-light">
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
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-{{ $user->role === 'Admin' ? 'danger' : ($user->role === 'Petugas' ? 'warning' : 'primary') }}">{{ $user->role }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info dan Links --}}
        @if($users->hasPages() || $users->total() > 0)
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 gap-2">
            <div class="text-muted small">
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
