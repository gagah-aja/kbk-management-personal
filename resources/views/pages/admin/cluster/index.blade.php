@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data Cluster</h2>
            <p>Kelola data cluster perumahan</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            {{-- 🔍 Search --}}
            <form action="{{ route('admin.cluster.index') }}" method="GET" class="d-flex" role="search">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Cari nama cluster / RT / blok..." 
                       value="{{ $search }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            {{-- ➕ Tambah --}}
            <a href="{{ route('admin.cluster.create') }}" class="btn-add">
                <i class="bi bi-plus"></i> Tambah Cluster
            </a>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="data-card">
        <div class="table-container">
            @if($clusters->count() > 0)
                <table class="table-minimal">
                    <thead>
                        <tr>
                            <th width="80" class="text-center">NO</th>
                            <th>NAMA CLUSTER</th>
                            <th>RT</th>
                            <th>BLOK</th>
                            <th width="200" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clusters as $index => $cluster)
                        <tr>
                            <td class="text-center">{{ $clusters->firstItem() + $index }}</td>
                            <td>{{ $cluster->namaCluster->nama_cluster ?? 'N/A' }}</td>
                            <td class="text-muted">RT {{ $cluster->rt->nomor_rt ?? 'N/A' }}</td>
                            <td class="text-muted">{{ $cluster->blok->nama_blok ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group-actions d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.cluster.edit', $cluster->id) }}" class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.cluster.destroy', $cluster->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                            data-nama="{{ $cluster->namaCluster->nama_cluster ?? 'Cluster' }}">
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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-3">
                    <div class="text-muted small text-center text-md-start">
                        Menampilkan <strong>{{ $clusters->firstItem() }}</strong> - 
                        <strong>{{ $clusters->lastItem() }}</strong> dari 
                        <strong>{{ $clusters->total() }}</strong> data
                    </div>

                    <div class="d-flex justify-content-center w-100">
                        <div class="custom-pagination">
                            {{ $clusters->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

            @else
                <div class="empty-state text-center py-5">
                    <i class="bi bi-inbox"></i>
                    @if($search)
                        <h5>Tidak Ada Hasil</h5>
                        <p>Tidak ditemukan hasil untuk "{{ $search }}"</p>
                        <a href="{{ route('admin.cluster.index') }}" class="btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    @else
                        <h5>Belum Ada Data</h5>
                        <p>Mulai tambahkan data cluster pertama</p>
                        <a href="{{ route('admin.cluster.create') }}" class="btn-add">
                            <i class="bi bi-plus"></i> Tambah Data
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

{{-- 🎨 Pagination Style --}}
<style>
.custom-pagination nav {
    display: flex;
    justify-content: center;
}

.custom-pagination .page-item .page-link {
    border-radius: 50% !important;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    border: 1px solid #d1d5db;
    transition: all 0.2s ease-in-out;
}

.custom-pagination .page-item.active .page-link {
    background-color: #2563eb !important;
    color: white !important;
    border-color: #2563eb !important;
}

.custom-pagination .page-item .page-link:hover {
    background-color: #eff6ff;
    color: #1d4ed8;
    border-color: #93c5fd;
}
</style>

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
                title: 'Hapus Cluster?',
                html: `Data cluster <strong>"${nama}"</strong> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endsection
