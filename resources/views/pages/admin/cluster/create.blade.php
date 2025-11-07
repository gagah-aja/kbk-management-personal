@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah Cluster</h2>
            <p>Tambahkan data cluster baru</p>
        </div>
        <a href="{{ route('admin.cluster.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
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

    @if (session('info'))
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <form action="{{ route('admin.cluster.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="id_nama_cluster" class="form-label">
                                Nama Cluster <span class="text-danger">*</span>
                            </label>
                            <select name="id_nama_cluster" 
                                    id="id_nama_cluster" 
                                    class="form-control @error('id_nama_cluster') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Nama Cluster --</option>
                                @foreach($nama_clusters as $nc)
                                    <option value="{{ $nc->id }}" {{ old('id_nama_cluster') == $nc->id ? 'selected' : '' }}>
                                        {{ $nc->nama_cluster }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_nama_cluster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="id_rt" class="form-label">
                                RT <span class="text-danger">*</span>
                            </label>
                            <select name="id_rt" 
                                    id="id_rt" 
                                    class="form-control @error('id_rt') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih RT --</option>
                                @foreach($rts as $rt)
                                    <option value="{{ $rt->id }}" {{ old('id_rt') == $rt->id ? 'selected' : '' }}>
                                        RT {{ $rt->nomor_rt }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="id_blok" class="form-label">
                                Blok <span class="text-danger">*</span>
                            </label>
                            <select name="id_blok" 
                                    id="id_blok" 
                                    class="form-control @error('id_blok') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Blok --</option>
                                @foreach($bloks as $blok)
                                    <option value="{{ $blok->id }}" {{ old('id_blok') == $blok->id ? 'selected' : '' }}>
                                        {{ $blok->nama_blok }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_blok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-hint mt-3">
                        <i class="bi bi-info-circle"></i>
                        Field bertanda <span class="text-danger">*</span> wajib diisi
                    </div>

                    <div class="d-flex gap-2 pt-4 mt-4" style="border-top: 1px solid #e5e7eb;">
                        <a href="{{ route('admin.cluster.index') }}" class="btn-cancel">
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