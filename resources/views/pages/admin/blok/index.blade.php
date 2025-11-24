@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2>Data Blok</h2>
                <p>Kelola data blok perumahan</p>
            </div>
            <a href="{{ route('admin.blok.create') }}" class="btn btn-dark">
            <i class="bi bi-plus"></i> Tambah Blok  
        </a>
        </div>

        {{-- Search Box --}}
        <div class="data-card mb-3">
            <form action="{{ route('admin.blok.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" name="search" class="form-control border-start-0"
                        placeholder="Cari nama blok..." value="{{ $search ?? '' }}">

                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search d-none d-sm-inline"></i>
                        <span class="d-none d-sm-inline">Cari</span>
                        <i class="bi bi-search d-sm-none"></i>
                    </button>

                    <a href="{{ route('admin.blok.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle d-none d-sm-inline"></i>
                        <span class="d-none d-sm-inline"></span>
                        <i class="bi bi-x-circle d-sm-none"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="data-card">
            <div class="table-container">

                @if ($bloks->count() > 0)

                    {{-- Desktop Table --}}
                    <div class="d-none d-md-block">
                        <table class="table-minimal">
                            <thead>
                                <tr>
                                    <th width="80" class="text-center">NO</th>
                                    <th>NAMA BLOK</th>
                                    <th width="200" class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bloks as $index => $blok)
                                    <tr>
                                        <td class="text-center">{{ $bloks->firstItem() + $index }}</td>
                                        <td>{{ $blok->nama_blok }}</td>
                                        <td>
                                            <div class="btn-group-actions d-flex justify-content-center gap-2">

                                                {{-- Edit --}}
                                                <a href="{{ route('admin.blok.edit', $blok->id) }}"
                                                    class="btn-action btn-edit">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('admin.blok.destroy', $blok->id) }}" method="POST"
                                                    class="delete-form d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete"
                                                        data-nama="{{ $blok->nama_blok }}">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Card View --}}
                    <div class="d-md-none">
                        @foreach ($bloks as $index => $blok)
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">

                                    <span class="badge bg-secondary small">No. {{ $bloks->firstItem() + $index }}</span>

                                    <div class="mt-3 mb-3">
                                        <small class="text-muted">Nama Blok</small>
                                        <div class="fw-bold">{{ $blok->nama_blok }}</div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.blok.edit', $blok->id) }}"
                                            class="btn btn-warning btn-sm flex-fill">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form action="{{ route('admin.blok.destroy', $blok->id) }}" method="POST"
                                            class="delete-form flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                                data-nama="{{ $blok->nama_blok }}">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="pagination-wrapper mt-3">
                        <div class="d-flex justify-content-between flex-wrap gap-3">
                            <div class="text-muted small">
                                Menampilkan {{ $bloks->firstItem() }} - {{ $bloks->lastItem() }}
                                dari {{ $bloks->total() }} data
                            </div>

                            <div>
                                {{ $bloks->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                @else
                    {{-- Empty State --}}
                    <div class="empty-state text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>

                        @if ($search)
                            <h5 class="mt-3 fw-bold">Tidak Ada Hasil</h5>
                            <p class="text-muted">Tidak ditemukan hasil untuk "<strong>{{ $search }}</strong>"</p>

                            <a href="{{ route('admin.blok.index') }}"
                                class="btn btn-outline-secondary btn-sm mt-2 px-3 py-1" style="font-size: 14px;">Reset</a>
                        @else
                            <h5 class="mt-3 fw-bold">Belum Ada Data</h5>
                            <p class="text-muted">Mulai tambahkan data blok pertama.</p>

                            <a href="{{ route('admin.blok.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus"></i> Tambah Data
                            </a>
                        @endif
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // DELETE CONFIRMATION
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const nama = this.querySelector('button').dataset.nama;

            Swal.fire({
                title: 'Hapus Blok?',
                text: `Data blok "${nama}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

    // ERROR ALERT DARI SESSION (Gagal hapus)
    @if(session('error'))
        const blokName = '{{ session('blok_name') ?? '' }}';
        const clusterUrl = '{{ session('cluster_redirect') }}';

        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            showCancelButton: true,          // Tombol kiri (OK)
            showConfirmButton: true,         // Tombol kanan (Cek Cluster)
            confirmButtonText: 'Cek Cluster',
            cancelButtonText: 'OK',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            reverseButtons: false            // Jangan dibalik
        }).then(result => {
            if (result.isConfirmed) {
                // Redirect ke halaman cluster dengan search nama blok
                window.location.href = `${clusterUrl}?search=${encodeURIComponent(blokName)}`;
            }
            // Klik OK otomatis menutup alert
        });
    @endif

});
</script>






    {{-- CSS untuk mengatur urutan tombol --}}
    <style>
        .swal2-actions {
            display: flex !important;
        }

        .swal2-cancel {
            order: 1;
        }

        .swal2-confirm {
            order: 2;
        }

        .swal2-deny {
            order: 3;
        }

        @media (max-width: 767.98px) {
            .card {
                border-radius: 12px;
            }

            .card-body {
                padding: 1rem;
            }

            .btn-sm {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }
    </style>

@endsection
