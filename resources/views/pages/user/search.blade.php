<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Warga - Kota Baru Keandra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    
    <style>
        /* Tambahan styling untuk filter */
        .search-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .search-filters select,
        .search-filters input {
            width: auto;
        }

        .result-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .result-wrapper {
            display: flex;
            gap: 12px;
        }

        .result-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .house-photo-result {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 12px;
        }

        .result-info {
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="search-container">
        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" class="back-button mb-3 d-inline-block">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
        </a>

        <!-- Header -->
        <div class="search-header mb-3">
            <h1><i class="bi bi-search"></i> Pencarian Warga</h1>
            <p>Temukan informasi penghuni Kota Baru Keandra dengan mudah</p>
        </div>

        <!-- Search + Filters -->
<div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
    <!-- Search Box -->
    <div class="search-box flex-grow-1">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Ketik nama warga..." autocomplete="off">
    </div>

    <!-- Filters (sekarang di samping) -->
    <div class="d-flex gap-2 flex-wrap">
        <select id="filterCluster" class="form-select">
            <option value="">Cluster</option>
            @foreach($clusters as $cluster)
                <option value="{{ $cluster->nama_cluster }}">{{ $cluster->nama_cluster }}</option>
            @endforeach
        </select>

        <select id="filterBlok" class="form-select">
            <option value="">Blok</option>
            @foreach(range('A', 'Z') as $letter)
                <option value="{{ $letter }}">{{ $letter }}</option>
            @endforeach
        </select>

        <input type="number" id="filterNomor" class="form-control" placeholder="Nomor Rumah">
    </div>
</div>


        <!-- Loading State -->
        <div id="loadingState" class="loading text-center" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Mencari data...</p>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="empty-state text-center">
            <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
            <h3>Mulai Pencarian</h3>
            <p>Masukkan nama warga atau filter rumah yang ingin Anda cari</p>
        </div>

        <!-- No Results -->
        <div id="noResults" class="empty-state text-center" style="display: none;">
            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan warga atau rumah dengan kriteria tersebut</p>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const searchInput = document.getElementById('searchInput');
        const filterCluster = document.getElementById('filterCluster');
        const filterBlok = document.getElementById('filterBlok');
        const filterNomor = document.getElementById('filterNomor');

        const resultsContainer = document.getElementById('resultsContainer');
        const emptyState = document.getElementById('emptyState');
        const noResults = document.getElementById('noResults');
        const loadingState = document.getElementById('loadingState');

        let searchTimeout;

        function performSearch() {
            clearTimeout(searchTimeout);

            const query = searchInput.value.trim();
            const cluster = filterCluster.value;
            const blok = filterBlok.value;
            const nomor = filterNomor.value.trim();

            if (!query && !cluster && !blok && !nomor) {
                showEmptyState();
                return;
            }

            showLoading();

            searchTimeout = setTimeout(() => {
                const params = new URLSearchParams();
                if (query) params.append('q', query);
                if (cluster) params.append('cluster', cluster);
                if (blok) params.append('blok', blok);
                if (nomor) params.append('nomor', nomor);

                fetch(`/api/search-warga?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        hideLoading();
                        if (data.length === 0) showNoResults();
                        else displayResults(data);
                    })
                    .catch(err => {
                        console.error(err);
                        hideLoading();
                        showNoResults();
                    });
            }, 400); // debounce
        }

        // Event listeners
        searchInput.addEventListener('input', performSearch);
        filterCluster.addEventListener('change', performSearch);
        filterBlok.addEventListener('change', performSearch);
        filterNomor.addEventListener('input', performSearch);

        function showLoading() {
            emptyState.style.display = 'none';
            noResults.style.display = 'none';
            resultsContainer.innerHTML = '';
            loadingState.style.display = 'block';
        }

        function hideLoading() { loadingState.style.display = 'none'; }
        function showEmptyState() { resultsContainer.innerHTML = ''; noResults.style.display = 'none'; loadingState.style.display = 'none'; emptyState.style.display = 'block'; }
        function showNoResults() { resultsContainer.innerHTML = ''; emptyState.style.display = 'none'; loadingState.style.display = 'none'; noResults.style.display = 'block'; }

        function displayResults(results) {
            emptyState.style.display = 'none';
            noResults.style.display = 'none';

            resultsContainer.innerHTML = results.map(r => `
                <div class="result-card">
                    <div class="result-wrapper">
                        <img src="${r.foto_rumah}" alt="Foto Rumah" class="house-photo-result">
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                                <img src="${r.foto}" class="result-avatar" alt="${r.nama_warga}">
                                <h4 class="result-name">${r.nama_warga}</h4>
                            </div>
                            <div class="result-info"><i class="bi bi-house-door"></i> ${r.alamat}</div>
                            <div class="result-info"><i class="bi bi-geo-alt"></i> Cluster ${r.cluster} - Blok ${r.blok} (RT ${r.rt})</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    </script>
</body>
</html>
