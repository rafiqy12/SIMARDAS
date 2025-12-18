@extends('layouts.app_admin')

@section('title', 'Edit Arsip - SIMARDAS')
@section('page-title', 'Edit Arsip')



@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm form-card">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-pencil-square" style="color: #2563eb; font-size: 1.2rem;"></i>
                        </div>
                        <h5 class="fw-bold m-0 fs-6" style="color: #1e293b;">Edit Data Arsip</h5>
                    </div>
                    <a href="{{ route('dokumen.index') }}" class="btn btn-primary btn-sm btn-back"><i class="bi bi-arrow-bar-left"></i> Kembali</a>
                </div>

                @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 10px; border: none; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
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
                        <label class="form-label small fw-semibold" for="formJudul" style="color: #374151;">
                            <i class="bi bi-file-earmark-text me-1" style="color: #3b82f6;"></i>Judul Dokumen
                        </label>
                        <input type="text" id="formJudul" name="judul" class="form-control" value="{{ old('judul', $dokumen->judul) }}" required autofocus />
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold" for="formKategori" style="color: #374151;">
                            <i class="bi bi-folder me-1" style="color: #3b82f6;"></i>Kategori
                        </label>
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
                        <label class="form-label small fw-semibold" for="formDeskripsi" style="color: #374151;">
                            <i class="bi bi-card-text me-1" style="color: #3b82f6;"></i>Deskripsi
                        </label>
                        <textarea id="formDeskripsi" name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold" style="color: #374151;">
                            <i class="bi bi-info-circle me-1" style="color: #3b82f6;"></i>Informasi File
                        </label>
                        <div class="p-3 info-box small">
                            <p class="mb-2"><i class="bi bi-file-earmark me-2" style="color: #3b82f6;"></i><strong>Tipe File:</strong> <span class="badge" style="background: #dbeafe; color: #1d4ed8;">{{ strtoupper($dokumen->tipe_file) }}</span></p>
                            <p class="mb-2"><i class="bi bi-calendar me-2" style="color: #3b82f6;"></i><strong>Tanggal Upload:</strong> {{ $dokumen->tanggal_upload }}</p>
                            <p class="mb-0 text-break"><i class="bi bi-folder2 me-2" style="color: #3b82f6;"></i><strong>Path:</strong> {{ $dokumen->path_file }}</p>
                        </div>
                    </div>

                    <div class="pt-1 text-center">
                        <button class="btn btn-primary w-100 btn-submit" type="submit">
                            <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
