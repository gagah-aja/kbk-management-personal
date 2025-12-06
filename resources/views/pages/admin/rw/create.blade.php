@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2>Tambah RW</h2>
                <p>Tambahkan data Rukun Warga baru</p>
            </div>
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
                    <form action="{{ route('admin.rw.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nomor_rw" class="form-label">
                                    Nomor RW <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="nomor_rw" id="nomor_rw"
                                    class="form-control @error('nomor_rw') is-invalid @enderror"
                                    placeholder="Contoh: 001, 002" value="{{ old('nomor_rw') }}" required>
                                @error('nomor_rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="id_warga" class="form-label">
                                    Ketua RW <span class="text-danger">*</span>
                                </label>
                                <select name="id_warga" id="id_warga"
                                    class="form-control @error('id_warga') is-invalid @enderror" required>
                                    <option value="">-- Pilih Ketua RW --</option>
                                    @foreach ($warga as $w)
                                        <option value="{{ $w->id }}"
                                            {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                            {{ $w->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_warga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    Warga yang sudah menjadi Ketua RW tidak ditampilkan
                                </small>
                            </div>
                        </div>

                        <div class="form-hint mt-3">
                            <i class="bi bi-info-circle"></i>
                            Field bertanda <span class="text-danger">*</span> wajib diisi
                        </div>

                        <div class="d-flex gap-2 pt-4 mt-4" style="border-top: 1px solid #e5e7eb;">
                            <a href="{{ route('admin.rw.index') }}" class="btn-cancel">
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


{{-- ========================================================= --}}
{{-- RESPONSIVE MOBILE CSS (TIDAK MENGUBAH TAMPILAN ASLI) --}}
{{-- ========================================================= --}}
<style>
    @media (max-width: 768px) {

        /* Kolom menjadi full-width */
        .row .col-md-4,
        .row .col-md-6,
        .row .col-lg-6,
        .row .col-6 {
            width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* Form card supaya tidak mepet */
        .form-card {
            padding: 1rem !important;
        }

        .form-card .form-label {
            font-size: 0.9rem !important;
        }

        .form-card .form-control,
        .form-card .form-select {
            font-size: 0.95rem !important;
        }

        /* Select2 fix */
        .select2-container,
        .select2-container--bootstrap-5 {
            width: 100% !important;
        }

        /* Tombol dibuat stack tanpa merubah tampilan */
        .d-flex.gap-2 {
            flex-direction: column !important;
            gap: 0.75rem !important;
        }

        .btn-cancel,
        .btn-submit {
            width: 100% !important;
        }
    }
</style>
