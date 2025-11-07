@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Data Rumah</h2>
            <p>Kelola data rumah perumahan</p>
        </div>
        <a href="{{ route('admin.rumah.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Rumah
        </a>
    </div>

    <div class="data-card">
        @if($rumah->count() > 0)
            {{-- Grid Cards --}}
            <div class="row g-4">
                @foreach($rumah as $r)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card-rumah">
                            {{-- Gambar Rumah --}}
                            <div class="card-rumah-image">
                                @if($r->gambar)
                                    <img src="{{ asset('storage/' . $r->gambar) }}" alt="Rumah {{ $r->nomor_rumah }}">
                                @else
                                    <div class="card-rumah-image-placeholder">
                                        <i class="bi bi-house-door"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="card-rumah-body">
                                {{-- Nomor Rumah & Status --}}
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-rumah-title mb-0">{{ $r->nomor_rumah }}</h5>
                                    @php
                                        $statusColor = [
                                            'tersedia' => 'success',
                                            'terisi' => 'primary',
                                            'rusak' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge-status badge-{{ $statusColor[$r->status] ?? 'secondary' }}">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </div>

                                {{-- Alamat --}}
                                <p class="card-rumah-text mb-2">
                                    <i class="bi bi-geo-alt"></i> {{ Str::limit($r->alamat_lengkap, 50) }}
                                </p>

                                <div class="card-rumah-divider"></div>

                                {{-- Info Cluster --}}
                                <div class="card-rumah-info">
                                    <small class="text-muted d-block">Cluster</small>
                                    <strong>{{ $r->cluster->namaCluster->nama_cluster ?? 'N/A' }}</strong>
                                    <div class="text-muted small">
                                        RT {{ $r->cluster->rt->nomor_rt ?? '-' }} • 
                                        Blok {{ $r->cluster->blok->nama_blok ?? '-' }}
                                    </div>
                                </div>

                                {{-- Info Penghuni --}}
                                <div class="card-rumah-info">
                                    <small class="text-muted d-block">Penghuni</small>
                                    @if($r->warga)
                                        <strong>{{ $r->warga->nama }}</strong>
                                    @else
                                        <span class="text-muted">Belum ada penghuni</span>
                                    @endif
                                </div>

                                {{-- Koordinat --}}
                                @if($r->latitude && $r->longitude)
                                    <div class="card-rumah-info">
                                        <small class="text-muted">
                                            <i class="bi bi-pin-map"></i>
                                            {{ number_format($r->latitude, 6) }}, {{ number_format($r->longitude, 6) }}
                                        </small>
                                    </div>
                                @endif

                                {{-- Tombol Aksi --}}
                                <div class="card-rumah-actions">
                                    <a href="{{ route('admin.rumah.edit', $r->id) }}" class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rumah.destroy', $r->id) }}" 
                                          method="POST" 
                                          class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-delete"
                                                data-nama="Rumah {{ $r->nomor_rumah }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>Belum Ada Data</h5>
                <p>Mulai tambahkan data rumah pertama</p>
                <a href="{{ route('admin.rumah.create') }}" class="btn-add">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
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
                title: 'Hapus Data?',
                html: `<strong>${nama}</strong> dan gambar akan dihapus permanen.`,
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
/* Card Rumah Styles */
.card-rumah {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-rumah:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.card-rumah-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.card-rumah-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-rumah-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.card-rumah-image-placeholder i {
    font-size: 4rem;
    opacity: 0.5;
}

.card-rumah-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-rumah-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
}

.card-rumah-text {
    font-size: 0.875rem;
    color: #64748b;
    line-height: 1.5;
}

.card-rumah-text i {
    margin-right: 0.25rem;
}

.card-rumah-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 0.75rem 0;
}

.card-rumah-info {
    margin-bottom: 0.75rem;
}

.card-rumah-info small {
    font-size: 0.75rem;
}

.card-rumah-info strong {
    font-size: 0.9rem;
    color: #1e293b;
}

.card-rumah-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: auto;
    padding-top: 0.75rem;
    border-top: 1px solid #e2e8f0;
}

.card-rumah-actions .btn-action {
    flex: 1;
    padding: 0.5rem;
    font-size: 0.875rem;
    text-align: center;
}

.badge-status {
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
    text-transform: uppercase;
}

.badge-success {
    background: #10b981;
    color: #fff;
}

.badge-primary {
    background: #3b82f6;
    color: #fff;
}

.badge-danger {
    background: #ef4444;
    color: #fff;
}

.badge-secondary {
    background: #6b7280;
    color: #fff;
}
</style>
@endsection