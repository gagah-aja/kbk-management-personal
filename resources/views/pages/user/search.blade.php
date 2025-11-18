<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pencarian Warga - Kota Baru Keandra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .search-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .search-header {
            text-align: center;
            color: #2d3748;
            margin-bottom: 3rem;
        }

        .search-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1a202c;
        }

        .search-header p {
            font-size: 1.1rem;
            color: #4a5568;
        }

        .search-box {
            background: white;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }

        .search-box:focus-within {
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
            border-color: #667eea;
        }

        .search-box input {
            border: none;
            outline: none;
            flex: 1;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
        }

        .search-box i {
            color: #667eea;
            font-size: 1.5rem;
        }

        .result-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .result-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #667eea;
        }

        .result-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }

        .result-info {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .result-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-top: 0.5rem;
        }

        .badge-pemilik {
            background: #c6f6d5;
            color: #22543d;
        }

        .badge-penyewa {
            background: #bee3f8;
            color: #2c5282;
        }

        .badge-kk {
            background: #feebc8;
            color: #7c2d12;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #4a5568;
        }

        .empty-state i {
            font-size: 4rem;
            opacity: 0.3;
            margin-bottom: 1rem;
            color: #a0aec0;
        }

        .loading {
            text-align: center;
            padding: 2rem;
            color: #4a5568;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .back-button {
            display: inline-block;
            color: #4a5568;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            color: #667eea;
            transform: translateX(-5px);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem 2rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .detail-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #667eea;
            margin-bottom: 1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #2d3748;
            margin-bottom: 0;
            padding: 0.75rem 1rem;
            background: #f7fafc;
            border-radius: 8px;
            border-left: 3px solid #667eea;
            font-size: 1rem;
        }

        .modal-body .row {
            margin-bottom: 0;
        }

        .modal-body hr {
            border-color: #e2e8f0;
            opacity: 1;
        }

        .modal-body h5 {
            color: #2d3748;
        }

        .empty-state h3 {
            color: #2d3748;
        }

        .empty-state p {
            color: #718096;
        }
            .search-header h1 {
                font-size: 2rem;
            }
            
            .result-avatar {
                width: 60px;
                height: 60px;
            }
            
            .result-name {
                font-size: 1.1rem;
            }
        }
    </style>
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
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Ketik nama warga untuk mencari..."
                autocomplete="off"
            >
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

        // Live Search
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

            // Show loading
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
            }, 500); // Debounce 500ms
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
                    <div class="d-flex">
                        <img src="${result.foto}" alt="${result.nama_warga}" class="result-avatar me-3">
                        <div class="flex-grow-1">
                            <div class="result-name">${result.nama_warga}</div>
                            <div class="result-info">
                                <i class="bi bi-house-door"></i> ${result.alamat}
                            </div>
                            <div class="result-info">
                                <i class="bi bi-geo-alt"></i> Cluster ${result.cluster} - Blok ${result.blok} (RT ${result.rt})
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

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="detail-label">👥 Status Penghuni</div>
                                <div class="detail-value">
                                    <span class="badge bg-warning text-dark">${data.status_penghuni}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">🏠 Tipe Penghuni</div>
                                <div class="detail-value">
                                    <span class="badge ${data.tipe_penghuni === 'Pemilik' ? 'bg-success' : 'bg-info'}">${data.tipe_penghuni}</span>
                                </div>
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