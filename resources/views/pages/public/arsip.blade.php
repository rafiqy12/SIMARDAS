@extends('layouts.app')

@section('title', 'Manajemen Arsip - SIMARDAS')

@push('styles')
<style>
    /* Page-specific overrides only */
    .page-header h4 {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .page-header p {
        color: #475569;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="page-header">
        <div class="d-flex align-items-center">
            <div class="me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-folder-fill text-white" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-folder me-2"></i>Manajemen Arsip</h4>
                <p class="mb-0">Kelola dokumen dan arsip digital dengan mudah</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
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
