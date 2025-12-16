@extends('layouts.app_admin')

@section('title', 'Edit Arsip - SIMARDAS')
@section('page-title', 'Edit Arsip')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
                    <h5 class="fw-bold m-0 fs-6">Edit Data Arsip</h5>
                    <a href="{{ route('dokumen.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-arrow-bar-left"></i> Kembali</a>
                </div>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('dokumen.update', $dokumen->id_dokumen) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formJudul">Judul Dokumen</label>
                        <input type="text" id="formJudul" name="judul" class="form-control" value="{{ old('judul', $dokumen->judul) }}" required autofocus />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formKategori">Kategori</label>
                        <select name="kategori" id="formKategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Administrasi" {{ old('kategori', $dokumen->kategori) == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                            <option value="Keuangan" {{ old('kategori', $dokumen->kategori) == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                            <option value="Notulen" {{ old('kategori', $dokumen->kategori) == 'Notulen' ? 'selected' : '' }}>Notulen</option>
                            <option value="Surat" {{ old('kategori', $dokumen->kategori) == 'Surat' ? 'selected' : '' }}>Surat</option>
                            <option value="Laporan" {{ old('kategori', $dokumen->kategori) == 'Laporan' ? 'selected' : '' }}>Laporan</option>
                            <option value="Data" {{ old('kategori', $dokumen->kategori) == 'Data' ? 'selected' : '' }}>Data</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formDeskripsi">Deskripsi</label>
                        <textarea id="formDeskripsi" name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Informasi File</label>
                        <div class="p-2 p-md-3 bg-light rounded small">
                            <p class="mb-1"><strong>Tipe File:</strong> {{ strtoupper($dokumen->tipe_file) }}</p>
                            <p class="mb-1"><strong>Tanggal Upload:</strong> {{ $dokumen->tanggal_upload }}</p>
                            <p class="mb-0 text-break"><strong>Path:</strong> {{ $dokumen->path_file }}</p>
                        </div>
                    </div>

                    <div class="pt-1 text-center">
                        <button class="btn btn-primary w-100" type="submit">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
