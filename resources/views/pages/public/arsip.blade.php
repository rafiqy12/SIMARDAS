@extends('layouts.app')

@section('title', 'Manajemen Arsip - SIMARDAS')

@section('content')
<div class="container py-4">
    <div class="row mb-3">
        <div class="col">
            <h4 class="fw-bold text-primary"><i class="bi bi-folder me-2"></i>Manajemen Arsip</h4>
            <p class="text-muted mb-0">Kelola dokumen dan arsip digital</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @include('pages.partials._arsip_content', [
        'dokumens' => $dokumens,
        'search' => $search ?? '',
        'perPage' => $perPage ?? 10,
        'searchRoute' => route('arsip.public'),
        'canUpload' => $canUpload ?? false,
        'canEdit' => $canEdit ?? false
    ])
</div>
@endsection
