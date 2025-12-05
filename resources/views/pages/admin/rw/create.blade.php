@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah RW</h2>
            <p>Tambahkan data Rukun Warga baru</p>
        </div>
    </div>

    {{-- Error --}}
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

    {{-- Info --}}
    @if (session('info'))
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
        </div>
    @endif

    {{-- Form --}}
    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <form action="{{ route('admin.rw.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        {{-- Nomor RW --}}
                        <div class="col-md-6">
                            <label for="nomor_rw" class="form-label">
                                Nomor RW <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                   name="nomor_rw"
                                   id="nomor_rw"
                                   class="form-control @error('nomor_rw') is-invalid @enderror"
                                   placeholder="Contoh: 001, 002"
                                   value="{{ old('nomor_rw') }}"
                                   min="1"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   required>

                            @error('nomor_rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Ketua RW --}}
                        <div class="col-md-6">
                            <label for="id_warga" class="form-label">
                                Ketua RW <span class="text-danger">*</span>
                            </label>

                            <select name="id_warga"
                                    id="id_warga"
                                    class="@error('id_warga') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Ketua RW --</option>
                                @foreach($warga as $w)
                                    <option value="{{ $w->id }}" {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_lengkap }} ({{ $w->nik }})
                                    </option>
                                @endforeach
                            </select>

                            @error('id_warga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted">Warga yang sudah menjadi Ketua RW tidak ditampilkan</small>
                        </div>
                    </div>

                    <div class="form-hint mt-3">
                        <i class="bi bi-info-circle"></i>
                        Field bertanda <span class="text-danger">*</span> wajib diisi
                    </div>

                    {{-- Tombol --}}
                    <div class="action-buttons" style="border-top:1px solid #e5e7eb; margin-top:25px; padding-top:20px;">
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

{{-- ========================================= --}}
{{-- RESPONSIVE CSS (TIDAK UBAH TAMPILAN) --}}
{{-- ========================================= --}}
<style>
/* Tombol tetap sama di desktop */
.action-buttons {
    display: flex;
    gap: 12px;
}

/* MOBILE MODE */
@media (max-width: 576px) {

    /* kolom kiri kanan berubah jadi 100% */
    .row .col-md-6 {
        width: 100%;
    }

    /* tombol jadi ke bawah */
    .action-buttons {
        flex-direction: column;
        width: 100%;
    }

    .action-buttons a,
    .action-buttons button {
        width: 100%;
    }

    /* select2 mengikuti lebar penuh */
    .select2-container {
        width: 100% !important;
    }
}
</style>

{{-- SELECT2 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#id_warga').select2({
            placeholder: "-- Pilih Ketua RW --",
            allowClear: true,
            width: '100%'
        });
    });
</script>

@endsection
