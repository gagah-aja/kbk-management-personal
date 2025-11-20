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

                        <div class="col-md-6">
                            <label for="id_warga" class="form-label">
                                Ketua RW <span class="text-danger">*</span>
                            </label>
                            <!-- NOTICE: form-control DIHAPUS di class -->
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

<!-- ======= SCRIPT SELECT2 (inline supaya pasti dieksekusi) ======= -->
<!-- jQuery (pastikan tidak duplikat jika layout sudah menyertakan jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#id_warga').select2({
            placeholder: "-- Pilih Ketua RW --",
            allowClear: true,
            width: '100%'
        });

        // Jika ingin menampilkan Select2 agar mirip tinggi input bootstrap, bisa aktifkan ini:
        $('.select2-container .select2-selection--single').css({
            'height': $('input.form-control').first().outerHeight() + 'px',
            'padding': '.375rem .75rem',
            'border-radius': '.375rem'
        });
    });
</script>
<!-- ============================================================== -->

@endsection
