    @extends('layouts.user.user')

    @section('content')
    <div class="container py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-light p-2 rounded">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">
                        <i class="bi bi-house-door-fill"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark" aria-current="page">
                    <i class="bi bi-people-fill"></i> Semua Ketua RW
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary border-bottom pb-2" style="font-size: 1.8rem;">
                Semua Ketua RW
            </h2>
            <span class="text-muted" style="font-size: 0.95rem;">
                Total: {{ $ketua_rw_list->count() }} Ketua RW
            </span>
        </div>

        {{-- Grid Ketua RW --}}
        <div class="row g-4">
            @foreach ($ketua_rw_list as $rw)
                @php
                    $foto_rw = $rw->warga && $rw->warga->foto && file_exists(storage_path('app/public/' . $rw->warga->foto))
                        ? asset('storage/' . $rw->warga->foto)
                        : null;
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100 hover-shadow">
                        <div class="card-body p-4 d-flex flex-column align-items-center">
                            {{-- Foto --}}
                            @if ($foto_rw)
                                <img src="{{ $foto_rw }}" alt="Ketua RW" class="leader-photo rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                            @else
                                <div class="leader-avatar mb-3" style="width:120px; height:120px; display:flex; align-items:center; justify-content:center; background:#f0f0f0; border-radius:50%;">
                                    <svg viewBox="0 0 24 24" fill="#6c757d" width="60" height="60">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                        1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8
                                        1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Jabatan & Nama --}}
                            <p class="text-uppercase text-muted fw-semibold small mb-1">KETUA RW {{ $rw->nomor_rw ?? '001' }}</p>
                            <h4 class="fw-bold text-dark mb-0">{{ $rw->warga->nama_lengkap ?? 'Belum Ada' }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tambahkan CSS untuk hover effect dan style header --}}
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .leader-photo {
            border: 3px solid #0d6efd;
        }

        @media (max-width: 768px) {
            .leader-photo, .leader-avatar {
                width: 100px !important;
                height: 100px !important;
            }
        }

        /* Breadcrumb ikon */
        .breadcrumb i {
            margin-right: 5px;
        }
    </style>
    @endsection
