@extends('layouts.app')
@section('content')

<div class="container py-4">
	<div class="row justify-content-center">
		<div class="col-lg-7">
			<div class="card shadow-sm mb-4">
				<div class="card-body">
					<h4 class="fw-bold text-primary mb-4 text-center">Scan & Upload Dokumen</h4>

					<form method="POST" action="" enctype="multipart/form-data" id="scanForm">
						@csrf
						<div class="mb-3">
							<label class="form-label">Scan Dokumen dengan Kamera</label>
							<div class="position-relative mb-2" style="width:100%; max-width:400px; margin:auto;">
								<video id="cameraPreview" autoplay playsinline style="width:100%; border-radius:12px; background:#000;"></video>
								<canvas id="captureCanvas" style="display:none;"></canvas>
								<div id="frameOverlay" style="position:absolute; top:0; left:0; width:100%; height:100%; pointer-events:none;">
									<svg width="100%" height="100%" viewBox="0 0 400 300" style="position:absolute; top:0; left:0;">
										<rect x="40" y="30" width="320" height="240" fill="none" stroke="red" stroke-width="4" rx="12"/>
									</svg>
								</div>
							</div>
							<div class="text-center mb-2">
								<button type="button" class="btn btn-danger" id="captureBtn">Ambil Foto</button>
							</div>
						</div>

						<div class="mb-3" id="previewContainer" style="display:none;">
							<label class="form-label">Preview Hasil Scan:</label>
							<img id="imgPreview" src="#" alt="Preview Scan" class="img-fluid rounded mx-auto d-block" style="max-height:400px;" />
						</div>

						<input type="hidden" name="scan_file_base64" id="scanFileBase64">
						<input type="file" id="hiddenFileInput" name="scan_file" style="display:none;" accept="image/jpeg">

						<div class="d-flex gap-2">
							<button type="submit" class="btn btn-primary" id="uploadBtn" style="display:none;">Upload</button>
							<a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
						</div>
					</form>

					@push('scripts')
					<script>
					const video = document.getElementById('cameraPreview');
					const canvas = document.getElementById('captureCanvas');
					const captureBtn = document.getElementById('captureBtn');
					const imgPreview = document.getElementById('imgPreview');
					const previewContainer = document.getElementById('previewContainer');
					const scanFileBase64 = document.getElementById('scanFileBase64');
					const uploadBtn = document.getElementById('uploadBtn');
					const scanForm = document.getElementById('scanForm');
					const hiddenFileInput = document.getElementById('hiddenFileInput');

					let cameraStream = null;
					function startCamera() {
						if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
							navigator.mediaDevices.getUserMedia({ video: { facingMode: { ideal: 'environment' } } })
								.then(function(stream) {
									cameraStream = stream;
									video.srcObject = stream;
									video.onloadedmetadata = function() {
										video.play();
									};
								})
								.catch(function(err) {
									alert('Tidak dapat mengakses kamera: ' + err.message);
								});
						} else {
							alert('Browser tidak mendukung kamera.');
						}
					}
					startCamera();

					captureBtn.addEventListener('click', function() {
						if (video.readyState < 2) {
							alert('Kamera belum siap. Mohon tunggu beberapa detik.');
							return;
						}
						const width = video.videoWidth;
						const height = video.videoHeight;
						if (!width || !height) {
							alert('Kamera belum siap. Mohon tunggu beberapa detik.');
							return;
						}
						canvas.width = width;
						canvas.height = height;
						const ctx = canvas.getContext('2d');
						ctx.drawImage(video, 0, 0, width, height);
						const dataUrl = canvas.toDataURL('image/jpeg');
						imgPreview.src = dataUrl;
						previewContainer.style.display = 'block';
						scanFileBase64.value = dataUrl;
						uploadBtn.style.display = 'inline-block';
					});

					scanForm.addEventListener('submit', function(e) {
						if (scanFileBase64.value) {
							const arr = scanFileBase64.value.split(','), mime = arr[0].match(/:(.*?);/)[1], bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
							for (let i = 0; i < n; i++) u8arr[i] = bstr.charCodeAt(i);
							const file = new File([u8arr], 'scan.jpg', {type: mime});
							const dataTransfer = new DataTransfer();
							dataTransfer.items.add(file);
							hiddenFileInput.files = dataTransfer.files;
						}
					});

					window.addEventListener('beforeunload', function() {
						if (cameraStream) {
							cameraStream.getTracks().forEach(track => track.stop());
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
