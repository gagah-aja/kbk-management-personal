@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2>Data Rumah</h2>
                <p>Kelola data rumah perumahan</p>
            </div>
            <a href="{{ route('admin.rumah.create') }}" class="btn-add">
                <i class="bi bi-plus"></i> Tambah Rumah
            </a>
        </div>

        {{-- 🔍 Search Box --}}
        <div class="data-card mb-3">
            <form action="{{ route('admin.rumah.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0"
                        placeholder="Cari nomor rumah, cluster, penghuni, atau alamat..." value="{{ $search ?? '' }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if ($search)
                        <a href="{{ route('admin.rumah.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Data Cards --}}
        <div class="data-card">
            @if ($rumah->count() > 0)
                <div class="row g-4">
                    @foreach ($rumah as $r)
                        <div class="col-md-6 col-lg-4">
                            <div class="card-rumah">
                                <div class="card-rumah-body">
                                    {{-- Header Card --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-rumah-title mb-0">{{ $r->nomor_rumah }}</h5>
                                        @php
                                            $statusColor = [
                                                'tersedia' => 'success',
                                                'terisi' => 'primary',
                                                'rusak' => 'danger',
                                                'disewakan' => 'warning',
                                            ];
                                            $statusNama = strtolower($r->statusRumah->nama_status ?? 'unknown');
                                        @endphp
                                        <span class="badge-status badge-{{ $statusColor[$statusNama] ?? 'secondary' }}">
                                            {{ ucfirst($r->statusRumah->nama_status ?? 'N/A') }}
                                        </span>
                                    </div>

                                    {{-- Pemilik --}}
                                    @if ($r->warga)
                                        <div class="mb-2">
                                            <small class="text-muted d-block">Pemilik</small>
                                            <strong class="text-primary">{{ $r->warga->nama_lengkap }}</strong>
                                        </div>
                                    @endif

                                    {{-- Alamat --}}
                                    <p class="text-muted mb-2 small">
                                        <i class="bi bi-geo-alt"></i> {{ Str::limit($r->alamat_lengkap, 50) }}
                                    </p>

                                    {{-- Cluster Info --}}
                                    <div class="mb-2">
                                        <small class="text-muted d-block">Cluster</small>
                                        <strong>{{ $r->cluster->namaCluster->nama_cluster ?? 'N/A' }}</strong>
                                        <div class="text-muted small mt-1">
                                            <span class="badge bg-success">RT {{ $r->cluster->rt->nomor_rt ?? '-' }}</span>
                                            <span class="badge bg-info">Blok
                                                {{ $r->cluster->blok->nama_blok ?? '-' }}</span>
                                        </div>
                                    </div>

                                    {{-- Penghuni Info --}}
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Penghuni</small>
                                        @if ($r->penghuniAktif->count() > 0)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <strong>{{ $r->penghuniAktif->count() }} Orang</strong>
                                                <a href="{{ route('admin.rumah.penghuni.show', $r->id) }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </div>
                                        @else
                                            <div class="text-muted small">Belum ada penghuni</div>
                                            <a href="{{ route('admin.rumah.penghuni.create', $r->id) }}"
                                                class="btn btn-sm btn-outline-info w-100 mt-1">
                                                <i class="bi bi-person-plus"></i> Tambah Penghuni
                                            </a>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="d-flex flex-column gap-2">
                                        @if ($r->latitude && $r->longitude)
                                            @php $mapsUrl = "https://www.google.com/maps?q={$r->latitude},{$r->longitude}"; @endphp
                                            <a href="{{ $mapsUrl }}" target="_blank"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-geo"></i> Lihat di Maps
                                            </a>
                                        @endif

                                        @if ($r->gambar)
                                            <button type="button" class="btn btn-sm btn-outline-primary open-modal-gambar"
                                                data-gambar="{{ asset('storage/' . $r->gambar) }}"
                                                data-nomor="{{ $r->nomor_rumah }}">
                                                <i class="bi bi-image"></i> Lihat Gambar
                                            </button>
                                        @endif

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.rumah.edit', $r->id) }}"
                                                class="btn-action btn-edit flex-fill">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.rumah.destroy', $r->id) }}" method="POST"
                                                class="delete-form flex-fill">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete w-100"
                                                    data-nama="Rumah {{ $r->nomor_rumah }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ✅ Pagination dengan Custom Style --}}
                <div class="pagination-wrapper">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $rumah->firstItem() }} - {{ $rumah->lastItem() }}
                            dari {{ $rumah->total() }} data
                        </div>
                        <div>
                            {{ $rumah->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    @if ($search)
                        <h5>Tidak Ada Hasil</h5>
                        <p>Tidak ditemukan hasil untuk "{{ $search }}"</p>
                        <a href="{{ route('admin.rumah.index') }}" class="btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    @else
                        <h5>Belum Ada Data</h5>
                        <p>Mulai tambahkan data rumah pertama</p>
                        <a href="{{ route('admin.rumah.create') }}" class="btn-add">
                            <i class="bi bi-plus"></i> Tambah Data
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Modal untuk Gambar --}}
    <div class="modal fade" id="modalGambar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGambarLabel">Gambar Rumah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalGambarImg" src="" alt="Gambar Rumah" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ef4444'
                });
            @endif

            // Hapus Rumah
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const nama = this.querySelector('button').dataset.nama;

                    Swal.fire({
                        title: 'Hapus Data?',
                        html: `<strong>${nama}</strong> akan dihapus permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Modal Gambar
            document.querySelectorAll('.open-modal-gambar').forEach(btn => {
                btn.addEventListener('click', function() {
                    const gambarUrl = this.dataset.gambar;
                    const nomorRumah = this.dataset.nomor;

                    document.getElementById('modalGambarImg').src = gambarUrl;
                    document.getElementById('modalGambarLabel').textContent = 'Gambar Rumah ' +
                        nomorRumah;

                    const modal = new bootstrap.Modal(document.getElementById('modalGambar'));
                    modal.show();
                });
            });
        });
    </script>

    <style>
        /* Card Rumah */
        .card-rumah {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-rumah:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .card-rumah-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-rumah-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
        }

        /* Badge Status */
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

        /* Responsive */
        @media (max-width: 768px) {
            .card-rumah-body {
                padding: 1rem;
            }
        }
    </style>
@endsection
