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
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .data-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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

        /* ============================= */
        /* 🎯 FOTO RW & RT RAPI FINAL   */
        /* ============================= */

        /* Ketua RW */
        .item-rw .leader-photo,
        .item-rw .leader-avatar {
            width: 110px !important;
            height: 110px !important;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0d6efd;
            /* biru RW */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            background: #e9ecef;
        }

        .item-rw .leader-avatar svg {
            width: 60px;
            height: 60px;
        }

        /* Ketua RT */
        .item-rt .leader-photo,
        .item-rt .leader-avatar {
            width: 110px !important;
            height: 110px !important;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #198754;
            /* hijau RT */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            background: #e9ecef;
        }

        .item-rt .leader-avatar svg {
            width: 60px;
            height: 60px;
        }

        /* tombol more kecil */
        .more-btn {
            min-width: 220px;
        }

        .leader-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .leader-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
        }
    </style>


    <div class="container py-4">

        {{-- ========================= --}}
        {{-- 🏡 BLOK 1: HERO SECTION   --}}
        {{-- ========================= --}}
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


        {{-- ======================= --}}
        {{-- BLOK 2: DATA STATISTIK --}}
        {{-- ======================= --}}
        <h2 id="statistik" class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2 pt-3">
            Data Pokok Kota Baru Keandra
        </h2>

        <div class="row g-4 mb-5 justify-content-center">

            {{-- Total Warga --}}
            <div class="col-lg-3 col-md-6">
                <div
                    class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-primary border-4">
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
                <div
                    class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-success border-4">
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
                <div
                    class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-info border-4">
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
                <div
                    class="card data-card border-0 rounded-3 shadow-sm h-100 text-center border-bottom border-warning border-4">
                    <div class="card-body p-4">
                        <i class="bi bi-buildings-fill text-warning mb-3" style="font-size: 2.5rem;"></i>
                        <p class="text-uppercase text-muted fw-semibold small mb-1">Jumlah RT</p>
                        <h3 class="display-6 fw-bolder text-dark mb-0">{{ $total_rt }}</h3>
                        <p class="text-secondary mb-0">RT</p>
                    </div>
                </div>
            </div>

        </div>


        {{-- ============================ --}}
        {{-- BLOK 3: PENGURUS RW & RT --}}
        {{-- ============================ --}}

        <h2 id="pengurus-warga"
            class="fs-4 fw-bold mb-3 text-dark border-bottom pb-2 d-flex align-items-center gap-3 flex-wrap">

            <span>Pengurus Warga (RW/RT)</span>

            <div class="d-flex gap-2">
                <button class="btn filter-btn active-btn" data-target="rw" style="font-size: .95rem; font-weight: 600;">
                    RW
                </button>

                <button class="btn filter-btn" data-target="rt" style="font-size: .95rem; font-weight: 600;">
                    RT
                </button>
            </div>
        </h2>

        <style>
            .filter-btn {
                border: 2px solid #6c757d;
                background: transparent;
                color: #6c757d;
                transition: .2s;
                border-radius: 6px;
                padding: 6px 14px;
            }

            .filter-btn.active-btn[data-target="rw"] {
                background: #0d6efd;
                border-color: #0d6efd;
                color: white;
                box-shadow: 0 0 0 3px rgba(13, 110, 253, .3);
            }

            .filter-btn.active-btn[data-target="rt"] {
                background: #198754;
                border-color: #198754;
                color: white;
                box-shadow: 0 0 0 3px rgba(25, 135, 84, .3);
            }
        </style>

        <div class="row g-4 mb-3 justify-content-center" id="leaders-row">

            {{-- Ketua RW --}}
            @foreach ($ketua_rw_list->take(6) as $rw)
                @php
                    $foto_rw =
                        $rw->warga && $rw->warga->foto && file_exists(storage_path('app/public/' . $rw->warga->foto))
                            ? asset('storage/' . $rw->warga->foto)
                            : null;
                @endphp

                <div class="col-lg-4 col-md-6 item-rw">
                    <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                        <div class="card-body p-4">
                            @if ($foto_rw)
                                <img src="{{ $foto_rw }}" alt="Ketua RW" class="leader-photo">
                            @else
                                <div class="leader-avatar">
                                    <svg viewBox="0 0 24 24" fill="#6c757d">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                    1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8
                                    1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                            @endif
                            <p class="text-uppercase text-muted fw-semibold small mb-1">KETUA RW
                                {{ $rw->nomor_rw ?? '001' }}</p>
                            <h4 class="fw-bold text-dark mb-0">{{ $rw->warga->nama_lengkap ?? $rw->nama_ketua }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Ketua RT --}}
            @foreach ($ketua_rt_list->take(6) as $rt)
                @php
                    $foto_rt =
                        $rt->warga && $rt->warga->foto && file_exists(storage_path('app/public/' . $rt->warga->foto))
                            ? asset('storage/' . $rt->warga->foto)
                            : null;
                @endphp

                <div class="col-lg-4 col-md-6 item-rt" style="display: none;">
                    <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                        <div class="card-body p-4">
                            @if ($foto_rt)
                                <img src="{{ $foto_rt }}" alt="Ketua RT" class="leader-photo">
                            @else
                                <div class="leader-avatar">
                                    <svg viewBox="0 0 24 24" fill="#6c757d">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                    1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8
                                    1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                            @endif
                            <p class="text-uppercase text-muted fw-semibold small mb-1">KETUA RT
                                {{ $rt->nomor_rt ?? '001' }}</p>
                            <h4 class="fw-bold text-dark mb-0">{{ $rt->warga->nama_lengkap ?? 'Belum Ada' }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tombol Lihat Selengkapnya --}}
        <div class="text-center mt-3" id="see-more-wrapper">
            @if ($ketua_rw_list->count() > 6)
                <a href="{{ route('ketua-rw.all') }}" class="btn btn-primary" id="see-more-rw">
                    Lihat Selengkapnya RW
                </a>
            @endif
            @if ($ketua_rt_list->count() > 6)
                <a href="{{ route('rt.index') }}" class="btn btn-success" id="see-more-rt" style="display: none;">
                    Lihat Selengkapnya RT
                </a>
            @endif
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const buttons = document.querySelectorAll('.filter-btn');
                const rwItems = document.querySelectorAll('.item-rw');
                const rtItems = document.querySelectorAll('.item-rt');
                const btnRW = document.getElementById('see-more-rw');
                const btnRT = document.getElementById('see-more-rt');

                function showItems(showList, hideList, activeTarget) {
                    showList.forEach(el => el.style.display = 'block');
                    hideList.forEach(el => el.style.display = 'none');

                    // Active button
                    buttons.forEach(btn => btn.classList.remove('active-btn'));
                    const btnActive = document.querySelector(`.filter-btn[data-target="${activeTarget}"]`);
                    if (btnActive) btnActive.classList.add('active-btn');

                    // Tombol lihat selengkapnya
                    if (activeTarget === 'rw') {
                        if (btnRW) btnRW.style.display = 'inline-block';
                        if (btnRT) btnRT.style.display = 'none';
                    } else {
                        if (btnRW) btnRW.style.display = 'none';
                        if (btnRT) btnRT.style.display = 'inline-block';
                    }
                }

                // Set default RW
                showItems(rwItems, rtItems, 'rw');

                buttons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const target = this.dataset.target;
                        if (target === 'rw') showItems(rwItems, rtItems, 'rw');
                        else showItems(rtItems, rwItems, 'rt');
                    });
                });

            });
        </script>


        {{-- =================== --}}
{{-- BLOK 4: PETA        --}}
{{-- =================== --}}
<h2 id="maps" class="fs-4 fw-bold mb-4 text-dark border-bottom pb-2">
    Peta Lokasi Kota Baru Keandra
