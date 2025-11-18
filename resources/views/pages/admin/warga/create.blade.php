@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah Data Warga</h2>
            <p>Tambahkan data warga baru</p>
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

    <form action="{{ route('admin.warga.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-6">
                {{-- Data Pribadi --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <i class="bi bi-person-badge"></i> Data Pribadi
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    placeholder="16 digit NIK" maxlength="16" value="{{ old('nik') }}" required autofocus>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    placeholder="Nama lengkap sesuai KTP" value="{{ old('nama_lengkap') }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            id="laki_laki" value="Laki-laki"
                                            {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="laki_laki">
                                            <i class="bi bi-gender-male text-info"></i> Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            id="perempuan" value="Perempuan"
                                            {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="perempuan">
                                            <i class="bi bi-gender-female text-danger"></i> Perempuan
                                        </label>
                                    </div>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select name="agama" id="agama"
                                    class="form-select @error('agama') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="gol_darah" class="form-label">Golongan Darah</label>
                                <select name="gol_darah" id="gol_darah"
                                    class="form-select @error('gol_darah') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['A','B','AB','O'] as $gol)
                                        <option value="{{ $gol }}" {{ old('gol_darah') == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                                    @endforeach
                                </select>
                                @error('gol_darah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <i class="bi bi-camera"></i> Upload Foto
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="foto" class="form-label">Foto Warga <span class="text-danger">*</span></label>
                                <input type="file" name="foto" id="foto"
                                    class="form-control @error('foto') is-invalid @enderror" accept="image/*" required
                                    onchange="previewFoto(event)">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-hint">
                                    <i class="bi bi-info-circle"></i> Format: JPG, PNG, JPEG. Maks 2MB
                                </div>
                                <div class="mt-2">
                                    <img id="preview_foto" class="img-thumbnail" style="max-width: 150px; display: none;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="foto_ktp" class="form-label">Foto KTP <span class="text-danger">*</span></label>
                                <input type="file" name="foto_ktp" id="foto_ktp"
                                    class="form-control @error('foto_ktp') is-invalid @enderror" accept="image/*" required
                                    onchange="previewKTP(event)">
                                @error('foto_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-hint">
                                    <i class="bi bi-info-circle"></i> Format: JPG, PNG, JPEG. Maks 2MB
                                </div>
                                <div class="mt-2">
                                    <img id="preview_ktp" class="img-thumbnail" style="max-width: 150px; display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-6">
                {{-- Data Keluarga & Rumah --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <i class="bi bi-house"></i> Data Keluarga & Rumah
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="hubungan" class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                                <input type="text" name="hubungan" id="hubungan"
                                    class="form-control @error('hubungan') is-invalid @enderror"
                                    placeholder="Contoh: Kepala Keluarga, Istri, Anak" value="{{ old('hubungan') }}"
                                    required>
                                @error('hubungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilih Rumah dengan Search Bar --}}
                            <div class="col-12">
                                <label for="id_rumah" class="form-label">Pilih Rumah <span class="text-danger">*</span></label>
                                <select name="id_rumah" id="id_rumah" class="form-select select2-rumah" required>
                                    <option value="">-- Pilih Rumah --</option>
                                    @foreach ($rumahList->unique('id') as $r)
                                        <option value="{{ $r->id }}" {{ old('id_rumah', $warga->id_rumah ?? null) == $r->id ? 'selected' : '' }}>
                                            {{ $r->warga->nama_lengkap ?? 'Tidak ada pemilik' }} - 
                                            {{ $r->cluster->blok->nama_blok ?? '-' }}{{ $r->cluster->blok->no_blok ?? '' }} - 
                                            {{ $r->cluster->namaCluster->nama_cluster ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_rumah')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Kontak --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <i class="bi bi-telephone"></i> Data Kontak
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" name="no_telp" id="no_telp"
                                    class="form-control @error('no_telp') is-invalid @enderror"
                                    placeholder="08xxxxxxxxxx" value="{{ old('no_telp') }}">
                                @error('no_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="email@example.com" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Pekerjaan & Pendidikan --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <i class="bi bi-briefcase"></i> Data Pekerjaan & Pendidikan
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                                    class="form-select @error('pendidikan_terakhir') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SD','SMP','SMA','D3','S1','S2','S3'] as $pendidikan)
                                        <option value="{{ $pendidikan }}" {{ old('pendidikan_terakhir') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                                    @endforeach
                                </select>
                                @error('pendidikan_terakhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    placeholder="Contoh: Pegawai Swasta, Wiraswasta" value="{{ old('pekerjaan') }}">
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="gaji" class="form-label">Gaji/Penghasilan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" name="gaji" id="gaji"
                                        class="form-control @error('gaji') is-invalid @enderror" placeholder="0"
                                        value="{{ old('gaji') ? number_format(old('gaji'), 0, '.', '.') : '' }}">
                                </div>
                                @error('gaji')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex gap-2 pt-3 border-top">
            <a href="{{ route('admin.warga.index') }}" class="btn-cancel">
                <i class="bi bi-x"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-check"></i> Simpan Data
            </button>
        </div>
    </form>
</div>

{{-- Include Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

{{-- Script Preview Foto & Gaji --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Initialize Select2 untuk dropdown rumah
$(document).ready(function() {
    $('.select2-rumah').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih rumah...',
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
            searchField.placeholder = '🔍 Ketik nama pemilik, blok, atau cluster...';
        }
    });
});

function previewFoto(event) {
    const preview = document.getElementById('preview_foto');
    if (event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
}

function previewKTP(event) {
    const preview = document.getElementById('preview_ktp');
    if (event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
}

// Format Gaji ribuan
const gajiInput = document.getElementById('gaji');
gajiInput.addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    this.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
});

// Hapus titik saat submit agar backend menerima angka murni
gajiInput.form.addEventListener('submit', function() {
    gajiInput.value = gajiInput.value.replace(/\./g, '');
});
</script>

{{-- Style --}}
<style>
.form-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 0.875rem 1.25rem;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
    font-size: 0.95rem;
}

.form-card-header i {
    margin-right: 0.5rem;
}

.form-card-body {
    padding: 1.5rem 1.25rem;
}

/* Custom styling untuk Select2 */
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
</style>
@endsection