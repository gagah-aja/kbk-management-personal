@extends('layouts.admin.admin')

@section('content')
    <style>
        .card-rumah {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-rumah:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .badge-status {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .badge-success {
            background: #10b981;
            color: #fff;
        }

        .badge-primary {
            background: #3b82f6;
            color: #fff;
        }

        .badge-danger {
            background: #ef4444;
            color: #fff;
        }

        .badge-secondary {
            background: #6b7280;
            color: #fff;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .pagination .page-item .page-link {
            border: none;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            font-size: .95rem;
            color: #374151;
            background: #f9fafb;
            transition: all .25s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
        }

        .pagination .page-item .page-link:hover {
            background: #2563eb;
            color: #fff;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 3px 8px rgba(37, 99, 235, .3);
        }

        .pagination .page-item.active .page-link {
            background: #2563eb;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(37, 99, 235, .4);
            transform: scale(1.05);
        }

        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background: #f3f4f6;
            cursor: not-allowed;
        }

        @media(max-width:576px) {
            .pagination .page-item .page-link {
                width: 34px;
                height: 34px;
                font-size: .85rem;
            }
        }
    </style>

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h2>Data Rumah</h2>
                <p>Kelola data rumah perumahan</p>
            </div>
            <a href="{{ route('admin.rumah.create') }}" class="btn btn-dark">
                <i class="bi bi-plus"></i> Tambah Rumah
            </a>
        </div>

        {{-- Pencarian --}}
<form method="GET" action="{{ route('admin.rumah.index') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
            placeholder="Cari rumah / cluster / penghuni...">
        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Cari
        </button>

        {{-- Tombol Reset di sebelah kanan --}}
        <a href="{{ route('admin.rumah.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle"></i> Reset
        </a>
    </div>
</form>


        {{-- Daftar Rumah --}}
        <div class="data-card">
            @if ($rumah->count() > 0)
                <div class="row g-4">
                    @foreach ($rumah as $r)
                        <div class="col-md-4 mb-4">
                            <div class="card-rumah p-3 h-100">

                                {{-- Pemilik Rumah --}}
                                <div class="mb-2">
                                    <p class="text-muted mb-0"><i class="bi bi-person"></i> Pemilik Rumah</p>
                                    <h5 class="fw-bold text-primary text-capitalize">
                                        {{ $r->warga->nama_lengkap ?? 'Belum ada pemilik' }}
                                    </h5>
                                </div>

                                {{-- Nomor Rumah --}}
                                <h4 class="fw-semibold">{{ $r->nomor_rumah }}</h4>

                                {{-- Cluster --}}
                                <p class="mb-1">
                                    Cluster <strong>{{ $r->cluster->namaCluster->nama_cluster ?? '-' }}</strong><br>
                                    RT {{ $r->cluster->rt->nomor_rt ?? '-' }} •
                                    Blok {{ $r->cluster->blok->nama_blok ?? '-' }}
                                </p>

                                {{-- Status Rumah --}}
                                <div class="mb-2">
                                    @if ($r->statusRumah && $r->statusRumah->id == 1)
                                        <span class="badge bg-primary">TERISI</span>
                                    @elseif($r->statusRumah && $r->statusRumah->id == 2)
                                        <span class="badge bg-success">TERSEDIA</span>
                                    @else
                                        <span class="badge bg-warning">DISEWAKAN</span>
                                    @endif
                                </div>

                                {{-- Penghuni --}}
                                <div class="mt-2">
                                    @if ($r->penghuniAktif && $r->penghuniAktif->count() > 0)
                                        <span class="text-dark fw-semibold">{{ $r->penghuniAktif->count() }} Orang</span>
                                        <a href="{{ route('admin.rumah.penghuni.show', $r->id) }}"
                                            class="btn btn-outline-info btn-sm ms-2">
                                            <i class="bi bi-eye"></i> Lihat Semua
                                        </a>
                                    @else
                                        <p class="text-muted mb-1">Belum ada penghuni</p>
                                        <a href="{{ route('admin.rumah.penghuni.create', $r->id) }}"
                                            class="btn btn-outline-primary btn-sm w-100">
                                            <i class="bi bi-person-plus"></i> Tambah Penghuni
                                        </a>
                                    @endif
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="mt-3 d-flex flex-wrap gap-2">
                                    <a href="https://www.google.com/maps?q={{ $r->latitude }},{{ $r->longitude }}"
                                        target="_blank" class="btn btn-outline-success btn-sm w-100">
                                        <i class="bi bi-geo"></i> Lihat di Maps
                                    </a>

                                    {{-- Tombol Modal Gambar --}}
                                    @if ($r->gambar)
                                        <button class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal"
                                            data-bs-target="#modalGambar{{ $r->id }}">
                                            <i class="bi bi-image"></i> Buka Gambar
                                        </button>
                                    @endif

                                    <div class="d-flex gap-2 w-100">
                                        <a href="{{ route('admin.rumah.edit', $r->id) }}"
                                            class="btn btn-outline-warning btn-sm flex-fill">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form action="{{ route('admin.rumah.destroy', $r->id) }}" method="POST"
                                            class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                onclick="return confirm('Yakin ingin menghapus rumah ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Gambar --}}
                        @if ($r->gambar)
                            <div class="modal fade" id="modalGambar{{ $r->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Gambar Rumah</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $r->gambar) }}" class="img-fluid rounded mb-3"
                                                alt="Gambar Rumah">
                                        </div>
                                        <div class="modal-footer justify-content-end">
                                            <a href="{{ asset('storage/' . $r->gambar) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-box-arrow-up-right"></i> Buka di Tab Baru
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($rumah->hasPages())
                    <div class="pagination-wrapper mt-4">
                        {{ $rumah->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="empty-state text-center py-5">
                    <i class="bi bi-inbox mb-2" style="font-size:2rem;"></i>
                    @if (request('search'))
                        <h5>Tidak Ada Hasil</h5>
                        <p>Tidak ditemukan hasil untuk "<strong>{{ request('search') }}</strong>"</p>
                        <a href="{{ route('admin.rumah.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    @else
                        <h5>Belum Ada Data</h5>
                        <p>Mulai tambahkan data rumah pertama</p>
                        <a href="{{ route('admin.rumah.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Tambah Data
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- SweetAlert Notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}"
                });
            @endif
        });
    </script>
@endsection
