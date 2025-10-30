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
                <div class="input-group w-100 w-md-50">
                    <!-- Menggunakan input-group untuk meletakkan ikon di dalam input -->
                    <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 rounded-end-3 py-2"
                        placeholder="Cari berdasarkan nama atau NIK..." aria-label="Search" aria-describedby="search-addon">
                </div>
            </div>

            <!-- TABEL DATA WARGA -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="border-bottom">
                        <tr>
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
                            <tr class="border-bottom">
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
                                        <i class="fas fa-image text-primary" title="Foto Tersedia"></i>
                                    @else
                                        <i class="fas fa-image text-secondary opacity-50" title="Tidak Ada Foto"></i>
                                    @endif
                                </td>

                                {{-- 7. FOTO KTP (Tampilkan ikon jika ada data, atau biarkan kosong jika null/kosong) --}}
                                <td>
                                    @if ($data->foto_ktp)
                                        <i class="fas fa-id-card text-success" title="Foto KTP Tersedia"></i>
                                    @else
                                        <i class="fas fa-id-card text-secondary opacity-50" title="Tidak Ada Foto KTP"></i>
                                    @endif
                                </td>

                                {{-- 8. ID Rumah --}}
                                <td>{{ $data->id_rumah }}</td>

                                {{-- 9. Aksi (Edit dan Hapus) --}}
                                <td class="text-center">
                                    <a href="#" class="text-secondary me-3" title="Edit Data"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="text-danger" title="Hapus Data"><i
                                            class="fas fa-trash-alt"></i></a>
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
@endsection
