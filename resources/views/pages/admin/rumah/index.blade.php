@extends('layouts.admin.admin')
@section('content')

<style>
/* styling sama seperti punyamu sebelumnya */
.card-rumah { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08); transition:0.3s; display:flex; flex-direction:column; height:100%; }
.card-rumah:hover { transform:translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
.card-rumah-body { padding:1rem; flex:1; display:flex; flex-direction:column; }
.card-rumah-title { font-size:1.1rem; font-weight:600; color:#1e293b; }
.badge-status { padding:0.3rem 0.6rem; font-size:0.7rem; font-weight:600; border-radius:6px; text-transform:uppercase; }
.badge-success { background:#10b981; color:#fff; }
.badge-primary { background:#3b82f6; color:#fff; }
.badge-danger  { background:#ef4444; color:#fff; }
.badge-secondary { background:#6b7280; color:#fff; }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2>Data Rumah</h2>
            <p>Kelola data rumah perumahan</p>
        </div>
        <a href="{{ route('admin.rumah.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Rumah
        </a>
    </div>

    {{-- 🔍 Form Search --}}
    <form method="GET" action="{{ route('admin.rumah.index') }}" class="mb-4 d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari rumah / cluster / penghuni...">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.rumah.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    {{-- Data Rumah --}}
    <div class="data-card">
        @if($rumah->count() > 0)
            <div class="row g-4">
                @foreach($rumah as $r)
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="card-rumah">
                        <div class="card-rumah-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-rumah-title mb-0">{{ $r->nomor_rumah }}</h5>
                                @php
                                    $statusColor = ['tersedia'=>'success','terisi'=>'primary','rusak'=>'danger'];
                                    $statusNama = $r->statusRumah->nama_status ?? 'unknown';
                                @endphp
                                <span class="badge-status badge-{{ $statusColor[$statusNama] ?? 'secondary' }}">
                                    {{ ucfirst($statusNama) }}
                                </span>
                            </div>

                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> {{ Str::limit($r->alamat_lengkap,50) }}
                            </p>

                            <div class="mb-2">
                                <small class="text-muted d-block">Cluster</small>
                                <strong>{{ $r->cluster->namaCluster->nama_cluster ?? 'N/A' }}</strong>
                                <div class="text-muted small">
                                    RT {{ $r->cluster->rt->nomor_rt ?? '-' }} • 
                                    Blok {{ $r->cluster->blok->nama_blok ?? '-' }}
                                </div>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted d-block">Penghuni</small>
                                @if($r->warga)
                                    <strong>{{ $r->warga->nama }}</strong>
                                @else
                                    <span class="text-muted">Belum ada penghuni</span>
                                @endif
                            </div>

                            {{-- Tombol Maps --}}
                            @if($r->latitude && $r->longitude)
                                @php $mapsUrl = "https://www.google.com/maps?q={$r->latitude},{$r->longitude}"; @endphp
                                <a href="{{ $mapsUrl }}" target="_blank" class="btn btn-sm btn-outline-success w-100 mb-2">
                                    <i class="bi bi-geo"></i> Lihat di Maps
                                </a>
                            @endif

                            {{-- Gambar --}}
                            @if($r->gambar)
                                <button type="button" class="btn btn-sm btn-outline-primary w-100 open-modal-gambar mb-2"
                                    data-gambar="{{ asset('storage/' . $r->gambar) }}"
                                    data-nomor="{{ $r->nomor_rumah }}">
                                    <i class="bi bi-image"></i> Buka Gambar
                                </button>
                            @endif

                            {{-- Aksi --}}
                            <div class="card-rumah-actions d-flex gap-2">
                                <a href="{{ route('admin.rumah.edit', $r->id) }}" class="btn btn-outline-warning btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.rumah.destroy', $r->id) }}" method="POST" class="form-hapus flex-fill">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" data-nama="Rumah {{ $r->nomor_rumah }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- 📄 Pagination Bootstrap --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $rumah->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-state text-center py-5">
                <i class="bi bi-inbox mb-2" style="font-size:2rem;"></i>
                <h5>Belum Ada Data</h5>
                <p>Mulai tambahkan data rumah pertama</p>
                <a href="{{ route('admin.rumah.create') }}" class="btn-add">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>
        @endif
    </div>
</div>

{{-- SweetAlert + Modal sama seperti sebelumnya --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Alert sukses / gagal
    @if(session('success'))
        Swal.fire({icon:'success',title:'Berhasil!',text:'{{ session('success') }}',showConfirmButton:false,timer:2000});
    @endif
    @if(session('error'))
        Swal.fire({icon:'error',title:'Gagal!',text:'{{ session('error') }}'});
    @endif

    // Hapus konfirmasi
    document.querySelectorAll('.form-hapus').forEach(form=>{
        form.addEventListener('submit',function(e){
            e.preventDefault();
            const nama=this.querySelector('button').dataset.nama;
            Swal.fire({
                title:'Hapus Data?',
                html:`<strong>${nama}</strong> akan dihapus permanen.`,
                icon:'warning',showCancelButton:true,
                confirmButtonColor:'#ef4444',cancelButtonColor:'#6b7280',
                confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal'
            }).then(res=>{if(res.isConfirmed) form.submit();});
        });
    });
});
</script>
@endsection
