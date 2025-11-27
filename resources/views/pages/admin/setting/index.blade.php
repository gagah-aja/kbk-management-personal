@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-gradient">Halaman Setting</h2>
        <p class="text-muted">Atur landing page & batas wilayah kota</p>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card Setting --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 980px;">
        <div class="card-header text-white text-center py-3"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 fw-semibold">Landing Page & Peta Wilayah</h5>
        </div>

        <div class="card-body p-4 bg-light">
            <form id="form-setting" method="POST" enctype="multipart/form-data" action="{{ route('admin.setting.update') }}">
                @csrf

                {{-- Preview Gambar Landing Page --}}
                <div class="text-center mb-4">
                    <p class="text-muted small mb-2">Gambar Landing Page Saat Ini</p>
                    @if ($landingPage && $landingPage->value)
                        <img id="current-image" src="{{ asset('storage/' . $landingPage->value) }}"
                             class="img-fluid rounded-4 shadow-sm mb-3"
                             style="max-height: 350px; object-fit: cover;">
                    @else
                        <p class="text-muted mb-3">Belum ada gambar landing page.</p>
                    @endif

                    <input type="file" name="landing_page" class="form-control w-50 mx-auto"
                           accept="image/*" onchange="previewImage(event)">
                </div>

                {{-- Preview Image Baru --}}
                <div id="preview-container" class="text-center" style="display:none;">
                    <p class="text-muted small">Preview Gambar Baru:</p>
                    <img id="preview-image" class="img-fluid rounded shadow-sm" style="max-height:300px;">
                </div>

                <hr class="my-4">

                {{-- ============================
      POLYGON MAP SECTION
============================ --}}
<h5 class="fw-bold mb-3">Atur Wilayah Kota (Polygon Peta)</h5>
<p class="text-muted small">Klik & gambar polygon sesuai batas wilayah.</p>

<div class="position-relative">

    {{-- MAP --}}
    <div id="map" class="map-area blur"></div>

    {{-- OVERLAY INFO --}}
    <div id="map-overlay" class="map-overlay">
        <span>Klik untuk interaksi dengan peta</span>
    </div>

    {{-- CLOSE BUTTON --}}
    <button id="close-map" type="button" class="close-map d-none">✖</button>
</div>

<textarea name="map_polygon" id="map_polygon" hidden>{{ $mapPolygon? $mapPolygon->value : '' }}</textarea>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save"></i> Simpan Setting
    </button>
</div>

{{-- ============================
      STYLE
============================ --}}
<style>
    .map-area {
        height: 450px;
        border-radius: 12px;
        overflow: hidden;
        transition: filter .35s ease;
    }

    .map-area.blur {
        filter: blur(4px);
        pointer-events: none;
    }

    .map-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.15rem;
        color: #fff;
        border-radius: 12px;
        z-index: 10;
        cursor: pointer;
        backdrop-filter: blur(2px);
    }

.close-map {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 20;
    padding: 6px 14px;
    background: rgba(0,0,0,1);   /* background solid hitam */
    color: #fff;                  /* warna font putih tebal */
    border: none;
    border-radius: 10px;
    font-size: 1.8rem;            /* lebih besar */
    font-weight: 1000;            /* super tebal */
    line-height: 1;
    cursor: pointer;
    text-shadow: 1px 1px 2px #000; /* shadow tipis agar lebih kontras */
    transition: 0.3s ease;
}

.close-map:hover {
    background: rgba(0,0,0,0.95);
    transform: scale(1.15);
}
</style>

{{-- ============================
      LEAFLET & MAP LOGIC
============================ --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
    const map = L.map('map').setView([-6.200, 106.816], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

    const drawnItems = new L.FeatureGroup().addTo(map);
    map.addControl(new L.Control.Draw({
        draw: { polygon: true, marker: false, polyline: false, rectangle: false, circle: false },
        edit: { featureGroup: drawnItems }
    }));

    @if($mapPolygon && $mapPolygon->value)
        const savedPolygon = {!! $mapPolygon->value !!};
        const polygon = L.polygon(savedPolygon).addTo(drawnItems);
        map.fitBounds(polygon.getBounds());
    @endif

    map.on(L.Draw.Event.CREATED, e => {
        drawnItems.clearLayers();
        drawnItems.addLayer(e.layer);
        map_polygon.value = JSON.stringify(e.layer.getLatLngs()[0]);
    });

    map.on(L.Draw.Event.EDITED, () => {
        drawnItems.eachLayer(layer => {
            map_polygon.value = JSON.stringify(layer.getLatLngs()[0]);
        });
    });

    // Overlay and close interactions
    const overlay = document.getElementById("map-overlay");
    const mapDiv = document.getElementById("map");
    const closeBtn = document.getElementById("close-map");

    overlay.addEventListener("click", () => {
        mapDiv.classList.remove("blur");
        overlay.classList.add("d-none");
        closeBtn.classList.remove("d-none");
    });

    closeBtn.addEventListener("click", () => {
        mapDiv.classList.add("blur");
        overlay.classList.remove("d-none");
        closeBtn.classList.add("d-none");
    });
</script>


@endsection
