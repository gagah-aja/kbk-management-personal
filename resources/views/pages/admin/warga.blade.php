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
                <i class="bi bi-plus"></i>
                Tambah Warga
            </a>

        </div>

        <!-- KARTU UTAMA (CONTAINER UNTUK SEARCH DAN TABEL) -->
        <div class="card border-0 rounded-4 shadow-lg p-4">
            <!-- BAR PENCARIAN -->
          <div class="mb-4">
    <form method="GET" action="{{ route('admin.warga.index') }}" class="d-flex w-100 w-md-50">
        <div class="input-group flex-grow-1">
            {{-- Ikon Search di Depan --}}
            <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3" id="search-addon">
                <i class="fas fa-search"></i>
            </span>

            {{-- Input Pencarian --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control border-start-0 py-2"
                placeholder="Cari berdasarkan nama atau NIK..."
                aria-label="Search"
                aria-describedby="search-addon">

            {{-- Tombol Search --}}
            <button type="submit" class="btn btn-primary px-4">
                Cari
            </button>

            {{-- Tombol Refresh (reset pencarian) --}}
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
                            <th scope="col" class="text-start text-muted fw-semibold">NIK</th>
                            <th scope="col" class="text-start text-muted fw-semibold">NAMA LENGKAP</th>
                            <th scope="col" class="text-start text-muted fw-semibold">JENIS KELAMIN</th>
                            <th scope="col" class="text-start text-muted fw-semibold">HUBUNGAN</th>
                            <th scope="col" class="text-start text-muted fw-semibold">PEKERJAAN</th>
                            <!-- Field Tambahan Sesuai Permintaan Migrasi -->
                            <th scope="col" class="text-start text-muted fw-semibold">FOTO</th>
                            <th scope="col" class="text-start text-muted fw-semibold">FOTO KTP</th>
                            <th scope="col" class="text-start text-muted fw-semibold">ID RUMAH</th>
                            <th scope="col" class="text-center text-muted fw-semibold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($warga as $data)
                            <tr class="border-bottom text-center">
                                {{-- 1. NIK (fw-semibold untuk bold) --}}
                                <td class="fw-semibold">{{ $data->nik }}</td>

                                {{-- 2. Nama Lengkap --}}
                                <td>{{ $data->nama_lengkap }}</td>

                                {{-- 3. Jenis Kelamin --}}
                                <td>{{ $data->jenis_kelamin }}</td>

                                {{-- 4. Hubungan --}}
                                <td>{{ $data->hubungan }}</td>

                                {{-- 5. Pekerjaan --}}
                                <td>{{ $data->pekerjaan }}</td>

                                {{-- 6. FOTO (Tampilkan ikon jika ada data, atau biarkan kosong jika null/kosong) --}}
                                <td>
                                    @if ($data->foto)
                                        <i class="bi bi-file-earmark-image"></i>
                                    @else
                                        <i class="fas fa-image text-secondary opacity-50" title="Tidak Ada Foto"></i>
                                    @endif
                                </td>

                                {{-- 7. FOTO KTP (Tampilkan ikon jika ada data, atau biarkan kosong jika null/kosong) --}}
                                <td>
                                    @if ($data->foto_ktp)
                                        <i class="bi bi-file-earmark-image"></i>
                                    @else
                                        <i class="fas fa-id-card text-secondary opacity-50" title="Tidak Ada Foto KTP"></i>
                                    @endif
                                </td>

                                {{-- 8. ID Rumah --}}
                                <td>{{ $data->id_rumah }}</td>

                                {{-- 9. Aksi (Edit dan Hapus) --}}
                                <td class="text-center">
                                    <a href="{{ route('admin.warga.edit.halaman', $data->id) }}" class="text-secondary me-3"
                                        title="Edit Data"><i class="bi bi-pencil-square"></i></a>
                                    <a href="#" class="text-danger btn-delete" title="Hapus Data"
                                        data-id="{{ $data->id }}" data-nama="{{ $data->nama_lengkap }}"
                                        onclick="confirmDelete(event, '{{ $data->id }}', '{{ $data->nama_lengkap }}')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            {{-- BARIS JIKA DATA WARGA KOSONG --}}
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox me-2"></i> Tidak ada data warga yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                        <form id="delete-form" method="POST" style="display: none;">
                            @csrf
                        </form>
                        {{-- Paginasi hanya ditampilkan jika ada data --}}
                        @if ($warga->hasPages())
                            <tr>
                                <td colspan="9">
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
    <script>
        const DELETE_URL_BASE = '{{ route('admin.warga.hapus', ['id' => ':id']) }}';

        /**
         * Menampilkan konfirmasi SweetAlert2 sebelum menghapus data.
         */
        function confirmDelete(event, id, nama) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Anda akan menghapus data warga <strong>${nama}</strong>. Data yang dihapus tidak dapat dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 1. Ambil form tersembunyi
                    const form = document.getElementById('delete-form');

                    // 2. GANTI PLACEHOLDER dengan ID yang sebenarnya
                    const finalUrl = DELETE_URL_BASE.replace(':id', id);

                    // 3. Set action form ke URL final
                    form.action = finalUrl;

                    // 4. Kirimkan form DELETE
                    form.submit();
                }
            });
        }
    </script>
@endsection
