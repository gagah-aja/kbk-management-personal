@extends('layouts.admin.admin')
@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-0">Dashboard</h2>
        <p class="text-secondary mb-4">Statistik dan Data Warga RT</p>

        <div class="row mb-4">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 h-100 p-3">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-blue-light me-3">
                            <i class="bi bi-houses"></i>
                        </div>
                        <div>
                            <small class="text-secondary d-block">Total Rumah</small>
                            <h4 class="bi-bold mb-0">{{ $totalRumah }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 h-100 p-3">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-green-light me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <small class="text-secondary d-block">Total Rt & Rw</small>
                            <h4 class="bi-bold mb-0">{{ $totalRt }} & {{ $totalRw }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 h-100 p-3">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-purple-light me-3">
                            <i class="bi bi-house"></i>
                        </div>
                        <div>
                            <small class="text-secondary d-block">Total cluster</small>
                            <h4 class="fw-bold mb-0">{{ $totalCluster }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 h-100 p-3">
                    <div class="d-flex align-items-start">
                        <div class="card-icon-wrapper bg-purple-light me-3">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <small class="text-secondary d-block">Total warga</small>
                            <h4 class="fw-bold mb-0">{{ $totalWarga }}</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- <div class="row">

            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100 p-4">
                    <div class="chart-title">Distribusi Jenis Kelamin</div>

                    <div class="d-flex justify-content-center mb-3 text-center">
                        <span class="text-primary fw-bold me-3">Laki-laki 41%</span>
                        <span class="text-danger fw-bold">Perempuan 59%</span>
                    </div>

                    <div class="chart-placeholder">
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <span class="me-4"><i class="fas fa-circle text-primary me-1"></i> Laki-laki</span>
                        <span><i class="fas fa-circle text-danger me-1"></i> Perempuan</span>
                    </div>
                </div>
            </div>


        </div> --}}

    </div>
@endsection
