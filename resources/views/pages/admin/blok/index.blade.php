@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- 📘 Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data Blok</h2>
            <p>Kelola data blok perumahan</p>
        </div>

        <div class="d-flex gap-2 align-items-center">
            {{-- 🔍 Form Pencarian --}}
            <form action="{{ route('admin.blok.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama blok..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <a href="{{ route('admin.blok.create') }}" class="btn-add">
                <i class="bi bi-plus"></i> Tambah Blok
            </a>
        </div>
    </div>

    {{-- 📋 Data Table --}}
    <div class="data-card mt-3">
        <div class="table-container">
            @if($bloks->count() > 0)
                <table class="table-minimal">
                    <thead>
                        <tr>
                            <th width="80" class="text-center">NO</th>
                            <th>NAMA BLOK</th>
                            <th width="200" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bloks as $index => $blok)
                        <tr>
                            <td class="text-center">
                                <span class="badge-number">
                                    {{ $bloks->firstItem() + $index }}
                                </span>
                            </td>
                            <td>
                                <span class="blok-name">{{ $blok->nama_blok }}</span>
                            </td>
                            <td>
                                <div class="btn-group-actions d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.blok.edit', $blok->id) }}" 
                                       class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.blok.destroy', $blok->id) }}" 
                                          method="POST" 
                                          class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-delete"
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

                {{-- 📄 Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small>
                            Menampilkan {{ $bloks->firstItem() }} - {{ $bloks->lastItem() }}
                            dari {{ $bloks->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $bloks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data blok pertama</p>
                    <a href="{{ route('admin.blok.create') }}" class="btn-add">
                        <i class="bi bi-plus"></i> Tambah Data
                    </a>
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

    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = this.querySelector('button').dataset.nama;
            
            Swal.fire({
                title: 'Hapus Blok?',
                html: `Data blok <strong>"${nama}"</strong> akan dihapus permanen.`,
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
