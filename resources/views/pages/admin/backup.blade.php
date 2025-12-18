@extends('layouts.app_admin')

@section('title', 'Backup Sistem')
@section('page-title', 'Backup & Restore Sistem')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-database-check me-2 text-primary"></i>Backup Sistem
            </h4>
            <p class="text-muted mb-0 small">
                Backup database sistem untuk keamanan dan pemulihan data
            </p>
        </div>

        <form method="POST" action="{{ route('backup.create') }}">
            @csrf
            <button class="btn btn-primary shadow-sm">
                <i class="bi bi-cloud-arrow-down me-1"></i> Buat Backup
            </button>
        </form>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="input-group">
            <input type="file" name="backup_zip" class="form-control" required>
            <button class="btn btn-warning">
                <i class="bi bi-arrow-clockwise"></i> Restore Backup
            </button>
        </div>
    </form>


    {{-- TABLE --}}
    <div class="card shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-body p-3 p-md-4">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal Backup</th>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>User</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($backups as $index => $b)
                        <tr>
                            <td class="fw-semibold">{{ $index + 1 }}</td>

                            <td>
                                <i class="bi bi-calendar3 me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($b->tanggal_backup)->format('d M Y H:i') }}
                            </td>

                            <td>
                                <i class="bi bi-file-earmark-zip me-1 text-primary"></i>
                                {{ basename($b->lokasi_file) }}
                            </td>

                            <td>
                                {{ number_format($b->ukuran_file / 1024, 2) }} KB
                            </td>

                            <td>
                                <i class="bi bi-person me-1"></i>
                                {{ $b->user->nama ?? '-' }}
                            </td>

                            <td>
                                @if($b->status === 'success')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Success
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i> Failed
                                </span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                <a href="{{ route('backup.download', $b->id_backup) }}"
                                    class="btn btn-success btn-sm mb-1">
                                    <i class="bi bi-download"></i>
                                </a>
                                <form action="{{ route('backup.restore.byid', $b->id_backup) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin merestore backup ini? Semua data saat ini akan tergantikan.')">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                Belum ada data backup
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection