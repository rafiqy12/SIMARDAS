@extends('layouts.app')
@section('content')

<div class="container py-3 py-md-4">

    {{-- Card Pencarian --}}
    <div class="card shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--primary-100, #dbeafe);">
        <div class="card-body p-3 p-md-4">

            <div class="text-center mb-3 mb-md-4">
                <span class="badge badge-primary-soft border border-primary-subtle mb-2 px-3 py-2" style="background: #dbeafe; color: #1d4ed8;">
                    <i class="bi bi-search me-1"></i>Pencarian Dokumen
                </span>
                <h4 class="fs-5 fs-md-4 fw-bold" style="color: #1e293b;">Cari Dokumen Arsip</h4>
            </div>

            <form method="GET" action="{{ route('search.page') }}">
                <div class="input-group mb-3" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <input type="text" class="form-control border-0 py-3"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Ketikkan nama dokumen arsip..."
                        style="font-size: 1rem;">
                    <button class="btn btn-primary px-4" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                        <i class="bi bi-search"></i><span class="d-none d-sm-inline ms-2">Cari</span>
                    </button>
                </div>

                {{-- Filter --}}
                <div class="border rounded-3 p-2 p-md-3" style="background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-color: #e2e8f0 !important;">
                    <div class="row g-2 g-md-3">
                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Kategori</label>
                            <select class="form-select form-select-sm" name="kategori">
                                <option value="">Semua</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ request('kategori') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Tipe</label>
                            <select class="form-select form-select-sm" name="tipe">
                                <option value="">Semua</option>
                                @foreach ($types as $type)
                                <option value="{{ strtoupper($type) }}"
                                    {{ request('tipe') == strtoupper($type) ? 'selected' : '' }}>
                                    {{ strtoupper($type) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Diunggah Oleh</label>
                            <select class="form-select form-select-sm" name="user">
                                <option value="">Semua</option>

                                @foreach ($users as $user)
                                <option value="{{ $user->id_user }}"
                                    {{ request('user') == $user->id_user ? 'selected' : '' }}>
                                    {{ $user->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Urutkan</label>
                            <select class="form-select form-select-sm" name="sort">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Tanggal Mulai</label>
                            <input type="date" class="form-control form-control-sm" name="start" value="{{ request('start') }}">
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Tanggal Akhir</label>
                            <input type="date" class="form-control form-control-sm" name="end" value="{{ request('end') }}">
                        </div>

                        <div class="col-12 col-md-6 d-flex align-items-end gap-2 mt-2 mt-md-0">
                            <a href="{{ route('search.page') }}" class="btn btn-outline-secondary btn-sm flex-grow-1 flex-md-grow-0" style="border-radius: 8px;">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                            <button class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                                <i class="bi bi-funnel"></i> Terapkan
                            </button>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>

    @if($hasSearch)
    {{-- Hasil Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold" style="color: #1e293b;">
                <i class="bi bi-file-earmark-text me-2" style="color: #3b82f6;"></i>Hasil Pencarian
            </h5>
            <small class="text-muted">
                <i class="bi bi-check2-circle me-1"></i>Ditemukan {{ count($documents) }} dokumen
            </small>
        </div>
    </div>

    @if(!$hasSearch)
    <div class="alert text-center" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: none; color: #1d4ed8; border-radius: 12px;">
        <i class="bi bi-info-circle me-2"></i>Silakan masukkan kata kunci atau filter lalu klik <b>Cari</b>.
    </div>
    @endif

    {{-- List Dokumen --}}
    <div class="row g-3">

        @forelse($documents as $doc)
        {{-- card dokumen --}}
        <div class="col-12">
            <div class="card shadow-sm p-3" style="border-radius: 12px; border: 1px solid #e2e8f0; transition: all 0.3s ease;">

                <div class="d-flex">

                    {{-- Icon --}}
                    <div class="me-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:70px; height:70px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 2px solid #93c5fd;">
                            <strong style="color: #1d4ed8;">{{ $doc->type }}</strong>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="flex-grow-1">

                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <h5 class="fw-bold" style="color: #1d4ed8;">{{ $doc->title }}</h5>

                            <div>
                                <a href="{{ route('dokumen.detail', $doc->id) }}"
                                    class="btn btn-outline-primary btn-sm" style="border-radius: 8px;">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                <a href="{{ route('dokumen.download', $doc->id) }}"
                                    class="btn btn-success btn-sm" style="border-radius: 8px;">
                                    <i class="bi bi-download me-1"></i>Unduh
                                </a>
                            </div>
                        </div>

                        <div class="text-muted small mt-1">
                            <span class="badge bg-light text-dark me-1">{{ $doc->category }}</span>
                            <i class="bi bi-calendar me-1"></i>{{ $doc->uploaded_at }} •
                            <i class="bi bi-person me-1"></i>{{ $doc->uploaded_by }} •
                            <i class="bi bi-file-earmark me-1"></i>{{ $doc->file_size }}
                        </div>

                        <p class="mt-2 mb-0 text-muted">{{ $doc->description }}</p>
                    </div>

                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert text-center" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border: none; border-radius: 12px;">
                <i class="bi bi-inbox me-2" style="font-size: 1.5rem; color: #64748b;"></i>
                <p class="mb-0 text-muted">Tidak ditemukan dokumen untuk kriteria ini.</p>
            </div>
        </div>
        @endforelse

    </div>
    @endif


    <!-- {{-- List Dokumen --}}
    <div class="row g-3">

        @forelse($documents ?? [] as $doc)
        <div class="col-12">
            <div class="card shadow-sm p-3">

                <div class="d-flex">

                    {{-- Icon --}}
                    <div class="me-3">
                        <div class="bg-danger bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                            style="width:70px; height:70px;">
                            <strong>{{ $doc->type }}</strong>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="flex-grow-1">

                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold text-primary">{{ $doc->title }}</h5>

                            <div>
                                <a href="#" class="btn btn-outline-primary btn-sm">Preview</a>
                                <a href="#" class="btn btn-success btn-sm">Unduh</a>
                            </div>
                        </div>

                        <div class="text-muted small mt-1">
                            {{ $doc->category }} •
                            {{ $doc->uploaded_at }} •
                            {{ $doc->uploaded_by }} •
                            {{ $doc->file_size }}
                        </div>

                        <p class="mt-2 mb-0">{{ $doc->description }}</p>
                    </div>

                </div>

            </div>
        </div>

        @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">
                Tidak ditemukan dokumen untuk kriteria ini.
            </div>
        </div>
        @endforelse

    </div> -->

</div>
@endsection