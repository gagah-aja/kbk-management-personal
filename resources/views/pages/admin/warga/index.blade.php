@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Data Warga</h2>
            <p>Kelola data warga perumahan</p>
        </div>
        <a href="{{ route('admin.warga.create') }}" class="btn btn-dark">
            <i class="bi bi-plus"></i> Tambah Warga
        </a>
    </div>

    {{-- Search Box --}}
<div class="data-card mb-3">
    <form action="{{ route('admin.warga.index') }}" method="GET">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0"
                   placeholder="Cari nama, NIK, atau no telepon..."
                   value="{{ $search ?? '' }}">
            
            {{-- Tombol Cari --}}
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>

            {{-- Tombol Reset --}}
            <a href="{{ route('admin.warga.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>
    </form>
</div>


    {{-- Data List --}}
    <div class="data-card">
        @if ($dataWarga->count() > 0)
            {{-- Accordion --}}
            <div class="accordion" id="accordionWarga">
                @foreach ($dataWarga as $index => $warga)
                    <div class="accordion-item">
                        {{-- Accordion Header --}}
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $warga->id }}">
                                <div class="d-flex align-items-center w-100">

                                    {{-- Foto --}}
                                    <div class="me-3">
                                        @if ($warga->foto)
                                            <img src="{{ asset('storage/' . $warga->foto) }}"
                                                 alt="{{ $warga->nama_lengkap }}"
                                                 class="rounded-circle"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="avatar-circle">
                                                {{ substr($warga->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info Singkat --}}
                                    <div class="flex-grow-1">
                                        <strong>{{ $warga->nama_lengkap }}</strong>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-card-text"></i> {{ $warga->nik }}
                                            @if ($warga->jenis_kelamin == 'Laki-laki')
                                                <span class="badge bg-info ms-2">
                                                    <i class="bi bi-gender-male"></i> L
                                                </span>
                                            @else
                                                <span class="badge bg-danger ms-2">
                                                    <i class="bi bi-gender-female"></i> P
                                                </span>
                                            @endif
                                        </small>
                                    </div>

                                    {{-- Nomor Urut --}}
                                    <span class="badge-number me-2">
                                        {{ $dataWarga->firstItem() + $index }}
                                    </span>
                                </div>
                            </button>
                        </h2>

                        {{-- Accordion Content --}}
                        <div id="collapse{{ $warga->id }}"
                             class="accordion-collapse collapse"
                             data-bs-parent="#accordionWarga">
                            <div class="accordion-body">
                                <div class="row g-3">

                                    {{-- Kolom Kiri --}}
                                    <div class="col-md-6">
                                        {{-- Data Pribadi --}}
                                        <div class="detail-section">
                                            <h6 class="detail-section-title">
                                                <i class="bi bi-person-badge"></i> Data Pribadi
                                            </h6>
                                            <div class="detail-grid">
                                                <div class="detail-item">
                                                    <span class="detail-label">NIK</span>
                                                    <span class="detail-value">{{ $warga->nik }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Nama Lengkap</span>
                                                    <span class="detail-value">{{ $warga->nama_lengkap }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Jenis Kelamin</span>
                                                    <span class="detail-value">{{ $warga->jenis_kelamin }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Tanggal Lahir</span>
                                                    <span class="detail-value">
                                                        {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Agama</span>
                                                    <span class="detail-value">{{ $warga->agama }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Golongan Darah</span>
                                                    <span class="detail-value">{{ $warga->gol_darah ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Data Kontak --}}
                                        <div class="detail-section">
                                            <h6 class="detail-section-title">
                                                <i class="bi bi-telephone"></i> Data Kontak
                                            </h6>
                                            <div class="detail-grid">
                                                <div class="detail-item">
                                                    <span class="detail-label">No. Telepon</span>
                                                    <span class="detail-value">{{ $warga->no_telp ?? '-' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Email</span>
                                                    <span class="detail-value">{{ $warga->email ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Foto KTP --}}
@if ($warga->foto_ktp)
    <div class="detail-section">
        <h6 class="detail-section-title">
            <i class="bi bi-card-image"></i> Foto KTP
        </h6>
        <img src="{{ asset('storage/' . $warga->foto_ktp) }}"
             alt="KTP {{ $warga->nama_lengkap }}"
             class="img-thumbnail ktp-img">
    </div>
@endif

                                    </div>

                                    {{-- Kolom Kanan --}}
                                    <div class="col-md-6">
                                        {{-- Data Rumah --}}
                                        <div class="detail-section">
                                            <h6 class="detail-section-title">
                                                <i class="bi bi-house"></i> Data Keluarga & Rumah
                                            </h6>
                                            <div class="detail-grid">
                                                <div class="detail-item">
                                                    <span class="detail-label">Hubungan Keluarga</span>
                                                    <span class="detail-value">{{ $warga->hubungan }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Alamat Rumah</span>
                                                    <span class="detail-value">
                                                        {{ $warga->rumah->warga->nama_lengkap ?? '-' }}
                                                        - {{ $warga->rumah->cluster->namaCluster->nama_cluster ?? '-' }}
                                                        - {{ $warga->rumah->nomor_rumah ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Pekerjaan --}}
                                        <div class="detail-section">
                                            <h6 class="detail-section-title">
                                                <i class="bi bi-briefcase"></i> Data Pekerjaan & Pendidikan
                                            </h6>
                                            <div class="detail-grid">
                                                <div class="detail-item">
                                                    <span class="detail-label">Pendidikan Terakhir</span>
                                                    <span class="detail-value">{{ $warga->pendidikan_terakhir ?? '-' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Pekerjaan</span>
                                                    <span class="detail-value">{{ $warga->pekerjaan ?? '-' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Gaji</span>
                                                    <span class="detail-value">
                                                        {{ $warga->gaji ? 'Rp ' . number_format($warga->gaji, 0, ',', '.') : '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tombol Aksi --}}
                                        <div class="detail-section">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.warga.edit', $warga->id) }}"
                                                   class="btn-action btn-edit flex-fill">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.warga.destroy', $warga->id) }}"
                                                      method="POST" class="form-hapus flex-fill">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn-action btn-delete w-100"
                                                            data-nama="{{ $warga->nama_lengkap }}">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div> {{-- End Kolom Kanan --}}

                                </div> {{-- End Row --}}
                            </div> {{-- End Accordion Body --}}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper mt-3">
                <div class="d-flex justify-content-between flex-wrap gap-3 align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $dataWarga->firstItem() }} - {{ $dataWarga->lastItem() }}
                        dari {{ $dataWarga->total() }} data
                    </div>
                    <div>
                        {{ $dataWarga->appends(request()->except('page'))->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>

        @else
            {{-- Empty State --}}
            <div class="empty-state text-center py-5">
                <i class="bi bi-inbox display-4 text-muted"></i>
                @if ($search)
                    <h5 class="mt-3 fw-bold">Tidak Ada Hasil</h5>
                    <p class="text-muted">Pencarian untuk "<strong>{{ $search }}</strong>" tidak ditemukan.</p>
                    <a href="{{ route('admin.warga.index') }}" 
                       class="btn btn-outline-secondary btn-sm mt-2 px-3 py-1"
                       style="font-size: 14px;">Reset</a>
                @else
                    <h5 class="mt-3 fw-bold">Belum Ada Data</h5>
                    <p class="text-muted">Silakan tambahkan data warga pertama Anda.</p>
                    <a href="{{ route('admin.warga.create') }}" class="btn btn-primary mt-2 px-4">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
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

    // Delete
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = this.querySelector('button').dataset.nama;

            Swal.fire({
                title: 'Hapus Data Warga?',
                html: `Data warga <strong>"${nama}"</strong> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>

{{-- Styles --}}
<style>
/* ======================================== */
/* ACCORDION ITEM & HEADER                  */
/* ======================================== */
.accordion-item {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 1rem;
    overflow: hidden;
}

.accordion-button {
    background: #fff;
    padding: 1rem 1.25rem;
    font-size: 0.95rem;
}

.accordion-button:not(.collapsed) {
    background: #f8fafc;
    color: #1e293b;
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: #e2e8f0;
}

/* ======================================== */
/* AVATAR & FOTO KTP                        */
/* ======================================== */
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    transition: transform 0.2s ease;
}

.accordion-button img,
.detail-section img.img-thumbnail {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    transition: transform 0.2s ease;
}

/* Hover zoom effect desktop */
@media (min-width: 769px) {
    .accordion-button img:hover,
    .avatar-circle:hover,
    .detail-section img.img-thumbnail:hover {
        transform: scale(1.1);
    }
}

/* ======================================== */
/* DETAIL SECTION                           */
/* ======================================== */
.detail-section {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.detail-section-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0.5rem;
}

.detail-grid {
    display: grid;
    gap: 0.75rem;
}

.detail-item .detail-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}

.detail-item .detail-value {
    font-size: 0.9rem;
    color: #1e293b;
}

/* ======================================== */
/* RESPONSIVE MOBILE                        */
/* ======================================== */
@media (max-width: 768px) {

    /* Accordion header → stack items */
    .accordion-button .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .accordion-button .me-3 {
        margin-bottom: 0.5rem !important;
    }

    .badge-number {
        align-self: flex-start;
        margin-top: 0.5rem;
    }

    /* Detail section 2 kolom → 1 kolom */
    .accordion-body .row.g-3 {
        flex-direction: column;
    }

    .col-md-6 {
        width: 100% !important;
    }

    /* Detail section padding & font */
    .detail-section {
        padding: 0.75rem;
    }

    .detail-section-title {
        font-size: 0.85rem;
    }

    .detail-item .detail-label {
        font-size: 0.7rem;
    }

    .detail-item .detail-value {
        font-size: 0.85rem;
    }

    /* Tombol aksi full-width */
    .detail-section .d-flex.gap-2 {
        flex-direction: column;
    }

    .detail-section .btn-action {
        width: 100%;
    }

    /* Avatar lebih besar di mobile */
    .accordion-button img,
    .avatar-circle {
        width: 55px;
        height: 55px;
        font-size: 1.1rem;
    }

    /* Foto KTP responsif dengan proporsi asli */
    .detail-section img.img-thumbnail.ktp-img {
        width: auto;
        max-width: 100%;
        height: auto;
        aspect-ratio: 856 / 540; /* rasio KTP asli */
        display: block;
        object-fit: cover;
    }

    /* Form input & select full-width */
    input.form-control,
    select.form-select,
    textarea.form-control {
        width: 100%;
    }

    /* Hapus margin horizontal untuk card/detail di mobile */
    .form-card {
        margin-left: 0;
        margin-right: 0;
    }
}


</style>



@endsection
