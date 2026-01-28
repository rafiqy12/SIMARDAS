@extends('layouts.app_admin')

@section('title', 'Log Aktivitas - SIMARDAS')
@section('page-title', 'Log Aktivitas')

@push('styles')
<style>
    /* Page-specific styles only */
    .log-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .log-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }
    .badge-backup {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
    }
    .badge-restore {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    .badge-upload {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    .badge-update {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    .badge-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    .badge-login {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }
    .badge-default {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
    }
    .mobile-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .mobile-card:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@section('content')
<div class="card shadow-sm log-card">
    <div class="card-body p-2 p-md-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold m-0 fs-6 fs-md-5" style="color: #1e293b;">
                <i class="bi bi-activity me-2" style="color: #3b82f6;"></i>Riwayat Aktivitas Sistem
            </h5>
            <span class="badge bg-primary">Total: {{ $aktivitas->total() }}</span>
        </div>

        {{-- Search dan Filter --}}
        <form method="GET" action="{{ route('log-aktivitas.index') }}">
            <div class="row mb-3 g-2">
                <div class="col-12 col-md-4">
                    <div class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama user, aktivitas, deskripsi..." value="{{ request('search') }}" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                        <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request()->hasAny(['search', 'jenis', 'tanggal_dari', 'tanggal_sampai']))
                        <a href="{{ route('log-aktivitas.index') }}" class="btn btn-secondary btn-sm" style="border-radius: 8px;">
                            <i class="bi bi-x-lg"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select name="jenis" class="form-select form-select-sm" style="border-radius: 8px;" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisAktivitas as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <input type="date" name="tanggal_dari" class="form-control form-control-sm" placeholder="Dari" value="{{ request('tanggal_dari') }}" style="border-radius: 8px;" onchange="this.form.submit()">
                </div>
                <div class="col-6 col-md-2">
                    <input type="date" name="tanggal_sampai" class="form-control form-control-sm" placeholder="Sampai" value="{{ request('tanggal_sampai') }}" style="border-radius: 8px;" onchange="this.form.submit()">
                </div>
                <div class="col-6 col-md-2 text-end">
                    <select name="per_page" class="form-select form-select-sm" style="border-radius: 8px; width: auto; display: inline-block;" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Mobile Card View --}}
        <div class="d-md-none">
            @forelse($aktivitas as $index => $log)
            @php
                $jenis = strtolower($log->jenis_aktivitas ?? '');
                $isBackup = str_contains($jenis, 'backup');
                $isRestore = str_contains($jenis, 'restore');
                $isUpload = str_contains($jenis, 'upload');
                $isUpdate = str_contains($jenis, 'update') || str_contains($jenis, 'edit');
                $isDelete = str_contains($jenis, 'hapus') || str_contains($jenis, 'delete');
                $isLogin = str_contains($jenis, 'login');
                
                if ($isBackup) {
                    $badgeClass = 'backup';
                    $icon = 'bi-hdd';
                } elseif ($isRestore) {
                    $badgeClass = 'restore';
                    $icon = 'bi-arrow-counterclockwise';
                } elseif ($isUpload) {
                    $badgeClass = 'upload';
                    $icon = 'bi-cloud-arrow-up';
                } elseif ($isUpdate) {
                    $badgeClass = 'update';
                    $icon = 'bi-pencil-square';
                } elseif ($isDelete) {
                    $badgeClass = 'delete';
                    $icon = 'bi-trash';
                } elseif ($isLogin) {
                    $badgeClass = 'login';
                    $icon = 'bi-box-arrow-in-right';
                } else {
                    $badgeClass = 'default';
                    $icon = 'bi-activity';
                }
            @endphp
            <div class="card mb-2 mobile-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1e293b;">{{ $log->user->nama ?? 'System' }}</h6>
                            <small class="text-muted"><i class="bi bi-person" style="color: #3b82f6;"></i> {{ $log->user->username ?? '-' }}</small>
                        </div>
                        <span class="badge badge-{{ $badgeClass }}">
                            <i class="bi {{ $icon }} me-1"></i>{{ $log->jenis_aktivitas }}
                        </span>
                    </div>
                    <p class="small text-muted mb-2">{{ $log->deskripsi }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('d M Y') }}
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('H:i:s') }}
                        </small>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox display-4" style="color: #93c5fd;"></i>
                <p class="text-muted mt-2">Tidak ada aktivitas ditemukan</p>
            </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle table-sm table-themed" style="border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 160px;">Waktu</th>
                        <th style="width: 150px;">User</th>
                        <th style="width: 120px;">Jenis</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aktivitas as $index => $log)
                    @php
                        $jenis = strtolower($log->jenis_aktivitas ?? '');
                        $isBackup = str_contains($jenis, 'backup');
                        $isRestore = str_contains($jenis, 'restore');
                        $isUpload = str_contains($jenis, 'upload');
                        $isUpdate = str_contains($jenis, 'update') || str_contains($jenis, 'edit');
                        $isDelete = str_contains($jenis, 'hapus') || str_contains($jenis, 'delete');
                        $isLogin = str_contains($jenis, 'login');
                        
                        if ($isBackup) {
                            $badgeClass = 'backup';
                            $icon = 'bi-hdd';
                        } elseif ($isRestore) {
                            $badgeClass = 'restore';
                            $icon = 'bi-arrow-counterclockwise';
                        } elseif ($isUpload) {
                            $badgeClass = 'upload';
                            $icon = 'bi-cloud-arrow-up';
                        } elseif ($isUpdate) {
                            $badgeClass = 'update';
                            $icon = 'bi-pencil-square';
                        } elseif ($isDelete) {
                            $badgeClass = 'delete';
                            $icon = 'bi-trash';
                        } elseif ($isLogin) {
                            $badgeClass = 'login';
                            $icon = 'bi-box-arrow-in-right';
                        } else {
                            $badgeClass = 'default';
                            $icon = 'bi-activity';
                        }
                    @endphp
                    <tr>
                        <td><span class="badge" style="background: #dbeafe; color: #1d4ed8;">{{ $aktivitas->firstItem() + $index }}</span></td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small fw-semibold">{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('d M Y') }}</span>
                                <span class="small text-muted"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($log->waktu_aktivitas)->format('H:i:s') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
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
                            <span class="badge badge-{{ $badgeClass }}">
                                <i class="bi {{ $icon }} me-1"></i>{{ $log->jenis_aktivitas }}
                            </span>
                        </td>
                        <td class="small">{{ $log->deskripsi }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-inbox display-6" style="color: #93c5fd;"></i>
                            <p class="text-muted mt-2 mb-0">Tidak ada aktivitas ditemukan</p>
                            <small class="text-muted">Coba ubah filter pencarian Anda</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info dan Links --}}
        @if($aktivitas->hasPages() || $aktivitas->total() > 0)
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 gap-2">
            <div class="text-muted small">
                <i class="bi bi-info-circle me-1" style="color: #3b82f6;"></i>
                Menampilkan {{ $aktivitas->firstItem() ?? 0 }} - {{ $aktivitas->lastItem() ?? 0 }} dari {{ $aktivitas->total() }} aktivitas
            </div>
            <div>
                {{ $aktivitas->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection