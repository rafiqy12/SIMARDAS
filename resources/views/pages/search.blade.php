@extends('layouts.app')
@section('content')

<div class="container py-4">

    {{-- Card Pencarian --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h4 class="text-center mb-4">Cari Dokumen Arsip</h4>

            <form method="GET" action="{{ route('search.page') }}">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Ketikkan nama dokumen arsip yang ingin dicari...">
                    <button class="btn btn-primary">Cari</button>
                </div>

                {{-- Filter --}}
                <div class="border rounded p-3 bg-light">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kategori Dokumen</label>
                            <select class="form-select" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ request('kategori') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tipe Dokumen</label>
                            <select class="form-select" name="tipe">
                                <option value="">Semua Tipe</option>
                                @foreach ($types as $type)
                                <option value="{{ strtoupper($type) }}"
                                    {{ request('tipe') == strtoupper($type) ? 'selected' : '' }}>
                                    {{ strtoupper($type) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Diunggah Oleh</label>
                            <select class="form-select" name="user">
                                <option value="">Semua Pengguna</option>

                                @foreach ($users as $user)
                                <option value="{{ $user->id_user }}"
                                    {{ request('user') == $user->id_user ? 'selected' : '' }}>
                                    {{ $user->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Urutkan</label>
                            <select class="form-select" name="sort">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Dokumen</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start" value="{{ request('start') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="end" value="{{ request('end') }}">
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <a href="{{ route('search.page') }}" class="btn btn-outline-secondary me-2">
                                Reset Filter
                            </a>
                            <button class="btn btn-primary">Terapkan Filter</button>
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
            <h5 class="fw-bold">Hasil Pencarian</h5>
            <small class="text-muted">
                Ditemukan {{ count($documents) }} dokumen
            </small>
        </div>
    </div>

    @if(!$hasSearch)
    <div class="alert alert-info text-center">
        Silakan masukkan kata kunci atau filter lalu klik <b>Cari</b>.
    </div>
    @endif

    {{-- List Dokumen --}}
    <div class="row g-3">

        @forelse($documents as $doc)
        {{-- card dokumen --}}
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
                                <a href="{{ route('dokumen.detail', $doc->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    Detail
                                </a>
                                <a href="{{ route('dokumen.download', $doc->id) }}"
                                    class="btn btn-success btn-sm">
                                    Unduh
                                </a>
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