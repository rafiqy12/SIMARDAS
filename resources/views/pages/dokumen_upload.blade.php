@extends('layouts.app')
@section('content')

<div class="container py-4">
	<div class="row justify-content-center">
		<div class="col-lg-7">
			<div class="card shadow-sm mb-4">
				<div class="card-body">
					<h4 class="fw-bold text-primary mb-4 text-center">Upload Dokumen</h4>

					@if(session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
					@endif

					<form method="POST"
                        action="{{ route('dokumen_upload.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">File Dokumen</label>
                            <input type="file"
                                name="dokumen"
                                class="form-control"
                                required
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <small class="text-muted">PDF, Word, Excel, PowerPoint</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul Dokumen</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Dokumen</label>
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
                            <label class="form-label">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-primary">Upload Dokumen</button>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection