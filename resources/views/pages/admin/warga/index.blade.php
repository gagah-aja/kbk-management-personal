@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- 📘 Header --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2>Data Warga</h2>
            <p>Kelola data warga perumahan</p>
        </div>
        <a href="{{ route('admin.warga.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Warga
        </a>
    </div>

    {{-- 🔍 Search Box --}}
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

    {{-- 📋 Data Accordion --}}
    <div class="data-card">
        @if($dataWarga->count() > 0)
            <div class="accordion" id="accordionWarga">
                @foreach($dataWarga as $index => $warga)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $warga->id }}" aria-expanded="false">
                                <div class="d-flex align-items-center w-100">
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
                                    <div class="flex-grow-1">
                                        <strong>{{ $warga->nama_lengkap }}</strong>
                                        <small class="text-muted">
                                            <i class="bi bi-card-text"></i> {{ $warga->nik }}
                                            @if($warga->jenis_kelamin == 'Laki-laki')
                                                <span class="badge bg-info ms-2"><i class="bi bi-gender-male"></i> L</span>
                                            @else
                                                <span class="badge bg-danger ms-2"><i class="bi bi-gender-female"></i> P</span>
                                            @endif
                                        </small>
                                    </div>
                                    <span class="badge-number me-2">{{ $dataWarga->firstItem() + $index }}</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $warga->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionWarga">
                            <div class="accordion-body">
                                {{-- Detail Warga --}}
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>Alamat Rumah:</strong> {{ $warga->rumah?->alamat_lengkap ?? '-' }}</div>
                                    <div class="col-md-6"><strong>No. Telepon:</strong> {{ $warga->no_telp ?? '-' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6"><strong>Email:</strong> {{ $warga->email ?? '-' }}</div>
                                    <div class="col-md-6"><strong>Pekerjaan:</strong> {{ $warga->pekerjaan ?? '-' }}</div>
                                </div>

                                {{-- Tombol Edit & Hapus --}}
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('admin.warga.edit', $warga->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('admin.warga.destroy', $warga->id) }}" method="POST" class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-nama="{{ $warga->nama_lengkap }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 📄 Pagination Bulat & Tengah --}}
            @if ($dataWarga->hasPages())
                <div class="pagination-wrapper mt-4">
                    <div class="pagination-container">
                        {{ $dataWarga->appends(['search' => $search ?? ''])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif

        @else
            <div class="empty-state text-center py-5">
                <i class="bi bi-inbox fs-1 mb-3 text-secondary"></i>
                @if($search)
                    <h5>Tidak Ada Hasil</h5>
                    <p>Tidak ada hasil untuk "<strong>{{ $search }}</strong>"</p>
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary mt-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                @else
                    <h5>Belum Ada Data</h5>
                    <p>Mulai tambahkan data warga pertama.</p>
                    <a href="{{ route('admin.warga.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus"></i> Tambah Data
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- 🎨 Style Pagination --}}
<style>
.pagination-wrapper { display:flex; justify-content:center; align-items:center; margin-top:1.5rem; }
.pagination-container { display:flex; justify-content:center; width:100%; }
.pagination { display:flex; flex-wrap:wrap; gap:10px; list-style:none; padding:0; margin:0; }
.pagination .page-item .page-link {
    border:none; border-radius:50%; width:42px; height:42px; display:flex; align-items:center; justify-content:center;
    font-weight:500; font-size:.95rem; color:#374151; background:#f9fafb; transition:all .25s; box-shadow:0 1px 3px rgba(0,0,0,.05);
}
.pagination .page-item .page-link:hover {
    background:#2563eb; color:#fff; transform:translateY(-2px) scale(1.05);
    box-shadow:0 3px 8px rgba(37,99,235,.3);
}
.pagination .page-item.active .page-link {
    background:#2563eb; color:#fff; font-weight:600; box-shadow:0 4px 10px rgba(37,99,235,.4); transform:scale(1.05);
}
.pagination .page-item.disabled .page-link {
    color:#9ca3af; background:#f3f4f6; box-shadow:none; cursor:not-allowed; transform:none;
}
@media(max-width:576px){
    .pagination .page-item .page-link { width:34px; height:34px; font-size:.85rem; }
}
</style>

{{-- 🧩 SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    @if (session('success'))
        Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session('success') }}', showConfirmButton:false, timer:2000 });
    @endif
    @if (session('error'))
        Swal.fire({ icon:'error', title:'Gagal!', text:'{{ session('error') }}', confirmButtonColor:'#ef4444' });
    @endif

    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const nama = form.querySelector('button').dataset.nama;
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
            }).then(r => { if(r.isConfirmed) form.submit(); });
        });
    });
});
</script>
@endsection
