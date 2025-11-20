@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data RT</h2>
            <p>Kelola data Rukun Tetangga (RT)</p>
        </div>

        <a href="{{ route('admin.rt.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah RT
        </a>
    </div>

    {{-- Search Box --}}
<div class="data-card mb-3">
    <form action="{{ route('admin.rt.index') }}" method="GET">
        <div class="input-group">

            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search"></i>
            </span>

            <input type="text" name="search" 
                   class="form-control border-start-0"
                   placeholder="Cari nomor RT, RW, nama ketua, atau NIK..."
                   value="{{ $search ?? '' }}">

            {{-- Tombol Cari --}}
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search d-none d-sm-inline"></i> 
                <span class="d-none d-sm-inline">Cari</span>
                <i class="bi bi-search d-sm-none"></i>
            </button>

            {{-- Tombol Reset --}}
            <a href="{{ route('admin.rt.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle d-none d-sm-inline"></i>
                <span class="d-none d-sm-inline">Reset</span>
                <i class="bi bi-x-circle d-sm-none"></i>
            </a>

        </div>
    </form>
</div>


    {{-- Tabel Data --}}
    <div class="data-card">
        <div class="table-container">

            @if ($dataRT->count() > 0)

                {{-- Desktop Table View --}}
                <div class="d-none d-md-block">
                    <table class="table-minimal">
                        <thead>
                            <tr>
                                <th width="80" class="text-center">NO</th>
                                <th>NOMOR RT</th>
                                <th>KETUA RT</th>
                                <th>RW</th>
                                <th width="200" class="text-center">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dataRT as $index => $rt)
                            <tr>
                                <td class="text-center">{{ $dataRT->firstItem() + $index }}</td>

                                <td>
                                    <span class="badge bg-success">RT {{ $rt->nomor_rt }}</span>
                                </td>

                                <td>{{ $rt->warga->nama_lengkap ?? 'N/A' }}</td>

                                <td>
                                    <span class="badge bg-primary">
                                        RW {{ $rt->rw->nomor_rw ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="btn-group-actions d-flex justify-content-center gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.rt.edit', $rt->id) }}" class="btn-action btn-edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.rt.destroy', $rt->id) }}" 
                                              method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" 
                                                    class="btn-action btn-delete"
                                                    data-nama="RT {{ $rt->nomor_rt }} - {{ $rt->warga->nama_lengkap ?? 'RT' }}">
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
                    @foreach ($dataRT as $index => $rt)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-secondary small">No. {{ $dataRT->firstItem() + $index }}</span>
                                <span class="badge bg-success">RT {{ $rt->nomor_rt }}</span>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted d-block">Ketua RT</small>
                                <strong>{{ $rt->warga->nama_lengkap ?? 'N/A' }}</strong>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">RW</small>
                                <span class="badge bg-primary">RW {{ $rt->rw->nomor_rw ?? 'N/A' }}</span>
                            </div>

                            <div class="d-flex gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('admin.rt.edit', $rt->id) }}" 
                                   class="btn btn-warning btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.rt.destroy', $rt->id) }}" 
                                      method="POST" class="delete-form flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm w-100"
                                            data-nama="RT {{ $rt->nomor_rt }} - {{ $rt->warga->nama_lengkap ?? 'RT' }}">
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
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $dataRT->firstItem() }} - {{ $dataRT->lastItem() }}
                            dari {{ $dataRT->total() }} data
                        </div>

                        <div>
                            {{ $dataRT->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
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

                        <a href="{{ route('admin.rt.index') }}" 
                           class="btn btn-outline-secondary btn-sm mt-2 px-3 py-1"
                           style="font-size: 14px;">
                            Reset
                        </a>

                    @else
                        <h5 class="mt-3 fw-bold">Belum Ada Data</h5>
                        <p class="text-muted">Mulai tambahkan data RT pertama.</p>

                        <a href="{{ route('admin.rt.create') }}" class="btn btn-primary mt-2">
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
document.addEventListener('DOMContentLoaded', () => {

    // Success Alert
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // Error Alert
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444'
        });
    @endif

    // Delete Confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const nama = this.querySelector('button').dataset.nama;

            Swal.fire({
                title: 'Hapus Data RT?',
                html: `Data <strong>"${nama}"</strong> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) this.submit();
            });
        });
    });

});
</script>

<style>
/* Mobile Card Styling */
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