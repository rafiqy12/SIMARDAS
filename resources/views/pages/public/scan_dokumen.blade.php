@extends('layouts.app')
@section('content')

<div class="container py-4">
	<div class="row justify-content-center">
		<div class="col-lg-7">
			<div class="card shadow-sm mb-4">
				<div class="card-body">
					<h4 class="fw-bold text-primary mb-4 text-center">
						Scan & Upload Dokumen
					</h4>

					@if(session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
					@endif

					<form method="POST"
						action="{{ route('scan_dokumen.store') }}"
						enctype="multipart/form-data"
						id="scanForm">
						@csrf

						{{-- CAMERA --}}
						<div class="mb-3">
							<label class="form-label">Scan Dokumen dengan Kamera</label>

							<div class="position-relative mb-2"
								style="width:100%;max-width:400px;margin:auto;">
								<video id="cameraPreview"
									autoplay
									playsinline
									style="width:100%;border-radius:12px;background:#000;"></video>

								<canvas id="captureCanvas" style="display:none;"></canvas>

								<div style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;">
									<svg width="100%" height="100%" viewBox="0 0 400 300">
										<rect x="40" y="30"
											width="320" height="240"
											fill="none"
											stroke="red"
											stroke-width="4"
											rx="12" />
									</svg>
								</div>
							</div>

							<div class="text-center">
								<button type="button"
									class="btn btn-danger"
									id="captureBtn">
									Ambil Foto
								</button>
							</div>
						</div>

						{{-- PREVIEW --}}
						<div class="mb-3" id="previewContainer" style="display:none;">
							<label class="form-label">Preview Hasil Scan</label>
							<div id="previewList" class="d-flex flex-wrap gap-2"></div>
						</div>

						{{-- HIDDEN INPUT --}}
						<input type="file" id="hiddenFileInput" name="scan_files[]" multiple hidden>

						{{-- FORM DATA --}}
						<div class="mb-3">
							<label class="form-label">Judul Dokumen</label>
							<input type="text"
								name="judul"
								class="form-control"
								required>
						</div>

						<div class="mb-3">
							<label class="form-label">Kategori Dokumen</label>
							<select name="kategori" class="form-select" required>
								<option value="">-- Pilih Kategori --</option>
								<option value="Administrasi">Administrasi</option>
								<option value="Keuangan">Keuangan</option>
								<option value="Notulen">Notulen</option>
								<option value="Surat">Surat</option>
								<option value="Scan">Scan</option>
							</select>
						</div>

						<div class="mb-3">
							<label class="form-label">Deskripsi (Opsional)</label>
							<textarea name="deskripsi"
								class="form-control"
								rows="3"></textarea>
						</div>

						<div class="d-flex gap-2">
							<button type="submit"
								class="btn btn-primary"
								id="uploadBtn"
								style="display:none;">
								Upload Dokumen
							</button>
							<a href="{{ url()->previous() }}"
								class="btn btn-secondary">
								Kembali
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
							img.style.height = '120px';
							img.classList.add('rounded', 'border');
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