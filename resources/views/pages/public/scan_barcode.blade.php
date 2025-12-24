@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-upc-scan"></i> Scan Barcode Arsip
                    </h5>

                    <div id="alertBox"></div>

                    <video id="preview" style="width:100%; border-radius:12px;"></video>

                    <small class="text-muted d-block mt-2">
                        Arahkan kamera ke barcode dokumen
                    </small>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- SOUND -->
<audio id="beepSound" preload="auto">
    <source src="https://actions.google.com/sounds/v1/cartoon/wood_plank_flicks.ogg" type="audio/ogg">
</audio>
@endsection

@push('scripts')
<script src="https://unpkg.com/@zxing/library@latest"></script>

<script>
    const codeReader = new ZXing.BrowserBarcodeReader();
    const beepSound = document.getElementById('beepSound');
    const alertBox = document.getElementById('alertBox');

    let scanned = false;

    codeReader.decodeFromVideoDevice(null, 'preview', (result, err) => {
        if (result && !scanned) {
            scanned = true;

            beepSound.play();
            codeReader.reset(); // stop camera

            fetch("{{ route('scan.barcode.process') }}", {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        kode_barcode: result.text
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        showError(data.message);
                    }
                })
                .catch(() => {
                    showError('Terjadi kesalahan sistem');
                });
        }
    });

    function showError(message) {
        alertBox.innerHTML = `
            <div class="alert alert-danger mt-3">
                ${message}
            </div>
        `;
        scanned = false;
    }
</script>
@endpush