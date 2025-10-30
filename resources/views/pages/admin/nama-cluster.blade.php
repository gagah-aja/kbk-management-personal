@extends('layouts.admin.admin')

@section('content')
<div class="p-6">

    {{-- 🏷️ Judul Halaman --}}
    <h1 class="text-2xl font-bold mb-4">Daftar Cluster</h1>

    {{-- ➕ Tombol Tambah Cluster --}}
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahClusterModal">
        + Tambah Cluster
    </button>

    {{-- 🧩 Modal Tambah Cluster --}}
    <div class="modal fade" id="tambahClusterModal" tabindex="-1" aria-labelledby="tambahClusterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahClusterLabel">Tambah Cluster</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.nama-cluster.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaCluster" class="form-label">Nama Cluster</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="namaCluster" 
                                   name="nama_cluster" 
                                   placeholder="Masukkan nama cluster" 
                                   required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- 📋 Tabel Daftar Cluster --}}
    <div class="table-responsive mt-4">
        <table class="table table-bordered align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Cluster</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($namaClusters->sortBy('id') as $cluster)
                    <tr class="text-center">
                        {{-- Nomor urut otomatis --}}
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cluster->nama_cluster }}</td>
                        <td>
                            {{-- Tombol Edit --}}
                            <button type="button" 
                                    class="btn btn-sm btn-warning text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $cluster->id }}">
                                Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.nama-cluster.destroy', $cluster->id) }}" 
                                  method="POST" 
                                  class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger btn-hapus"
                                        data-nama="{{ $cluster->nama_cluster }}">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- 🛠️ Modal Edit Cluster --}}
                    <div class="modal fade" 
                         id="editModal{{ $cluster->id }}" 
                         tabindex="-1" 
                         aria-labelledby="editModalLabel{{ $cluster->id }}" 
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel{{ $cluster->id }}">Edit Cluster</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('admin.nama-cluster.update', $cluster->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="namaCluster{{ $cluster->id }}" class="form-label">Nama Cluster</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="namaCluster{{ $cluster->id }}" 
                                                   name="nama_cluster" 
                                                   value="{{ $cluster->nama_cluster }}" 
                                                   required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ✅ SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ✅ Notifikasi Sukses --}}
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000
});
</script>
@endif

{{-- ✅ Konfirmasi Hapus SweetAlert --}}
<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const nama = form.querySelector('.btn-hapus').getAttribute('data-nama');
        Swal.fire({
            title: `Hapus cluster "${nama}"?`,
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
