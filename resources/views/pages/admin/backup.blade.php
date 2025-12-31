@extends('layouts.app_admin')

@section('title', 'Backup & Restore - SIMARDAS')
@section('page-title', 'Backup & Restore Sistem')

@push('styles')
<style>
    .backup-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }

    .backup-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }

    .header-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        border-radius: 16px;
    }

    .restore-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fbbf24;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .restore-card.drag-over {
        background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
        border-color: #f59e0b;
        transform: scale(1.01);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.2);
    }

    .restore-card.has-file {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-color: #10b981;
    }

    .badge-success-custom {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
    }

    .badge-danger-custom {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.4rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
    }

    .btn-backup {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-backup:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-restore-upload {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-restore-upload:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        transform: translateY(-2px);
    }

    .restore-drop-zone {
        border: 2px dashed #fbbf24;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.5);
    }

    .restore-drop-zone:hover {
        border-color: #f59e0b;
        background: rgba(255, 255, 255, 0.8);
    }

    .restore-drop-zone.drag-over {
        border-color: #d97706;
        background: rgba(255, 255, 255, 0.9);
    }

    .restore-drop-zone.has-file {
        border-color: #10b981;
        border-style: solid;
        background: white;
    }

    .restore-file-info {
        display: none;
    }

    .restore-drop-zone.has-file .restore-prompt {
        display: none;
    }

    .restore-drop-zone.has-file .restore-file-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .file-input-hidden {
        display: none;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .empty-state i {
        color: #93c5fd;
    }
</style>
@endpush

@section('content')
<div class="card shadow-sm backup-card mb-4">
    <div class="card-body p-3 p-md-4">

        {{-- GOOGLE DRIVE STATUS BAR --}}
        <div class="d-flex justify-content-end mb-2">
            <div class="d-flex align-items-center gap-2">
                @if(session()->has('google_drive_token'))
                <span class="badge-success-custom">
                    <i class="bi bi-cloud-check me-1"></i>
                    Google Drive terhubung
                </span>
                <a href="{{ url('/google/auth') }}"
                    class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-repeat"></i> Ganti Akun
                </a>
                @else
                <span class="badge-danger-custom">
                    <i class="bi bi-cloud-slash me-1"></i>
                    Google Drive belum terhubung
                </span>
                <a href="{{ url('/google/auth') }}"
                    class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-google"></i> Hubungkan
                </a>
                @endif
            </div>
        </div>

        {{-- Header Section --}}
        <div class="header-card p-3 p-md-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-2" style="color: #1e40af;">
                        <i class="bi bi-database-check me-2"></i>Backup Database Sistem
                    </h5>
                    <p class="text-muted mb-0 small">
                        <i class="bi bi-info-circle me-1"></i>
                        Buat backup database untuk keamanan dan pemulihan data. Backup disimpan dalam format ZIP.
                    </p>
                </div>
                <form method="POST" action="{{ route('backup.create') }}" id="backupForm">
                    @csrf
                    <button type="button" class="btn btn-primary btn-backup" id="btnCreateBackup">
                        <i class="bi bi-cloud-arrow-down me-2"></i>Buat Backup Baru
                    </button>
                </form>
            </div>
        </div>

        {{-- Restore Section --}}
        <div class="restore-card p-3 p-md-4 mb-4" id="restoreCard">
            <h6 class="fw-bold mb-2" style="color: #92400e;">
                <i class="bi bi-arrow-clockwise me-2"></i>Restore dari File Backup
            </h6>
            <p class="small mb-3" style="color: #a16207;">
                Upload file backup (.zip) untuk memulihkan data. <strong>Perhatian:</strong> Data saat ini akan digantikan.
            </p>
            <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data" id="restoreUploadForm">
                @csrf
                <div class="restore-drop-zone" id="restoreDropZone">
                    <input type="file" name="backup_zip" class="file-input-hidden" id="restoreFileInput" accept=".zip" required>

                    {{-- Default Prompt --}}
                    <div class="restore-prompt">
                        <i class="bi bi-file-earmark-zip display-6" style="color: #f59e0b;"></i>
                        <p class="mb-1 mt-2 fw-semibold" style="color: #92400e;">Seret & lepas file backup di sini</p>
                        <p class="mb-2 small" style="color: #a16207;">atau klik untuk memilih file</p>
                        <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #92400e;">
                            <i class="bi bi-info-circle me-1"></i>Hanya file .zip
                        </span>
                    </div>

                    {{-- File Info --}}
                    <div class="restore-file-info">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-file-earmark-zip text-white fs-4"></i>
                            </div>
                            <div class="text-start">
                                <p class="mb-0 fw-semibold" style="color: #065f46;" id="restoreFileName">backup.zip</p>
                                <small class="text-muted" id="restoreFileSize">0 KB</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="removeRestoreFile">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="button" class="btn btn-warning btn-restore-upload" id="btnRestoreUpload">
                        <i class="bi bi-arrow-clockwise me-2"></i>Restore Backup
                    </button>
                </div>
            </form>
        </div>

        {{-- Stats Info --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
                    <h4 class="fw-bold mb-0" style="color: #1e40af;">{{ $backups->count() }}</h4>
                    <small class="text-muted">Total Backup</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1px solid #6ee7b7;">
                    <h4 class="fw-bold mb-0" style="color: #065f46;">{{ $backups->where('status', 'success')->count() }}</h4>
                    <small class="text-muted">Berhasil</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 1px solid #fca5a5;">
                    <h4 class="fw-bold mb-0" style="color: #991b1b;">{{ $backups->where('status', 'failed')->count() }}</h4>
                    <small class="text-muted">Gagal</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 rounded-3 text-center" style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border: 1px solid #c4b5fd;">
                    @php
                    $totalSize = $backups->sum('ukuran_file');
                    $sizeDisplay = $totalSize >= 1048576
                    ? number_format($totalSize / 1048576, 2) . ' MB'
                    : number_format($totalSize / 1024, 2) . ' KB';
                    @endphp
                    <h4 class="fw-bold mb-0" style="color: #5b21b6;">{{ $sizeDisplay }}</h4>
                    <small class="text-muted">Total Ukuran</small>
                </div>
            </div>
        </div>

        {{-- Table Header --}}
        <h6 class="fw-bold mb-3" style="color: #1e293b;">
            <i class="bi bi-list-ul me-2" style="color: #3b82f6;"></i>Riwayat Backup
        </h6>

        {{-- Mobile Card View --}}
        <div class="d-md-none">
            @forelse($backups as $index => $b)
            <div class="card mb-2 mobile-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1e293b; font-size: 0.85rem;">
                                <i class="bi bi-file-earmark-zip me-1" style="color: #3b82f6;"></i>
                                {{ basename($b->lokasi_file) }}
                            </h6>
                            <small class="text-muted d-block">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($b->tanggal_backup)->format('d M Y H:i') }}
                            </small>
                            <small class="text-muted d-block">
                                <i class="bi bi-person me-1"></i>{{ $b->user->nama ?? '-' }}
                            </small>
                        </div>
                        @if($b->status === 'success')
                        <span class="badge-success-custom">
                            <i class="bi bi-check-circle me-1"></i>Success
                        </span>
                        @else
                        <span class="badge-danger-custom">
                            <i class="bi bi-x-circle me-1"></i>Failed
                        </span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2" style="border-top: 1px solid #e2e8f0;">
                        <small class="text-muted">
                            <i class="bi bi-hdd me-1"></i>{{ number_format($b->ukuran_file / 1024, 2) }} KB
                        </small>
                        <div class="d-flex gap-1">
                            <a href="{{ route('backup.download', $b->id_backup) }}" class="btn btn-success btn-sm btn-action">
                                <i class="bi bi-download"></i>
                            </a>
                            <form action="{{ route('backup.restore.byid', $b->id_backup) }}" method="POST" class="d-inline restore-form" data-name="{{ basename($b->lokasi_file) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm btn-action">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center empty-state">
                <i class="bi bi-database display-4"></i>
                <p class="text-muted mt-2 mb-0">Belum ada data backup</p>
            </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle table-sm table-themed" style="border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal Backup</th>
                        <th>Nama File</th>
                        <th>Ukuran</th>
                        <th>User</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $index => $b)
                    <tr>
                        <td class="fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <i class="bi bi-calendar3 me-1" style="color: #3b82f6;"></i>
                            {{ \Carbon\Carbon::parse($b->tanggal_backup)->format('d M Y H:i') }}
                        </td>
                        <td>
                            <i class="bi bi-file-earmark-zip me-1" style="color: #3b82f6;"></i>
                            <span style="color: #1e293b;">{{ basename($b->lokasi_file) }}</span>
                        </td>
                        <td>
                            <span class="text-muted">{{ number_format($b->ukuran_file / 1024, 2) }} KB</span>
                        </td>
                        <td>
                            <i class="bi bi-person me-1" style="color: #64748b;"></i>
                            {{ $b->user->nama ?? '-' }}
                        </td>
                        <td>
                            @if($b->status === 'success')
                            <span class="badge-success-custom">
                                <i class="bi bi-check-circle me-1"></i>Success
                            </span>
                            @else
                            <span class="badge-danger-custom">
                                <i class="bi bi-x-circle me-1"></i>Failed
                            </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('backup.download', $b->id_backup) }}" class="btn btn-success btn-sm btn-action" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <form action="{{ route('backup.restore.byid', $b->id_backup) }}" method="POST" class="d-inline restore-form" data-name="{{ basename($b->lokasi_file) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm btn-action" title="Restore">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center empty-state">
                            <i class="bi bi-database display-4 d-block mb-2"></i>
                            <span class="text-muted">Belum ada data backup</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const restoreDropZone = document.getElementById('restoreDropZone');
        const restoreCard = document.getElementById('restoreCard');
        const restoreFileInput = document.getElementById('restoreFileInput');
        const restoreFileName = document.getElementById('restoreFileName');
        const restoreFileSize = document.getElementById('restoreFileSize');
        const removeRestoreFile = document.getElementById('removeRestoreFile');

        // Click to open file browser
        restoreDropZone.addEventListener('click', function(e) {
            if (!e.target.closest('#removeRestoreFile')) {
                restoreFileInput.click();
            }
        });

        // Drag events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            restoreDropZone.addEventListener(eventName, preventDefaults, false);
            restoreCard.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Drag enter/over - highlight
        ['dragenter', 'dragover'].forEach(eventName => {
            restoreDropZone.addEventListener(eventName, () => restoreDropZone.classList.add('drag-over'), false);
            restoreCard.addEventListener(eventName, () => restoreCard.classList.add('drag-over'), false);
        });

        // Drag leave/drop - unhighlight
        ['dragleave', 'drop'].forEach(eventName => {
            restoreDropZone.addEventListener(eventName, () => restoreDropZone.classList.remove('drag-over'), false);
            restoreCard.addEventListener(eventName, () => restoreCard.classList.remove('drag-over'), false);
        });

        // Handle drop on card or zone
        [restoreDropZone, restoreCard].forEach(el => {
            el.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    restoreFileInput.files = files;
                    handleRestoreFile(files[0]);
                }
            });
        });

        // Handle file input change
        restoreFileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleRestoreFile(this.files[0]);
            }
        });

        function handleRestoreFile(file) {
            const ext = file.name.split('.').pop().toLowerCase();

            if (ext !== 'zip') {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Valid',
                    text: 'Hanya file .zip yang diizinkan untuk restore backup.',
                    confirmButtonColor: '#3b82f6'
                });
                resetRestoreInput();
                return;
            }

            // Show file info
            restoreDropZone.classList.add('has-file');
            restoreCard.classList.add('has-file');
            restoreFileName.textContent = file.name;
            restoreFileSize.textContent = formatFileSize(file.size);
        }

        function formatFileSize(bytes) {
            if (bytes >= 1048576) {
                return (bytes / 1048576).toFixed(2) + ' MB';
            } else if (bytes >= 1024) {
                return (bytes / 1024).toFixed(2) + ' KB';
            }
            return bytes + ' Bytes';
        }

        function resetRestoreInput() {
            restoreFileInput.value = '';
            restoreDropZone.classList.remove('has-file');
            restoreCard.classList.remove('has-file');
        }

        // Remove file button
        removeRestoreFile.addEventListener('click', function(e) {
            e.stopPropagation();
            resetRestoreInput();
        });

        // Buat Backup - Konfirmasi
        document.getElementById('btnCreateBackup').addEventListener('click', function() {
            Swal.fire({
                title: '<i class="bi bi-database-add" style="color: #3b82f6; font-size: 2rem;"></i>',
                html: `
                <div style="text-align: center;">
                    <h5 style="color: #1e293b; margin-bottom: 0.5rem;">Buat Backup Baru?</h5>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 0;">
                        Sistem akan membuat backup database dalam format ZIP.
                    </p>
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Buat Backup',
                cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal-popup-custom',
                    confirmButton: 'swal-confirm-custom',
                    cancelButton: 'swal-cancel-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('backupForm').submit();
                }
            });
        });

        // Restore Upload - Konfirmasi
        document.getElementById('btnRestoreUpload').addEventListener('click', function() {
            if (!restoreFileInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File Belum Dipilih',
                    text: 'Silakan pilih atau seret file backup (.zip) terlebih dahulu.',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            const fileName = restoreFileInput.files[0].name;

            Swal.fire({
                title: '<i class="bi bi-exclamation-triangle" style="color: #f59e0b; font-size: 2rem;"></i>',
                html: `
                <div style="text-align: center;">
                    <h5 style="color: #1e293b; margin-bottom: 0.5rem;">Restore dari File Backup?</h5>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">
                        <strong style="color: #dc2626;">Perhatian:</strong> Semua data saat ini akan digantikan dengan data dari backup.
                    </p>
                    <div style="background: #fef3c7; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #fbbf24;">
                        <small style="color: #92400e;">File: <strong>${fileName}</strong></small>
                    </div>
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-arrow-clockwise me-1"></i> Ya, Restore',
                cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal-popup-custom',
                    confirmButton: 'swal-confirm-custom',
                    cancelButton: 'swal-cancel-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('restoreUploadForm').submit();
                }
            });
        });

        // Restore by ID - Konfirmasi
        document.querySelectorAll('.restore-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const fileName = this.dataset.name;

                Swal.fire({
                    title: '<i class="bi bi-exclamation-triangle" style="color: #f59e0b; font-size: 2rem;"></i>',
                    html: `
                    <div style="text-align: center;">
                        <h5 style="color: #1e293b; margin-bottom: 0.5rem;">Restore Backup Ini?</h5>
                        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">
                            <strong style="color: #dc2626;">Perhatian:</strong> Semua data saat ini akan digantikan dengan data dari backup.
                        </p>
                        <div style="background: #fef3c7; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid #fbbf24;">
                            <small style="color: #92400e;">File: <strong>${fileName}</strong></small>
                        </div>
                    </div>
                `,
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-arrow-clockwise me-1"></i> Ya, Restore',
                    cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
                    confirmButtonColor: '#f59e0b',
                    cancelButtonColor: '#64748b',
                    customClass: {
                        popup: 'swal-popup-custom',
                        confirmButton: 'swal-confirm-custom',
                        cancelButton: 'swal-cancel-custom'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush