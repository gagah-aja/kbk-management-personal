@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data Cluster</h2>
            <p>Kelola data cluster perumahan</p>
        </div>

        <a href="{{ route('admin.cluster.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Cluster
        </a>
    </div>

    {{-- Search Box --}}
    <div class="data-card mb-3">
        <form action="{{ route('admin.cluster.index') }}" method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search"></i>
                </span>

                <input 
                    type="text" 
                    name="search" 
                    class="form-control border-start-0"
                    placeholder="Cari nama cluster, RT, atau blok..." 
                    value="{{ $search ?? '' }}"
                >

                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search d-none d-sm-inline"></i> 
                    <span class="d-none d-sm-inline">Cari</span>
                    <i class="bi bi-search d-sm-none"></i>
                </button>

                <a href="{{ route('admin.cluster.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle d-none d-sm-inline"></i>
                    <span class="d-none d-sm-inline">Reset</span>
                    <i class="bi bi-x-circle d-sm-none"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="data-card">
        <div class="table-container">

            @if ($clusters->count() > 0)

                {{-- Desktop Table --}}
                <div class="d-none d-md-block">
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
                            @foreach ($clusters as $index => $cluster)
                                <tr>
                                    <td class="text-center">{{ $clusters->firstItem() + $index }}</td>

                                    <td>{{ $cluster->namaCluster->nama_cluster ?? 'N/A' }}</td>

                                    <td class="text-muted">RT {{ $cluster->rt->nomor_rt ?? 'N/A' }}</td>

                                    <td class="text-muted">{{ $cluster->blok->nama_blok ?? 'N/A' }}</td>

                                    <td>
                                        <div class="btn-group-actions d-flex justify-content-center gap-2">

                                            {{-- Edit --}}
                                            <a 
                                                href="{{ route('admin.cluster.edit', $cluster->id) }}" 
                                                class="btn-action btn-edit"
                                            >
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>

                                            {{-- Delete --}}
                                            <form 
                                                action="{{ route('admin.cluster.destroy', $cluster->id) }}" 
                                                method="POST" 
                                                class="delete-form d-inline"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button 
                                                    type="submit" 
                                                    class="btn-action btn-delete"
                                                    data-nama="{{ $cluster->namaCluster->nama_cluster ?? 'Cluster' }}"
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
                </div>

                {{-- Mobile Card View --}}
                <div class="d-md-none">
                    @foreach ($clusters as $index => $cluster)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-secondary small">No. {{ $clusters->firstItem() + $index }}</span>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted d-block">Nama Cluster</small>
                                <strong>{{ $cluster->namaCluster->nama_cluster ?? 'N/A' }}</strong>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted d-block">RT</small>
                                <span class="badge bg-success">RT {{ $cluster->rt->nomor_rt ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Blok</small>
                                <strong>{{ $cluster->blok->nama_blok ?? 'N/A' }}</strong>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.cluster.edit', $cluster->id) }}" 
                                   class="btn btn-warning btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('admin.cluster.destroy', $cluster->id) }}" 
                                      method="POST" class="delete-form flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm w-100"
                                            data-nama="{{ $cluster->namaCluster->nama_cluster ?? 'Cluster' }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="pagination-wrapper">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div class="text-muted small">
                            Menampilkan {{ $clusters->firstItem() }} - {{ $clusters->lastItem() }}
                            dari {{ $clusters->total() }} data
                        </div>

                        <div>
                            {{ $clusters->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                        </div>

                    </div>
                </div>

            @else

                {{-- Empty State --}}
                <div class="empty-state text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>

                    @if ($search)
                        <h5 class="mt-3 fw-bold">Tidak Ada Hasil</h5>
                        <p class="text-muted">
                            Tidak ditemukan hasil untuk "<strong>{{ $search }}</strong>"
                        </p>

                        <a href="{{ route('admin.cluster.index') }}" 
                           class="btn btn-outline-secondary btn-sm mt-2 px-3 py-1"
                           style="font-size: 14px;">
                            Reset
                        </a>
                    @else
                        <h5 class="mt-3 fw-bold">Belum Ada Data</h5>
                        <p class="text-muted">Mulai tambahkan data cluster pertama.</p>

                        <a href="{{ route('admin.cluster.create') }}" class="btn btn-primary mt-2">
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

    @if (session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: '{{ session('info') }}',
            confirmButtonColor: '#3b82f6'
        });
    @endif

    // Delete Confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const nama = this.querySelector('button').dataset.nama;

            Swal.fire({
                title: 'Hapus Cluster?',
                html: `Data cluster <strong>"${nama}"</strong> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                denyButtonText: 'Cek Rumah',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',

                confirmButtonColor: '#ef4444',
                denyButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',

                reverseButtons: false
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                } 
                else if (result.isDenied) {
                    window.location.href = `/admin/rumah?search=${nama}`;
                }

            });
        });
    });

});
</script>

<style>
/* urutan tombol sweetalert */
.swal2-actions {
    display: flex !important;
    justify-content: center !important;
    gap: 8px !important;
}

.swal2-cancel { order: 1 !important; }
.swal2-confirm { order: 2 !important; }
.swal2-deny { order: 3 !important; }

/* Mobile Card Styling */
@media (max-width: 767.98px) {
    .card { border-radius: 12px; }
    .card-body { padding: 1rem; }
    .btn-sm { padding: 0.5rem 0.75rem; font-size: 0.875rem; }
}
</style>
@endsection
