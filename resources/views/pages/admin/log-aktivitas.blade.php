@extends('layouts.app')

@section('title', 'Log Aktivitas - SIMARDAS')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h4 class="fw-bold mb-1">
                <i class="bi bi-activity text-primary me-2"></i>Log Aktivitas
            </h4>
            <p class="text-muted mb-0">Riwayat seluruh aktivitas sistem</p>
        </div>
        <a href="{{ route('dashboard.page') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Filter & Search Card --}}
    <div class="card shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-body p-3">
            <form action="{{ route('log-aktivitas.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-search me-1"></i>Cari
                        </label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari nama user, aktivitas, deskripsi..." 
                               value="{{ request('search') }}">
                    </div>

                    {{-- Jenis Aktivitas --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-tag me-1"></i>Jenis
                        </label>
                        <select name="jenis" class="form-select">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisAktivitas as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Dari --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-calendar me-1"></i>Dari Tanggal
                        </label>
                        <input type="date" name="tanggal_dari" class="form-control" 
                               value="{{ request('tanggal_dari') }}">
                    </div>

                    {{-- Tanggal Sampai --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">
                            <i class="bi bi-calendar me-1"></i>Sampai Tanggal
                        </label>
                        <input type="date" name="tanggal_sampai" class="form-control" 
                               value="{{ request('tanggal_sampai') }}">
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <a href="{{ route('log-aktivitas.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-table me-2"></i>Daftar Aktivitas
            </h6>
            <span class="badge bg-primary">Total: {{ $aktivitas->total() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width: 50px;">No</th>
                            <th style="width: 180px;">Waktu</th>
                            <th style="width: 150px;">User</th>
                            <th style="width: 120px;">Jenis</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aktivitas as $index => $log)
                        @php
                            $jenis = strtolower($log->jenis_aktivitas ?? '');
                            $isUpload = str_contains($jenis, 'upload');
                            $isUpdate = str_contains($jenis, 'update') || str_contains($jenis, 'edit');
                            $isDelete = str_contains($jenis, 'hapus') || str_contains($jenis, 'delete');
                            $isBackup = str_contains($jenis, 'backup');
                            $isRestore = str_contains($jenis, 'restore');
                            $isLogin = str_contains($jenis, 'login');
                            
                            if ($isUpload) {
                                $badgeClass = 'success';
                                $icon = 'bi-cloud-arrow-up';
                            } elseif ($isUpdate) {
                                $badgeClass = 'primary';
                                $icon = 'bi-pencil-square';
                            } elseif ($isDelete) {
                                $badgeClass = 'danger';
                                $icon = 'bi-trash';
                            } elseif ($isBackup) {
                                $badgeClass = 'info';
                                $icon = 'bi-hdd';
                            } elseif ($isRestore) {
                                $badgeClass = 'warning';
                                $icon = 'bi-arrow-counterclockwise';
                            } elseif ($isLogin) {
                                $badgeClass = 'secondary';
                                $icon = 'bi-box-arrow-in-right';
                            } else {
                                $badgeClass = 'secondary';
                                $icon = 'bi-activity';
                            }
                        @endphp
                        <tr>
                            <td class="ps-3 text-muted">{{ $aktivitas->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="small fw-semibold">
                                        {{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('d M Y') }}
                                    </span>
                                    <span class="small text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('H:i:s') }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2" 
                                         style="width: 32px; height: 32px;">
                                        <i class="bi bi-person text-primary small"></i>
                                    </div>
                                    <div>
                                        <span class="small fw-semibold">{{ $log->user->nama ?? 'System' }}</span>
                                        <br>
                                        <span class="small text-muted">{{ $log->user->username ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $badgeClass }}">
                                    <i class="bi {{ $icon }} me-1"></i>{{ $log->jenis_aktivitas }}
                                </span>
                            </td>
                            <td class="small">{{ $log->deskripsi }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                </div>
                                <h6 class="text-muted">Tidak ada aktivitas ditemukan</h6>
                                <p class="small text-muted mb-0">Coba ubah filter pencarian Anda</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Pagination --}}
        @if($aktivitas->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan {{ $aktivitas->firstItem() }} - {{ $aktivitas->lastItem() }} dari {{ $aktivitas->total() }} aktivitas
                </div>
                {{ $aktivitas->links() }}
            </div>
        </div>
        @endif
    </div>

</div>
@endsection
