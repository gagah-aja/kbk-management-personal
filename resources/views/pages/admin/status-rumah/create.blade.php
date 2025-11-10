@extends('layouts.admin.admin')

@section('title', 'Tambah Status Rumah')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Status Rumah</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.status-rumah.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_status" class="form-label">Nama Status Rumah</label>
                    <input 
                        type="text" 
                        name="nama_status" 
                        id="nama_status" 
                        class="form-control @error('nama_status') is-invalid @enderror" 
                        value="{{ old('nama_status') }}" 
                        placeholder="Contoh: Ditempati, Kosong, Disewakan" 
                        required
                    >
                    @error('nama_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.status-rumah.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
