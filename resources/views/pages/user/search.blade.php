<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Warga - Kota Baru Keandra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
</head>

<body>
    <div class="search-container">
        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" class="back-button">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>

        <!-- Header -->
        <div class="search-header">
            <h1><i class="bi bi-search"></i> Pencarian Warga</h1>
            <p>Temukan informasi penghuni Kota Baru Keandra dengan mudah</p>
        </div>

        <!-- Search Box -->
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Ketik nama warga untuk mencari..." autocomplete="off">
        </div>

        <!-- ⭐ NEW: Filter Section -->
        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="filterCluster">📍 Pilih Cluster</label>
                    <select id="filterCluster" class="form-select">
                        <option value="">-- Semua Cluster --</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filterBlok">🧱 Pilih Blok</label>
                    <select id="filterBlok" class="form-select" disabled>
                        <option value="">-- Pilih Cluster Dulu --</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filterRumah">🏠 Pilih Nomor Rumah</label>
                    <select id="filterRumah" class="form-select" disabled>
                        <option value="">-- Pilih Blok Dulu --</option>
                    </select>
                </div>
            </div>

            <button class="btn-reset" onclick="resetFilters()">
                <i class="bi bi-arrow-clockwise"></i> Reset Filter
            </button>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="loading" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Mencari data...</p>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="empty-state">
            <i class="bi bi-person-circle"></i>
            <h3>Mulai Pencarian</h3>
            <p>Gunakan pencarian atau filter untuk menemukan warga</p>
        </div>

        <!-- No Results -->
        <div id="noResults" class="empty-state" style="display: none;">
            <i class="bi bi-inbox"></i>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan warga dengan kriteria tersebut</p>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer"></div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-badge"></i> Detail Penghuni</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const searchInput = document.getElementById('searchInput');
        const filterCluster = document.getElementById('filterCluster');
        const filterBlok = document.getElementById('filterBlok');
        const filterRumah = document.getElementById('filterRumah');
        const resultsContainer = document.getElementById('resultsContainer');
        const emptyState = document.getElementById('emptyState');
        const noResults = document.getElementById('noResults');
        const loadingState = document.getElementById('loadingState');
        let searchTimeout;

        // Load clusters on page load
        loadClusters();

        // Search input handler
        searchInput.addEventListener('input', function() {
            performSearch();
        });

        // Filter change handlers
        filterCluster.addEventListener('change', function() {
            const clusterId = this.value;

            // Reset dependent filters
            filterBlok.innerHTML = '<option value="">-- Pilih Blok --</option>';
            filterBlok.disabled = !clusterId;
            filterRumah.innerHTML = '<option value="">-- Pilih Blok Dulu --</option>';
            filterRumah.disabled = true;

            if (clusterId) {
                loadBlokByCluster(clusterId);
            }

            performSearch();
        });

        filterBlok.addEventListener('change', function() {
            const blokId = this.value;
            const clusterId = filterCluster.value;

            // Reset rumah filter
            filterRumah.innerHTML = '<option value="">-- Pilih Nomor Rumah --</option>';
            filterRumah.disabled = !blokId;

            if (clusterId && blokId) {
                loadRumahByFilter(clusterId, blokId);
            }

            performSearch();
        });

        filterRumah.addEventListener('change', function() {
            performSearch();
        });

        // Load clusters
        function loadClusters() {
            fetch('/api/clusters')
                .then(response => response.json())
                .then(data => {
                    filterCluster.innerHTML = '<option value="">-- Semua Cluster --</option>';
                    data.forEach(cluster => {
                        filterCluster.innerHTML += `<option value="${cluster.id}">${cluster.nama}</option>`;
                    });
                })
                .catch(error => console.error('Error loading clusters:', error));
        }

        // Load blok by cluster
        function loadBlokByCluster(clusterId) {
            fetch(`/api/blok-by-cluster/${clusterId}`)
                .then(response => response.json())
                .then(data => {
                    filterBlok.innerHTML = '<option value="">-- Semua Blok --</option>';
                    data.forEach(blok => {
                        filterBlok.innerHTML += `<option value="${blok.id}">${blok.nama}</option>`;
                    });
                })
                .catch(error => console.error('Error loading blok:', error));
        }

        // Load rumah by filter
        function loadRumahByFilter(clusterId, blokId) {
            fetch(`/api/rumah-by-filter?cluster=${clusterId}&blok=${blokId}`)
                .then(response => response.json())
                .then(data => {
                    filterRumah.innerHTML = '<option value="">-- Semua Rumah --</option>';
                    data.forEach(rumah => {
                        filterRumah.innerHTML +=
                            `<option value="${rumah.id}">${rumah.nomor} - ${rumah.alamat}</option>`;
                    });
                })
                .catch(error => console.error('Error loading rumah:', error));
        }

        // Perform search with filters
        function performSearch() {
            clearTimeout(searchTimeout);

            const query = searchInput.value.trim();
            const cluster = filterCluster.value;
            const blok = filterBlok.value;
            const rumah = filterRumah.value;

            // If no search query and no filters, show empty state
            if (!query && !cluster && !blok && !rumah) {
                showEmptyState();
                return;
            }

            showLoading();

            searchTimeout = setTimeout(() => {
                const params = new URLSearchParams();
                if (query) params.append('q', query);
                if (cluster) params.append('cluster', cluster);
                if (blok) params.append('blok', blok);
                if (rumah) params.append('rumah', rumah);

                fetch(`/api/search-warga?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.length === 0) {
                            showNoResults();
                        } else {
                            displayResults(data);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        hideLoading();
                        showNoResults();
                    });
            }, 500);
        }

        // Reset all filters
        function resetFilters() {
            searchInput.value = '';
            filterCluster.value = '';
            filterBlok.innerHTML = '<option value="">-- Pilih Cluster Dulu --</option>';
            filterBlok.disabled = true;
            filterRumah.innerHTML = '<option value="">-- Pilih Blok Dulu --</option>';
            filterRumah.disabled = true;
            showEmptyState();
        }

        function showLoading() {
            emptyState.style.display = 'none';
            noResults.style.display = 'none';
            resultsContainer.innerHTML = '';
            loadingState.style.display = 'block';
        }

        function hideLoading() {
            loadingState.style.display = 'none';
        }

        function showEmptyState() {
            resultsContainer.innerHTML = '';
            noResults.style.display = 'none';
            loadingState.style.display = 'none';
            emptyState.style.display = 'block';
        }

        function showNoResults() {
            resultsContainer.innerHTML = '';
            emptyState.style.display = 'none';
            loadingState.style.display = 'none';
            noResults.style.display = 'block';
        }

        function displayResults(results) {
            emptyState.style.display = 'none';
            noResults.style.display = 'none';

            resultsContainer.innerHTML = results.map(result => `
            <div class="result-card" onclick="showDetail(${result.id})">
                <div class="result-wrapper">
                    <img src="${result.foto_rumah}" alt="Foto Rumah" class="house-photo-result">

                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                            <img src="${result.foto}" class="result-avatar" alt="${result.nama_warga}">
                            <h4 class="result-name">${result.nama_warga}</h4>
                        </div>

                        <div class="result-info">
                            <i class="bi bi-house-door"></i> ${result.alamat}
                        </div>

                        <div class="result-info">
                            <i class="bi bi-geo-alt"></i> 
                            Cluster ${result.cluster} - Blok ${result.blok} (RT ${result.rt})
                        </div>
                    </div>
                </div>
            </div>
            `).join('');
        }
    </script>
</body>

</html>
