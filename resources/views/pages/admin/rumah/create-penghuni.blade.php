@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="page-header mb-4">
            <h2>Tambah Penghuni</h2>
            <p>Rumah: <strong>{{ $rumah->nomor_rumah }}</strong> - {{ $rumah->alamat_lengkap }}</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.rumah.penghuni.store', $rumah->id) }}" method="POST">
                    @csrf

                    {{-- Pilih Warga --}}
                    <div class="mb-3">
                        <label for="id_warga" class="form-label">
                            Pilih Warga <span class="text-danger">*</span>
                        </label>
                        <select name="id_warga" id="id_warga"
                            class="form-select form-control select2-warga @error('id_warga') is-invalid @enderror" required>
                            <option value="">-- Pilih Warga --</option>
                            @foreach ($warga as $w)
                                <option value="{{ $w->id }}" {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nama_lengkap }} - {{ $w->nik }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_warga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipe Penghuni --}}
                    <div class="mb-3">
                        <label for="tipe_penghuni" class="form-label">Tipe Penghuni <span
                                class="text-danger">*</span></label>
                        <select name="tipe_penghuni" id="tipe_penghuni"
                            class="form-select @error('tipe_penghuni') is-invalid @enderror" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Pemilik" {{ old('tipe_penghuni') == 'Pemilik' ? 'selected' : '' }}>🏠 Pemilik
                            </option>
                            <option value="Penyewa" {{ old('tipe_penghuni') == 'Penyewa' ? 'selected' : '' }}>🏘️ Penyewa
                            </option>
                        </select>
                        @error('tipe_penghuni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Penghuni --}}
                    <div class="mb-3">
                        <label for="status_penghuni" class="form-label">Status Penghuni <span
                                class="text-danger">*</span></label>
                        <select name="status_penghuni" id="status_penghuni"
                            class="form-select @error('status_penghuni') is-invalid @enderror" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Kepala Keluarga"
                                {{ old('status_penghuni') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga
                            </option>
                            <option value="Istri" {{ old('status_penghuni') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Suami" {{ old('status_penghuni') == 'Suami' ? 'selected' : '' }}>Suami</option>
                            <option value="Anak" {{ old('status_penghuni') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Orang Tua" {{ old('status_penghuni') == 'Orang Tua' ? 'selected' : '' }}>Orang
                                Tua</option>
                            <option value="Keluarga Lainnya"
                                {{ old('status_penghuni') == 'Keluarga Lainnya' ? 'selected' : '' }}>Keluarga Lainnya
                            </option>
                        </select>
                        @error('status_penghuni')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Masuk --}}
                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                            class="form-control @error('tanggal_masuk') is-invalid @enderror"
                            value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                            rows="3" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Penghuni
                        </button>
                        <a href="{{ route('admin.rumah.penghuni.show', $rumah->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    {{-- Include Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    {{-- Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Initialize Select2 untuk dropdown warga
        $(document).ready(function() {
            $('.select2-warga').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih warga...',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "❌ Tidak ada hasil yang ditemukan";
                    },
                    searching: function() {
                        return "🔄 Mencari...";
                    },
                    inputTooShort: function() {
                        return "⌨️ Ketik untuk mencari...";
                    }
                }
            });

            // Tambahkan icon search di input search
            $(document).on('select2:open', () => {
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    searchField.placeholder = '🔍 Ketik nama atau NIK warga...';
                }
            });
        });
    </script>

    {{-- Style --}}
    <style>
        /* ======================================== */
        /* SELECT2 CUSTOM STYLE                      */
        /* ======================================== */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            padding: 0.375rem 0.75rem;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .select2-dropdown {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
        }

        .select2-results__option--highlighted {
            background-color: #667eea !important;
        }

        /* ======================================== */
        /* RESPONSIVE MOBILE                         */
        /* ======================================== */
        @media (max-width: 768px) {

            /* Select2 full-width */
            .select2-container--bootstrap-5 {
                width: 100% !important;
            }

            /* Tombol aksi full-width */
            .d-flex.gap-2 {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
@endsection
