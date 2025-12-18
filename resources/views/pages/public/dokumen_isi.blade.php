@extends('layouts.app')

@push('styles')
<style>
    /* Page-specific styles */
    .preview-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .preview-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }
    .doc-type-badge {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    .preview-title {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .preview-frame {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .alert-preview {
        border-radius: 12px;
        border: 1px solid #bfdbfe;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }
</style>
@endpush

@section('content')

<div class="container py-3 py-md-4">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10">
			<div class="card shadow-sm preview-card mb-4">
				<div class="card-body p-3 p-md-4">
					<div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-4 gap-3">
						<div class="doc-type-badge flex-shrink-0">
							<span class="small">{{ $document->type ?? '-' }}</span>
						</div>
						<div class="flex-grow-1">
							<h4 class="fw-bold preview-title mb-1 fs-5 fs-md-4">
                                <i class="bi bi-file-earmark-text me-2"></i>Preview: {{ $document->title ?? 'Judul Dokumen' }}
                            </h4>
							<div class="text-muted small">
								<i class="bi bi-folder me-1" style="color: #3b82f6;"></i>{{ $document->category ?? '-' }} •
								<i class="bi bi-calendar me-1 ms-2" style="color: #3b82f6;"></i>{{ $document->uploaded_at ?? '-' }} •
								<i class="bi bi-person me-1 ms-2" style="color: #3b82f6;"></i>{{ $document->uploaded_by ?? '-' }}
							</div>
						</div>
					</div>

					<div class="mb-4">
						@if(isset($document->type) && $document->type === 'PDF')
						<div class="ratio ratio-16x9 preview-frame">
							<iframe src="{{ $document->file_url ?? '#' }}"></iframe>
						</div>
						@elseif(isset($document->type) && in_array($document->type, ['Word', 'Excel']))
						<div class="alert alert-preview text-center py-4">
                            <i class="bi bi-file-earmark-excel display-4 mb-3" style="color: #3b82f6;"></i>
							<p class="mb-2">Pratinjau file {{ $document->type }} belum didukung.</p>
							<a href="{{ $document->file_url ?? '#' }}" class="btn btn-download btn-sm mt-2">
                                <i class="bi bi-download me-1"></i>Unduh File
                            </a>
						</div>
						@elseif(isset($document->type) && $document->type === 'Gambar')
						<img src="{{ $document->file_url ?? '#' }}" alt="Preview Gambar" class="img-fluid rounded mx-auto d-block preview-frame" style="max-height:500px;" />
						@else
						<div class="alert alert-preview text-center py-4">
                            <i class="bi bi-file-earmark display-4 mb-3" style="color: #93c5fd;"></i>
							<p class="mb-0">Pratinjau tidak tersedia untuk tipe dokumen ini.</p>
						</div>
						@endif
					</div>

					<div class="d-flex gap-2 flex-wrap">
						<a href="{{ url()->previous() }}" class="btn btn-back btn-sm text-white">
							<i class="bi bi-arrow-left me-1"></i> Kembali
						</a>
						<a href="{{ route('dokumen.download', $document->id) }}" class="btn btn-download btn-sm text-white">
							<i class="bi bi-download me-1"></i> Unduh
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection