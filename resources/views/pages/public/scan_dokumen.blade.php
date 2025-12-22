@extends('layouts.app')

@push('styles')
<style>
    .scan-card {
        border-radius: 16px;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .scan-card:hover {
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
    }
    .scan-title {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .camera-container {
        border: 3px solid #3b82f6;
        border-radius: 16px;
        overflow: hidden;
        background: #000;
    }
    .btn-capture {
        border-radius: 50px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }
    .btn-capture:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 20px rgba(37, 99, 235, 0.4);
    }
    .btn-upload {
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(37, 99, 235, 0.35);
    }
    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(37, 99, 235, 0.35);
    }
    .btn-kembali {
        border-radius: 10px;
        background: transparent;
        border: 2px solid #3b82f6;
        color: #3b82f6 !important;
        transition: all 0.3s ease;
    }
    .btn-kembali:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white !important;
        transform: translateX(-3px);
    }
    .preview-img {
        border: 2px solid #3b82f6 !important;
        border-radius: 8px !important;
    }
</style>
@endpush

@section('content')

<div class="container py-3 py-md-4">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-7">
			<div class="card shadow-sm scan-card mb-4">
				<div class="card-body p-3 p-md-4">
					<div class="text-center mb-4">
                        <div class="mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-camera-fill" style="color: #2563eb; font-size: 1.8rem;"></i>
                        </div>
                        <h4 class="fw-bold scan-title mb-1 fs-5 fs-md-4">
                            Scan & Upload Dokumen
                        </h4>
                        <p class="text-muted small mb-0">Gunakan kamera untuk memindai dokumen</p>
                    </div>

					{{-- Alert untuk pesan sukses --}}
					@if(session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					@endif

					{{-- Alert untuk pesan error --}}
					@if(session('error'))
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					@endif

					{{-- Alert untuk validation errors --}}
					@if($errors->any())
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="bi bi-exclamation-triangle-fill me-2"></i>
						<ul class="mb-0 ps-3">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					@endif

					<form method="POST"
						action="{{ route('scan_dokumen.store') }}"
						enctype="multipart/form-data"
						id="scanForm">
						@csrf

						{{-- CAMERA --}}
						<div class="mb-3">
							<label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-camera me-1" style="color: #3b82f6;"></i>Scan Dokumen dengan Kamera
                            </label>

							<div class="position-relative mb-3 camera-container"
								style="width:100%;max-width:100%;margin:auto;">
								<video id="cameraPreview"
									autoplay
									playsinline
									style="width:100%;display:block;background:#000;"></video>

								<canvas id="captureCanvas" style="display:none;"></canvas>
							</div>

							<div class="text-center">
								<button type="button"
									class="btn btn-capture text-white"
									id="captureBtn">
									<i class="bi bi-camera me-1"></i> Ambil Foto
								</button>
							</div>
						</div>

						{{-- PREVIEW --}}
						<div class="mb-3" id="previewContainer" style="display:none;">
							<label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-images me-1" style="color: #3b82f6;"></i>Preview Hasil Scan
                            </label>
							<div id="previewList" class="d-flex flex-wrap gap-2"></div>
						</div>

						{{-- HIDDEN INPUT --}}
						<input type="file" id="hiddenFileInput" name="scan_files[]" multiple hidden>

						{{-- FORM DATA --}}
						<div class="mb-3">
							<label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-file-earmark-text me-1" style="color: #3b82f6;"></i>Judul Dokumen
                            </label>
							<input type="text"
								name="judul"
								class="form-control"
								required
                                placeholder="Masukkan judul dokumen">
						</div>

						<div class="mb-3">
							<label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-folder me-1" style="color: #3b82f6;"></i>Kategori Dokumen
                            </label>
							<select name="kategori" class="form-select rounded-xl shadow-sm border border-primary-200 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition-all" required>
								<option value="">-- Pilih Kategori --</option>
								<option value="Administrasi">Administrasi</option>
								<option value="Keuangan">Keuangan</option>
								<option value="Notulen">Notulen</option>
								<option value="Surat">Surat</option>
								<option value="Scan">Scan</option>
							</select>
						</div>

						<div class="mb-4">
							<label class="form-label small fw-semibold" style="color: #374151;">
                                <i class="bi bi-card-text me-1" style="color: #3b82f6;"></i>Deskripsi (Opsional)
                            </label>
							<textarea name="deskripsi"
								class="form-control"
								rows="3"
                                placeholder="Tambahkan deskripsi dokumen (opsional)"></textarea>
						</div>

						<div class="d-flex gap-2 flex-wrap">
							<button type="submit"
								class="btn btn-upload text-white"
								id="uploadBtn"
								style="display:none;">
								<i class="bi bi-upload me-1"></i> Upload Dokumen
							</button>
							<a href="{{ url()->previous() }}"
								class="btn btn-kembali">
								<i class="bi bi-arrow-left me-1"></i> Kembali
							</a>
						</div>
					</form>

					@push('scripts')
					<script>
						const video = document.getElementById('cameraPreview');
						const canvas = document.getElementById('captureCanvas');
						const captureBtn = document.getElementById('captureBtn');
						const previewContainer = document.getElementById('previewContainer');
						const previewList = document.getElementById('previewList');
						const uploadBtn = document.getElementById('uploadBtn');
						const hiddenFileInput = document.getElementById('hiddenFileInput');
						const scanForm = document.getElementById('scanForm');

						let cameraStream = null;
						let capturedFiles = [];

						navigator.mediaDevices.getUserMedia({
							video: {
								facingMode: {
									ideal: "environment"
								}
							}
						}).then(stream => {
							cameraStream = stream;
							video.srcObject = stream;
						}).catch(err => {
							alert('Gagal membuka kamera: ' + err.message);
						});

						captureBtn.addEventListener('click', () => {
							canvas.width = video.videoWidth;
							canvas.height = video.videoHeight;

							const ctx = canvas.getContext('2d');
							ctx.drawImage(video, 0, 0);

							const dataUrl = canvas.toDataURL('image/jpeg');

							const arr = dataUrl.split(',');
							const mime = arr[0].match(/:(.*?);/)[1];
							const bstr = atob(arr[1]);
							let n = bstr.length;
							const u8arr = new Uint8Array(n);
							while (n--) u8arr[n] = bstr.charCodeAt(n);

							const file = new File(
								[u8arr],
								`scan_${Date.now()}.jpg`, {
									type: mime
								}
							);

							capturedFiles.push(file);

							const img = document.createElement('img');
							img.src = dataUrl;
							img.style.height = '100px';
							img.classList.add('rounded', 'border', 'preview-img');
							previewList.appendChild(img);

							previewContainer.style.display = 'block';
							uploadBtn.style.display = 'inline-block';
						});

						scanForm.addEventListener('submit', () => {
							const dt = new DataTransfer();
							capturedFiles.forEach(f => dt.items.add(f));
							hiddenFileInput.files = dt.files;
						});

						window.addEventListener('beforeunload', () => {
							if (cameraStream) {
								cameraStream.getTracks().forEach(t => t.stop());
							}
						});
					</script>
					@endpush
				</div>
			</div>
		</div>
	</div>
</div>

@endsection