</h2>

<div class="card shadow-lg border-0 rounded-3 mb-5">
    <div class="card-body p-4">

        <p class="text-muted small mb-3">
            Peta ini menampilkan perkiraan batas area Kota Baru Keandra dan lokasi fasilitas umum.
        </p>

        <!-- MAP WRAPPER -->
        <div class="position-relative rounded-4" style="height: 550px; overflow: hidden;">

            <!-- MAP -->
            <div id="mapid" class="rounded-4"
                 style="height: 100%; filter: blur(4px); pointer-events: none; transition: .4s;">
            </div>

            <!-- OVERLAY CLICK -->
            <div id="map-overlay"
                 class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center
                        bg-dark bg-opacity-50 rounded-4"
                 style="cursor: pointer; z-index: 9999;">
                <h2 class="fw-bold text-white">Klik Untuk Interaksi dengan Map</h2>
            </div>

            <!-- CLOSE BUTTON -->
            <button id="map-close-btn"
                    class="btn btn-light border position-absolute top-0 end-0 m-3 rounded-circle shadow-sm"
                    style="z-index: 10000; display:none;">
                <i class="bi bi-x-lg"></i>
            </button>

        </div>
    </div>
</div>


{{-- =================== --}}
{{-- Leaflet MAP SCRIPT --}}
{{-- =================== --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    /* ==================== INIT MAP ==================== */
    const map = L.map('mapid').setView([-6.1900, 106.7980], 15);

    L.tileLayer(
        "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
        { attribution: "Tiles © Esri, USGS, etc.", maxZoom: 18 }
    ).addTo(map);


    /* ==================== POLYGON AREA ==================== */
    const boundaryCoords = [];

    @if ($mapPolygon)
        @foreach (json_decode($mapPolygon) as $point)
            boundaryCoords.push([{{ $point->lat }}, {{ $point->lng }}]);
        @endforeach
    @else
        boundaryCoords.push(
            [-6.7005, 108.4700],
            [-6.7018, 108.4740],
            [-6.7045, 108.4745],
            [-6.7040, 108.4695]
        );
    @endif

    L.polygon(boundaryCoords, {
        color: "white",
        weight: 3,
        fillColor: "#0d6efd",
        fillOpacity: 0.15
    }).addTo(map).bindPopup("<b>Perkiraan Batas Kota Baru Keandra</b>");

    map.fitBounds(boundaryCoords);


    /* ==================== POI MARKERS ==================== */
    const poiList = [
        { lat: -6.7025, lon: 108.4725, name: "Kantor Pengelola / Pos Utama" },
        { lat: -6.7040, lon: 108.4735, name: "Fasilitas Olahraga (Lapangan)" },
        { lat: -6.7015, lon: 108.4710, name: "Area Komersial / Ruko" }
    ];

    poiList.forEach(item => {
        L.marker([item.lat, item.lon]).addTo(map).bindPopup(`<b>${item.name}</b>`);
    });


    /* ==================== MAP INTERACTION TOGGLE ==================== */
const overlay  = document.getElementById("map-overlay");
const mapLayer = document.getElementById("mapid");
const closeBtn = document.getElementById("map-close-btn");

overlay.addEventListener("click", () => {
    mapLayer.style.filter = "none";
    mapLayer.style.pointerEvents = "auto";

    // sembunyikan overlay dengan fade
    overlay.style.opacity = "0";
    overlay.style.pointerEvents = "none"; // biarkan klik ke peta
    closeBtn.style.display = "block";
});

closeBtn.addEventListener("click", () => {
    mapLayer.style.filter = "blur(4px)";
    mapLayer.style.pointerEvents = "none";

    overlay.style.opacity = "1";
    overlay.style.pointerEvents = "auto";
    closeBtn.style.display = "none";
});


});
</script>

    {{-- =================== --}}
    {{-- FOOTER             --}}
    {{-- =================== --}}
    <footer class="mt-5 bg-dark text-white pt-4 pb-3">
        <div class="container">

            <div class="row gy-4">

                {{-- Kolom kiri --}}
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Kota Baru Keandra</h5>
                    <p class="small text-white-50 mb-0">
                        Portal informasi resmi untuk warga Kota Baru Keandra.
                        Menyediakan layanan data dan informasi lingkungan secara
                        transparan, aman, dan mudah diakses.
                    </p>
                </div>

                {{-- Kolom kanan --}}
                <div class="col-md-6">
                    <div class="row">

                        {{-- Media Sosial --}}
                        <div class="col-6">
                            <h5 class="fw-bold mb-3">Media Sosial</h5>
                            <ul class="list-unstyled small mb-0">

                                <li class="mb-2 d-flex align-items-center">
                                    <svg width="26" height="26" viewBox="0 0 24 24" class="me-2">
                                        <defs>
                                            <linearGradient id="igGradient" x1="0%" y1="0%" x2="100%"
                                                y2="100%">
                                                <stop offset="0%" stop-color="#fdf497" />
                                                <stop offset="25%" stop-color="#fd5949" />
                                                <stop offset="50%" stop-color="#d6249f" />
                                                <stop offset="100%" stop-color="#285AEB" />
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#igGradient)" d="M7 2C4.243 2 2 4.243 2 7v10c0
                2.757 2.243 5 5 5h10c2.757 0 5-2.243
                5-5V7c0-2.757-2.243-5-5-5H7zm10
                2c1.654 0 3 1.346 3
                3v10c0 1.654-1.346 3-3
                3H7c-1.654 0-3-1.346-3-3V7c0-1.654
                1.346-3 3-3h10zm-5 3c-2.757 0-5
                2.243-5 5s2.243 5 5
                5 5-2.243 5-5-2.243-5-5-5zm0
                2c1.654 0 3 1.346 3
                3s-1.346 3-3 3-3-1.346-3-3
                1.346-3 3-3zm4.5-.75a1.25 1.25 0 110
                2.5 1.25 1.25 0 010-2.5z" />
                                    </svg>

                                    <a class="text-white-50 text-decoration-none" target="_blank"
                                        href="https://www.instagram.com">Instagram</a>
                                </li>


                                <li class="mb-2 d-flex align-items-center">
                                    <svg width="26" height="26" viewBox="0 0 24 24" class="me-2">
                                        <path fill="#1877F2"
                                            d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5a3.5 3.5 0 013.7-3.9c1 0 2 .1 2 .1v2.3H15c-1.2 0-1.6.8-1.6 1.6V12H18l-.5 3h-3.1v7A10 10 0 0022 12" />
                                    </svg>

                                    <a class="text-white-50 text-decoration-none" target="_blank"
                                        href="https://www.facebook.com">Facebook</a>
                                </li>


                                <li class="d-flex align-items-center">
                                    <svg width="26" height="26" viewBox="0 0 48 48" class="me-2">
                                        <!-- Cyan shadow -->
                                        <path fill="#69C9D0" d="M34.5 14.2c-2.8-1.4-5-3.7-6.4-6.5v18.2c0 5.8-4.7 10.5-10.5 10.5S7 31.7 7 25.9
                    S11.7 15.4 17.5 15.4c1 .0 2 .1 3 .4v6.7c-.9-.4-1.9-.6-3-.6c-3.6 0-6.5 2.9-6.5 6.5S13.9 35 17.5 35
                    s6.5-2.9 6.5-6.5V4h6v1.7c0 2.9 1.5 5.6 4 7.1c1.2.7 2.5 1.1 3.9 1.2v6.1c-2.1-.2-4.2-.8-6.4-1.9z" />

                                        <!-- Magenta shadow -->
                                        <path fill="#EE1D52" d="M38.4 11.9c-1.4-.1-2.7-.5-3.9-1.2c-2.5-1.5-4-4.2-4-7.1V4h-6v24.5
                    c0 3.6-2.9 6.5-6.5 6.5v6.7c5.8 0 10.5-4.7 10.5-10.5V13.8c1.4 2.8 3.6 5.1 6.4 6.5c2.1 1.1 4.3 1.7 6.4 1.9
                    v-6.1c-1.4-.1-2.7-.5-3.9-1.2z" />

                                        <!-- Main black shape -->
                                        <path fill="#010101" d="M30.7 10.4c-2.8-1.4-5-3.7-6.4-6.5V4H18v24.5c0 3.6-2.9 6.5-6.5 6.5
                    S5 32.1 5 28.5s2.9-6.5 6.5-6.5c1.1 0 2.1.2 3 .6v-6.7c-1-.3-2-.4-3-.4C5.8 15.4 1 20.2 1 25.9
                    S5.8 36.4 11.5 36.4S22 31.7 22 25.9V9c1.4 2.8 3.6 5.1 6.4 6.5c2.2 1.1 4.3 1.7 6.4 1.9v-6.1
                    c-1.4-.1-2.7-.5-3.9-1.2z" />
                                    </svg>

                                    <a class="text-white-50 text-decoration-none" target="_blank"
                                        href="https://www.tiktok.com">
                                        TikTok
                                    </a>
                                </li>






                            </ul>
                        </div>

                        {{-- Navigasi --}}
                        <div class="col-6">
                            <h5 class="fw-bold mb-3">Navigasi</h5>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2"><a href="#statistik"
                                        class="text-white-50 text-decoration-none">Statistik</a></li>
                                <li class="mb-2"><a href="#pengurus-warga"
                                        class="text-white-50 text-decoration-none">Pengurus</a></li>
                                <li><a href="#maps" class="text-white-50 text-decoration-none">Peta Lokasi</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>

            <hr class="border-secondary mt-4">

            <div class="text-center small text-white-50">
                © {{ date('Y') }} Kota Baru Keandra. All rights reserved.
            </div>

        </div>
    </footer>
@endsection
