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
                <form id="form-setting" method="POST" enctype="multipart/form-data"
                    action="{{ route('admin.setting.update') }}">
                    @csrf

                    {{-- Preview Gambar Landing Page --}}
                    <div class="text-center mb-4">
                        <p class="text-muted small mb-2">Gambar Landing Page Saat Ini</p>
                        @if ($landingPage && $landingPage->value)
                            <img id="current-image" src="{{ asset('storage/' . $landingPage->value) }}"
                                class="img-fluid rounded-4 shadow-sm mb-3" style="max-height: 350px; object-fit: cover;">
                        @else
                            <p class="text-muted mb-3">Belum ada gambar landing page.</p>
                        @endif

                        <input type="file" name="landing_page" class="form-control w-50 mx-auto" accept="image/*"
                            onchange="previewImage(event)">
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

                    <!-- MAP WRAPPER -->
                    <div class="position-relative rounded-4" style="height: 450px; overflow: hidden;">

                        <!-- MAP (TANPA BLUR) -->
                        <div id="map" class="rounded-4" style="height: 100%; pointer-events: none; opacity: 0.5;">
                        </div>

                        <!-- OVERLAY DENGAN BACKDROP BLUR -->
                        <div id="map-overlay"
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center rounded-4"
                            style="cursor: pointer; 
                                   z-index: 999;
                                   background: rgba(0, 0, 0, 0.5);
                                   backdrop-filter: blur(8px);
                                   -webkit-backdrop-filter: blur(8px);
                                   transition: opacity 0.4s ease;">
                            <h2 class="fw-bold text-white">Klik Untuk Interaksi dengan Map</h2>
                        </div>

                        <!-- CLOSE BUTTON -->
                        <button id="close-map" type="button"
                            class="btn btn-light border position-absolute top-0 end-0 m-3 rounded-circle shadow-sm"
                            style="z-index: 1000; display:none;">
                            <i class="bi bi-x-lg"></i>
                        </button>

                    </div>

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

    {{-- ============================
         LEAFLET & MAP LOGIC
         ============================ --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            /* ==================== INIT MAP ==================== */
            const map = L.map('map').setView([-6.200, 106.816], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            /* ==================== DRAW CONTROL ==================== */
            const drawnItems = new L.FeatureGroup().addTo(map);
            map.addControl(new L.Control.Draw({
                draw: {
                    polygon: true,
                    marker: false,
                    polyline: false,
                    rectangle: false,
                    circle: false
                },
                edit: {
                    featureGroup: drawnItems
                }
            }));

            // Sembunyikan semua kontrol Leaflet di awal
            document.querySelectorAll('.leaflet-control').forEach(ctrl => {
                ctrl.style.display = 'none';
            });

            /* ==================== LOAD SAVED POLYGON ==================== */
            @if ($mapPolygon && $mapPolygon->value)
                const savedPolygon = {!! $mapPolygon->value !!};
                const polygon = L.polygon(savedPolygon).addTo(drawnItems);
                map.fitBounds(polygon.getBounds());
            @endif

            /* ==================== DRAW EVENTS ==================== */
            map.on(L.Draw.Event.CREATED, e => {
                drawnItems.clearLayers();
                drawnItems.addLayer(e.layer);
                document.getElementById('map_polygon').value = JSON.stringify(e.layer.getLatLngs()[0]);
            });

            map.on(L.Draw.Event.EDITED, () => {
                drawnItems.eachLayer(layer => {
                    document.getElementById('map_polygon').value = JSON.stringify(layer
                    .getLatLngs()[0]);
                });
            });

            /* ==================== MAP INTERACTION TOGGLE ==================== */
            const overlay = document.getElementById("map-overlay");
            const mapLayer = document.getElementById("map");
            const closeBtn = document.getElementById("close-map");

            overlay.addEventListener("click", () => {
                // Aktifkan interaksi map
                mapLayer.style.pointerEvents = "auto";
                mapLayer.style.opacity = "1";

                // Sembunyikan overlay
                overlay.style.opacity = "0";
                overlay.style.pointerEvents = "none";

                // Tampilkan tombol close
                closeBtn.style.display = "block";

                // Tampilkan kontrol Leaflet (zoom & draw tools)
                document.querySelectorAll('.leaflet-control').forEach(ctrl => {
                    ctrl.style.display = 'block';
                });
            });

            closeBtn.addEventListener("click", () => {
                // Nonaktifkan interaksi map
                mapLayer.style.pointerEvents = "none";
                mapLayer.style.opacity = "0.5";

                // Tampilkan overlay
                overlay.style.opacity = "1";
                overlay.style.pointerEvents = "auto";

                // Sembunyikan tombol close
                closeBtn.style.display = "none";

                // Sembunyikan kontrol Leaflet
                document.querySelectorAll('.leaflet-control').forEach(ctrl => {
                    ctrl.style.display = 'none';
                });
            });

        });

        /* ==================== PREVIEW IMAGE ==================== */
        function previewImage(event) {
            const preview = document.getElementById('preview-image');
            const container = document.getElementById('preview-container');

            if (event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection
