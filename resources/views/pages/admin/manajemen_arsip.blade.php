@extends('layouts.app_admin')

@section('title', 'Manajemen Arsip - SIMARDAS')
@section('page-title', 'Manajemen Arsip')

@section('content')
@include('pages.partials._arsip_content', [
    'dokumens' => $dokumens,
    'search' => $search ?? '',
    'perPage' => $perPage ?? 10,
    'searchRoute' => route('dokumen.index'),
    'canUpload' => true,
    'canEdit' => true
])
@endsection
