@extends('layouts.app')
@section('content')

<style>
	.detail-card {
		border-radius: 16px;
		border: 1px solid #dbeafe;
	}

	.doc-icon {
		background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
		border: 2px solid #93c5fd;
		border-radius: 12px;
	}

	.info-table th {
		background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%);
		color: #1e40af;
	}

	.barcode-card {
		background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
		border: 1px solid #e2e8f0;
		border-radius: 12px;
	}

	.btn-action {
		border-radius: 8px;
		transition: all 0.3s ease;
	}

	.btn-action:hover {
		transform: translateY(-2px);
	}
</style>

<div class="container py-3 py-md-4">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<div class="card shadow-sm mb-4 detail-card">
				<div class="card-body p-3 p-md-4">
					<div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-4 gap-3">
						<div class="doc-icon d-flex align-items-center justify-content-center flex-shrink-0" style="width:60px; height:60px;">
							<strong class="small" style="color: #1d4ed8;">{{ $document->tipe_file ?? '-' }}</strong>
						</div>
						<div>
							<h4 class="fw-bold mb-1 fs-5 fs-md-4" style="color: #1d4ed8;">{{ $document->judul ?? 'Judul Dokumen' }}</h4>
							<div class="text-muted small">
								<span class="badge" style="background: #dbeafe; color: #1d4ed8;">{{ $document->kategori ?? '-' }}</span>
								<span class="ms-1"><i class="bi bi-calendar"></i> {{ $document->tanggal_upload ?? '-' }}</span>
								<span class="ms-1"><i class="bi bi-person"></i> {{ $document->user->nama ?? '-' }}</span>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<h6 class="fw-bold" style="color: #1e293b;"><i class="bi bi-file-text me-2" style="color: #3b82f6;"></i>Deskripsi</h6>
						<p class="small text-muted">{{ $document->deskripsi ?? '-' }}</p>
					</div>
					<div class="mb-3">
						<h6 class="fw-bold" style="color: #1e293b;"><i class="bi bi-info-circle me-2" style="color: #3b82f6;"></i>Informasi Dokumen</h6>
						<div class="table-responsive">
							<table class="table table-bordered table-sm info-table" style="border-radius: 8px; overflow: hidden;">
								<tr>
									<th style="width: 140px; white-space: nowrap;">Nama File</th>
									<td>{{ $document->judul ?? '-' }}</td>
								</tr>
								<tr>
									<th>Kategori</th>
									<td>{{ $document->kategori ?? '-' }}</td>
								</tr>
								<tr>
									<th>Tipe</th>
									<td>
										@php
										$fileType = strtolower($document->tipe_file ?? '');
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
										$colorData = $fileColors[$fileType] ?? $fileColors['default'];
										@endphp
										<span class="badge" style="background: {{ $colorData['bg'] }}; color: {{ $colorData['color'] }}; font-weight:600;">{{ strtoupper($document->tipe_file ?? '-') }}</span>
									</td>
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
					</div>

					<div class="mb-4">
						<h6 class="fw-bold" style="color: #1e293b;"><i class="bi bi-upc-scan me-2" style="color: #3b82f6;"></i>Barcode Arsip</h6>
						<div class="card barcode-card">
							<div class="barcode-card p-4 d-flex justify-content-center">
								@if($document->barcode)
								<div class="barcode-wrapper text-center">
									<div class="barcode-image">
										{!! DNS1D::getBarcodeHTML($document->barcode->kode_barcode,'C128',2,80) !!}
									</div>

									<div class="barcode-code mt-2">
										{{ $document->barcode->kode_barcode }}
									</div>

									<div class="barcode-meta mt-1">
										<i class="bi bi-clock me-1"></i>
										Digenerate otomatis
									</div>
									<a href="{{ route('barcode.download', $document->id_dokumen) }}"
										class="btn btn-outline-primary btn-sm mt-2">
										<i class="bi bi-download"></i> Download Barcode
									</a>
								</div>
								@else
								<div class="text-center">
									<i class="bi bi-upc display-5 text-muted"></i>
									<p class="text-muted mb-0">Barcode belum tersedia</p>
								</div>
								@endif
							</div>
						</div>
					</div>
					<div class="d-flex flex-wrap gap-2">
						@php
						$previewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
						$canPreview = in_array(strtolower($document->tipe_file), $previewableTypes);
						@endphp
						@if($canPreview)
						<a href="{{ route('dokumen.preview', $document->id_dokumen) }}"
							class="btn btn-outline-primary btn-sm btn-action"
							target="_blank">
							<i class="bi bi-eye"></i> Preview
						</a>
						@else
						<button type="button"
							class="btn btn-outline-primary btn-sm btn-action btn-preview-unavailable"
							data-title="{{ $document->judul }}"
							data-type="{{ strtoupper($document->tipe_file) }}"
							data-download-url="{{ route('dokumen.download', $document->id_dokumen) }}">
							<i class="bi bi-eye"></i> Preview
						</button>
						@endif

						<a href="{{ route('dokumen.download', $document->id_dokumen) }}"
							class="btn btn-success btn-sm btn-action">
							<i class="bi bi-download"></i> Unduh
						</a>
						<a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm btn-action">
							<i class="bi bi-arrow-left"></i> Kembali
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
<div class="col-12 col-lg-4 d-flex flex-column">
	<div class="mb-4 mb-lg-0 h-100 d-flex flex-column">
		<div class="mb-3">
			<div class="d-flex align-items-center mb-3 justify-content-center text-center">
				<div class="me-2" style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
					<i class="bi bi-stars text-white fs-5"></i>
				</div>
				<div>
					<h5 class="fw-bold mb-0" style="color: #1d4ed8;">Rekomendasi Arsip Terkait</h5>
					<small class="text-muted">Arsip lain yang sangat relevan dengan dokumen ini</small>
				</div>
			</div>
			<div class="d-flex flex-column align-items-center gap-3">
				@foreach($recommendations as $rec)
				<div class="col-12 col-md-10 col-lg-8 px-0" style="max-width: 500px;">
					<div class="card h-100 shadow-sm mx-auto" style="border-radius: 14px; border: 1px solid #dbeafe; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%); transition: all 0.3s ease; margin-left:auto; margin-right:auto;">
						<div class="card-body p-3">
							<div class="d-flex align-items-start mb-2">
								<div class="me-2 rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
									style="width: 45px; height: 45px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 1px solid #3b82f6;">
									<strong style="color: #1d4ed8; font-size: 0.75rem;">{{ strtoupper($rec->tipe_file) }}</strong>
								</div>
								<div class="flex-grow-1 min-w-0">
									<h6 class="fw-bold mb-1 text-truncate" style="color: #1e293b; max-width: 180px;" title="{{ $rec->judul }}">
										{{ \Illuminate\Support\Str::limit($rec->judul, 40) }}
									</h6>
									<span class="badge" style="background: #dbeafe; color: #1d4ed8; font-size: 0.7rem;">{{ $rec->kategori }}</span>
								</div>
							</div>
							<p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 100%;">
								{{ \Illuminate\Support\Str::limit($rec->deskripsi ?? 'Tidak ada deskripsi', 70) }}
							</p>
							<div class="d-flex gap-1">
								<a href="{{ route('dokumen.detail', $rec->id_dokumen) }}" class="btn btn-outline-primary btn-sm flex-grow-1" style="border-radius: 7px; font-size: 0.75rem;">
									<i class="bi bi-eye"></i> Detail
								</a>
								<a href="{{ route('dokumen.download', $rec->id_dokumen) }}" class="btn btn-primary btn-sm flex-grow-1 text-white" style="border-radius: 7px; font-size: 0.75rem;">
									<i class="bi bi-download"></i> Unduh
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>

