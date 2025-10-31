@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    {{-- 🔹 Judul Halaman --}}
    <h2 class="fw-bold mb-3">🏘️ Data Cluster</h2>

    {{-- 🔘 Tombol Tambah Data Cluster --}}
    <div class="mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahCluster">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data Cluster
        </button>
    </div>

    {{-- ✅ Notifikasi sukses --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif

    {{-- ⚠️ Error validasi --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                });
            });
        </script>
    @endif

    {{-- 📋 Daftar Cluster --}}
    <div class="row g-3">
        @forelse($clusters as $cluster)
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-2">Cluster #{{ $loop->iteration }}</h5>
                        <p class="mb-1"><strong>Nama Cluster:</strong> {{ $cluster->id_nama_cluster }}</p>
                        <p class="mb-1"><strong>RT:</strong> {{ $cluster->id_rt }}</p>
                        <p class="mb-2"><strong>Blok:</strong> {{ $cluster->id_blok }}</p>

                        <div class="d-flex gap-2">
                            {{-- Tombol Edit --}}
                            <button class="btn btn-sm btn-warning flex-fill" data-bs-toggle="modal" data-bs-target="#modalEditCluster{{ $cluster->id }}">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.data-cluster.destroy', $cluster->id) }}" method="POST" class="delete-form flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Modal Edit Cluster --}}
            <div class="modal fade" id="modalEditCluster{{ $cluster->id }}" tabindex="-1" aria-labelledby="modalEditClusterLabel{{ $cluster->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title fw-semibold" id="modalEditClusterLabel{{ $cluster->id }}">Edit Data Cluster</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('admin.data-cluster.update', $cluster->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Cluster</label>
                                        <select name="id_nama_cluster" class="form-select" required>
                                            @foreach($nama_clusters as $nc)
                                                <option value="{{ $nc->id }}" {{ $cluster->id_nama_cluster == $nc->id ? 'selected' : '' }}>
                                                    {{ $nc->nama_cluster }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">RT</label>
                                        <select name="id_rt" class="form-select" required>
                                            @foreach($rts as $rt)
                                                <option value="{{ $rt->id }}" {{ $cluster->id_rt == $rt->id ? 'selected' : '' }}>
                                                    RT {{ $rt->nomor_rt }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Blok</label>
                                        <select name="id_blok" class="form-select" required>
                                            @foreach($bloks as $blok)
                                                <option value="{{ $blok->id }}" {{ $cluster->id_blok == $blok->id ? 'selected' : '' }}>
                                                    {{ $blok->nama_blok }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning text-white">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-inboxes display-6"></i>
                <p class="mt-3">Belum ada data cluster.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- 🔹 Modal Tambah Cluster --}}
<div class="modal fade" id="modalTambahCluster" tabindex="-1" aria-labelledby="modalTambahClusterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold" id="modalTambahClusterLabel">Tambah Data Cluster</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.data-cluster.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nama Cluster</label>
                            <select name="id_nama_cluster" class="form-select" required>
                                <option value="">-- Pilih Nama Cluster --</option>
                                @foreach($nama_clusters as $nc)
                                    <option value="{{ $nc->id }}">{{ $nc->nama_cluster }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">RT</label>
                            <select name="id_rt" class="form-select" required>
                                <option value="">-- Pilih RT --</option>
                                @foreach($rts as $rt)
                                    <option value="{{ $rt->id }}">RT {{ $rt->nomor_rt }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Blok</label>
                            <select name="id_blok" class="form-select" required>
                                <option value="">-- Pilih Blok --</option>
                                @foreach($bloks as $blok)
                                    <option value="{{ $blok->id }}">{{ $blok->nama_blok }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert & Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data cluster akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
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
