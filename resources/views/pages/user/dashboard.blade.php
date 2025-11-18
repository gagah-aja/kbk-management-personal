@extends('layouts.user.user')

@section('content')
<style>
    /* Hero section */
    .hero-section {
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
        background: rgba(0, 0, 0, 0.65);
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

    #mapid {
        height: 500px;
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container py-4">

    {{-- 🏡 BLOK 1: HERO SECTION --}}
    <div class="hero-section shadow-lg mb-5"
         style="background-image: url('{{ $landingPage && $landingPage->value ? asset('storage/' . $landingPage->value) : asset('image/Graha-Keandra-1.jpg') }}');">
        <div class="container hero-content text-center">
            <h5 class="text-uppercase fw-light mb-2 opacity-75">Selamat Datang di Portal Resmi</h5>
            <h1 class="display-3 fw-bolder mb-3">KOTA BARU KEANDRA</h1>
            <p class="lead mb-5 fs-4">
                Melayani Warga dengan Transparansi dan Integritas.
                Mari wujudkan Lingkungan Asri, Aman, dan Nyaman.
            </p>

            <a href="{{ route('search.index') }}" class="btn btn-outline-light btn-lg fw-bold rounded-pill shadow-sm">
                🔍 Cari Warga KBK <i class="bi bi-arrow-right-short"></i>
            </a>
            </div>
        </div>

    {{-- BLOK 2: DATA STATISTIK --}}
    <h2 id="statistik" class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2 pt-3">
        Data Pokok Kota Baru Keandra
    </h2>

    <div class="row g-4 mb-5 justify-content-center">

        {{-- Total Warga --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-primary border-4">
                <div class="card-body p-4">
                    <i class="bi bi-people-fill text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Total Warga</p>
                    <h3 class="display-6 fw-bolder text-dark mb-0">{{ $total_warga }}</h3>
                    <p class="text-secondary mb-0">Jiwa</p>
                </div>
            </div>
        </div>

        {{-- Total Cluster --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-success border-4">
                <div class="card-body p-4">
                    <i class="bi bi-house-door-fill text-success mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Jumlah Cluster</p>
                    <h3 class="display-6 fw-bolder text-dark mb-0">{{ $total_cluster }}</h3>
                    <p class="text-secondary mb-0">Cluster</p>
                </div>
            </div>
        </div>

        {{-- Luas Wilayah --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-info border-4">
                <div class="card-body p-4">
                    <i class="bi bi-map-fill text-info mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Luas Total</p>
                    <h3 class="display-6 fw-bolder text-dark mb-0">35</h3>
                    <p class="text-secondary mb-0">Hektar</p>
                </div>
            </div>
        </div>

        {{-- Jumlah RT --}}
        <div class="col-lg-3 col-md-6">
            <div class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-warning border-4">
                <div class="card-body p-4">
                    <i class="bi bi-buildings-fill text-warning mb-3" style="font-size: 2.5rem;"></i>
                    <p class="text-uppercase text-muted fw-semibold small mb-1">Jumlah Blok / RT</p>
                    <h3 class="display-6 fw-bolder text-dark mb-0">{{ $total_rt }}</h3>
                    <p class="text-secondary mb-0">RT</p>
                </div>
            </div>
        </div>

    </div>

    {{-- BLOK 3: PENGURUS RW & RT --}}
    <h2 id="pengurus-warga" class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2">
        Pengurus Warga (RW)
    </h2>

    <div class="row g-4 mb-5 justify-content-center">

        {{-- Ketua RW --}}
        @if ($ketua_rw && $ketua_rw->warga)
            <div class="col-lg-4 col-md-6">
                <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <img src="{{ asset('storage/' . ($ketua_rw->warga->foto ?? 'default.png')) }}"
                             alt="Ketua RW"
                             class="rounded-circle mb-3 border border-2 border-success"
                             style="width:80px; height:80px; object-fit:cover;">

                        <p class="text-uppercase text-muted fw-semibold small mb-1">KETUA RW</p>
                        <h4 class="fw-bold text-dark mb-0">{{ $ketua_rw->warga->nama_lengkap }}</h4>
                        <p class="text-success fw-semibold mb-3">Bidang Kepemimpinan</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Ketua RT --}}
        @foreach ($ketua_rt as $ketua_rtdata)
            <div class="col-lg-4 col-md-6">
                <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <img src="{{ asset('storage/' . ($ketua_rtdata->warga->foto ?? 'default.png')) }}"
                             alt="Ketua RT"
                             class="rounded-circle mb-3 border border-2 border-success"
                             style="width:80px; height:80px; object-fit:cover;">

                        <p class="text-uppercase text-muted fw-semibold small mb-1">
                            KETUA RT {{ $ketua_rtdata->nomor_rt ?? '001' }}
                        </p>
                        <h4 class="fw-bold text-dark mb-0">{{ $ketua_rtdata->warga->nama_lengkap }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- BLOK 4: PETA --}}
    <h2 id="maps" class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2">
        Peta Lokasi Kota Baru Keandra
    </h2>

    <div class="card shadow-lg border-0 rounded-3 mb-5">
        <div class="card-body p-4">
            <p class="text-muted small mb-3">
                Peta ini menampilkan perkiraan batas area Kota Baru Keandra dan lokasi fasilitas umum.
            </p>
            <div id="mapid"></div>
        </div>
    </div>

</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initialCoords = [-6.7025, 108.4725];
        const mymap = L.map('mapid').setView(initialCoords, 15);

        L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles © Esri, USGS, etc.',
                maxZoom: 18
            }).addTo(mymap);

        const keandraBoundary = [
            [-6.7005, 108.4700],
            [-6.7018, 108.4740],
            [-6.7045, 108.4745],
            [-6.7040, 108.4695]
        ];

        L.polygon(keandraBoundary, {
            color: 'white',
            weight: 3,
            fillColor: '#0d6efd',
            fillOpacity: 0.15
        }).addTo(mymap).bindPopup("<b>Perkiraan Batas Kota Baru Keandra</b>");

        const pointsOfInterest = [
            { lat: -6.7025, lon: 108.4725, name: "Kantor Pengelola / Pos Utama" },
            { lat: -6.7040, lon: 108.4735, name: "Fasilitas Olahraga (Lapangan)" },
            { lat: -6.7015, lon: 108.4710, name: "Area Komersial / Ruko" }
        ];

        pointsOfInterest.forEach(point => {
            L.marker([point.lat, point.lon]).addTo(mymap)
                .bindPopup("<b>" + point.name + "</b>");
        });

        mymap.fitBounds(keandraBoundary);
    });
</script>

{{-- FOOTER --}}
<footer class="mt-5 bg-dark text-white pt-4 pb-3">
    <div class="container">

        <div class="row align-items-start gy-4">

            {{-- Kolom Kiri --}}
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Kota Baru Keandra</h5>
                <p class="small text-white-50 mb-0">
                    Portal informasi resmi untuk warga Kota Baru Keandra.
                    Menyediakan layanan data dan informasi lingkungan secara transparan,
                    aman, dan mudah diakses.
                </p>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Navigasi</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2">
                        <a href="#statistik" class="text-white-50 text-decoration-none">Statistik</a>
                    </li>
                    <li class="mb-2">
                        <a href="#pengurus-warga" class="text-white-50 text-decoration-none">Pengurus</a>
                    </li>
                    <li>
                        <a href="#maps" class="text-white-50 text-decoration-none">Peta Lokasi</a>
                    </li>
                </ul>
            </div>

        </div>

        <hr class="border-secondary mt-4">

        <div class="text-center small text-white-50">
            © {{ date('Y') }} Kota Baru Keandra. All rights reserved.
        </div>

    </div>
</footer>

@endsection