@endsection

@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelectorAll('.btn-preview-unavailable').forEach(function(btn) {
			btn.addEventListener('click', function() {
				const title = this.dataset.title;
				const type = this.dataset.type;
				const downloadUrl = this.dataset.downloadUrl;
				Swal.fire({
					title: '<i class="bi bi-exclamation-circle" style="color: #f59e0b;"></i>',
					html: `
					<div style="text-align: center;">
						<h5 style="color: #1e293b; margin-bottom: 0.5rem;">Preview Tidak Tersedia</h5>
						<p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">
							File dengan format <strong style="color: #3b82f6;">${type}</strong> tidak dapat ditampilkan di browser.
						</p>
						<div style="background: #f1f5f9; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 0.5rem;">
							<small style="color: #64748b;">Nama File:</small><br>
							<strong style="color: #1e293b; font-size: 0.9rem;">${title}</strong>
						</div>
					</div>
				`,
					showCancelButton: true,
					confirmButtonText: '<i class="bi bi-download me-1"></i> Download',
					cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Tutup',
					confirmButtonColor: '#10b981',
					cancelButtonColor: '#64748b',
					customClass: {
						popup: 'swal-popup-custom',
						confirmButton: 'swal-confirm-custom',
						cancelButton: 'swal-cancel-custom'
					}
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = downloadUrl;
					}
				});
			});
		});
	});
</script>
@endpush