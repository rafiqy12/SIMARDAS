@extends('layouts.app')
@section('content')

<div class="container py-4">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<div class="card shadow-sm mb-4">
				<div class="card-body">
					<div class="d-flex align-items-center mb-4">
						<div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width:60px; height:60px;">
							<strong>{{ $document->type ?? '-' }}</strong>
						</div>
						<div>
							<h4 class="fw-bold text-primary mb-1">Preview: {{ $document->title ?? 'Judul Dokumen' }}</h4>
							<div class="text-muted small">
								{{ $document->category ?? '-' }} •
								{{ $document->uploaded_at ?? '-' }} •
								{{ $document->uploaded_by ?? '-' }}
							</div>
						</div>
					</div>

					<div class="mb-4">
						@if(isset($document->type) && $document->type === 'PDF')
							<iframe src="{{ $document->file_url ?? '#' }}" width="100%" height="600" style="border:1px solid #ccc; border-radius:8px;"></iframe>
						@elseif(isset($document->type) && in_array($document->type, ['Word', 'Excel']))
							<div class="alert alert-info text-center">
								Pratinjau file {{ $document->type }} belum didukung. <br>
								<a href="{{ $document->file_url ?? '#' }}" class="btn btn-success mt-2">Unduh File</a>
							</div>
						@elseif(isset($document->type) && $document->type === 'Gambar')
							<img src="{{ $document->file_url ?? '#' }}" alt="Preview Gambar" class="img-fluid rounded mx-auto d-block" style="max-height:600px;" />
						@else
							<div class="alert alert-secondary text-center">
								Pratinjau tidak tersedia untuk tipe dokumen ini.
							</div>
						@endif
					</div>

					<div class="d-flex gap-2">
						<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
						<a href="{{ $document->download_url ?? '#' }}" class="btn btn-success">Unduh</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
