@extends('layouts.admin.admin')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Daftar Nama Blok</h1>

    {{-- Tombol Tambah --}}
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahNamaBlokModal">
        + Tambah Nama Blok
    </button>

    {{-- Modal Tambah Nama Blok --}}
    <div class="modal fade" id="tambahNamaBlokModal" tabindex="-1" aria-labelledby="tambahNamaBlokLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Nama Blok</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.blok.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Blok</label>
                            <input type="text" name="nama_blok" class="form-control" placeholder="Masukkan nama blok" required>
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

    {{-- Tabel Daftar Nama Blok --}}
    <div class="table-responsive mt-4">
        <table class="table table-bordered align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Blok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bloks as $blok)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $blok->nama_blok }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <button type="button" class="btn btn-sm btn-warning text-white"
                            data-bs-toggle="modal" data-bs-target="#editModal{{ $blok->id }}">
                            Edit
                        </button>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.blok.destroy', $blok->id) }}" method="POST" class="d-inline form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-hapus" data-nama="{{ $blok->nama_blok }}">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal{{ $blok->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Edit Nama Blok</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('admin.blok.update', $blok->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Blok</label>
                                        <input type="text" name="nama_blok" class="form-control"
                                               value="{{ $blok->nama_blok }}" required>
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

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<script>
document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        const nama = form.querySelector('.btn-hapus').dataset.nama;
        Swal.fire({
            title: `Hapus blok "${nama}"?`,
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endsection
