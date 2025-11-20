@extends('layouts.admin.admin')
@section('content')

    <head>
        <!-- CSS lainnya -->
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    </head>

    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="bi bi-stars me-2"></i>Selamat Datang di Dashboard Admin</h2>
            <p>Kelola data warga, rumah, dan wilayah RT/RW dengan mudah</p>
        </div>

        <!-- Stats Cards Row -->
        <div class="row mb-4">
            <!-- Total Warga -->
            <div class="col-xl col-lg-4 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-gradient-blue me-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="card-content">
                            <small>Total Warga</small>
                            <h4>{{ $totalWarga }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Rumah -->
            <div class="col-xl col-lg-4 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-gradient-green me-3">
                            <i class="bi bi-house-door-fill"></i>
                        </div>
                        <div class="card-content">
                            <small>Total Rumah</small>
                            <h4>{{ $totalRumah }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total RT -->
            <div class="col-xl col-lg-4 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-gradient-purple me-3">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <div class="card-content">
                            <small>Total RT</small>
                            <h4>{{ $totalRt }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total RW -->
            <div class="col-xl col-lg-4 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-gradient-orange me-3">
                            <i class="bi bi-pin-map-fill"></i>
                        </div>
                        <div class="card-content">
                            <small>Total RW</small>
                            <h4>{{ $totalRw }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Cluster -->
            <div class="col-xl col-lg-4 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-gradient-red me-3">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="card-content">
                            <small>Total Cluster</small>
                            <h4>{{ $totalCluster }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & System Info -->
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-lg-6 mb-4">
                <div class="quick-actions-card">
                    <div class="section-title">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Aksi Cepat
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('admin.warga.create') }}" class="action-btn">
                                <i class="bi bi-person-plus-fill"></i>
                                Tambah Warga
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.rumah.create') }}" class="action-btn btn-success">
                                <i class="bi bi-house-add-fill"></i>
                                Tambah Rumah
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.rt.index') }}" class="action-btn btn-info">
                                <i class="bi bi-diagram-2-fill"></i>
                                Kelola RT
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.cluster.index') }}" class="action-btn btn-warning">
                                <i class="bi bi-collection-fill"></i>
                                Kelola Cluster
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="col-lg-6 mb-4">
                <div class="info-card">
                    <div class="section-title">
                        <i class="bi bi-info-circle-fill me-2"></i>Informasi Sistem
                    </div>

                    <div class="info-item">
                        <div class="info-icon bg-gradient-blue">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div class="info-content">
                            <h6>Tanggal Hari Ini</h6>
                            <p>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon bg-gradient-green">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div class="info-content">
                            <h6>Waktu Sekarang</h6>
                            <p id="current-time">{{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon bg-gradient-purple">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div class="info-content">
                            <h6>Login Sebagai</h6>
                            <p>Administrator</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon bg-gradient-orange">
                            <i class="bi bi-database-fill"></i>
                        </div>
                        <div class="info-content">
                            <h6>Total Data Tersimpan</h6>
                            <p>{{ $totalWarga + $totalRumah + $totalRt + $totalRw + $totalCluster }} Records</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update current time every second
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds} WIB`;
        }

        setInterval(updateTime, 1000);
    </script>
@endsection
