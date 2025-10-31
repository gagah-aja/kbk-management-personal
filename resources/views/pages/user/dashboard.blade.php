@extends('layouts.user.user')

@section('content')
<style>
    /* Custom style untuk hero section */
    .hero-section {
        /* Placeholder untuk foto kantor desa atau suasana perumahan */
        background-image: url('https://placehold.co/1200x500/0d6efd/ffffff/png?text=Kantor+Pengelola+atau+Pemandangan+Perumahan+Keandra');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 6rem 0;
        border-radius: 0.75rem;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.65); /* Overlay lebih gelap */
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    .data-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .data-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
    }
    /* Style untuk peta Leaflet */
    #mapid {
        height: 500px; /* Tinggi peta */
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>

<div class="container py-4">

    {{-- BLOK 1: HERO SECTION - SELAMAT DATANG & CALL TO ACTION --}}
    <div class="hero-section shadow-lg mb-5">
        <div class="container hero-content">
            <h5 class="text-uppercase fw-light mb-2 opacity-75">Selamat Datang di Portal Resmi</h5>
            <h1 class="display-3 fw-bolder mb-3">KOTA BARU KEANDRA</h1>
            <p class="lead mb-5 fs-4">Melayani Warga dengan Transparansi dan Integritas. Mari wujudkan Lingkungan Asri, Aman, dan Nyaman.</p>
            <a href="/login" class="btn btn-warning btn-lg fw-bold rounded-pill shadow-lg me-3">
                <i class="bi bi-person-fill me-2"></i> Masuk Portal Warga
            </a>
             <a href="#statistik" class="btn btn-outline-light btn-lg fw-bold rounded-pill shadow-sm">
                Pelajari Statistik Perumahan <i class="bi bi-arrow-down-short"></i>
            </a>
        </div>
    </div>

    {{-- BLOK 2: DATA STATISTIK PERUMAHAN --}}
    <h2 id="statistik" class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2 pt-3">Data Pokok Kota Baru Keandra</h2>

    <div class="row g-4 mb-5 justify-content-center">

        {{-- Card Statistik 1: Jumlah Penduduk --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-primary border-4">
                <div class="card-body p-4">
                    <i class="bi bi-people-fill text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Total Warga</p>
                    {{-- Ganti '7.540' dengan data dinamis --}}
                    <h3 class="display-6 fw-bolder text-dark mb-0">{{$total_warga}}</h3>
                    <p class="text-secondary mb-0">Jiwa</p>
                </div>
            </div>
        </div>

        {{-- Card Statistik 2: Jumlah Keluarga (KK) --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-success border-4">
                <div class="card-body p-4">
                    <i class="bi bi-house-door-fill text-success mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Jumlah Cluster</p>
                    {{-- Ganti '2.100' dengan data dinamis --}}
                    <h3 class="display-6 fw-bolder text-dark mb-0">{{$total_cluster}}</h3>
                    <p class="text-secondary mb-0">Cluster</p>
                </div>
            </div>
        </div>

        {{-- Card Statistik 3: Luas Wilayah --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-info border-4">
                <div class="card-body p-4">
                    <i class="bi bi-map-fill text-info mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Luas Total</p>
                    {{-- Ganti '350' dengan data dinamis --}}
                    <h3 class="display-6 fw-bolder text-dark mb-0">35</h3>
                    <p class="text-secondary mb-0">Hektar</p>
                </div>
            </div>
        </div>

        {{-- Card Statistik 4: Jumlah RT --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-warning border-4">
                <div class="card-body p-4">
                    <i class="bi bi-buildings-fill text-warning mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Jumlah Blok / RT</p>
                    {{-- Ganti '25' dengan data dinamis --}}
                    <h3 class="display-6 fw-bolder text-dark mb-0">{{$total_rt}}</h3>
                    <p class="text-secondary mb-0">Rt</p>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOK 3: APARATUR PENGELOLA PERUMAHAN (Fokus Ketua RW) --}}
    <h2 class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2">Pengurus Warga (RW)</h2>

    <div class="row g-4 mb-5 justify-content-center">

        {{-- Card Ketua RW (Dibuat Lebih Menonjol) --}}
        <div class="col-lg-4 col-md-6">
            <div class="card leader-card border-0 rounded-3 shadow-lg text-center bg-light">
                <div class="card-header bg-primary text-white py-3 rounded-top-3">
                    <h5 class="mb-0 fw-bold">KETUA RUKUN WARGA (RW) 001</h5>
                </div>
                <div class="card-body p-4">
                     {{-- Placeholder Foto Ketua RW --}}
                    <img src="https://placehold.co/120x120/0d6efd/ffffff/png?text=FOTO+KETUA+RW" alt="Ketua RW" class="rounded-circle mb-3 shadow-sm border border-3 border-white" style="margin-top: -60px;">

                    {{-- Ganti 'Bapak Haji Ahmad' dengan data dinamis --}}
                    <h3 class="fw-bolder text-dark mt-2 mb-1">Bapak Rizky Pratama</h3>
                    <p class="text-primary fw-semibold mb-3">Masa Jabatan 2023 - 2026</p>

                    <p class="small text-muted mb-3">"Mewujudkan lingkungan yang guyub, bersih, dan berprestasi."</p>

                    <button class="btn btn-outline-primary rounded-pill mt-2 px-4">
                        <i class="bi bi-info-circle-fill me-2"></i> Struktur Pengurus
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Aparatur Lain 1 (Placeholder Sekretaris) --}}
        <div class="col-lg-4 col-md-6">
            <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                <div class="card-body p-4">
                    <img src="https://placehold.co/80x80/28a745/ffffff/png?text=SEKRETARIS" alt="Sekretaris RW" class="rounded-circle mb-3 border border-2 border-success">
                    <p class="text-uppercase text-muted fw-semibold small mb-1">SEKRETARIS RW</p>
                    {{-- Ganti 'Ibu Siti Khadijah' dengan data dinamis --}}
                    <h4 class="fw-bold text-dark mb-0">Ibu Siti Khadijah</h4>
                    <p class="text-success fw-semibold mb-3">Bidang Administrasi</p>

                    <button class="btn btn-outline-success btn-sm rounded-pill mt-2">
                        <i class="bi bi-whatsapp me-2"></i> Kontak
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Aparatur Lain 2 (Placeholder Bendahara) --}}
        <div class="col-lg-4 col-md-6">
            <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                <div class="card-body p-4">
                    <img src="https://placehold.co/80x80/dc3545/ffffff/png?text=BENDAHARA" alt="Bendahara RW" class="rounded-circle mb-3 border border-2 border-danger">
                    <p class="text-uppercase text-muted fw-semibold small mb-1">BENDAHARA RW</p>
                    {{-- Ganti 'Bapak Jajang' dengan data dinamis --}}
                    <h4 class="fw-bold text-dark mb-0">Bapak Jajang Sudrajat</h4>
                    <p class="text-danger fw-semibold mb-3">Bidang Keuangan</p>

                    <button class="btn btn-outline-danger btn-sm rounded-pill mt-2">
                        <i class="bi bi-whatsapp me-2"></i> Kontak
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOK 4: PENGUMUMAN PUBLIK --}}
    <h2 class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2">Pengumuman dan Kegiatan Warga</h2>
    <div class="row g-4 mb-5">

        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark d-flex align-items-center">
                        <i class="bi bi-newspaper me-2 text-primary"></i> Info Terbaru Keandra
                    </h5>
                    <ul class="list-group list-group-flush">

                        {{-- Item Pengumuman 1 --}}
                        <li class="list-group-item list-group-item-action py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-semibold text-dark">Jadwal Fogging Massal Blok A dan B</h6>
                                <small class="text-muted">2 jam lalu</small>
                            </div>
                            <p class="mb-1 small">Mohon siapkan rumah Anda, kegiatan akan dilaksanakan Sabtu pagi, 5 November 2025.</p>
                             <small class="text-primary fw-semibold">Baca Detail <i class="bi bi-arrow-right"></i></small>
                        </li>

                        {{-- Item Pengumuman 2 --}}
                        <li class="list-group-item list-group-item-action py-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 fw-semibold text-dark">Laporan Keuangan Kas RT 03 - Bulan Oktober</h6>
                                <small class="text-muted">Kemarin</small>
                            </div>
                            <p class="mb-1 small">Telah dipublikasikan laporan kas RT 03 secara transparan. Dapat diakses di portal warga.</p>
                            <small class="text-primary fw-semibold">Baca Selengkapnya <i class="bi bi-arrow-right"></i></small>
                        </li>
                    </ul>
                    <div class="text-end mt-3">
                        <a href="/public/berita" class="btn btn-primary btn-sm rounded-pill">
                            Lihat Semua Pengumuman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BLOK 5: PETA PERUMAHAN --}}
    <h2 class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2">Peta Lokasi Kota Baru Keandra</h2>
    <div class="card shadow-lg border-0 rounded-3 mb-5">
        <div class="card-body p-4">
            <p class="text-muted small mb-3">Peta ini menampilkan perkiraan batas area Kota Baru Keandra dan lokasi fasilitas umum (Point of Interest).</p>
            <div id="mapid"></div>
        </div>
    </div>

