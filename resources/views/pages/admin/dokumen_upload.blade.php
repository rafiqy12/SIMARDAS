@extends('layouts.app')

@section('title', 'Upload Dokumen - SIMARDAS')

@push('styles')
<style>
    /* Page-specific styles only */
    .upload-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
    }
    .upload-zone {
        border: 2px dashed #93c5fd;
        border-radius: 12px;
        background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .upload-zone:hover {
        border-color: #3b82f6;
        background: linear-gradient(180deg, #dbeafe 0%, #bfdbfe 100%);
    }
    .btn-upload {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }
    .btn-upload:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm upload-card">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                        <h5 class="fw-bold m-0" style="color: #1e293b;">
                            <i class="bi bi-cloud-arrow-up me-2" style="color: #3b82f6;"></i>Upload Dokumen Baru
                        </h5>
                        <a href="{{ route('arsip.public') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 8px;">
                            <i class="bi bi-arrow-bar-left"></i> Kembali ke Arsip
                        </a>
                    </div>

                    <form method="POST" action="{{ route('dokumen_upload.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Alert untuk pesan sukses --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        {{-- Alert untuk pesan error --}}
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        {{-- Alert untuk validation errors --}}
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label small fw-semibold" style="color: #1e293b;">
                                <i class="bi bi-file-earmark me-1" style="color: #3b82f6;"></i>File Dokumen
                            </label>
                            <div class="upload-zone p-4 text-center">
                                <i class="bi bi-cloud-upload display-4" style="color: #3b82f6;"></i>
                                <p class="mb-2 mt-2 fw-semibold" style="color: #1e293b;">Pilih atau seret file ke sini</p>
                                <input type="file" name="dokumen" class="form-control" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            </div>
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>PDF, Word, Excel, PowerPoint (Max: 10MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold" style="color: #1e293b;">
                                <i class="bi bi-type me-1" style="color: #3b82f6;"></i>Judul Dokumen
                            </label>
                            <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul dokumen...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold" style="color: #1e293b;">
                                <i class="bi bi-tag me-1" style="color: #3b82f6;"></i>Kategori Dokumen
                            </label>
                            <select name="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Administrasi">📁 Administrasi</option>
                                <option value="Keuangan">💰 Keuangan</option>
                                <option value="Notulen">📝 Notulen</option>
                                <option value="Surat">✉️ Surat</option>
                                <option value="Laporan">📊 Laporan</option>
                                <option value="Data">📋 Data</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold" style="color: #1e293b;">
                                <i class="bi bi-text-paragraph me-1" style="color: #3b82f6;"></i>Deskripsi (Opsional)
                            </label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tambahkan deskripsi dokumen..."></textarea>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-upload w-100 text-white" type="submit">
                                <i class="bi bi-upload me-2"></i>Upload Dokumen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection