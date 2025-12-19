@extends(Auth::check() && Auth::user()->role === 'Admin' ? 'layouts.app_admin' : 'layouts.app')

@section('title', 'Upload Dokumen - SIMARDAS')
@section('page-title', 'Upload Dokumen')

@push('styles')
<style>
    .page-header h4 {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .upload-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-bottom: 1px solid #bfdbfe;
        padding: 1.25rem;
    }
    .upload-zone {
        border: 2px dashed #93c5fd;
        border-radius: 12px;
        background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%);
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 2rem;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: #3b82f6;
        background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
        box-shadow: 0 5px 20px rgba(59, 130, 246, 0.15);
    }
    .upload-zone.has-file {
        border-color: #10b981;
        border-style: solid;
        background: linear-gradient(180deg, #ecfdf5 0%, #d1fae5 100%);
    }
    .file-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
    }
    .file-icon-box.pdf { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .file-icon-box.doc { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .file-icon-box.xls { background: linear-gradient(135deg, #10b981, #059669); }
    .file-icon-box.ppt { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .file-icon-box.default { background: linear-gradient(135deg, #64748b, #475569); }
    .form-control:focus, .form-select:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
    .file-preview { display: none; }
    .upload-zone.has-file .file-preview { display: block; }
    .upload-zone.has-file .upload-prompt { display: none; }
    .info-tip {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fbbf24;
        border-radius: 10px;
        padding: 12px 16px;
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
                <i class="bi bi-cloud-arrow-up-fill text-white" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-cloud-arrow-up me-2"></i>Upload Dokumen</h4>
                <p class="mb-0 text-muted">Unggah dokumen arsip baru ke sistem</p>
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

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
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

            {{-- Upload Form Card --}}
            <div class="card shadow-sm upload-card">
                <div class="form-card-header">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-file-earmark-plus text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #1e293b;">Form Upload Dokumen</h6>
                                <small class="text-muted">Isi data dokumen dengan lengkap</small>
                            </div>
                        </div>
                        <a href="{{ Auth::check() && Auth::user()->role === 'Admin' ? route('dokumen.index') : route('arsip.public') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 8px;">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4">
                    <form method="POST" action="{{ route('dokumen_upload.store') }}" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        {{-- Upload Zone --}}
                        <div class="mb-4">
                            <label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-file-earmark-arrow-up me-1" style="color: #3b82f6;"></i>File Dokumen <span class="text-danger">*</span>
                            </label>
                            <div class="upload-zone text-center" id="uploadZone">
                                {{-- Default prompt --}}
                                <div class="upload-prompt">
                                    <div class="file-icon-box default mx-auto">
                                        <i class="bi bi-cloud-arrow-up text-white fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2" style="color: #1e293b;">Seret & Lepas File di Sini</h6>
                                    <p class="text-muted mb-3">atau klik untuk memilih file dari komputer</p>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <span class="badge" style="background: linear-gradient(135deg, #ef4444, #dc2626);"><i class="bi bi-file-pdf me-1"></i>PDF</span>
                                        <span class="badge" style="background: linear-gradient(135deg, #3b82f6, #2563eb);"><i class="bi bi-file-word me-1"></i>Word</span>
                                        <span class="badge" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="bi bi-file-excel me-1"></i>Excel</span>
                                        <span class="badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><i class="bi bi-file-ppt me-1"></i>PowerPoint</span>
                                    </div>
                                </div>
                                
                                {{-- File preview --}}
                                <div class="file-preview">
                                    <div class="file-icon-box default mx-auto" id="fileIconBox">
                                        <i class="bi bi-file-earmark text-white fs-3" id="fileIconInner"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1" style="color: #065f46;" id="fileNameText">filename.pdf</h6>
                                    <p class="text-muted mb-3" id="fileSizeText">0 KB</p>
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="removeFileBtn">
                                        <i class="bi bi-x-lg me-1"></i>Hapus File
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="dokumen" id="fileInput" class="d-none" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Maksimal ukuran file: 10MB</small>
                        </div>

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold" for="formJudul" style="color: #374151;">
                                <i class="bi bi-type me-1" style="color: #3b82f6;"></i>Judul Dokumen <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="formJudul" name="judul" class="form-control" value="{{ old('judul') }}" required placeholder="Masukkan judul dokumen..." style="border-radius: 10px;">
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold" for="formKategori" style="color: #374151;">
                                <i class="bi bi-folder me-1" style="color: #3b82f6;"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="kategori" id="formKategori" class="form-select" required style="border-radius: 10px;">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Administrasi" {{ old('kategori') == 'Administrasi' ? 'selected' : '' }}>📁 Administrasi</option>
                                <option value="Keuangan" {{ old('kategori') == 'Keuangan' ? 'selected' : '' }}>💰 Keuangan</option>
                                <option value="Notulen" {{ old('kategori') == 'Notulen' ? 'selected' : '' }}>📝 Notulen</option>
                                <option value="Surat" {{ old('kategori') == 'Surat' ? 'selected' : '' }}>✉️ Surat</option>
                                <option value="Laporan" {{ old('kategori') == 'Laporan' ? 'selected' : '' }}>📊 Laporan</option>
                                <option value="Data" {{ old('kategori') == 'Data' ? 'selected' : '' }}>📋 Data</option>
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label small fw-semibold" for="formDeskripsi" style="color: #374151;">
                                <i class="bi bi-card-text me-1" style="color: #3b82f6;"></i>Deskripsi <small class="text-muted">(Opsional)</small>
                            </label>
                            <textarea id="formDeskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Tambahkan deskripsi dokumen..." style="border-radius: 10px;">{{ old('deskripsi') }}</textarea>
                        </div>

                        {{-- Info Tip --}}
                        <div class="info-tip mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb me-2" style="color: #b45309; font-size: 1.1rem;"></i>
                                <div class="small" style="color: #92400e;">
                                    <strong>Tips:</strong> Pastikan judul dokumen jelas dan deskriptif agar mudah ditemukan saat pencarian.
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center">
                            <button type="submit" class="btn w-100 text-white" 
                                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 12px; padding: 14px 28px; font-weight: 600; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); transition: all 0.3s ease; display: block !important; visibility: visible !important;"
                                onmouseover="this.style.background='linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(37, 99, 235, 0.4)';"
                                onmouseout="this.style.background='linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(37, 99, 235, 0.3)';">
                                <i class="bi bi-cloud-arrow-up me-2"></i>Upload Dokumen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    const fileNameText = document.getElementById('fileNameText');
    const fileSizeText = document.getElementById('fileSizeText');
    const fileIconBox = document.getElementById('fileIconBox');
    const fileIconInner = document.getElementById('fileIconInner');
    const removeBtn = document.getElementById('removeFileBtn');

    // Click to upload
    uploadZone.addEventListener('click', function(e) {
        if (e.target.id !== 'removeFileBtn' && !e.target.closest('#removeFileBtn')) {
            fileInput.click();
        }
    });

    // Drag & Drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('drag-over');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('drag-over');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('drag-over');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            showFileInfo(e.dataTransfer.files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            showFileInfo(this.files[0]);
        }
    });

    function showFileInfo(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        const validExts = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];
        
        if (!validExts.includes(ext)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Tidak Valid',
                text: 'Hanya file PDF, Word, Excel, dan PowerPoint yang diizinkan.',
                confirmButtonColor: '#3b82f6'
            });
            resetFile();
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Ukuran Terlalu Besar',
                text: 'Maksimal ukuran file adalah 10MB.',
                confirmButtonColor: '#3b82f6'
            });
            resetFile();
            return;
        }

        uploadZone.classList.add('has-file');
        fileNameText.textContent = file.name;
        fileSizeText.textContent = formatSize(file.size);
        setFileIcon(ext);
    }

    function setFileIcon(ext) {
        fileIconBox.className = 'file-icon-box mx-auto';
        let iconClass = 'bi-file-earmark';
        
        if (ext === 'pdf') {
            fileIconBox.classList.add('pdf');
            iconClass = 'bi-file-earmark-pdf';
        } else if (['doc', 'docx'].includes(ext)) {
            fileIconBox.classList.add('doc');
            iconClass = 'bi-file-earmark-word';
        } else if (['xls', 'xlsx'].includes(ext)) {
            fileIconBox.classList.add('xls');
            iconClass = 'bi-file-earmark-excel';
        } else if (['ppt', 'pptx'].includes(ext)) {
            fileIconBox.classList.add('ppt');
            iconClass = 'bi-file-earmark-ppt';
        } else {
            fileIconBox.classList.add('default');
        }
        
        fileIconInner.className = 'bi ' + iconClass + ' text-white fs-3';
    }

    function formatSize(bytes) {
        if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
        if (bytes >= 1024) return (bytes / 1024).toFixed(2) + ' KB';
        return bytes + ' Bytes';
    }

    function resetFile() {
        fileInput.value = '';
        uploadZone.classList.remove('has-file');
    }

    removeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        resetFile();
    });
});
</script>
@endpush
