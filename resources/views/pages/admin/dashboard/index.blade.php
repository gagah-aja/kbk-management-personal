@extends('layouts.admin.admin')
@section('content')
<style>
    /* Page Header */
    .page-header {
        margin-bottom: 40px;
        animation: fadeInDown 0.6s ease;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 32px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }
    
    .page-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: white;
        margin-bottom: 8px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        letter-spacing: -0.5px;
    }
    
    .page-header p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 500;
        margin: 0;
    }
    
    /* Stats Cards */
    .stats-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 24px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease backwards;
        height: 100%;
    }
    
    .stats-card:nth-child(1) { animation-delay: 0.1s; }
    .stats-card:nth-child(2) { animation-delay: 0.2s; }
    .stats-card:nth-child(3) { animation-delay: 0.3s; }
    .stats-card:nth-child(4) { animation-delay: 0.4s; }
    .stats-card:nth-child(5) { animation-delay: 0.5s; }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
    }
    
    .stats-card:hover::before {
        opacity: 1;
    }
    
    .card-icon-wrapper {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 1;
        flex-shrink: 0;
    }
    
    .stats-card:hover .card-icon-wrapper {
        transform: scale(1.15) rotate(8deg);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    /* Gradient Backgrounds for Icons */
    .bg-gradient-blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
    }
    
    .bg-gradient-green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 8px 16px rgba(17, 153, 142, 0.3);
    }
    
    .bg-gradient-purple {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #764ba2;
        box-shadow: 0 8px 16px rgba(168, 237, 234, 0.4);
    }
    
    .bg-gradient-orange {
        background: linear-gradient(135deg, #ff9a56 0%, #ffce54 100%);
        color: white;
        box-shadow: 0 8px 16px rgba(255, 154, 86, 0.3);
    }

    .bg-gradient-red {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        box-shadow: 0 8px 16px rgba(245, 87, 108, 0.3);
    }
    
    .stats-card .card-content {
        position: relative;
        z-index: 1;
    }
    
    .stats-card small {
        font-size: 13px;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: block;
        margin-bottom: 10px;
    }
    
    .stats-card h4 {
        font-size: 34px;
        font-weight: 900;
        color: #333;
        margin: 0;
        line-height: 1;
    }
    
    /* Quick Actions */
    .quick-actions-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        margin-bottom: 24px;
        animation: fadeInUp 0.6s ease backwards;
        animation-delay: 0.6s;
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #333;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 3px solid #f0f0f0;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        padding: 18px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        border: none;
        width: 100%;
        margin-bottom: 12px;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .action-btn i {
        font-size: 20px;
        margin-right: 12px;
    }

    .action-btn.btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
    }

    .action-btn.btn-success:hover {
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
    }

    .action-btn.btn-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
    }

    .action-btn.btn-info:hover {
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    }

    .action-btn.btn-warning {
        background: linear-gradient(135deg, #ff9a56 0%, #ffce54 100%);
        box-shadow: 0 4px 15px rgba(255, 154, 86, 0.3);
    }

    .action-btn.btn-warning:hover {
        box-shadow: 0 8px 25px rgba(255, 154, 86, 0.4);
    }

    /* Info Cards */
    .info-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        margin-bottom: 24px;
        animation: fadeInUp 0.6s ease backwards;
        animation-delay: 0.7s;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 16px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .info-content h6 {
        font-size: 14px;
        color: #888;
        margin: 0 0 4px 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-content p {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Card Shine Effect */
    .stats-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            to bottom right,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.1) 50%,
            rgba(255, 255, 255, 0) 100%
        );
        transform: rotate(45deg);
        transition: all 0.6s ease;
        opacity: 0;
    }
    
    .stats-card:hover::after {
        opacity: 1;
        left: 100%;
    }

    /* Welcome Alert */
    .welcome-alert {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 16px;
        padding: 24px 28px;
        color: white;
        margin-bottom: 32px;
        animation: fadeInDown 0.6s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .welcome-alert h5 {
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 20px;
    }

    .welcome-alert p {
        margin: 0;
        opacity: 0.95;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 28px;
        }
        
        .stats-card {
            padding: 24px;
        }
        
        .card-icon-wrapper {
            width: 56px;
            height: 56px;
            font-size: 24px;
        }
        
        .stats-card h4 {
            font-size: 28px;
        }

        .action-btn {
            padding: 14px 20px;
            font-size: 14px;
        }
    }
</style>

<div class="container-fluid py-4">
    {{-- <!-- Welcome Alert -->
    <div class="alert welcome-alert" role="alert">
        <h5><i class="bi bi-stars me-2"></i>Selamat Datang di Dashboard Admin</h5>
        <p>Kelola data warga, rumah, dan wilayah RT/RW dengan mudah</p>
    </div> --}}

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