@extends('layouts.app_admin')

@section('title', 'Manajemen Arsip - SIMARDAS')
@section('page-title', 'Manajemen Arsip')



@section('content')
<div class="page-header">
    <div class="d-flex align-items-center">
        <div class="me-3" style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-archive-fill text-white" style="font-size: 1.2rem;"></i>
        </div>
        <div>
            <h5 class="fw-bold mb-1">Manajemen Arsip Digital</h5>
            <p class="text-muted small mb-0">Kelola dan atur dokumen arsip dengan mudah</p>
        </div>
    </div>
</div>

@include('pages.partials._arsip_content', [
    'dokumens' => $dokumens,
    'search' => $search ?? '',
    'perPage' => $perPage ?? 10,
    'searchRoute' => route('dokumen.index'),
    'canUpload' => true,
    'canEdit' => true
])
@endsection
