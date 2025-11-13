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
            <form action="{{ route('admin.nama-cluster.index') }}" method="GET" class="d-flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Cari nama cluster..." 
                    value="{{ request('search') }}" 
                    style="min-width: 220px;"
                >
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            {{-- ➕ Tombol Tambah --}}
            <a href="{{ route('admin.nama-cluster.create') }}" class="btn btn-dark">
                <i class="bi bi-plus"></i> Tambah
            </a>
        </div>
    </div>

    {{-- 📋 Tabel Data --}}
    <div class="data-card mt-3">
        <div class="table-container">
            @if ($namaClusters->count() > 0)
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80" class="text-center">No</th>
                            <th>Nama Cluster</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($namaClusters as $cluster)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($namaClusters->currentPage() - 1) * $namaClusters->perPage() }}
                                </td>
                                <td>{{ $cluster->nama_cluster }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.nama-cluster.edit', $cluster->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form 
                                            action="{{ route('admin.nama-cluster.destroy', $cluster->id) }}" 
                                            method="POST" 
                                            class="form-hapus d-inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="btn btn-danger btn-sm" 
                                                data-nama="{{ $cluster->nama_cluster }}"
                                            >
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 📄 Pagination (Tengah & Bulat) --}}
                <div class="pagination-wrapper mt-4">
                    <div class="pagination-container">
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
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-top: 1.5rem;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item .page-link {
        border: none;
        border-radius: 50%; /* Bulat */
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        font-size: 0.95rem;
        color: #374151;
        background-color: #f9fafb;
        transition: all 0.25s ease-in-out;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .pagination .page-item .page-link:hover {
        background-color: #2563eb;
        color: #fff;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 3px 8px rgba(37, 99, 235, 0.3);
    }

    .pagination .page-item.active .page-link {
        background-color: #2563eb;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);
        transform: scale(1.05);
    }

    .pagination .page-item.disabled .page-link {
        color: #9ca3af;
        background-color: #f3f4f6;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    @media (max-width: 576px) {
        .pagination .page-item .page-link {
            width: 34px;
            height: 34px;
            font-size: 0.85rem;
        }
    }
</style>

{{-- 🧩 SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            form.addEventListener('submit', function (e) {
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
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    });
</script>
@endsection
