@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Data Warga</h2>
            <p>Kelola data warga perumahan</p>
        </div>
        <a href="{{ route('admin.warga.create') }}" class="btn-add">
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
                <input type="text" 
                       name="search" 
                       class="form-control border-start-0" 
                       placeholder="Cari nama, NIK, atau no telepon..."
                       value="{{ $search ?? '' }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="data-card">
        @if($dataWarga->count() > 0)
            {{-- Accordion List --}}
            <div class="accordion" id="accordionWarga">
                @foreach($dataWarga as $index => $warga)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapse{{ $warga->id }}" aria-expanded="false">
                            <div class="d-flex align-items-center w-100">
                                {{-- Foto --}}
                                <div class="me-3">
                                    @if($warga->foto)
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
                                    <strong class="d-block">{{ $warga->nama_lengkap }}</strong>
                                    <small class="text-muted">
                                        <i class="bi bi-card-text"></i> {{ $warga->nik }} 
                                        @if($warga->jenis_kelamin == 'Laki-laki')
                                            <span class="badge bg-info ms-2"><i class="bi bi-gender-male"></i> L</span>
                                        @else
                                            <span class="badge bg-danger ms-2"><i class="bi bi-gender-female"></i> P</span>
                                        @endif
                                    </small>
                                </div>
                                
                                {{-- Nomor Urut --}}
                                <span class="badge-number me-2">{{ $dataWarga->firstItem() + $index }}</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{ $warga->id }}" class="accordion-collapse collapse" 
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
                                                <span class="detail-value">{{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d/m/Y') }}</span>
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
                                    @if($warga->foto_ktp)
                                    <div class="detail-section">
                                        <h6 class="detail-section-title">
                                            <i class="bi bi-card-image"></i> Foto KTP
                                        </h6>
                                        <img src="{{ asset('storage/' . $warga->foto_ktp) }}" 
                                             alt="KTP {{ $warga->nama_lengkap }}"
                                             class="img-thumbnail"
                                             style="max-width: 300px;">
                                    </div>
                                    @endif
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    {{-- Data Keluarga & Rumah --}}
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
                                                <span class="detail-value">{{ $warga->rumah->alamat ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Data Pekerjaan & Pendidikan --}}
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
                                                <span class="detail-label">Gaji/Penghasilan</span>
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
                                                  method="POST" 
                                                  class="form-hapus flex-fill">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted">
                    Menampilkan {{ $dataWarga->firstItem() }} - {{ $dataWarga->lastItem() }} 
                    dari {{ $dataWarga->total() }} data
                </div>
                <div>
                    {{ $dataWarga->links() }}
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                @if($search)
                    <h5>Tidak Ada Hasil</h5>
                    <p>Tidak ada hasil untuk "{{ $search }}"</p>
                    <a href="{{ route('admin.warga.index') }}" class="btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                @else
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data warga pertama</p>
                    <a href="{{ route('admin.warga.create') }}" class="btn-add">
                        <i class="bi bi-plus"></i> Tambah Data
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<style>
/* Accordion Custom Styles */
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

.accordion-button::after {
    margin-left: auto;
}

.accordion-body {
    padding: 1.5rem 1.25rem;
    background: #fff;
}

/* Avatar Circle */
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}

/* Detail Section */
.detail-section {
    background: #f8fafc;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.detail-section-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e2e8f0;
}

.detail-section-title i {
    margin-right: 0.5rem;
    color: #667eea;
}

.detail-grid {
    display: grid;
    gap: 0.75rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    font-weight: 500;
}

.detail-value {
    font-size: 0.9rem;
    color: #1e293b;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .accordion-button {
        padding: 0.875rem;
    }
    
    .accordion-button .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .accordion-button .me-3 {
        margin-bottom: 0.5rem;
    }
    
    .detail-section {
        padding: 0.75rem;
    }
}
</style>
@endsection