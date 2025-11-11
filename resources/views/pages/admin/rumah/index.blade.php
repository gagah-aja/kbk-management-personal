@extends('layouts.admin.admin')

@section('content')

{{-- Styles --}}
<style>
.card-rumah { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08); transition:0.3s; display:flex; flex-direction:column; height:100%; }
.card-rumah:hover { transform:translateY(-4px); box-shadow:0 4px 16px rgba(0,0,0,0.12); }
.card-rumah-body { padding:1rem; flex:1; display:flex; flex-direction:column; }
.card-rumah-title { font-size:1.1rem; font-weight:600; color:#1e293b; }
.card-rumah-text { font-size:0.85rem; color:#64748b; line-height:1.5; }
.card-rumah-divider { height:1px; background:#e2e8f0; margin:0.5rem 0; }
.card-rumah-info { margin-bottom:0.5rem; }
.card-rumah-actions { display:flex; gap:0.5rem; margin-top:auto; padding-top:0.75rem; border-top:1px solid #e2e8f0; }
/* .card-rumah-actions .btn-action { flex:1; padding:0.4rem; font-size:0.8rem; text-align:center; } */

.card-rumah-actions .btn-action {
    flex:1;
    display: inline-flex;       /* bikin <a> dan <button> sama */
    align-items: center;        /* vertikal center icon & text */
    justify-content: center;    /* horizontal center */
    gap: 0.3rem;                /* jarak icon dan text */
    padding: 0.35rem 0.5rem;    /* sesuaikan */
    font-size: 0.8rem;
    line-height: 1;             /* hapus perbedaan default */
    border-radius: 6px;
    text-decoration: none;      /* untuk <a> */
    border: none;               /* untuk <button> */
    cursor: pointer;
    transition: 0.2s;
}

.btn-add { display:inline-flex; align-items:center; gap:0.3rem; padding:0.4rem 0.6rem; background:#3b82f6; color:#fff; border-radius:6px; text-decoration:none; }
.btn-add i { font-size:0.9rem; }
.empty-state { text-align:center; padding:4rem 1rem; color:#64748b; }
.badge-status { padding:0.3rem 0.6rem; font-size:0.7rem; font-weight:600; border-radius:6px; text-transform:uppercase; }
.badge-success { background:#10b981; color:#fff; }
.badge-primary { background:#3b82f6; color:#fff; }
.badge-danger  { background:#ef4444; color:#fff; }
.badge-secondary { background:#6b7280; color:#fff; }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Rumah</h2>
            <p>Kelola data rumah perumahan</p>
        </div>
        <a href="{{ route('admin.rumah.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Rumah
        </a>
    </div>

    {{-- Data Rumah --}}
    <div class="data-card">
        @if($rumah->count() > 0)
            <div class="row g-4">
                @foreach($rumah as $r)
                    {{-- <div class="col-md-6 col-lg-4 col-xl-3"> --}}
                    <div class="col-md-6 col-lg-4 col-xl-4">
                        <div class="card-rumah">
                            <div class="card-rumah-body">
                                {{-- Nomor Rumah & Status --}}
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

                                {{-- Alamat --}}
                                <p class="card-rumah-text mb-2">
                                    <i class="bi bi-geo-alt"></i> {{ Str::limit($r->alamat_lengkap,50) }}
                                </p>

                                <div class="card-rumah-divider"></div>

                                {{-- Cluster --}}
                                <div class="card-rumah-info">
                                    <small class="text-muted d-block">Cluster</small>
                                    <strong>{{ $r->cluster->namaCluster->nama_cluster ?? 'N/A' }}</strong>
                                    <div class="text-muted small">
                                        RT {{ $r->cluster->rt->nomor_rt ?? '-' }} • 
                                        Blok {{ $r->cluster->blok->nama_blok ?? '-' }}
                                    </div>
                                </div>

                                {{-- Penghuni --}}
                                <div class="card-rumah-info">
                                    <small class="text-muted d-block">Penghuni</small>
                                    @if($r->warga)
                                        <strong>{{ $r->warga->nama }}</strong>
                                    @else
                                        <span class="text-muted">Belum ada penghuni</span>
                                    @endif
                                </div>

                                {{-- Koordinat sebagai tombol Google Maps --}}
                                @if($r->latitude && $r->longitude)
                                    <div class="card-rumah-info mt-2">
                                        @php
                                            $mapsUrl = "https://www.google.com/maps?q={$r->latitude},{$r->longitude}";
                                        @endphp
                                        <a href="{{ $mapsUrl }}" target="_blank" class="btn btn-sm btn-outline-success w-100">
                                            Lihat di Maps
                                        </a>
                                    </div>
                                @endif


                                {{-- Tombol Buka Gambar --}}
                                @if($r->gambar)
                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 open-modal-gambar" 
                                            data-gambar="{{ asset('storage/' . $r->gambar) }}"
                                            data-nomor="{{ $r->nomor_rumah }}">
                                            Buka Gambar
                                    </button>
                                @endif

                                {{-- Aksi --}}
                                <div class="card-rumah-actions mt-3">
                                    <a href="{{ route('admin.rumah.edit', $r->id) }}" class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.rumah.destroy', $r->id) }}" method="POST" class="form-hapus d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" data-nama="Rumah {{ $r->nomor_rumah }}">
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

{{-- Modal Global --}}
<div class="modal fade" id="modalGambarGlobal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGambarTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalGambarImg" src="" alt="" class="img-fluid rounded" style="max-height:400px;width:auto;">
            </div>
            <div class="modal-footer">
                <a id="modalGambarLink" href="#" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-box-arrow-up-right"></i> Buka di Tab Baru
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert & JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Notifikasi
    @if(session('success'))
        Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session('success') }}', showConfirmButton:false, timer:2000 });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Gagal!', text:'{{ session('error') }}', confirmButtonColor:'#ef4444' });
    @endif

    // Konfirmasi hapus
    document.querySelectorAll('.form-hapus').forEach(form=>{
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const nama = this.querySelector('button').dataset.nama;
            Swal.fire({
                title:'Hapus Data?',
                html:`<strong>${nama}</strong> dan gambar akan dihapus permanen.`,
                icon:'warning', showCancelButton:true,
                confirmButtonColor:'#ef4444', cancelButtonColor:'#6b7280',
                confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
                reverseButtons:true
            }).then(result=>{ if(result.isConfirmed) form.submit(); });
        });
    });

    // Modal Global Gambar
    const modal = new bootstrap.Modal(document.getElementById('modalGambarGlobal'));
    const imgModal = document.getElementById('modalGambarImg');
    const titleModal = document.getElementById('modalGambarTitle');
    const linkModal = document.getElementById('modalGambarLink');

    document.querySelectorAll('.open-modal-gambar').forEach(btn=>{
        btn.addEventListener('click', function(){
            const src = this.dataset.gambar;
            const nomor = this.dataset.nomor;
            imgModal.src = src;
            titleModal.textContent = `Gambar Rumah ${nomor}`;
            linkModal.href = src; // link untuk tab baru
            modal.show();
        });
    });
});
</script>


@endsection
