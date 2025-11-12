@extends('layouts.admin.admin')
@section('title', 'Status Rumah')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Status Rumah</h3>

        <div class="d-flex gap-2">
            {{-- Form Search --}}
            <form action="{{ route('admin.status-rumah.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama status..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>

            <a href="{{ route('admin.status-rumah.create') }}" class="btn btn-dark">
                Tambah Status
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if ($statuses->isEmpty())
                <p class="text-muted text-center mb-0">
                    Belum ada data status rumah. Silakan tambahkan terlebih dahulu.
                </p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th class="text-center">Nama Status</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $index => $s)
                            <tr class="text-center">
                                <td>{{ $statuses->firstItem() + $index }}</td>
                                <td>{{ $s->nama_status }}</td>
                                <td>
                                    <a href="{{ route('admin.status-rumah.edit', $s->id) }}" 
                                       class="btn btn-sm btn-warning me-1">
                                       Edit
                                    </a>
                                    <form action="{{ route('admin.status-rumah.destroy', $s->id) }}" 
                                          method="POST" class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                data-nama="{{ $s->nama_status }}">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- 📄 Pagination Bulat & Tengah --}}
                @if ($statuses->hasPages())
                    <div class="pagination-wrapper mt-4">
                        <div class="pagination-container">
                            {{ $statuses->appends(['search' => $search ?? ''])->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

{{-- 🎨 Style Pagination --}}
<style>
.pagination-wrapper { display:flex; justify-content:center; align-items:center; margin-top:1.5rem; }
.pagination-container { display:flex; justify-content:center; width:100%; }
.pagination { display:flex; flex-wrap:wrap; gap:10px; list-style:none; padding:0; margin:0; }
.pagination .page-item .page-link {
    border:none; border-radius:50%; width:42px; height:42px; display:flex; align-items:center; justify-content:center;
    font-weight:500; font-size:.95rem; color:#374151; background:#f9fafb; transition:all .25s; box-shadow:0 1px 3px rgba(0,0,0,.05);
}
.pagination .page-item .page-link:hover {
    background:#2563eb; color:#fff; transform:translateY(-2px) scale(1.05);
    box-shadow:0 3px 8px rgba(37,99,235,.3);
}
.pagination .page-item.active .page-link {
    background:#2563eb; color:#fff; font-weight:600; box-shadow:0 4px 10px rgba(37,99,235,.4); transform:scale(1.05);
}
.pagination .page-item.disabled .page-link {
    color:#9ca3af; background:#f3f4f6; box-shadow:none; cursor:not-allowed; transform:none;
}
@media(max-width:576px){
    .pagination .page-item .page-link { width:34px; height:34px; font-size:.85rem; }
}
</style>

{{-- 🧩 SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = this.querySelector('button').dataset.nama;
            
            Swal.fire({
                title: 'Hapus Status Rumah?',
                html: `Data status <strong>"${nama}"</strong> akan dihapus permanen.`,
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
