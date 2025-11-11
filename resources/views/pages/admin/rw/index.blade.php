@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data RW</h2>
            <p>Kelola data Rukun Warga (RW)</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            {{-- 🔍 Form Pencarian --}}
            <form action="{{ route('admin.rw.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Cari nomor RW / nama ketua..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            {{-- ➕ Tombol Tambah (warna hitam / class lama) --}}
            <a href="{{ route('admin.rw.create') }}" class="btn-add">
                <i class="bi bi-plus"></i> Tambah RW
            </a>
        </div>
    </div>

    <div class="data-card mt-3">
        <div class="table-container">
            @if($dataRW->count() > 0)
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="80">NO</th>
                            <th>NOMOR RW</th>
                            <th>NIK KETUA RW</th>
                            <th>KETUA RW</th>
                            <th width="200">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataRW as $index => $rw)
                        <tr>
                            <td class="text-center">
                                {{ $dataRW->firstItem() + $index }}
                            </td>
                            <td>RW {{ $rw->nomor_rw }}</td>
                            <td>{{ $rw->warga->nik ?? 'N/A' }}</td>
                            <td>{{ $rw->warga->nama_lengkap ?? 'N/A' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.rw.edit', $rw->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rw.destroy', $rw->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
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

                {{-- 📄 Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $dataRW->links('pagination::bootstrap-5') }}
                </div>

            @else
                <div class="empty-state text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data RW pertama</p>
                    <a href="{{ route('admin.rw.create') }}" class="btn-add">
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
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endsection
    