@extends('layouts.app')
@section('content')

<div class="container py-3 py-md-4">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<div class="card shadow-sm mb-4">
				<div class="card-body p-3 p-md-4">
					<div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-4 gap-3">
						<div class="bg-danger bg-opacity-10 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width:60px; height:60px;">
							<strong class="small">{{ $document->tipe_file ?? '-' }}</strong>
						</div>
						<div>
							<h4 class="fw-bold text-primary mb-1 fs-5 fs-md-4">{{ $document->judul ?? 'Judul Dokumen' }}</h4>
							<div class="text-muted small">
								{{ $document->kategori ?? '-' }} •
								{{ $document->tanggal_upload ?? '-' }} •
								{{ $document->user->nama ?? '-' }}
							</div>
						</div>
					</div>

					<div class="mb-3">
						<h6 class="fw-bold">Deskripsi</h6>
						<p class="small">{{ $document->deskripsi ?? '-' }}</p>
					</div>

					<div class="mb-3">
						<h6 class="fw-bold">Informasi Dokumen</h6>
						<div class="table-responsive">
							<table class="table table-bordered table-sm">
								<tr>
									<th class="bg-light" style="width: 40%;">Nama File</th>
									<td>{{ $document->judul ?? '-' }}</td>
								</tr>
								<tr>
									<th class="bg-light">Kategori</th>
									<td>{{ $document->kategori ?? '-' }}</td>
								</tr>
								<tr>
									<th class="bg-light">Tipe</th>
									<td>{{ $document->tipe_file ?? '-' }}</td>
								</tr>
								<tr>
									<th class="bg-light">Diunggah Oleh</th>
									<td>{{ $document->user->nama ?? '-' }}</td>
								</tr>
								<tr>
									<th class="bg-light">Tanggal Upload</th>
									<td>{{ $document->tanggal_upload ?? '-' }}</td>
								</tr>
								<tr>
									<th class="bg-light">Ukuran File</th>
									<td>{{ $document->file_size ?? '-' }}</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="mb-4">
						<h6 class="fw-bold">Barcode Arsip</h6>
						<div class="card shadow-sm">
							<div class="card-body text-center p-3">
								@if($document->barcode)
								{{-- IMAGE BARCODE --}}
								<img
									src="https://barcode.tec-it.com/barcode.ashx?data={{ $document->barcode->kode_barcode }}&code=Code128&translate-esc=true"
									alt="Barcode Dokumen"
									class="img-fluid mb-2" style="max-width: 250px;">
								{{-- TEXT BARCODE --}}
								<div class="mt-2">
									<span class="badge bg-secondary">
										{{ $document->barcode->kode_barcode }}
									</span>
								</div>
								<small class="text-muted d-block mt-1">
									Digenerate: {{ $document->barcode->tanggal_generate }}
								</small>
								@else
								<span class="text-muted">Barcode belum tersedia</span>
								@endif
							</div>
						</div>
					</div>

					<div class="d-flex flex-wrap gap-2">
						<a href="{{ route('dokumen.preview', $document->id_dokumen) }}"
							class="btn btn-outline-primary btn-sm"
							target="_blank">
							<i class="bi bi-eye"></i> Preview
						</a>
						<a href="{{ route('dokumen.download', $document->id_dokumen) }}"
							class="btn btn-success btn-sm">
							<i class="bi bi-download"></i> Unduh
						</a>
						<a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
							<i class="bi bi-arrow-left"></i> Kembali
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection