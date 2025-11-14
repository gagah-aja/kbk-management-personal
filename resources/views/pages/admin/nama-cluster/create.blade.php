@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah Nama Cluster</h2>
            <p>Tambahkan data nama cluster baru</p>
        </div>
        {{-- <a href="{{ route('admin.nama-cluster.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a> --}}
    </div>

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

    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="form-card">
                <form action="{{ route('admin.nama-cluster.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nama_cluster" class="form-label">
                            Nama Cluster <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama_cluster" 
                               id="nama_cluster"
                               class="form-control @error('nama_cluster') is-invalid @enderror" 
                               placeholder="Contoh: Cluster A, Cluster Premium, dll"
                               value="{{ old('nama_cluster') }}"
                               required
                               autofocus>
                        @error('nama_cluster')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Nama cluster harus unik dan belum terdaftar
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3">
                        <a href="{{ route('admin.nama-cluster.index') }}" class="btn-cancel">
                            <i class="bi bi-x"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection