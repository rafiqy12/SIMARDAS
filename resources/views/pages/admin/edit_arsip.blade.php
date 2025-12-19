@extends(Auth::check() && Auth::user()->role === 'Admin' ? 'layouts.app_admin' : 'layouts.app')

@section('title', 'Edit Arsip - SIMARDAS')
@section('page-title', 'Edit Arsip')

@push('styles')
<style>
    .page-header h4 {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .edit-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-bottom: 1px solid #bfdbfe;
        padding: 1.25rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .info-box {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem;
    }
    .info-box-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #bfdbfe;
    }
    .info-box-item:last-child {
        border-bottom: none;
    }
    .info-box-item i {
        width: 24px;
        color: #3b82f6;
    }
    .btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }
    .badge-file-type {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-submit-custom {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        transition: all 0.3s ease;
    }
    .btn-submit-custom:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }
    .btn-submit-custom:active {
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-pencil-square text-white" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-pencil-square me-2"></i>Edit Arsip</h4>
                <p class="mb-0 text-muted">Perbarui informasi dokumen arsip</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            {{-- Alert Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Edit Form Card --}}
            <div class="card shadow-sm edit-card">
                <div class="form-card-header">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-file-earmark-text text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #1e293b;">Edit Data Dokumen</h6>
                                <small class="text-muted">Perbarui informasi yang diperlukan</small>
                            </div>
                        </div>
                        <a href="{{ Auth::check() && Auth::user()->role === 'Admin' ? route('dokumen.index') : route('arsip.public') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 8px;">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4">
                    <form method="POST" action="{{ route('dokumen.update', $dokumen->id_dokumen) }}">
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold" for="formJudul" style="color: #374151;">
                                <i class="bi bi-type me-1" style="color: #3b82f6;"></i>Judul Dokumen <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="formJudul" name="judul" class="form-control" value="{{ old('judul', $dokumen->judul) }}" required autofocus style="border-radius: 10px;">
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold" for="formKategori" style="color: #374151;">
                                <i class="bi bi-folder me-1" style="color: #3b82f6;"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="kategori" id="formKategori" class="form-select" required style="border-radius: 10px;">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Administrasi" {{ old('kategori', $dokumen->kategori) == 'Administrasi' ? 'selected' : '' }}>📁 Administrasi</option>
                                <option value="Keuangan" {{ old('kategori', $dokumen->kategori) == 'Keuangan' ? 'selected' : '' }}>💰 Keuangan</option>
                                <option value="Notulen" {{ old('kategori', $dokumen->kategori) == 'Notulen' ? 'selected' : '' }}>📝 Notulen</option>
                                <option value="Surat" {{ old('kategori', $dokumen->kategori) == 'Surat' ? 'selected' : '' }}>✉️ Surat</option>
                                <option value="Laporan" {{ old('kategori', $dokumen->kategori) == 'Laporan' ? 'selected' : '' }}>📊 Laporan</option>
                                <option value="Data" {{ old('kategori', $dokumen->kategori) == 'Data' ? 'selected' : '' }}>📋 Data</option>
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label small fw-semibold" for="formDeskripsi" style="color: #374151;">
                                <i class="bi bi-card-text me-1" style="color: #3b82f6;"></i>Deskripsi <small class="text-muted">(Opsional)</small>
                            </label>
                            <textarea id="formDeskripsi" name="deskripsi" class="form-control" rows="3" style="border-radius: 10px;">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
                        </div>

                        {{-- Informasi File --}}
                        <div class="mb-4">
                            <label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-info-circle me-1" style="color: #3b82f6;"></i>Informasi File
                            </label>
                            <div class="info-box">
                                <div class="info-box-item">
                                    <i class="bi bi-file-earmark me-2"></i>
                                    <span class="small"><strong>Tipe File:</strong></span>
                                    <span class="badge-file-type ms-2">{{ strtoupper($dokumen->tipe_file) }}</span>
                                </div>
                                <div class="info-box-item">
                                    <i class="bi bi-calendar me-2"></i>
                                    <span class="small"><strong>Tanggal Upload:</strong></span>
                                    <span class="ms-2 small text-muted">{{ $dokumen->tanggal_upload }}</span>
                                </div>
                                <div class="info-box-item">
                                    <i class="bi bi-hdd me-2"></i>
                                    <span class="small"><strong>Ukuran File:</strong></span>
                                    <span class="ms-2 small text-muted">
                                        @if($dokumen->ukuran_file)
                                            @if($dokumen->ukuran_file >= 1048576)
                                                {{ number_format($dokumen->ukuran_file / 1048576, 2) }} MB
                                            @else
                                                {{ number_format($dokumen->ukuran_file / 1024, 2) }} KB
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="info-box-item">
                                    <i class="bi bi-folder2 me-2"></i>
                                    <span class="small"><strong>Path:</strong></span>
                                    <span class="ms-2 small text-muted text-break">{{ $dokumen->path_file }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center">
                            <button type="submit" class="btn w-100 text-white" 
                                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 12px; padding: 14px 28px; font-weight: 600; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); transition: all 0.3s ease; display: block !important; visibility: visible !important;"
                                onmouseover="this.style.background='linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(37, 99, 235, 0.4)';"
                                onmouseout="this.style.background='linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(37, 99, 235, 0.3)';">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
