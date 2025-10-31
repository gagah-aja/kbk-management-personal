@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 fw-bold">Data Warga</h2>
            <p class="text-secondary">Kelola data anggota keluarga di RT</p>
        </div>
        <!-- Tombol Tambah Warga -->
        <a href="{{ route('admin.warga.tambah.halaman') }}"
            class="btn btn-primary fw-semibold rounded-3 shadow-sm d-flex align-items-center py-2 px-3">
            <i class="bi bi-plus me-2"></i>
            Tambah Warga
        </a>
    </div>

    <!-- KARTU UTAMA -->
    <div class="card border-0 rounded-4 shadow-lg p-4">
        <!-- BAR PENCARIAN -->
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.warga.index') }}" class="d-flex w-100 w-md-50">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control border-start-0 py-2"
                        placeholder="Cari berdasarkan nama atau NIK..."
                        aria-label="Search" aria-describedby="search-addon">
                    <button type="submit" class="btn btn-primary px-4">Cari</button>
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </a>
                </div>
            </form>
        </div>

        <!-- TABEL DATA WARGA -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="border-bottom">
                    <tr class="text-center">
                        <th class="text-start text-muted fw-semibold">NIK</th>
                        <th class="text-start text-muted fw-semibold">NAMA LENGKAP</th>
                        <th class="text-start text-muted fw-semibold">JENIS KELAMIN</th>
                        <th class="text-start text-muted fw-semibold">EMAIL</th>
                        <th class="text-start text-muted fw-semibold">NO. TELP</th>
                        <th class="text-start text-muted fw-semibold">GOLONGAN DARAH</th>
                        <th class="text-start text-muted fw-semibold">AGAMA</th>
                        <th class="text-start text-muted fw-semibold">PENDIDIKAN</th>
                        <th class="text-start text-muted fw-semibold">GAJI</th>
                        <th class="text-start text-muted fw-semibold">TANGGAL LAHIR</th>
                        <th class="text-start text-muted fw-semibold">HUBUNGAN KELUARGA</th>
                        <th class="text-start text-muted fw-semibold">FOTO</th>
                        <th class="text-start text-muted fw-semibold">FOTO KTP</th>
                        <th class="text-start text-muted fw-semibold">ID RUMAH</th>
                        <th class="text-center text-muted fw-semibold">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warga as $data)
                        <tr class="border-bottom text-center">
                            <td class="fw-semibold">{{ $data->nik }}</td>
                            <td>{{ $data->nama_lengkap }}</td>
                            <td>{{ $data->jenis_kelamin }}</td>
                            <td>{{ $data->email ?? '-' }}</td>
                            <td>{{ $data->no_telp ?? '-' }}</td>
                            <td>{{ $data->gol_darah ?? '-' }}</td>
                            <td>{{ $data->agama ?? '-' }}</td>
                            <td>{{ $data->pendidikan_terakhir ?? '-' }}</td>
                            <td>{{ $data->gaji ? 'Rp ' . number_format($data->gaji,0,',','.') : '-' }}</td>
                            <td>{{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $data->hubungan ?? '-' }}</td>
                            <td>
                                @if ($data->foto)
                                    <i class="bi bi-file-earmark-image text-primary" title="Lihat Foto"></i>
                                @else
                                    <i class="fas fa-image text-secondary opacity-50" title="Tidak Ada Foto"></i>
                                @endif
                            </td>
                            <td>
                                @if ($data->foto_ktp)
                                    <i class="bi bi-file-earmark-image text-primary" title="Lihat KTP"></i>
                                @else
                                    <i class="fas fa-id-card text-secondary opacity-50" title="Tidak Ada Foto KTP"></i>
                                @endif
                            </td>
                            <td>{{ $data->id_rumah }}</td>

                            <!-- AKSI -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.warga.edit.halaman', $data->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-3"
                                        title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Hapus -->
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger rounded-3"
                                        title="Hapus Data"
                                        onclick="confirmDelete(event, '{{ $data->id }}', '{{ $data->nama_lengkap }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-2"></i> Tidak ada data warga yang ditemukan.
                            </td>
                        </tr>
                    @endforelse

                    <form id="delete-form" method="POST" style="display: none;">
                        @csrf
                    </form>

                    @if ($warga->hasPages())
                        <tr>
                            <td colspan="15">
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $warga->links('pagination::bootstrap-5') }}
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPT KONFIRMASI HAPUS -->
<script>
    const DELETE_URL_BASE = '{{ route('admin.warga.hapus', ['id' => ':id']) }}';

    function confirmDelete(event, id, nama) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Anda akan menghapus data warga <strong>${nama}</strong>.<br>Data yang dihapus tidak dapat dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = DELETE_URL_BASE.replace(':id', id);
                form.submit();
            }
        });
    }
</script>

<style>
    /* Efek hover lembut untuk tombol aksi */
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff !important;
        transition: 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff !important;
        transition: 0.2s ease;
    }
</style>
@endsection
