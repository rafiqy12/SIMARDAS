@extends('layouts.app')

@section('title', 'Upload Dokumen - SIMARDAS')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                        <h5 class="fw-bold m-0">
                            <i class="bi bi-cloud-arrow-up text-primary me-2"></i>Upload Dokumen Baru
                        </h5>
                        <a href="{{ route('arsip.public') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-bar-left"></i> Kembali ke Arsip
                        </a>
                    </div>

                    <form method="POST" action="{{ route('dokumen_upload.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Alert untuk pesan sukses --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        {{-- Alert untuk pesan error --}}
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        {{-- Alert untuk validation errors --}}
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">File Dokumen</label>
                            <input type="file" name="dokumen" class="form-control form-control-sm" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <small class="text-muted">PDF, Word, Excel, PowerPoint</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Judul Dokumen</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kategori Dokumen</label>
                            <select name="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Keuangan">Keuangan</option>
                                <option value="Notulen">Notulen</option>
                                <option value="Surat">Surat</option>
                                <option value="Laporan">Laporan</option>
                                <option value="Data">Data</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary w-100" type="submit">
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