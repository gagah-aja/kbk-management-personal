@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Data Nama Cluster</h2>
            <p>Kelola data nama cluster perumahan</p>
        </div>
        <a href="{{ route('admin.nama-cluster.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Nama Cluster
        </a>
    </div>

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
                        @foreach($namaClusters as $cluster)
                        <tr>
                            <td class="text-center">
                                <span class="badge-number">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <span class="blok-name">{{ $cluster->nama_cluster }}</span>
                            </td>
                            <td>
                                <div class="btn-group-actions d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.nama-cluster.edit', $cluster->id) }}" 
                                       class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.nama-cluster.destroy', $cluster->id) }}" 
                                          method="POST" 
                                          class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-delete"
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
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data nama cluster pertama</p>
                    <a href="{{ route('admin.nama-cluster.create') }}" class="btn-add">
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

    document.querySelectorAll('.form-hapus').forEach(form => {
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