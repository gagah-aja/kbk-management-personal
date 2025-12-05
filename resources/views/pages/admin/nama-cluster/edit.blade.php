@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Edit Nama Cluster</h2>
            <p>Perbarui data nama cluster</p>
        </div>
    </div>

    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Section --}}
    <div class="row">
        <div class="col-lg-8 col-xl-6">

            <div class="form-card">

                {{-- Box info data lama --}}
                <div class="info-box">
                    <div class="info-box-label">Data Sebelumnya</div>
                    <div class="info-box-value">{{ $namaCluster->nama_cluster }}</div>
                </div>

                {{-- Form Update --}}
                <form action="{{ route('admin.nama-cluster.update', $namaCluster->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Input --}}
                    <div class="mb-4">
                        <label for="nama_cluster" class="form-label">
                            Nama Cluster Baru <span class="text-danger">*</span>
                        </label>

                        <input 
                            type="text" 
                            name="nama_cluster" 
                            id="nama_cluster"
                            class="form-control @error('nama_cluster') is-invalid @enderror" 
                            placeholder="Contoh: Cluster A, Cluster Premium, dll"
                            value="{{ old('nama_cluster', $namaCluster->nama_cluster) }}"
                            required
                            autofocus
                        >

                        @error('nama_cluster')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Nama cluster harus unik dan belum terdaftar
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="action-buttons">
                        <a href="{{ route('admin.nama-cluster.index') }}" class="btn-cancel">
                            <i class="bi bi-x"></i> Batal
                        </a>

                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check"></i> Update Data
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>

{{-- RESPONSIVE CSS --}}
<style>
/* Tombol seperti aslinya namun responsif */
.action-buttons {
    display: flex;
    gap: 10px;
    padding-top: 15px;
}

/* Mobile responsive tanpa mengubah tampilan */
@media (max-width: 576px) {
    .action-buttons {
        flex-direction: column;
    }

    .action-buttons a,
    .action-buttons button {
        width: 100%;
    }
}
</style>

@endsection
