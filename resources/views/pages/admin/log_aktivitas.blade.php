@extends('layouts.app_admin')

@section('title', 'Log Aktivitas - SIMARDAS')
@section('page-title', 'Log Aktivitas')

@push('styles')
<style>
    /* Page-specific styles */
    .log-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .log-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }

    /* Activity Item Styles */
    .activity-item {
        padding: 16px;
        border-radius: 12px;
        transition: all 0.2s ease;
        border-left: 4px solid transparent;
        background: #fff;
        margin-bottom: 12px;
        border: 1px solid #e2e8f0;
    }
    .activity-item:hover {
        background: var(--primary-50);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }
    .activity-item.upload {
        border-left-color: #10b981;
    }
    .activity-item.update {
        border-left-color: var(--primary-500);
    }
    .activity-item.delete {
        border-left-color: #ef4444;
    }
    .activity-item.login {
        border-left-color: #8b5cf6;
    }
    .activity-item.download {
        border-left-color: #f59e0b;
    }
    .activity-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .activity-icon.upload {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .activity-icon.update {
        background: rgba(59, 130, 246, 0.1);
        color: var(--primary-500);
    }
    .activity-icon.delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    .activity-icon.login {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
    }
    .activity-icon.download {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    /* Table Styles */
    .table-themed thead {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }
    .table-themed thead th {
        color: #1e40af;
        font-weight: 600;
        border: none;
        padding: 12px 16px;
        font-size: 0.85rem;
    }
    .table-themed tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-color: #e2e8f0;
    }
    .table-themed tbody tr:hover {
        background: var(--primary-50);
    }

    /* Filter Card */
    .filter-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 12px;
        border: 1px solid #bfdbfe;
    }

    /* Stats Mini Cards */
    .stats-mini {
        background: #fff;
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .stats-mini:hover {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }
    .stats-mini .stats-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="card shadow-sm log-card">
    <div class="card-body p-2 p-md-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
            <h5 class="fw-bold m-0 fs-6 fs-md-5" style="color: #1e293b;">
                <i class="bi bi-activity me-2" style="color: #3b82f6;"></i>Riwayat Aktivitas Sistem
            </h5>
            <a href="{{ route('dashboard.page') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 8px;">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="filter-card p-3 mb-4">
            <form method="GET" action="{{ route('log-aktivitas.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-semibold text-primary mb-1">
                            <i class="bi bi-search me-1"></i>Pencarian
                        </label>
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Cari nama user, deskripsi..." 
                               value="{{ $search ?? '' }}" 
                               style="border-radius: 8px;">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-primary mb-1">
                            <i class="bi bi-funnel me-1"></i>Jenis Aktivitas
                        </label>
                        <select name="jenis" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisAktivitasList as $jenis)
                                <option value="{{ $jenis }}" {{ ($jenisFilter ?? '') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label small fw-semibold text-primary mb-1">
                            <i class="bi bi-list-ol me-1"></i>Tampilkan
                        </label>
                        <select name="per_page" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            @if($search || $jenisFilter)
                            <a href="{{ route('log-aktivitas.index') }}" class="btn btn-secondary btn-sm" style="border-radius: 8px;">
                                <i class="bi bi-x-lg"></i> Reset
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Mobile Card View --}}
        <div class="d-md-none">
            @forelse($logAktivitas as $aktivitas)
            @php
                $jenisAktivitas = strtolower($aktivitas->jenis_aktivitas ?? '');
                $isUpload = str_contains($jenisAktivitas, 'upload');
                $isUpdate = str_contains($jenisAktivitas, 'update') || str_contains($jenisAktivitas, 'edit');
                $isDelete = str_contains($jenisAktivitas, 'hapus') || str_contains($jenisAktivitas, 'delete');
                $isLogin = str_contains($jenisAktivitas, 'login');
                $isDownload = str_contains($jenisAktivitas, 'download');
                
                $activityClass = $isUpload ? 'upload' : ($isUpdate ? 'update' : ($isDelete ? 'delete' : ($isLogin ? 'login' : ($isDownload ? 'download' : 'upload'))));
                $icon = $isUpload ? 'bi-cloud-arrow-up' : ($isUpdate ? 'bi-pencil-square' : ($isDelete ? 'bi-trash' : ($isLogin ? 'bi-box-arrow-in-right' : ($isDownload ? 'bi-download' : 'bi-file-earmark-text'))));
                $badgeClass = $isUpload ? 'success' : ($isUpdate ? 'primary' : ($isDelete ? 'danger' : ($isLogin ? 'info' : ($isDownload ? 'warning' : 'secondary'))));
            @endphp
            <div class="activity-item {{ $activityClass }}">
                <div class="d-flex align-items-start gap-3">
                    <div class="activity-icon {{ $activityClass }} flex-shrink-0">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 fw-bold" style="color: #1e293b;">{{ $aktivitas->user->nama ?? 'Unknown User' }}</h6>
                                <span class="badge bg-{{ $badgeClass }}">{{ $aktivitas->jenis_aktivitas }}</span>
                            </div>
                        </div>
                        <p class="mb-2 text-muted small">{{ $aktivitas->deskripsi ?? '-' }}</p>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($aktivitas->waktu_aktivitas)->format('d M Y, H:i') }}
                            <span class="mx-2">•</span>
                            {{ \Carbon\Carbon::parse($aktivitas->waktu_aktivitas)->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                </div>
                <h6 class="text-muted">Belum ada data aktivitas</h6>
                <p class="text-muted small">Aktivitas sistem akan muncul di sini</p>
            </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle table-themed" style="border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 180px;">Pengguna</th>
                        <th style="width: 140px;">Jenis Aktivitas</th>
                        <th>Deskripsi</th>
                        <th style="width: 180px;">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logAktivitas as $index => $aktivitas)
                    @php
                        $jenisAktivitas = strtolower($aktivitas->jenis_aktivitas ?? '');
                        $isUpload = str_contains($jenisAktivitas, 'upload');
                        $isUpdate = str_contains($jenisAktivitas, 'update') || str_contains($jenisAktivitas, 'edit');
                        $isDelete = str_contains($jenisAktivitas, 'hapus') || str_contains($jenisAktivitas, 'delete');
                        $isLogin = str_contains($jenisAktivitas, 'login');
                        $isDownload = str_contains($jenisAktivitas, 'download');
                        
                        $icon = $isUpload ? 'bi-cloud-arrow-up' : ($isUpdate ? 'bi-pencil-square' : ($isDelete ? 'bi-trash' : ($isLogin ? 'bi-box-arrow-in-right' : ($isDownload ? 'bi-download' : 'bi-file-earmark-text'))));
                        $badgeClass = $isUpload ? 'success' : ($isUpdate ? 'primary' : ($isDelete ? 'danger' : ($isLogin ? 'info' : ($isDownload ? 'warning' : 'secondary'))));
                        $iconBg = $isUpload ? 'rgba(16, 185, 129, 0.1)' : ($isUpdate ? 'rgba(59, 130, 246, 0.1)' : ($isDelete ? 'rgba(239, 68, 68, 0.1)' : ($isLogin ? 'rgba(139, 92, 246, 0.1)' : ($isDownload ? 'rgba(245, 158, 11, 0.1)' : 'rgba(100, 116, 139, 0.1)'))));
                        $iconColor = $isUpload ? '#10b981' : ($isUpdate ? '#3b82f6' : ($isDelete ? '#ef4444' : ($isLogin ? '#8b5cf6' : ($isDownload ? '#f59e0b' : '#64748b'))));
                    @endphp
                    <tr>
                        <td>
                            <span class="badge" style="background: #dbeafe; color: #1d4ed8;">
                                {{ $logAktivitas->firstItem() + $index }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold" style="color: #1e293b;">{{ $aktivitas->user->nama ?? 'Unknown' }}</div>
                                <small class="text-muted">{{ $aktivitas->user->role ?? '-' }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; border-radius: 6px; background: {{ $iconBg }}; color: {{ $iconColor }};">
                                    <i class="bi {{ $icon }}"></i>
                                </span>
                                <span class="badge bg-{{ $badgeClass }}">{{ $aktivitas->jenis_aktivitas }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted">{{ $aktivitas->deskripsi ?? '-' }}</span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold small" style="color: #1e293b;">
                                    <i class="bi bi-calendar3 me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($aktivitas->waktu_aktivitas)->format('d M Y') }}
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($aktivitas->waktu_aktivitas)->format('H:i:s') }}
                                    <span class="ms-1">({{ \Carbon\Carbon::parse($aktivitas->waktu_aktivitas)->diffForHumans() }})</span>
                                </small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                            </div>
                            <h6 class="text-muted">Belum ada data aktivitas</h6>
                            <p class="text-muted small mb-0">Aktivitas sistem akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info dan Links --}}
        @if($logAktivitas->hasPages() || $logAktivitas->total() > 0)
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 gap-2">
            <div class="text-muted small">
                <i class="bi bi-info-circle me-1" style="color: #3b82f6;"></i>
                Menampilkan {{ $logAktivitas->firstItem() ?? 0 }} - {{ $logAktivitas->lastItem() ?? 0 }} dari {{ $logAktivitas->total() }} aktivitas
            </div>
            <div>
                {{ $logAktivitas->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form when select changes
    document.querySelectorAll('.filter-card select').forEach(function(select) {
        select.addEventListener('change', function() {
            // Optional: uncomment if you want auto-submit on select change
            // this.closest('form').submit();
        });
    });
</script>
@endpush
