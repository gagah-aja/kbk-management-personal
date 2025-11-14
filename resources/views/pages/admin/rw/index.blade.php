@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data RW</h2>
            <p>Kelola data Rukun Warga (RW)</p>
        </div>
        <a href="{{ route('admin.rw.create') }}" class="btn-add">
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

                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>

                @if ($search)
                    <a href="{{ route('admin.rw.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="data-card">
        <div class="table-container">

            @if($dataRW->count() > 0)

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

                            <td>
                                <span class="badge bg-primary">RW {{ $rw->nomor_rw }}</span>
                            </td>

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
                                          method="POST" 
                                          class="delete-form d-inline">
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

                {{-- Pagination --}}
                <div class="pagination-wrapper">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-muted small">
                            Menampilkan {{ $dataRW->firstItem() }} - {{ $dataRW->lastItem() }}
                            dari {{ $dataRW->total() }} data
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
                        <p class="text-muted">
                            Tidak ditemukan hasil untuk "<strong>{{ $search }}</strong>"
                        </p>

                        <a href="{{ route('admin.rw.index') }}" 
                           class="btn btn-outline-secondary mt-2">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>

                    @else
                        <h5 class="mt-3 fw-bold">Belum Ada Data</h5>
                        <p class="text-muted">Mulai tambahkan data RW pertama.</p>

                        <a href="{{ route('admin.rw.create') }}" 
                           class="btn btn-primary mt-2">
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
@endsection
