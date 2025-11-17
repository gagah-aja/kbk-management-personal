@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah Blok</h2>
            <p>Tambahkan data blok baru</p>
        </div>
        {{-- <a href="{{ route('admin.blok.index') }}" class="btn-back">
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
                <form action="{{ route('admin.blok.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
    <label for="nama_blok" class="form-label">
        Nama Blok <span class="text-danger">*</span>
    </label>
    <select name="nama_blok" id="nama_blok" class="form-select @error('nama_blok') is-invalid @enderror" required>
        <option value="">-- Pilih Blok --</option>
        @foreach (range('A', 'Z') as $letter)
            <option value="{{ $letter }}" {{ old('nama_blok') == $letter ? 'selected' : '' }}>
                {{ $letter }}
            </option>
        @endforeach
    </select>
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
                            <i class="bi bi-x"></i> Kembali
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