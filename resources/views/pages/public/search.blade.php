@extends('layouts.app')
@section('content')

<div class="container py-3 py-md-4">

    {{-- Card Pencarian --}}
    <div class="card shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--primary-100, #dbeafe);">
        <div class="card-body p-3 p-md-4">

            <div class="text-center mb-3 mb-md-4">
                <span class="badge badge-primary-soft border border-primary-subtle mb-2 px-3 py-2" style="background: #dbeafe; color: #1d4ed8;">
                    <i class="bi bi-search me-1"></i>Pencarian Dokumen
                </span>
                <h4 class="fs-5 fs-md-4 fw-bold" style="color: #1e293b;">Cari Dokumen Arsip</h4>
            </div>

            <form method="GET" action="{{ route('search.page') }}">
                <div class="input-group mb-3" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <input type="text" class="form-control border-0 py-3"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Ketikkan nama dokumen arsip..."
                        style="font-size: 1rem;">
                    <button class="btn btn-primary px-4" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                        <i class="bi bi-search"></i><span class="d-none d-sm-inline ms-2">Cari</span>
                    </button>
                </div>

                {{-- Filter --}}
                <div class="border rounded-3 p-2 p-md-3" style="background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-color: #e2e8f0 !important;">
                    <style>
                        .custom-dropdown {
                            border: none !important;
                            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                            border-radius: 12px !important;
                            padding: 8px 12px;
                            background-color: #fff !important;
                            transition: box-shadow 0.3s, border-color 0.3s;
                        }
                        .custom-dropdown:focus {
                            box-shadow: 0 0 0 2px var(--primary-200);
                            border-color: var(--primary-400) !important;
                        }
                        .custom-dropdown option {
                            border-radius: 8px;
                            padding: 10px 16px;
                            transition: all 0.2s;
                        }
                    </style>
                    <div class="row g-2 g-md-3">
                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Kategori</label>
                            <select class="form-select form-select-sm rounded-xl shadow-sm border border-primary-200 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all" name="kategori">
                                <option value="">Semua</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Tipe</label>
                            <select class="form-select form-select-sm rounded-xl shadow-sm border border-primary-200 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all" name="tipe">
                                <option value="">Semua</option>
                                @foreach ($types as $type)
                                <option value="{{ strtoupper($type) }}" {{ request('tipe') == strtoupper($type) ? 'selected' : '' }}>
                                    {{ strtoupper($type) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Diunggah Oleh</label>
                            <select class="form-select form-select-sm rounded-xl shadow-sm border border-primary-200 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all" name="user">
                                <option value="">Semua</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id_user }}" {{ request('user') == $user->id_user ? 'selected' : '' }}>
                                    {{ $user->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Urutkan</label>
                            <select class="form-select form-select-sm rounded-xl shadow-sm border border-primary-200 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all" name="sort">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Tanggal Mulai</label>
                            <input type="date" class="form-control form-control-sm" name="start" value="{{ request('start') }}">
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Tanggal Akhir</label>
                            <input type="date" class="form-control form-control-sm" name="end" value="{{ request('end') }}">
                        </div>

                        <div class="col-12 col-md-6 d-flex align-items-end gap-2 mt-2 mt-md-0">
                            <a href="{{ route('search.page') }}" class="btn btn-outline-secondary btn-sm flex-grow-1 flex-md-grow-0" style="border-radius: 8px;">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                            <button class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0" style="border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                                <i class="bi bi-funnel"></i> Terapkan
                            </button>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>

    @if($hasSearch)
    {{-- Hasil Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold" style="color: #1e293b;">
                <i class="bi bi-file-earmark-text me-2" style="color: #3b82f6;"></i>Hasil Pencarian
            </h5>
            <small class="text-muted">
                <i class="bi bi-check2-circle me-1"></i>Ditemukan {{ count($documents) }} dokumen
            </small>
        </div>
    </div>

    @if(!$hasSearch)
    <div class="alert text-center" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: none; color: #1d4ed8; border-radius: 12px;">
        <i class="bi bi-info-circle me-2"></i>Silakan masukkan kata kunci atau filter lalu klik <b>Cari</b>.
    </div>
    @endif

    {{-- List Dokumen --}}
    <div class="row g-3">

        @forelse($documents as $doc)
        {{-- card dokumen --}}
        <div class="col-12 mb-3">
            <a href="{{ route('dokumen.detail', $doc->id) }}" class="text-decoration-none" style="display:block;">
                <div class="card shadow-sm p-3" style="border-radius: 12px; border: 1px solid #e2e8f0; transition: all 0.3s ease; cursor:pointer; margin-bottom: 18px;">
                    <div class="d-flex">
                        {{-- Icon --}}
                        @php
                            $fileType = strtolower($doc->type ?? '');
                            $fileIcons = [
                                'pdf' => ['icon' => 'bi-file-earmark-pdf-fill', 'color' => '#ef4444', 'bg' => '#fee2e2'],
                                'doc' => ['icon' => 'bi-file-earmark-word-fill', 'color' => '#2563eb', 'bg' => '#dbeafe'],
                                'docx' => ['icon' => 'bi-file-earmark-word-fill', 'color' => '#2563eb', 'bg' => '#dbeafe'],
                                'xls' => ['icon' => 'bi-file-earmark-excel-fill', 'color' => '#16a34a', 'bg' => '#dcfce7'],
                                'xlsx' => ['icon' => 'bi-file-earmark-excel-fill', 'color' => '#16a34a', 'bg' => '#dcfce7'],
                                'jpg' => ['icon' => 'bi-file-earmark-image-fill', 'color' => '#f59e42', 'bg' => '#fef9c3'],
                                'jpeg' => ['icon' => 'bi-file-earmark-image-fill', 'color' => '#f59e42', 'bg' => '#fef9c3'],
                                'png' => ['icon' => 'bi-file-earmark-image-fill', 'color' => '#f59e42', 'bg' => '#fef9c3'],
                                'zip' => ['icon' => 'bi-file-earmark-zip-fill', 'color' => '#a16207', 'bg' => '#fef3c7'],
                                'rar' => ['icon' => 'bi-file-earmark-zip-fill', 'color' => '#a16207', 'bg' => '#fef3c7'],
                                'default' => ['icon' => 'bi-file-earmark-fill', 'color' => '#64748b', 'bg' => '#f1f5f9'],
                            ];
                            $iconData = $fileIcons[$fileType] ?? $fileIcons['default'];
                        @endphp
                        <div class="me-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center position-relative"
                                style="width:70px; height:70px; background: {{ $iconData['bg'] }}; border: 2px solid {{ $iconData['color'] }};">
                                <i class="bi {{ $iconData['icon'] }} fs-1" style="color: {{ $iconData['color'] }};"></i>
                                @if(isset($doc->relevance_score) && $doc->relevance_score >= 100)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 0.6rem;">
                                    <i class="bi bi-star-fill"></i>
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- Detail --}}
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                <div>
                                    <h5 class="fw-bold mb-0" style="color: #1d4ed8;">{{ $doc->title }}</h5>
                                    @if(isset($doc->relevance_score) && request('q'))
                                    <small class="text-muted">
                                        @if($doc->relevance_score >= 150)
                                        <span class="badge" style="background: #dcfce7; color: #166534;"><i class="bi bi-check-circle-fill me-1"></i>Sangat Relevan</span>
                                        @elseif($doc->relevance_score >= 100)
                                        <span class="badge" style="background: #dbeafe; color: #1d4ed8;"><i class="bi bi-check-circle me-1"></i>Relevan</span>
                                        @elseif($doc->relevance_score >= 50)
                                        <span class="badge" style="background: #fef3c7; color: #92400e;"><i class="bi bi-dash-circle me-1"></i>Cukup Relevan</span>
                                        @endif
                                    </small>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('dokumen.download', $doc->id) }}"
                                        class="btn btn-success btn-sm" style="border-radius: 8px;" onclick="event.stopPropagation();">
                                        <i class="bi bi-download me-1"></i>Unduh
                                    </a>
                                </div>
                            </div>
                            <div class="text-muted small mt-1">
                                <span class="badge bg-light text-dark me-1">{{ $doc->category }}</span>
                                <i class="bi bi-calendar me-1"></i>{{ $doc->uploaded_at }} •
                                <i class="bi bi-person me-1"></i>{{ $doc->uploaded_by }} •
                                <i class="bi bi-file-earmark me-1"></i>{{ $doc->file_size }}
                            </div>
                            <p class="mt-2 mb-0 text-muted">{{ $doc->description }}</p>
                        </div>
                    </div>
                </div>
            </a>
        @empty
        <div class="col-12">
            <div class="alert text-center" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border: none; border-radius: 12px;">
                <i class="bi bi-inbox me-2" style="font-size: 1.5rem; color: #64748b;"></i>
                <p class="mb-0 text-muted">Tidak ditemukan dokumen untuk kriteria ini.</p>
            </div>
        </div>
        @endforelse

    </div>

    {{-- Rekomendasi Dokumen Terkait --}}
    @if(isset($recommendations) && $recommendations->isNotEmpty())
    <div class="mt-5">
        <div class="d-flex align-items-center mb-3">
            <div class="me-2" style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-stars text-white fs-5"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="color: #1d4ed8;">Rekomendasi Dokumen Terkait</h5>
                <small class="text-muted">Dokumen lain yang sangat relevan dengan pencarian Anda</small>
            </div>
        </div>

        <div class="row g-3">
            @foreach($recommendations as $rec)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm" style="border-radius: 14px; border: 1px solid #dbeafe; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%); transition: all 0.3s ease;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-start mb-2">
                            <div class="me-2 rounded-2 d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 45px; height: 45px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 1px solid #3b82f6;">
                                <strong style="color: #1d4ed8; font-size: 0.75rem;">{{ strtoupper($rec->type) }}</strong>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="fw-bold mb-1 text-truncate" style="color: #1e293b; max-width: 180px;" title="{{ $rec->title }}">{{ \Illuminate\Support\Str::limit($rec->title, 40) }}</h6>
                                <span class="badge" style="background: #dbeafe; color: #1d4ed8; font-size: 0.7rem;">{{ $rec->category }}</span>
                            </div>
                        </div>
                        <p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 100%;">
                            {{ \Illuminate\Support\Str::limit($rec->description ?? 'Tidak ada deskripsi', 70) }}
                        </p>
                        <div class="d-flex gap-1">
                            <a href="{{ route('dokumen.detail', $rec->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1" style="border-radius: 7px; font-size: 0.75rem;">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <a href="{{ route('dokumen.download', $rec->id) }}" class="btn btn-primary btn-sm flex-grow-1 text-white" style="border-radius: 7px; font-size: 0.75rem;">
                                <i class="bi bi-download"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endif

</div>
@endsection