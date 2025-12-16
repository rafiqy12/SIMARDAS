@extends('layouts.app')
@section('content')

<div class="container py-3 py-md-4">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10">
			<div class="card shadow-sm mb-4">
				<div class="card-body p-3 p-md-4">
					<div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-4 gap-3">
						<div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px; height:50px;">
							<strong class="small">{{ $document->type ?? '-' }}</strong>
						</div>
						<div class="flex-grow-1">
							<h4 class="fw-bold text-primary mb-1 fs-5 fs-md-4">Preview: {{ $document->title ?? 'Judul Dokumen' }}</h4>
							<div class="text-muted small">
								{{ $document->category ?? '-' }} •
								{{ $document->uploaded_at ?? '-' }} •
								{{ $document->uploaded_by ?? '-' }}
							</div>
						</div>
					</div>

					<div class="mb-4">
						@if(isset($document->type) && $document->type === 'PDF')
						<div class="ratio ratio-16x9">
							<iframe src="{{ $document->file_url ?? '#' }}" style="border:1px solid #ccc; border-radius:8px;"></iframe>
						</div>
						@elseif(isset($document->type) && in_array($document->type, ['Word', 'Excel']))
						<div class="alert alert-info text-center">
							Pratinjau file {{ $document->type }} belum didukung. <br>
							<a href="{{ $document->file_url ?? '#' }}" class="btn btn-success btn-sm mt-2">Unduh File</a>
						</div>
						@elseif(isset($document->type) && $document->type === 'Gambar')
						<img src="{{ $document->file_url ?? '#' }}" alt="Preview Gambar" class="img-fluid rounded mx-auto d-block" style="max-height:500px;" />
						@else
						<div class="alert alert-secondary text-center">
							Pratinjau tidak tersedia untuk tipe dokumen ini.
						</div>
						@endif
					</div>

					<div class="d-flex gap-2 flex-wrap">
						<a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
							<i class="bi bi-arrow-left me-1"></i> Kembali
						</a>
						<a href="{{ route('dokumen.download', $document->id) }}" class="btn btn-success btn-sm">
							<i class="bi bi-download me-1"></i> Unduh
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection