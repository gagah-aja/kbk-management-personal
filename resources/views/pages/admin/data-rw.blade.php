@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">📋 Data RW</h2>

    {{-- ✅ SweetAlert Notifikasi Sukses --}}
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

    {{-- ⚠️ SweetAlert untuk Error Validasi --}}
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

    {{-- 🔹 Form Tambah RW --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-semibold">
            Tambah Data RW
        </div>
        <div class="card-body">
            <form id="form-tambah-rw" method="POST" action="{{ route('admin.rw.store') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="nomor_rw" class="form-label">Nomor RW</label>
                        <input type="number" name="nomor_rw" id="nomor_rw" class="form-control" required>
                    </div>

                    <div class="col-md-6">
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

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- 📊 Tabel Data RW --}}
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

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Edit Data RW
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            const nomor = this.dataset.nomor;
            const idWarga = this.dataset.warga;

            const { value: formValues } = await Swal.fire({
                title: 'Edit Data RW',
                html: `
                    <label>Nomor RW</label>
                    <input id="swal-nomor" class="form-control mb-2" type="number" value="${nomor}" required>
                    <label>Pilih Ketua RW (Warga)</label>
                    <select id="swal-warga" class="form-select">
                        @foreach($wargas as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_lengkap }} ({{ $w->nik }})</option>
                        @endforeach
                    </select>
                `,
                didOpen: () => {
                    document.getElementById('swal-warga').value = idWarga;
                },
                confirmButtonText: 'Simpan Perubahan',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                preConfirm: () => ({
                    nomor_rw: document.getElementById('swal-nomor').value,
                    id_warga: document.getElementById('swal-warga').value
                })
            });

            if(formValues){
                fetch(`/admin/data-rw/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formValues)
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        const tr = document.querySelector(`tr[data-id="${id}"]`);
                        tr.querySelector('.nomor-rw').textContent = formValues.nomor_rw;
                        tr.querySelector('.nik-rw').textContent = data.rw.warga.nik;
                        tr.querySelector('.nama-rw').textContent = data.rw.warga.nama_lengkap;
                        Swal.fire('Berhasil!', 'Data RW berhasil diperbarui.', 'success');
                    } else {
                        Swal.fire('Gagal!', 'Gagal memperbarui data.', 'error');
                    }
                });
            }
        });
    });

    // Hapus Data RW (tanpa AJAX)
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

});
</script>
@endsection
