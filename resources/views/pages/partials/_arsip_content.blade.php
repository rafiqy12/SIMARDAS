{{-- Partial view untuk konten manajemen arsip (reusable di admin dan user) --}}
<style>
    .arsip-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .arsip-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }
    .arsip-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table-arsip {
        width: 100%;
        min-width: 650px;
    }
    .table-arsip td, .table-arsip th {
        white-space: nowrap;
    }
    .table-arsip td.wrap-text {
        white-space: normal;
        word-break: break-word;
        max-width: 200px;
    }
    .table-arsip thead {
        background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
    }
    .table-arsip thead th {
        color: #1e40af;
        font-weight: 600;
        border-bottom: 2px solid #93c5fd;
    }
    .table-arsip tbody tr {
        transition: all 0.2s ease;
    }
    .table-arsip tbody tr:hover {
        background: #eff6ff;
    }
    .btn-action {
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .mobile-arsip-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .mobile-arsip-card:hover {
        border-color: #93c5fd;
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
    }
</style>
<div class="card-arsip-wrapper">
    <div class="card shadow-sm arsip-card">
    <div class="card-body p-2 p-md-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold m-0 fs-6 fs-md-5" style="color: #1e293b;">
                <i class="bi bi-folder2-open me-2" style="color: #3b82f6;"></i>Daftar Arsip/Dokumen
            </h5>
            @if($canUpload ?? false)
            <a href="{{ route('dokumen_upload.page') }}" class="btn btn-primary btn-sm" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Upload Dokumen</span><span class="d-sm-none">Upload</span>
            </a>
            @endif
        </div>

        {{-- Search dan Per Page --}}
        <div class="row mb-3 g-2">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ $searchRoute ?? route('dokumen.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul, kategori..." value="{{ $search ?? '' }}" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    <input type="hidden" name="per_page" value="{{ $perPage ?? 10 }}">
                    <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search ?? false)
                    <a href="{{ ($searchRoute ?? route('dokumen.index')) . '?per_page=' . ($perPage ?? 10) }}" class="btn btn-secondary btn-sm" style="border-radius: 8px;">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </form>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <form method="GET" action="{{ $searchRoute ?? route('dokumen.index') }}" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <label class="mb-0 small text-muted">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width: auto; border-radius: 8px;" onchange="this.form.submit()">
                        <option value="5" {{ ($perPage ?? 10) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="d-md-none">
            @php
                $fileColors = [
                    'pdf' => ['color' => '#ef4444', 'bg' => '#fee2e2'],
                    'doc' => ['color' => '#2563eb', 'bg' => '#dbeafe'],
                    'docx' => ['color' => '#2563eb', 'bg' => '#dbeafe'],
                    'xls' => ['color' => '#16a34a', 'bg' => '#dcfce7'],
                    'xlsx' => ['color' => '#16a34a', 'bg' => '#dcfce7'],
                    'jpg' => ['color' => '#f59e42', 'bg' => '#fef9c3'],
                    'jpeg' => ['color' => '#f59e42', 'bg' => '#fef9c3'],
                    'png' => ['color' => '#f59e42', 'bg' => '#fef9c3'],
                    'zip' => ['color' => '#a16207', 'bg' => '#fef3c7'],
                    'rar' => ['color' => '#a16207', 'bg' => '#fef3c7'],
                    'default' => ['color' => '#64748b', 'bg' => '#f1f5f9'],
                ];
            @endphp
            @forelse($dokumens as $index => $dokumen)
            @php
                $fileType = strtolower($dokumen->tipe_file ?? '');
                $colorData = $fileColors[$fileType] ?? $fileColors['default'];
            @endphp
            <div class="card mb-2 mobile-arsip-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1" style="color: #1e293b;">{{ $dokumen->judul }}</h6>
                            <small class="text-muted">{{ $dokumen->kategori }} • <span class="badge" style="background: {{ $colorData['bg'] }}; color: {{ $colorData['color'] }};">{{ strtoupper($dokumen->tipe_file) }}</span></small>
                        </div>
                        <span class="badge" style="background: #dbeafe; color: #1d4ed8;">{{ $dokumens->firstItem() + $index }}</span>
                    </div>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar" style="color: #3b82f6;"></i> {{ $dokumen->tanggal_upload }} • <i class="bi bi-person" style="color: #3b82f6;"></i> {{ $dokumen->user->nama ?? '-' }}
                    </div>
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="{{ route('dokumen.detail', $dokumen->id_dokumen) }}" class="btn btn-info btn-sm btn-action"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-success btn-sm btn-action"><i class="bi bi-download"></i></a>
                        @if($canEdit ?? false)
                        <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}" class="btn btn-warning btn-sm btn-action"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}" method="POST" class="d-inline delete-form" data-name="{{ $dokumen->judul }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox display-4" style="color: #93c5fd;"></i>
                <p class="text-muted mt-2">Belum ada data arsip/dokumen</p>
            </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="arsip-table-wrapper d-none d-md-block">
            <table class="table table-hover align-middle table-sm table-arsip" style="border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th style="width: 60px;">Tipe</th>
                        <th>Tanggal Upload</th>
                        <th>Diunggah Oleh</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokumens as $index => $dokumen)
                    <tr>
                        <td><span class="badge" style="background: #dbeafe; color: #1d4ed8;">{{ $dokumens->firstItem() + $index }}</span></td>
                        <td class="fw-semibold wrap-text" style="color: #1e293b;">{{ $dokumen->judul }}</td>
                        <td>{{ $dokumen->kategori }}</td>
                        @php
                            $fileType = strtolower($dokumen->tipe_file ?? '');
                            $colorData = $fileColors[$fileType] ?? $fileColors['default'];
                        @endphp
                        <td><span class="badge" style="background: {{ $colorData['bg'] }}; color: {{ $colorData['color'] }}; font-size: 0.75rem; padding: 0.35em 0.7em; font-weight: 600; letter-spacing: 0.5px; border-radius: 6px;">{{ strtoupper($dokumen->tipe_file) }}</span></td>
                        <td>{{ $dokumen->tanggal_upload }}</td>
                        <td>{{ $dokumen->user->nama ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('dokumen.detail', $dokumen->id_dokumen) }}" class="btn btn-info btn-sm btn-action" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-success btn-sm btn-action" title="Download"><i class="bi bi-download"></i></a>
                                @if($canEdit ?? false)
                                <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}" class="btn btn-warning btn-sm btn-action" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}" method="POST" class="d-inline delete-form" data-name="{{ $dokumen->judul }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-action" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox display-6" style="color: #93c5fd;"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada data arsip/dokumen</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info dan Links --}}
        @if($dokumens->hasPages() || $dokumens->total() > 0)
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 gap-2">
            <div class="text-muted small">
                <i class="bi bi-info-circle me-1" style="color: #3b82f6;"></i>
                Menampilkan {{ $dokumens->firstItem() ?? 0 }} - {{ $dokumens->lastItem() ?? 0 }} dari {{ $dokumens->total() }} data
            </div>
            <div>
                {{ $dokumens->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
    </div>
</div>
<style>
.card-arsip-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px;
    box-sizing: border-box;
}
</style>