</div> {{-- Akhir container --}}

{{-- Load Leaflet CSS and JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Inisialisasi Peta
    document.addEventListener('DOMContentLoaded', function () {
        // Koordinat tengah untuk Kota Baru Keandra, Cirebon (Berdasarkan tautan Google Maps: -6.7025, 108.4725)
        const initialCoords = [-6.7025, 108.4725];

        // Inisialisasi peta dan atur view ke koordinat awal
        const mymap = L.map('mapid').setView(initialCoords, 15); // Zoom level 15 (sangat dekat untuk perumahan)

        // Tambahkan Tile Layer (Peta Satelit - dari Esri World Imagery)
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA FSA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 18
        }).addTo(mymap);

        // =========================================================
        // BATAS PERUMAHAN (POLYGON) - Placeholder
        // Koordinat disesuaikan sedikit agar lebih fokus pada area perumahan.
        // Anda harus menggantinya dengan data batas Perumahan yang sebenarnya (GeoJSON).
        // =========================================================
        const keandraBoundary = [
            [-6.7005, 108.4700],
            [-6.7018, 108.4740],
            [-6.7045, 108.4745],
            [-6.7040, 108.4695]
        ];

        L.polygon(keandraBoundary, {
            color: 'white', // Warna garis batas
            weight: 3,
            fillColor: '#0d6efd', // Warna isi polygon (biru Bootstrap)
            fillOpacity: 0.15 // Transparansi isi
        }).addTo(mymap).bindPopup("<b>Perkiraan Batas Kota Baru Keandra</b>");

        // =========================================================
        // POINT OF INTEREST (Marker) - Disesuaikan untuk fasilitas perumahan
        // =========================================================
        const pointsOfInterest = [
            { lat: -6.7025, lon: 108.4725, name: "Kantor Pengelola / Pos Utama" }, // Di pusat koordinat
            { lat: -6.7040, lon: 108.4735, name: "Fasilitas Olahraga (Lapangan)" },
            { lat: -6.7015, lon: 108.4710, name: "Area Komersial/Ruko" }
        ];

        pointsOfInterest.forEach(point => {
            L.marker([point.lat, point.lon]).addTo(mymap)
                .bindPopup("<b>" + point.name + "</b>").openPopup();
        });

        // Set peta agar fokus pada polygon yang sudah ditambahkan
        mymap.fitBounds(keandraBoundary);
    });
</script>
@endsection
