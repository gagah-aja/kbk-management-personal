@extends('layouts.admin.admin')
@section('content')

    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
        }

        .info-rumah {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3b82f6;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .info-rumah h4 {
            margin: 0;
            color: #1e293b;
            font-size: 1.2rem;
        }

        .info-rumah p {
            margin: 0.25rem 0 0 0;
            color: #64748b;
            font-size: 0.9rem;
            word-break: break-word;
        }

        .badge-pemilik {
            background: #059669;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
            font-weight: 600;
        }

        .badge-penyewa {
            background: #0891b2;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
            font-weight: 600;
        }

        .badge-kk {
            background: #10b981;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-istri {
            background: #ec4899;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-suami {
            background: #3b82f6;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-anak {
            background: #f59e0b;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-ortu {
            background: #8b5cf6;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
        }

        .badge-lainnya {
            background: #6b7280;
            color: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            display: inline-block;
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        /* 📱 Mobile Card View */
        .penghuni-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .penghuni-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            gap: 0.5rem;
        }

        .penghuni-card-header>div:first-child {
            flex: 1;
            min-width: 0;
        }

        .penghuni-nama {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
            margin: 0;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .penghuni-nik {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            word-break: break-all;
        }

        .penghuni-detail {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #e5e7eb;
        }

        .penghuni-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
        }

        .penghuni-detail-label {
            color: #64748b;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .penghuni-detail-value {
            color: #1e293b;
            font-weight: 500;
            font-size: 0.8rem;
            text-align: right;
        }

        /* Desktop Table (default) */
        .table-desktop {
            display: block !important;
            width: 100%;
            overflow-x: auto;
        }

        .mobile-cards {
            display: none !important;
        }

        /* 📱 Mobile Responsive */
        @media (max-width: 768px) {

            /* Hide desktop table */
            .table-desktop {
                display: none !important;
            }

            .mobile-cards {
                display: block !important;
            }

            /* Container adjustments */
            .container-fluid {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }

            /* Info Rumah */
            .info-rumah {
                padding: 0.75rem;
                margin-bottom: 1rem;
                font-size: 0.85rem;
            }

            .info-rumah h4 {
                font-size: 0.95rem;
            }

            .info-rumah p {
                font-size: 0.75rem;
                line-height: 1.5;
            }

            /* Page Header */
            .page-header {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 0.75rem !important;
            }

            .page-header h2 {
                font-size: 1.25rem;
                margin-bottom: 0.25rem;
            }

            .page-header p {
                font-size: 0.85rem;
            }

            .page-header>div:last-child {
                margin-top: 0 !important;
                width: 100%;
            }

            .page-header .d-flex {
                flex-direction: column !important;
                gap: 0.5rem !important;
                width: 100%;
            }

            .page-header .btn {
                width: 100% !important;
                justify-content: center;
            }

            /* Card adjustments */
            .card {
                border-radius: 8px;
                margin: 0;
                width: 100%;
            }

            .card-body {
                padding: 0 !important;
            }

            /* Mobile Cards Container */
            .mobile-cards {
                padding: 0.75rem !important;
                width: 100%;
            }

            /* Summary Stats */
            .summary-stats {
                flex-direction: column !important;
                gap: 0 !important;
            }

            .summary-stats>div {
                text-align: center !important;
                padding: 0.75rem !important;
                border-bottom: 1px solid #e5e7eb;
                font-size: 0.85rem;
            }

            .summary-stats>div:last-child {
                border-bottom: none;
            }

            /* Button adjustments */
            .btn-sm {
                font-size: 0.8rem;
                padding: 0.35rem 0.7rem;
            }
        }

        /* Extra small devices */
        @media (max-width: 390px) {
            .info-rumah {
                padding: 0.5rem;
            }

            .info-rumah h4 {
                font-size: 0.9rem;
            }

            .info-rumah p {
                font-size: 0.7rem;
            }

            .penghuni-card {
                padding: 0.75rem;
            }

            .penghuni-nama {
                font-size: 0.9rem;
            }

            .penghuni-nik {
                font-size: 0.75rem;
            }

            .penghuni-detail-label,
            .penghuni-detail-value {
                font-size: 0.75rem;
            }
        }
    </style>

    <div class="container-fluid py-4" style="max-width:100%; padding-left:1rem; padding-right:1rem;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3 page-header">
            <div>
                <h2>Daftar Penghuni</h2>
                <p class="mb-0">Detail penghuni rumah</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.rumah.penghuni.create', $rumah->id) }}" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i> Tambah Penghuni
                </a>
                <a href="{{ route('admin.rumah.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Info Rumah --}}
        <div class="info-rumah">
            <h4>🏠 Rumah {{ $rumah->nomor_rumah }}</h4>
            <p>
                <i class="bi bi-geo-alt"></i> {{ $rumah->alamat_lengkap }} •
                <strong>{{ $rumah->cluster->namaCluster->nama_cluster ?? 'N/A' }}</strong> •
                RT {{ $rumah->cluster->rt->nomor_rt ?? '-' }} •
                Blok {{ $rumah->cluster->blok->nama_blok ?? '-' }}
            </p>
        </div>

        {{-- Tabel Penghuni --}}
        <div class="card">
            <div class="card-body p-0">
                @if ($penghuni->count() > 0)
                    {{-- 🖥️ Desktop: Tabel --}}
                    <div class="table-responsive table-desktop">
                        <table class="table table-hover mb-0">
                            <thead style="background:#f1f5f9;">
                                <tr>
                                    <th width="4%">No</th>
                                    <th width="18%">Nama Lengkap</th>
                                    <th width="12%">NIK</th>
                                    <th width="10%">Tipe</th>
                                    <th width="12%">Status</th>
                                    <th width="10%">Tanggal Masuk</th>
                                    <th width="10%">Tanggal Keluar</th>
                                    <th width="8%">Status Aktif</th>
                                    <th width="8%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penghuni as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $p->warga->nama_lengkap }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $p->warga->jenis_kelamin }}</small>
                                        </td>
                                        <td>{{ $p->warga->nik }}</td>
                                        <td>
                                            @if ($p->tipe_penghuni == 'Pemilik')
                                                <span class="badge-pemilik">🏠 Pemilik</span>
                                            @else
                                                <span class="badge-penyewa">🏘️ Penyewa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = [
                                                    'Kepala Keluarga' => 'badge-kk',
                                                    'Istri' => 'badge-istri',
                                                    'Suami' => 'badge-suami',
                                                    'Anak' => 'badge-anak',
                                                    'Orang Tua' => 'badge-ortu',
                                                    'Keluarga Lainnya' => 'badge-lainnya',
                                                ];
                                            @endphp
                                            <span class="{{ $badgeClass[$p->status_penghuni] ?? 'badge-lainnya' }}">
                                                {{ $p->status_penghuni }}
                                            </span>
                                        </td>
                                        <td>{{ $p->tanggal_masuk->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($p->tanggal_keluar)
                                                {{ $p->tanggal_keluar->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->is_active)
                                                <form action="{{ route('admin.penghuni.destroy', $p->id) }}" method="POST"
                                                    class="form-hapus-penghuni">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        data-nama="{{ $p->warga->nama_lengkap }}" title="Hapus Penghuni">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Sudah keluar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 📱 Mobile: Card View --}}
                    <div class="mobile-cards p-3">
                        @foreach ($penghuni as $index => $p)
                            <div class="penghuni-card">
                                <div class="penghuni-card-header">
                                    <div style="flex:1;">
                                        <h6 class="penghuni-nama">{{ $p->warga->nama_lengkap }}</h6>
                                        <div class="penghuni-nik">NIK: {{ $p->warga->nik }}</div>
                                    </div>
                                    @if ($p->is_active)
                                        <form action="{{ route('admin.penghuni.destroy', $p->id) }}" method="POST"
                                            class="form-hapus-penghuni">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                data-nama="{{ $p->warga->nama_lengkap }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="penghuni-detail">
                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Tipe</span>
                                        @if ($p->tipe_penghuni == 'Pemilik')
                                            <span class="badge-pemilik">🏠 Pemilik</span>
                                        @else
                                            <span class="badge-penyewa">🏘️ Penyewa</span>
                                        @endif
                                    </div>

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Status</span>
                                        @php
                                            $badgeClass = [
                                                'Kepala Keluarga' => 'badge-kk',
                                                'Istri' => 'badge-istri',
                                                'Suami' => 'badge-suami',
                                                'Anak' => 'badge-anak',
                                                'Orang Tua' => 'badge-ortu',
                                                'Keluarga Lainnya' => 'badge-lainnya',
                                            ];
                                        @endphp
                                        <span class="{{ $badgeClass[$p->status_penghuni] ?? 'badge-lainnya' }}">
                                            {{ $p->status_penghuni }}
                                        </span>
                                    </div>

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Jenis Kelamin</span>
                                        <span class="penghuni-detail-value">{{ $p->warga->jenis_kelamin }}</span>
                                    </div>

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Tanggal Masuk</span>
                                        <span class="penghuni-detail-value">{{ $p->tanggal_masuk->format('d/m/Y') }}</span>
                                    </div>

                                    @if ($p->tanggal_keluar)
                                        <div class="penghuni-detail-item">
                                            <span class="penghuni-detail-label">Tanggal Keluar</span>
                                            <span
                                                class="penghuni-detail-value">{{ $p->tanggal_keluar->format('d/m/Y') }}</span>
                                        </div>
                                    @endif

                                    <div class="penghuni-detail-item">
                                        <span class="penghuni-detail-label">Status</span>
                                        @if ($p->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Info Tambahan --}}
                    <div class="p-3 bg-light border-top">
                        <div class="row summary-stats">
                            <div class="col-md-3">
                                <strong>Total Penghuni:</strong> {{ $penghuni->count() }} orang
                            </div>
                            <div class="col-md-3">
                                <strong>Pemilik:</strong>
                                {{ $penghuni->where('is_active', true)->where('tipe_penghuni', 'Pemilik')->count() }} orang
                            </div>
                            <div class="col-md-3">
                                <strong>Penyewa:</strong>
                                {{ $penghuni->where('is_active', true)->where('tipe_penghuni', 'Penyewa')->count() }} orang
                            </div>
                            <div class="col-md-3">
                                <strong>Sudah Keluar:</strong> {{ $penghuni->where('is_active', false)->count() }} orang
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-people" style="font-size:3rem; color:#cbd5e1;"></i>
                        <h5 class="mt-3">Belum Ada Penghuni</h5>
                        <p class="text-muted">Mulai tambahkan penghuni untuk rumah ini</p>
                        <a href="{{ route('admin.rumah.penghuni.create', $rumah->id) }}" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Tambah Penghuni
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

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
                    text: '{{ session('error') }}'
                });
            @endif

            // Konfirmasi Hapus Penghuni
            document.querySelectorAll('.form-hapus-penghuni').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const nama = this.querySelector('button').dataset.nama;
                    Swal.fire({
                        title: 'Hapus Penghuni?',
                        html: `<strong>${nama}</strong> akan dihapus dari daftar penghuni rumah ini.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then(res => {
                        if (res.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>

@endsection
