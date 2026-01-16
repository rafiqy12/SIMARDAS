@extends('layouts.app_admin')

@section('title', 'Dashboard - SIMARDAS')
@section('page-title', 'Dashboard Admin')

@push('styles')
<style>
    /* Stat Card Styles */
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        border: 1px solid var(--primary-100);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15) !important;
        border-color: var(--primary-300);
    }
    .stat-card .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
        background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .stat-card .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0;
    }
    .stat-card .stat-trend {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 20px;
    }
    
    /* Activity Card */
    .activity-item {
        padding: 12px;
        border-radius: 10px;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    .activity-item:hover {
        background: var(--primary-50);
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
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
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
    
    /* Quick Action Buttons */
    .quick-action-btn {
        border: 2px dashed var(--primary-200);
        border-radius: 16px;
        transition: all 0.3s ease;
        background: #fff;
    }
    .quick-action-btn:hover {
        border-color: var(--primary-500);
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);
        transform: scale(1.02);
    }
    .quick-action-btn i {
        transition: transform 0.3s ease;
    }
    .quick-action-btn:hover i {
        transform: scale(1.2);
        color: var(--primary-600);
    }
    
    /* Progress bar animation */
    .progress-animated .progress-bar {
        animation: progressAnimation 1.5s ease-out;
        background: linear-gradient(90deg, var(--primary-500) 0%, var(--primary-600) 100%);
    }
    @keyframes progressAnimation {
        from { width: 0; }
    }
    
    /* Kategori badges */
    .kategori-item {
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .kategori-item:hover {
        background: var(--primary-50);
    }
    
    /* Counter animation */
    .counter {
        display: inline-block;
    }
    
    /* Card hover effect */
    .card-hover {
        transition: all 0.3s ease;
        border: 1px solid var(--primary-100);
    }
    .card-hover:hover {
        box-shadow: 0 5px 20px rgba(37, 99, 235, 0.1) !important;
        border-color: var(--primary-200);
    }
    
    /* Pulse animation for online status */
    .pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    /* Welcome section - Blue Theme */
    .welcome-section {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 50%, #1e40af 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    /* Gradient backgrounds - Blue Primary Theme */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
    }
</style>
@endpush

@section('content')
<!-- Welcome Section -->
<div class="welcome-section text-white p-4 mb-4 shadow">
    <div class="position-relative" style="z-index: 1;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-hand-wave me-2"></i>Selamat datang, {{ Auth::user()->nama ?? 'Admin' }}!
                </h4>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="mt-3 mt-md-0">
                <span class="badge bg-white px-3 py-2 fs-6" style="color: #2563eb;">
                    <i class="bi bi-shield-check me-1"></i>{{ Auth::user()->role ?? 'Admin' }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <!-- Total Arsip -->
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-gradient-primary text-white">
                        <i class="bi bi-archive"></i>
                    </div>
                    <span class="stat-trend bg-success bg-opacity-10 text-success">
                        <i class="bi bi-arrow-up"></i> Aktif
                    </span>
                </div>
                <h3 class="stat-value text-dark counter" data-target="{{ $totalArsip }}">{{ number_format($totalArsip) }}</h3>
                <p class="stat-label">Total Arsip</p>
            </div>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-gradient-success text-white">
                        <i class="bi bi-people"></i>
                    </div>
                    <span class="stat-trend bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-person-plus"></i> Users
                    </span>
                </div>
                <h3 class="stat-value text-dark counter" data-target="{{ $totalUser }}">{{ number_format($totalUser) }}</h3>
                <p class="stat-label">Total Pengguna</p>
            </div>
        </div>
    </div>

    <!-- Arsip Bulan Ini -->
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-gradient-warning text-white">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <span class="stat-trend bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-clock"></i> {{ now()->translatedFormat('M') }}
                    </span>
                </div>
                <h3 class="stat-value text-dark counter" data-target="{{ $arsipBulanIni }}">{{ number_format($arsipBulanIni) }}</h3>
                <p class="stat-label">Arsip Bulan Ini</p>
            </div>
        </div>
    </div>

    <!-- Storage -->
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow h-100">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-gradient-info text-white">
                        <i class="bi bi-hdd"></i>
                    </div>
                    <span class="stat-trend bg-info bg-opacity-10 text-info">
                        <i class="bi bi-pie-chart"></i> {{ $storagePercentage }}%
                    </span>
                </div>
                <h3 class="stat-value text-dark">{{ $storageUsed }}</h3>
                <p class="stat-label">Storage Terpakai</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row g-3 mb-4">
    <!-- Aktivitas Terbaru -->
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm card-hover h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 py-3" style="border-radius: 16px 16px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-activity text-primary me-2"></i>Aktivitas Terbaru
                    </h6>
                    <a href="{{ route('log-aktivitas.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-3">
                @forelse($aktivitasTerbaru as $aktivitas)
                @php
                    $jenisAktivitas = strtolower($aktivitas->jenis_aktivitas ?? '');
                    $isUpload = str_contains($jenisAktivitas, 'upload');
                    $isUpdate = str_contains($jenisAktivitas, 'update');
                    $isDelete = str_contains($jenisAktivitas, 'hapus');
                    $activityClass = $isUpload ? 'upload' : ($isUpdate ? 'update' : ($isDelete ? 'delete' : 'upload'));
                    $icon = $isUpload ? 'bi-cloud-arrow-up' : ($isUpdate ? 'bi-pencil-square' : ($isDelete ? 'bi-trash' : 'bi-file-earmark-text'));
                    $badgeClass = $isUpload ? 'success' : ($isUpdate ? 'primary' : ($isDelete ? 'danger' : 'secondary'));
                @endphp
                <div class="activity-item {{ $activityClass }} d-flex align-items-start mb-2">
                    <div class="activity-icon {{ $activityClass }} me-3 flex-shrink-0">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1 fw-semibold small">{{ $aktivitas->user->nama ?? 'Unknown' }}</p>
                                <p class="mb-0 text-muted small">
                                    {{ $aktivitas->deskripsi ?? $aktivitas->jenis_aktivitas }}
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $badgeClass }}">
                                    {{ $aktivitas->jenis_aktivitas }}
                                </span>
                                <p class="mb-0 text-muted small mt-1">
                                    <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($aktivitas->waktu_aktivitas)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                    </div>
                    <h6 class="text-muted">Belum ada aktivitas</h6>
                    <p class="small text-muted mb-0">Aktivitas upload dokumen akan muncul di sini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Status Sistem & Statistik -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm card-hover mb-3" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 py-3" style="border-radius: 16px 16px 0 0;">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-gear text-primary me-2"></i>Status Sistem
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <span class="badge bg-success pulse px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i> Online
                        </span>
                    </div>
                    <small class="text-muted">Server berjalan normal</small>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <small class="fw-semibold">Storage Usage</small>
                        <small class="text-{{ $storagePercentage > 80 ? 'danger' : ($storagePercentage > 50 ? 'warning' : 'success') }}">{{ $storagePercentage }}%</small>
                    </div>
                    <div class="progress progress-animated" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar bg-{{ $storagePercentage > 80 ? 'danger' : ($storagePercentage > 50 ? 'warning' : 'success') }}" 
                             role="progressbar" 
                             style="width: {{ $storagePercentage }}%; border-radius: 10px;"
                             aria-valuenow="{{ $storagePercentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">{{ $storageUsed }} dari 500 GB</small>
                </div>

                <hr>

                <div>
                    <small class="fw-semibold d-block mb-2">
                        <i class="bi bi-bar-chart me-1"></i>Statistik Kategori
                    </small>
                    @forelse($statistikKategori as $stat)
                    <div class="kategori-item d-flex justify-content-between align-items-center mb-1">
                        <span class="small">
                            <i class="bi bi-folder2 me-1" style="color: #6366f1;"></i>
                            {{ $stat->kategori ?? 'Tanpa Kategori' }}
                        </span>
                        <span class="badge rounded-pill" style="background-color: #6366f1;">{{ $stat->total }}</span>
                    </div>
                    @empty
                    <p class="text-muted small mb-0">Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0 py-3" style="border-radius: 16px 16px 0 0;">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-lightning-charge text-warning me-2"></i>Aksi Cepat
        </h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a class="quick-action-btn d-block text-center p-4 text-decoration-none" href="{{ route('dokumen_upload.page') }}">
                    <div class="mb-2">
                        <i class="bi bi-cloud-arrow-up display-5" style="color: #6366f1;"></i>
                    </div>
                    <span class="fw-semibold text-dark small">Upload Dokumen</span>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a class="quick-action-btn d-block text-center p-4 text-decoration-none" href="{{ route('scan_dokumen.page') }}">
                    <div class="mb-2">
                        <i class="bi bi-qr-code-scan display-5" style="color: #10b981;"></i>
                    </div>
                    <span class="fw-semibold text-dark small">Scan Dokumen</span>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a class="quick-action-btn d-block text-center p-4 text-decoration-none" href="{{ route('search.page') }}">
                    <div class="mb-2">
                        <i class="bi bi-search display-5" style="color: #3b82f6;"></i>
                    </div>
                    <span class="fw-semibold text-dark small">Cari Arsip</span>
                </a>
            </div>

            <div class="col-6 col-md-3">
                <a class="quick-action-btn d-block text-center p-4 text-decoration-none" href="{{ route('user.index') }}">
                    <div class="mb-2">
                        <i class="bi bi-people display-5" style="color: #f59e0b;"></i>
                    </div>
                    <span class="fw-semibold text-dark small">Kelola User</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target')) || parseInt(counter.textContent.replace(/,/g, ''));
        const duration = 1500;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    });
});
</script>
@endpush
