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

	.barcode-wrapper {
		padding: 1.5rem;
		background: #f8fafc;
		border-radius: 8px;
		border: 1px solid #e2e8f0;
	}

	.barcode-wrapper svg {
		margin: 0 auto;
		display: block;
	}

	.btn-action {
		border-radius: 8px;
		transition: all 0.3s ease;
	}

	.btn-action:hover {
		transform: translateY(-2px);
	}

	.recommendation-card {
		border-radius: 12px;
		border: 1px solid #dbeafe;
		transition: all 0.3s ease;
	}

	.recommendation-card:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
	}
</style>

<div class="container py-3 py-md-4">
	@php
		$hasRecommendations = isset($recommendations) && count($recommendations) > 0;
	@endphp
	
	<div class="row {{ $hasRecommendations ? '' : 'justify-content-center' }}">
		<!-- Kolom Detail Dokumen -->
		<div class="col-12 {{ $hasRecommendations ? 'col-md-7' : '' }}" style="{{ !$hasRecommendations ? 'max-width: 800px;' : '' }}">
			<div class="card shadow-sm mb-4 detail-card">
				<div class="card-body p-3 p-md-4">
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
						<h6 class="fw-bold mb-3" style="color: #1e293b;"><i class="bi bi-upc-scan me-2" style="color: #3b82f6;"></i>Barcode Arsip</h6>
						@if($document->barcode)
						<div class="barcode-wrapper text-center">
							{!! DNS1D::getBarcodeHTML($document->barcode->kode_barcode,'C128',2,80) !!}
							<div class="mt-2 fw-semibold" style="color: #475569; font-size: 0.9rem;">
								{{ $document->barcode->kode_barcode }}
							</div>
							<div class="text-muted small mt-1">
								<i class="bi bi-clock me-1"></i>Digenerate otomatis
							</div>
							<a href="{{ route('barcode.download', $document->id_dokumen) }}"
								class="btn btn-outline-primary btn-sm mt-3">
								<i class="bi bi-download"></i> Download Barcode
							</a>
						</div>
						@else
						<div class="barcode-wrapper text-center">
							<i class="bi bi-upc display-6 text-muted"></i>
							<p class="text-muted mb-0 mt-2 small">Barcode belum tersedia</p>
						</div>
						@endif
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

		<!-- Kolom Rekomendasi (hanya tampil jika ada) -->
		@if($hasRecommendations)
		<div class="col-12 col-md-5">
			<div class="card shadow-sm" style="border-radius: 14px; border: 1px solid #bfdbfe; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
				<div class="card-body p-3 p-md-4">
					<div class="d-flex align-items-center mb-3 gap-2">
						<div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items-center; justify-content-center;">
							<i class="bi bi-stars text-white"></i>
						</div>
						<div>
							<h6 class="fw-bold mb-0" style="color: #1d4ed8;">Rekomendasi Terkait</h6>
							<small class="text-muted">Dokumen relevan lainnya</small>
						</div>
					</div>

					<div class="d-flex flex-column gap-3">
						@foreach($recommendations as $rec)
						<div class="card recommendation-card shadow-sm">
							<div class="card-body p-3">
								<div class="d-flex gap-2 mb-2">
									<div class="rounded d-flex align-items-center justify-content-center flex-shrink-0"
										style="width: 38px; height: 38px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 1px solid #3b82f6;">
										<strong style="color: #1d4ed8; font-size: 0.7rem;">{{ strtoupper($rec->tipe_file) }}</strong>
									</div>
									<div class="flex-grow-1 min-w-0">
										<h6 class="fw-bold mb-1 text-truncate" style="color: #1e293b; font-size: 0.9rem;" title="{{ $rec->judul }}">
											{{ \Illuminate\Support\Str::limit($rec->judul, 35) }}
										</h6>
										<span class="badge" style="background: #dbeafe; color: #1d4ed8; font-size: 0.65rem;">{{ $rec->kategori }}</span>
									</div>
								</div>
								<p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.85rem;">
									{{ \Illuminate\Support\Str::limit($rec->deskripsi ?? 'Tidak ada deskripsi', 70) }}
								</p>
								<div class="d-grid gap-2">
									<a href="{{ route('dokumen.detail', $rec->id_dokumen) }}" class="btn btn-outline-primary btn-sm">
										<i class="bi bi-eye"></i> Lihat Detail
									</a>
									<a href="{{ route('dokumen.download', $rec->id_dokumen) }}" class="btn btn-primary btn-sm text-white">
										<i class="bi bi-download"></i> Unduh
									</a>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		@endif
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