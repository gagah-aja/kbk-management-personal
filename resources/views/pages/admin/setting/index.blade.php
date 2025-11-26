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

                {{-- Polygon Map --}}
                <h5 class="fw-bold mb-3">Atur Wilayah Kota (Polygon Peta)</h5>
                <p class="text-muted small">Klik & gambar polygon sesuai batas wilayah.</p>

                <div id="map" style="height: 450px; border-radius: 12px; overflow: hidden;"></div>
                <textarea name="map_polygon" id="map_polygon" hidden>{{ $mapPolygon ? $mapPolygon->value : '' }}</textarea>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Simpan Setting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Style --}}
<style>
.text-gradient {
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

{{-- Leaflet + Draw --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<script>
    // Preview gambar landing page
    function previewImage(event) {
        const preview = document.getElementById('preview-image');
        const container = document.getElementById('preview-container');
        preview.src = URL.createObjectURL(event.target.files[0]);
        container.style.display = 'block';
    }

    // ================================
    // Leaflet Map & Polygon
    // ================================
    const map = L.map('map').setView([-6.200, 106.816], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    let drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    const drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            marker: false,
            circle: false,
            polyline: false,
            rectangle: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);

    // Tampilkan polygon dari database jika ada
    @if($mapPolygon && $mapPolygon->value)
        const savedPolygon = {!! $mapPolygon->value !!};
        const polygon = L.polygon(savedPolygon).addTo(drawnItems);
        map.fitBounds(polygon.getBounds());
    @endif

    // Event saat polygon dibuat
    map.on(L.Draw.Event.CREATED, function(e) {
        drawnItems.clearLayers(); // hanya satu polygon
        const layer = e.layer;
        drawnItems.addLayer(layer);

        document.getElementById('map_polygon').value = JSON.stringify(layer.getLatLngs()[0]);
    });

    // Event saat polygon diedit
    map.on(L.Draw.Event.EDITED, function() {
        drawnItems.eachLayer(function(layer) {
            document.getElementById('map_polygon').value = JSON.stringify(layer.getLatLngs()[0]);
        });
    });

</script>
@endsection
