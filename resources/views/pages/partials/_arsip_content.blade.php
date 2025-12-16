{{-- Partial view untuk konten manajemen arsip (reusable di admin dan user) --}}
<div class="card shadow-sm">
    <div class="card-body p-2 p-md-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold m-0 fs-6 fs-md-5">Daftar Arsip/Dokumen</h5>
            @if($canUpload ?? false)
            <a href="{{ route('dokumen_upload.page') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> <span class="d-none d-sm-inline">Upload Dokumen</span><span class="d-sm-none">Upload</span></a>
            @endif
        </div>

        {{-- Search dan Per Page --}}
        <div class="row mb-3 g-2">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ $searchRoute ?? route('dokumen.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul, kategori..." value="{{ $search ?? '' }}">
                    <input type="hidden" name="per_page" value="{{ $perPage ?? 10 }}">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                    @if($search ?? false)
                    <a href="{{ ($searchRoute ?? route('dokumen.index')) . '?per_page=' . ($perPage ?? 10) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
                    @endif
                </form>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <form method="GET" action="{{ $searchRoute ?? route('dokumen.index') }}" class="d-inline-flex align-items-center gap-2">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <label class="mb-0 small">Tampilkan:</label>
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
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
            @forelse($dokumens as $index => $dokumen)
            <div class="card mb-2">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $dokumen->judul }}</h6>
                            <small class="text-muted">{{ $dokumen->kategori }} • <span class="badge bg-secondary">{{ strtoupper($dokumen->tipe_file) }}</span></small>
                        </div>
                        <span class="badge bg-light text-dark">{{ $dokumens->firstItem() + $index }}</span>
                    </div>
                    <div class="small text-muted mb-2">
                        <i class="bi bi-calendar"></i> {{ $dokumen->tanggal_upload }} • <i class="bi bi-person"></i> {{ $dokumen->user->nama ?? '-' }}
                    </div>
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="{{ route('dokumen.detail', $dokumen->id_dokumen) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-success btn-sm"><i class="bi bi-download"></i></a>
                        @if($canEdit ?? false)
                        <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">Belum ada data arsip/dokumen</div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover align-middle table-sm">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Tanggal Upload</th>
                        <th>Diunggah Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokumens as $index => $dokumen)
                    <tr>
                        <td>{{ $dokumens->firstItem() + $index }}</td>
                        <td>{{ $dokumen->judul }}</td>
                        <td>{{ $dokumen->kategori }}</td>
                        <td><span class="badge bg-secondary">{{ strtoupper($dokumen->tipe_file) }}</span></td>
                        <td>{{ $dokumen->tanggal_upload }}</td>
                        <td>{{ $dokumen->user->nama ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('dokumen.detail', $dokumen->id_dokumen) }}" class="btn btn-info btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('dokumen.download', $dokumen->id_dokumen) }}" class="btn btn-success btn-sm" title="Download"><i class="bi bi-download"></i></a>
                                @if($canEdit ?? false)
                                <a href="{{ route('dokumen.edit', $dokumen->id_dokumen) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('dokumen.destroy', $dokumen->id_dokumen) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data arsip/dokumen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Info dan Links --}}
        @if($dokumens->hasPages() || $dokumens->total() > 0)
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-3 gap-2">
            <div class="text-muted small">
                Menampilkan {{ $dokumens->firstItem() ?? 0 }} - {{ $dokumens->lastItem() ?? 0 }} dari {{ $dokumens->total() }} data
            </div>
            <div>
                {{ $dokumens->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
