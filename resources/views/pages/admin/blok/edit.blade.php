@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Edit Blok</h2>
            <p>Perbarui data blok</p>
        </div>
        <a href="{{ route('admin.blok.index') }}" class="btn-back">
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

    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="form-card">
                <div class="info-box">
                    <div class="info-box-label">Data Sebelumnya</div>
                    <div class="info-box-value">{{ $blok->nama_blok }}</div>
                </div>

                <form action="{{ route('admin.blok.update', $blok->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="nama_blok" class="form-label">
                            Nama Blok Baru <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama_blok" 
                               id="nama_blok"
                               class="form-control @error('nama_blok') is-invalid @enderror" 
                               placeholder="Contoh: Blok A, Blok B, dll"
                               value="{{ old('nama_blok', $blok->nama_blok) }}"
                               required
                               autofocus>
                        @error('nama_blok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-info-circle"></i>
                            Nama blok harus unik dan belum terdaftar
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3">
                        <a href="{{ route('admin.blok.index') }}" class="btn-cancel">
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
@endsection