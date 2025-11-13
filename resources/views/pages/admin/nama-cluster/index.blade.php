@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data Nama Cluster</h2>
            <p>Kelola data nama cluster perumahan</p>
        </div>
        <a href="{{ route('admin.nama-cluster.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Nama Cluster
        </a>
    </div>

    {{-- 🔍 Search Box --}}
    <div class="data-card mb-3">
        <form action="{{ route('admin.nama-cluster.index') }}" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                    placeholder="Cari nama cluster..." value="{{ $search ?? '' }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
                @if ($search)
                    <a href="{{ route('admin.nama-cluster.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Data --}}
    <div class="data-card">
        <div class="table-container">
            @if($namaClusters->count() > 0)
                <table class="table-minimal">
                    <thead>
                        <tr>
                            <th width="80" class="text-center">NO</th>
                            <th>NAMA CLUSTER</th>
                            <th width="200" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($namaClusters as $index => $cluster)
                        <tr>
                            <td class="text-center">{{ $namaClusters->firstItem() + $index }}</td>
                            <td>{{ $cluster->nama_cluster }}</td>
                            <td>
                                <div class="btn-group-actions d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.nama-cluster.edit', $cluster->id) }}" class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.nama-cluster.destroy', $cluster->id) }}" method="POST" class="delete-form d-inline">
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

                {{-- ✅ Pagination dengan Custom Style --}}
                <div class="pagination-wrapper">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $namaClusters->firstItem() }} - {{ $namaClusters->lastItem() }}
                            dari {{ $namaClusters->total() }} data
                        </div>
                        <div>
                            {{ $namaClusters->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>

            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    @if($search)
                        <h5>Tidak Ada Hasil</h5>
                        <p>Tidak ditemukan hasil untuk "{{ $search }}"</p>
                        <a href="{{ route('admin.nama-cluster.index') }}" class="btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    @else
                        <h5>Belum Ada Data</h5>
                        <p>Mulai tambahkan data nama cluster pertama</p>
                        <a href="{{ route('admin.nama-cluster.create') }}" class="btn-add">
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

    document.querySelectorAll('.delete-form').forEach(form => {
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