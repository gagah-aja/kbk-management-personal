@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Data RT</h2>
            <p>Kelola data Rukun Tetangga (RT)</p>
        </div>
        <a href="{{ route('admin.rt.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah RT
        </a>
    </div>

    <div class="data-card">
        <div class="table-container">
            @if($dataRT->count() > 0)
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
                        @foreach($dataRT as $rt)
                        <tr>
                            <td class="text-center">
                                <span class="badge-number">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <span class="blok-name">RT {{ $rt->nomor_rt }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $rt->warga->nama_lengkap ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">RW {{ $rt->rw->nomor_rw ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <div class="btn-group-actions d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.rt.edit', $rt->id) }}" 
                                       class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.rt.destroy', $rt->id) }}" 
                                          method="POST" 
                                          class="delete-form d-inline">
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
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data RT pertama</p>
                    <a href="{{ route('admin.rt.create') }}" class="btn-add">
                        <i class="bi bi-plus"></i> Tambah Data
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

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

    @if (session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: '{{ session('info') }}',
            confirmButtonColor: '#3b82f6'
        });
    @endif

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
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