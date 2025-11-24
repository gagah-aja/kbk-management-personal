@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2>Data Rumah</h2>
            <p>Kelola data rumah perumahan</p>
        </div>
        <a href="{{ route('admin.rumah.create') }}" class="btn btn-dark">
            <i class="bi bi-plus"></i> Tambah Rumah
        </a>
    </div>

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('admin.rumah.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari rumah / cluster / penghuni...">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
            <a href="{{ route('admin.rumah.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Reset</a>
        </div>
    </form>

    {{-- Daftar Rumah --}}
    <div class="data-card">
        @if ($rumah->count() > 0)
            <div class="row g-4">
                @foreach ($rumah as $r)
                    <div class="col-md-4 mb-4">
                        <div class="card-rumah p-3 h-100">

                            {{-- Pemilik Rumah --}}
                            <div class="mb-2">
                                <p class="text-muted mb-0"><i class="bi bi-person"></i> Pemilik Rumah</p>
                                <h5 class="fw-bold text-primary text-capitalize">{{ $r->warga->nama_lengkap ?? 'Belum ada pemilik' }}</h5>
                            </div>

                            {{-- Nomor Rumah --}}
                            <h4 class="fw-semibold">{{ $r->nomor_rumah }}</h4>

                            {{-- Cluster --}}
                            <p class="mb-1">
                                Cluster <strong>{{ $r->cluster->namaCluster->nama_cluster ?? '-' }}</strong><br>
                                RT {{ $r->cluster->rt->nomor_rt ?? '-' }} •
                                Blok {{ $r->cluster->blok->nama_blok ?? '-' }}
                            </p>

                            {{-- Status Rumah --}}
                            <div class="mb-2">
                                @if ($r->statusRumah && $r->statusRumah->id == 1)
                                    <span class="badge bg-primary">TERISI</span>
                                @elseif($r->statusRumah && $r->statusRumah->id == 2)
                                    <span class="badge bg-success">TERSEDIA</span>
                                @else
                                    <span class="badge bg-warning">DISEWAKAN</span>
                                @endif
                            </div>

                            {{-- Penghuni --}}
                            <div class="mt-2">
                                @if ($r->penghuniAktif && $r->penghuniAktif->count() > 0)
                                    <span class="text-dark fw-semibold">{{ $r->penghuniAktif->count() }} Orang</span>
                                    <a href="{{ route('admin.rumah.penghuni.show', $r->id) }}" class="btn btn-outline-info btn-sm ms-2">
                                        <i class="bi bi-eye"></i> Lihat Semua
                                    </a>
                                @else
                                    <p class="text-muted mb-1">Belum ada penghuni</p>
                                    <a href="{{ route('admin.rumah.penghuni.create', $r->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="bi bi-person-plus"></i> Tambah Penghuni
                                    </a>
                                @endif
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <a href="https://www.google.com/maps?q={{ $r->latitude }},{{ $r->longitude }}" target="_blank" class="btn btn-outline-success btn-sm w-100">
                                    <i class="bi bi-geo"></i> Lihat di Maps
                                </a>

                                @if ($r->gambar)
                                    <button class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalGambar{{ $r->id }}">
                                        <i class="bi bi-image"></i> Buka Gambar
                                    </button>
                                @endif

                                <div class="d-flex gap-2 w-100">
                                    <a href="{{ route('admin.rumah.edit', $r->id) }}" class="btn btn-outline-warning btn-sm flex-fill">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.rumah.destroy', $r->id) }}" method="POST" class="flex-fill delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100 delete-btn" data-nama="{{ $r->nomor_rumah }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($rumah->hasPages())
                <div class="pagination-wrapper mt-4">
                    {{ $rumah->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="empty-state text-center py-5">
                <i class="bi bi-inbox mb-2" style="font-size:2rem;"></i>
                @if (request('search'))
                    <h5>Tidak Ada Hasil</h5>
                    <p>Tidak ditemukan hasil untuk "<strong>{{ request('search') }}</strong>"</p>
                    <a href="{{ route('admin.rumah.index') }}" class="btn btn-outline-secondary">Reset</a>
                @else
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data rumah pertama</p>
                    <a href="{{ route('admin.rumah.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Tambah Data
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Konfirmasi hapus
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            const namaRumah = this.dataset.nama;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Rumah nomor ${namaRumah} akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Notifikasi success/error
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}"
        });
    @endif

});
</script>
@endsection
