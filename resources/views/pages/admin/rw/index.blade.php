@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h2>Data RW</h2>
            <p>Kelola data Rukun Warga (RW)</p>
        </div>
        
        {{-- Tombol Tambah RW --}}
        <a href="{{ route('admin.rw.create') }}" class="btn btn-dark">
            <i class="bi bi-plus"></i> Tambah RW
        </a>
    </div>

    {{-- Search Box --}}
<div class="data-card mb-3">
    <form action="{{ route('admin.rw.index') }}" method="GET">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search"></i>
            </span>

            <input type="text" name="search" class="form-control border-start-0"
                   placeholder="Cari nomor RW, nama ketua, atau NIK..."
                   value="{{ $search ?? '' }}">

            {{-- Tombol Cari --}}
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search d-none d-sm-inline"></i> 
                <span class="d-none d-sm-inline">Cari</span>
                <i class="bi bi-search d-sm-none"></i>
            </button>

            {{-- Tombol Reset --}}
            <a href="{{ route('admin.rw.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle d-none d-sm-inline"></i>
                <span class="d-none d-sm-inline"></span>
                <i class="bi bi-x-circle d-sm-none"></i>
            </a>
        </div>
    </form>
</div>


    {{-- Data Table --}}
    <div class="data-card">
        <div class="table-container">
            @if($dataRW->count() > 0)
                {{-- Desktop Table View --}}
                <div class="d-none d-md-block">
                    <table class="table-minimal">
                        <thead>
                            <tr>
                                <th width="80" class="text-center">NO</th>
                                <th>NOMOR RW</th>
                                <th>NIK KETUA RW</th>
                                <th>KETUA RW</th>
                                <th width="200" class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataRW as $index => $rw)
                            <tr>
                                <td class="text-center">{{ $dataRW->firstItem() + $index }}</td>
                                <td><span class="badge bg-primary">RW {{ $rw->nomor_rw }}</span></td>
                                <td class="text-muted">{{ $rw->warga->nik ?? 'N/A' }}</td>
                                <td>{{ $rw->warga->nama_lengkap ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group-actions d-flex justify-content-center gap-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.rw.edit', $rw->id) }}" class="btn-action btn-edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.rw.destroy', $rw->id) }}" 
                                              method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-action btn-delete"
                                                    data-nama="RW {{ $rw->nomor_rw }} - {{ $rw->warga->nama_lengkap ?? 'RW' }}">
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
                    @foreach($dataRW as $index => $rw)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-secondary small">No. {{ $dataRW->firstItem() + $index }}</span>
                                </div>
                                <span class="badge bg-primary">RW {{ $rw->nomor_rw }}</span>
                            </div>
                            
                            <div class="mb-2">
                                <small class="text-muted d-block">NIK Ketua RW</small>
                                <strong>{{ $rw->warga->nik ?? 'N/A' }}</strong>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Ketua RW</small>
                                <strong>{{ $rw->warga->nama_lengkap ?? 'N/A' }}</strong>
                            </div>

                            <div class="d-flex gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('admin.rw.edit', $rw->id) }}" 
                                   class="btn btn-warning btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.rw.destroy', $rw->id) }}" 
                                      method="POST" class="delete-form flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm w-100"
                                            data-nama="RW {{ $rw->nomor_rw }} - {{ $rw->warga->nama_lengkap ?? 'RW' }}">
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
                            Menampilkan {{ $dataRW->firstItem() }} - {{ $dataRW->lastItem() }} dari {{ $dataRW->total() }} data
                        </div>
                        <div>
                            {{ $dataRW->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="empty-state text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>

                    @if($search)
                        <h5 class="mt-3 fw-bold">Tidak Ada Hasil</h5>
                        <p class="text-muted">Tidak ditemukan hasil untuk "<strong>{{ $search }}</strong>"</p>
                        <a href="{{ route('admin.rw.index') }}" 
                           class="btn btn-outline-secondary btn-sm mt-2 px-3 py-1"
                           style="font-size: 14px;">
                            Reset
                        </a>
                    @else
                        <h5 class="mt-3 fw-bold">Belum Ada Data</h5>
                        <p class="text-muted">Mulai tambahkan data RW pertama.</p>
                        <a href="{{ route('admin.rw.create') }}" class="btn btn-primary mt-2">
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
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'Cek RT',
        cancelButtonText: 'OK',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // kirim nomor RW lewat query string
            const rwNomor = '{{ session('rwNomor') ?? '' }}'; // misal 9
            window.location.href = `/admin/rt?search=${rwNomor}`;
        }
    });
@endif


    // Konfirmasi hapus biasa
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = this.querySelector('button').dataset.nama;

            Swal.fire({
                title: 'Hapus Data RW?',
                html: `Data <strong>"${nama}"</strong> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
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