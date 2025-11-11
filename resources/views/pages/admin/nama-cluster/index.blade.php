@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">
        {{-- 📘 Header --}}
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2>Data Nama Cluster</h2>
                <p>Kelola data nama cluster perumahan</p>
            </div>

            <div class="d-flex gap-2 align-items-center">
                {{-- 🔍 Form Pencarian --}}
                <form action="{{ route('admin.nama-cluster.index') }}" method="GET" class="d-flex" style="gap: .5rem;">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama cluster..."
                        value="{{ request('search') }}" style="min-width: 220px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                {{-- ➕ Tombol Tambah --}}
                <a href="{{ route('admin.nama-cluster.create') }}" class="btn-add">
                    <i class="bi bi-plus"></i> Tambah
                </a>
            </div>
        </div>

        {{-- 📋 Tabel Data --}}
        <div class="data-card mt-3">
            <div class="table-container">
                @if ($namaClusters->count() > 0)
                    <table class="table-minimal">
                        <thead>
                            <tr>
                                <th width="80" class="text-center">NO</th>
                                <th>NAMA CLUSTER</th>
                                <th width="200" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($namaClusters as $cluster)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge-number">
                                            {{ $loop->iteration + ($namaClusters->currentPage() - 1) * $namaClusters->perPage() }}
                                        </span>
                                    </td>
                                    <td><span class="blok-name">{{ $cluster->nama_cluster }}</span></td>
                                    <td>
                                        <div class="btn-group-actions d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.nama-cluster.edit', $cluster->id) }}"
                                                class="btn-action btn-edit">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.nama-cluster.destroy', $cluster->id) }}"
                                                method="POST" class="form-hapus d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete"
                                                    data-nama="{{ $cluster->nama_cluster }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- 📄 Pagination --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
                        <div class="text-muted small">
                            Menampilkan <strong>{{ $namaClusters->firstItem() }}</strong> –
                            <strong>{{ $namaClusters->lastItem() }}</strong> dari
                            <strong>{{ $namaClusters->total() }}</strong> data
                        </div>
                        <div>
                            {{-- 🌀 Pagination Bootstrap --}}
                            {{ $namaClusters->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center py-3 mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Belum ada data nama cluster.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 🎨 Style Pagination --}}
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 4px;
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 500;
            color: #374151;
            background-color: #f9fafb;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #2563eb;
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        }

        .pagination .page-item .page-link:hover {
            background-color: #e5e7eb;
            color: #111827;
        }

        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: #f3f4f6;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #6b7280;
        }
    </style>

    {{-- 🧩 SweetAlert --}}
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

            // Konfirmasi hapus data
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const nama = this.querySelector('button').dataset.nama;
                    Swal.fire({
                        title: 'Hapus Nama Cluster?',
                        html: `Data nama cluster <strong>"${nama}"</strong> akan dihapus permanen.`,
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
        });
    </script>
@endsection
