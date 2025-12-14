@extends('layouts.app')
@section('content')

<div class="container py-4">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="card shadow-sm mb-4">
				<div class="card-body">
					<div class="d-flex align-items-center mb-4">
						<div class="bg-danger bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width:70px; height:70px;">
							<strong>{{ $document->tipe_file ?? '-' }}</strong>
						</div>
						<div>
							<h3 class="fw-bold text-primary mb-1">{{ $document->judul ?? 'Judul Dokumen' }}</h3>
							<div class="text-muted small">
								{{ $document->kategori ?? '-' }} •
								{{ $document->tanggal_upload ?? '-' }} •
								{{ $document->user->nama ?? '-' }} •
								{{ $document->file_size ?? '-' }}
							</div>
						</div>
					</div>

					<div class="mb-3">
						<h6 class="fw-bold">Deskripsi</h6>
						<p>{{ $document->deskripsi ?? '-' }}</p>
					</div>

					<div class="mb-3">
						<h6 class="fw-bold">Informasi Dokumen</h6>
						<table class="table table-bordered">
							<tr>
								<th width="200">Nama File</th>
								<td>{{ $document->judul ?? '-' }}</td>
							</tr>
							<tr>
								<th>Kategori</th>
								<td>{{ $document->kategori ?? '-' }}</td>
							</tr>
							<tr>
								<th>Tipe</th>
								<td>{{ $document->tipe_file ?? '-' }}</td>
							</tr>
							<tr>
								<th>Diunggah Oleh</th>
								<td>{{ $document->user->nama ?? '-' }}</td>
							</tr>
							<tr>
								<th>Tanggal Upload</th>
								<td>{{ $document->tanggal_upload ?? '-' }}</td>
							</tr>
							<tr>
								<th>Ukuran File</th>
								<td>{{ $document->file_size ?? '-' }}</td>
							</tr>
						</table>
					</div>

					<div class="d-flex gap-2">
						<a href="{{ $document->preview_url ?? '#' }}" class="btn btn-outline-primary" target="_blank">Preview</a>
						<a href="{{ $document->download_url ?? '#' }}" class="btn btn-success">Unduh</a>
						<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
