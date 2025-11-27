@extends('layouts.user.user')

@section('content')
    <div class="container py-4">

        {{-- Header + Tombol Kembali --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold text-success mb-0" style="font-size: 1.8rem;">
                Semua Ketua RT
            </h2>

            <a href="{{ route('dashboard') }}" class="btn btn-outline-success btn-kembali d-flex align-items-center">
                <i class="bi bi-arrow-left-circle me-2"></i>
                <span>Kembali Dashboard</span>
            </a>
        </div>

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-light p-2 rounded shadow-sm">
                <li class="breadcrumb-item text-success">
                    <i class="bi bi-people-fill"></i> Semua Ketua RT
                </li>
            </ol>
        </nav>

        {{-- Search --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-wrap align-items-center gap-2">

                <form action="" method="GET" class="d-flex flex-grow-1 gap-2">
                    <input type="text" name="q" class="form-control"
                        placeholder="Cari nama Ketua RT atau nomor RT..." value="{{ request('q') }}">

                    <button class="btn btn-success">
                        <i class="bi bi-search"></i>
                    </button>

                    @if (request('q'))
                        <a href="{{ url()->current() }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </form>

                <span class="text-muted small">
                    Total: <b>{{ $ketua_rt_list->count() }}</b> Ketua RT
                </span>

            </div>
        </div>

        @php
            if (request('q')) {
                $ketua_rt_list = $ketua_rt_list->filter(function ($rt) {
                    $q = strtolower(request('q'));
                    return str_contains(strtolower($rt->warga->nama_lengkap ?? ''), $q) ||
                        str_contains(strtolower($rt->nomor_rt ?? ''), $q);
                });
            }
        @endphp

        {{-- Grid Ketua RT --}}
        <div class="row g-4 mt-1">
            @forelse ($ketua_rt_list as $rt)
                @php
                    $foto_rt =
                        $rt->warga && $rt->warga->foto && file_exists(storage_path('app/public/' . $rt->warga->foto))
                            ? asset('storage/' . $rt->warga->foto)
                            : null;
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card leader-card border-0 rounded-3 shadow-sm text-center h-100">
                        <div class="card-body p-4">

                            {{-- Foto --}}
                            @if ($foto_rt)
                                <img src="{{ $foto_rt }}" alt="Ketua RT" class="leader-photo">
                            @else
                                <div class="leader-avatar">
                                    <svg viewBox="0 0 24 24" fill="#6c757d">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                                        1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8
                                                        1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                            @endif

                            <p class="text-uppercase text-muted fw-semibold small mb-1">
                                KETUA RT {{ $rt->nomor_rt ?? '001' }}
                            </p>
                            <h4 class="fw-bold text-dark mb-0">
                                {{ $rt->warga->nama_lengkap ?? 'Belum Ada' }}
                            </h4>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Tidak ada data ditemukan untuk pencarian "<b>{{ request('q') }}</b>"</h5>
                </div>
            @endforelse
        </div>
    </div>

    {{-- CSS --}}
    <style>
        /* Tombol kembali – hijau */
        .btn-kembali {
            padding: 6px 14px;
            font-size: .85rem;
            border-radius: 8px;
            font-weight: 500;
            border-color: #198754 !important;
            color: #198754 !important;
        }

        .btn-kembali:hover {
            background-color: #198754 !important;
            color: white !important;
        }

        .btn-kembali i {
            font-size: 1rem;
        }

        /* Mobile Responsif */
        @media (max-width: 576px) {
            .btn-kembali {
                padding: 6px 12px;
                font-size: .82rem;
            }

            .btn-kembali i {
                font-size: .95rem;
            }
        }

        .breadcrumb i {
            margin-right: 5px;
            color: #198754 !important;
        }

        /* ============================= */
        /* 🎯 FOTO RT RAPI FINAL         */
        /* ============================= */

        .leader-photo,
        .leader-avatar {
            width: 110px !important;
            height: 110px !important;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #198754;
            /* hijau RT */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            background: #e9ecef;
        }

        .leader-avatar svg {
            width: 60px;
            height: 60px;
        }

        /* Hover Effect Card */
        .leader-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .leader-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
        }

        @media (max-width: 768px) {

            .leader-photo,
            .leader-avatar {
                width: 90px !important;
                height: 90px !important;
            }

            .leader-avatar svg {
                width: 50px;
                height: 50px;
            }
        }
    </style>

    @include('components.footer')
@endsection
