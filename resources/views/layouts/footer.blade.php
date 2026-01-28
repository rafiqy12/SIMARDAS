<footer class="bg-primary text-white pt-5 mt-5">
    <div class="container pb-4">
        <div class="row gy-4">

            <!-- Profil Instansi -->
            <div class="col-md-3">
                <div class="d-flex mb-3">
                    <img src="{{asset('images/Logo_kabupaten_serang.png')}}" width="60" class="me-2" alt="Logo">
                    <div>
                        <h6 class="fw-bold mb-0">PEMKAB SERANG</h6>
                        <small>Sistem Informasi Manajemen Arsip Daerah Serang</small>
                    </div>
                </div>
                <p class="small">
                    Sistem Digitalisasi dan Manajemen Arsip Daerah Kabupaten Serang – 
                    Mewujudkan tata kelola arsip yang modern dan efisien.
                </p>
            </div>

            <!-- Tautan Cepat -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home.page') }}" class="text-white text-decoration-none d-block mb-1">Beranda</a></li>
                    <li><a href="{{ route('profile.page') }}" class="text-white text-decoration-none d-block mb-1">Profil</a></li>
                    <li><a href="{{ route('search.page') }}" class="text-white text-decoration-none d-block mb-1">Fitur Sistem</a></li>
                    <li><a href="{{ route('search.page') }}" class="text-white text-decoration-none d-block mb-1">Layanan</a></li>
                    <li><a href="{{ route('kontak.page') }}" class="text-white text-decoration-none d-block mb-1">Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Layanan</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Upload Arsip</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Pencarian Dokumen</a></li>
                    <li><a href="#" class="text-white text-decoration-none d-block mb-1">Bantuan & Panduan</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Kontak Kami</h6>

                <p class="small mb-1">
                    <i class="bi bi-geo-alt me-2"></i>
                    Jl. Raya Serang-Jakarta KM 5, Serang, Banten 42116
                </p>

                <p class="small mb-1">
                    <i class="bi bi-telephone me-2"></i>
                    (0254) 200-100
                </p>

                <p class="small mb-3">
                    <i class="bi bi-envelope me-2"></i>
                    arsip@serangkab.go.id
                </p>

                <h6 class="fw-bold mb-2">Media Sosial</h6>

                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="btn btn-dark btn-sm"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- Garis pemisah -->
    <div class="border-top border-light"></div>

    <!-- Bagian bawah -->
    <div class="container text-center text-md-start py-3 small">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                © 2025 Pemerintah Kabupaten Serang. Hak Cipta Dilindungi.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white text-decoration-none me-3">Kebijakan Privasi</a>
                <a href="#" class="text-white text-decoration-none me-3">Syarat & Ketentuan</a>
                <a href="#" class="text-white text-decoration-none">Peta Situs</a>
            </div>
        </div>
    </div>

</footer>