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

        <!-- Loading State -->
        <div id="loadingState" class="loading" style="display: none;">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Mencari data...</p>
        </div>

        <!-- Empty State (Default) -->
        <div id="emptyState" class="empty-state">
            <i class="bi bi-person-circle"></i>
            <h3>Mulai Pencarian</h3>
            <p>Masukkan nama warga yang ingin Anda cari</p>
        </div>

        <!-- No Results -->
        <div id="noResults" class="empty-state" style="display: none;">
            <i class="bi bi-inbox"></i>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan warga dengan nama tersebut</p>
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
        const resultsContainer = document.getElementById('resultsContainer');
        const emptyState = document.getElementById('emptyState');
        const noResults = document.getElementById('noResults');
        const loadingState = document.getElementById('loadingState');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length === 0) {
                showEmptyState();
                return;
            }

            if (query.length < 2) {
                return;
            }

            showLoading();

            searchTimeout = setTimeout(() => {
                fetch(`/api/search-warga?q=${encodeURIComponent(query)}`)
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
        });

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
                    <img 
                        src="${result.foto_rumah}" 
                        alt="Foto Rumah"
                        class="house-photo-result"
                    >

                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                            <img 
                                src="${result.foto}" 
                                class="result-avatar"
                                alt="${result.nama_warga}"
                            >
                            <h4 class="result-name">${result.nama_warga}</h4>
                        </div>

                        <div class="result-info">
                            <i class="bi bi-house-door"></i> ${result.alamat}
                        </div>

                        <div class="result-info">
                            <i class="bi bi-geo-alt"></i> 
                            Cluster ${result.cluster} - Blok ${result.blok} (RT ${result.rt})
                        </div>

                        <div>
                            <span class="result-badge ${result.tipe_penghuni === 'Pemilik' ? 'badge-pemilik' : 'badge-penyewa'}">
                                ${result.tipe_penghuni}
                            </span>
                            <span class="result-badge badge-kk">
                                ${result.status_penghuni}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            `).join('');
        }

        function showDetail(id) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const modalBody = document.getElementById('modalBody');

            modalBody.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Memuat detail...</p>
                </div>
            `;

            modal.show();

            fetch(`/api/detail-penghuni/${id}`)
                .then(response => response.json())
                .then(data => {
                    modalBody.innerHTML = `
                        <div class="text-center mb-4">
                            <img src="${data.foto}" alt="${data.nama_warga}" class="detail-avatar">
                            <h4 class="mt-2 mb-0 fw-bold">${data.nama_warga}</h4>
                            <p class="text-muted mb-0">${data.nik}</p>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="detail-label">📧 Email</div>
                                <div class="detail-value">${data.email || '-'}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">📱 No. Telepon</div>
                                <div class="detail-value">${data.no_telp || '-'}</div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="detail-label">👤 Jenis Kelamin</div>
                                <div class="detail-value">${data.jenis_kelamin}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">🎂 Tanggal Lahir</div>
                                <div class="detail-value">${data.tanggal_lahir}</div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="detail-label">🕌 Agama</div>
                                <div class="detail-value">${data.agama}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">💼 Pekerjaan</div>
                                <div class="detail-value">${data.pekerjaan || '-'}</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">🎓 Pendidikan Terakhir</div>
                            <div class="detail-value">${data.pendidikan || '-'}</div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3 fw-bold"><i class="bi bi-house-fill"></i> Informasi Rumah</h5>

                        <div class="mb-3">
                            <div class="detail-label">🏠 Alamat Lengkap</div>
                            <div class="detail-value">${data.alamat}</div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="detail-label">🏘️ Cluster</div>
                                <div class="detail-value">${data.cluster}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">📍 Blok</div>
                                <div class="detail-value">${data.blok}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">🏘️ RT</div>
                                <div class="detail-value">${data.rt}</div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="detail-label">📅 Tanggal Masuk</div>
                            <div class="detail-value">${data.tanggal_masuk}</div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> Gagal memuat detail. Silakan coba lagi.
                        </div>
                    `;
                });
        }
    </script>
</body>

</html>