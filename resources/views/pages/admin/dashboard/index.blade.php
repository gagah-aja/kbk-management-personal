@extends('layouts.admin.admin')
@section('content')
<style>
    /* Page Header */
    .page-header {
        margin-bottom: 40px;
        animation: fadeInDown 0.6s ease;
    }
    
    .page-header h2 {
        font-size: 36px;
        font-weight: 800;
        color: white;
        margin-bottom: 8px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
    
    /* Chart Cards */
    .chart-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 36px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        margin-bottom: 24px;
        animation: fadeInUp 0.6s ease backwards;
        animation-delay: 0.5s;
        transition: all 0.3s ease;
    }
    
    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
    }
    
    .chart-title {
        font-size: 22px;
        font-weight: 700;
        color: #333;
        margin-bottom: 28px;
        padding-bottom: 16px;
        border-bottom: 3px solid #f0f0f0;
        position: relative;
    }
    
    .chart-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
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
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Statistik dan Data Warga RT</p>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <!-- Total Rumah -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex align-items-start">
                    <div class="card-icon-wrapper bg-gradient-blue me-3">
                        <i class="bi bi-houses-fill"></i>
                    </div>
                    <div class="card-content">
                        <small>Total Rumah</small>
                        <h4>{{ $totalRumah }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total RT & RW -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex align-items-start">
                    <div class="card-icon-wrapper bg-gradient-green me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="card-content">
                        <small>Total RT & RW</small>
                        <h4>{{ $totalRt }} & {{ $totalRw }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cluster -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex align-items-start">
                    <div class="card-icon-wrapper bg-gradient-purple me-3">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div class="card-content">
                        <small>Total Cluster</small>
                        <h4>{{ $totalCluster }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Warga -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex align-items-start">
                    <div class="card-icon-wrapper bg-gradient-orange me-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="card-content">
                        <small>Total Warga</small>
                        <h4>{{ $totalWarga }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section (Optional - Uncomment if needed) -->
    {{-- 
    <div class="row">
        <!-- Gender Distribution Chart -->
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-title">Distribusi Jenis Kelamin</div>
                
                <div class="d-flex justify-content-center mb-3 text-center">
                    <span class="fw-bold me-4" style="color: #667eea;">
                        <i class="bi bi-circle-fill me-1"></i> Laki-laki 41%
                    </span>
                    <span class="fw-bold" style="color: #f5576c;">
                        <i class="bi bi-circle-fill me-1"></i> Perempuan 59%
                    </span>
                </div>

                <div class="text-center">
                    <canvas id="genderChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Age Distribution Chart -->
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-title">Distribusi Kelompok Umur</div>
                
                <div>
                    <canvas id="ageChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gender Distribution Chart
        const genderCtx = document.getElementById('genderChart');
        if (genderCtx) {
            new Chart(genderCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [41, 59],
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.85)',
                            'rgba(245, 87, 108, 0.85)'
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 14,
                                    weight: '600',
                                    family: "'Inter', sans-serif"
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Age Distribution Chart
        const ageCtx = document.getElementById('ageChart');
        if (ageCtx) {
            new Chart(ageCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['18-34', '35-59', '5-17', '60+'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [2, 7, 7, 1],
                        backgroundColor: 'rgba(102, 126, 234, 0.85)',
                        borderRadius: 12,
                        borderSkipped: false,
                        hoverBackgroundColor: 'rgba(118, 75, 162, 0.85)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
    --}}
</div>
@endsection