@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah RT</h2>
            <p>Tambahkan data Rukun Tetangga baru</p>
        </div>
        {{-- <a href="{{ route('admin.rt.index') }}" class="btn-back">
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

    @if (session('info'))
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <form action="{{ route('admin.rt.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="nomor_rt" class="form-label">
                                Nomor RT <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   name="nomor_rt" 
                                   id="nomor_rt" 
                                   class="form-control @error('nomor_rt') is-invalid @enderror" 
                                   placeholder="Contoh: 001, 002"
                                   value="{{ old('nomor_rt') }}"
                                   required>
                            @error('nomor_rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="id_warga" class="form-label">
                                Ketua RT <span class="text-danger">*</span>
                            </label>
                            <select name="id_warga" 
                                    id="id_warga" 
                                    class="form-control @error('id_warga') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Ketua RT --</option>
                                @foreach($warga as $w)
                                    <option value="{{ $w->id }}" {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_warga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Warga yang sudah menjadi Ketua RT tidak ditampilkan</small>
                        </div>

                        <div class="col-md-4">
                            <label for="id_rw" class="form-label">
                                RW <span class="text-danger">*</span>
                            </label>
                            <select name="id_rw" 
                                    id="id_rw" 
                                    class="form-control @error('id_rw') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih RW --</option>
                                @foreach($rwList as $rw)
                                    <option value="{{ $rw->id }}" {{ old('id_rw') == $rw->id ? 'selected' : '' }}>
                                        RW {{ $rw->nomor_rw }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-hint mt-3">
                        <i class="bi bi-info-circle"></i>
                        Field bertanda <span class="text-danger">*</span> wajib diisi
                    </div>

                    <div class="d-flex gap-2 pt-4 mt-4" style="border-top: 1px solid #e5e7eb;">
                        <a href="{{ route('admin.rt.index') }}" class="btn-cancel">
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