@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">📋 Data RW</h2>

    {{-- Tombol Tambah RW --}}
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahRwModal">
        + Tambah Data RW
    </button>

    {{-- Modal Tambah RW --}}
    <div class="modal fade" id="tambahRwModal" tabindex="-1" aria-labelledby="tambahRwLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahRwLabel">Tambah Data RW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.rw.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomor_rw" class="form-label">Nomor RW</label>
                            <input type="number" name="nomor_rw" id="nomor_rw" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_warga" class="form-label">Pilih Ketua RW (Warga)</label>
                            <select name="id_warga" id="id_warga" class="form-select" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach($wargas as $warga)
                                    @php
                                        $sudahKetua = $rws->contains('id_warga', $warga->id);
                                    @endphp
                                    <option value="{{ $warga->id }}" {{ $sudahKetua ? 'disabled' : '' }}>
                                        {{ $warga->nama_lengkap }} ({{ $warga->nik }})
                                        {{ $sudahKetua ? '— Sudah jadi Ketua RW' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit RW --}}
    <div class="modal fade" id="editRwModal" tabindex="-1" aria-labelledby="editRwLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRwLabel">Edit Data RW</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="form-edit-rw">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nomor_rw" class="form-label">Nomor RW</label>
                            <input type="number" name="nomor_rw" id="edit_nomor_rw" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_warga" class="form-label">Pilih Ketua RW (Warga)</label>
                            <select name="id_warga" id="edit_id_warga" class="form-select" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach($wargas as $warga)
                                    <option value="{{ $warga->id }}">{{ $warga->nama_lengkap }} ({{ $warga->nik }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabel Daftar RW --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white fw-semibold">
            Daftar RW
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle text-center" id="table-rw">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor RW</th>
                        <th>NIK Ketua RW</th>
                        <th>Nama Ketua RW</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rws as $index => $rw)
                        <tr data-id="{{ $rw->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td class="nomor-rw">{{ $rw->nomor_rw }}</td>
                            <td class="nik-rw">{{ $rw->warga->nik ?? '-' }}</td>
                            <td class="nama-rw">{{ $rw->warga->nama_lengkap ?? '-' }}</td>
                            <td>
                                {{-- Tombol Edit --}}
                                <button type="button" 
                                        class="btn btn-sm btn-warning btn-edit"
                                        data-id="{{ $rw->id }}"
                                        data-nomor="{{ $rw->nomor_rw }}"
                                        data-warga="{{ $rw->id_warga }}">
                                    Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.rw.destroy', $rw->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Belum ada data RW.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Notifikasi Sukses --}}
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

{{-- Notifikasi Error Validasi --}}
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

{{-- Konfirmasi Hapus --}}
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data RW yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

// Tombol Edit RW
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const nomor = this.dataset.nomor;
        const wargaId = this.dataset.warga;

        document.getElementById('edit_nomor_rw').value = nomor;
        document.getElementById('edit_id_warga').value = wargaId;

        // Set action form edit
        document.getElementById('form-edit-rw').action = `/admin/data-rw/${id}`;
        
        // Tampilkan modal edit
        new bootstrap.Modal(document.getElementById('editRwModal')).show();
    });
});
</script>
@endsection
