@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2>Tambah Data Rumah</h2>
                <p>Tambahkan data rumah baru</p>
            </div>
        </div>

        {{-- SweetAlert Error Validation --}}
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#d33'
                });
            </script>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="form-card">
                    <form id="formRumah" action="{{ route('admin.rumah.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Nomor Rumah --}}
                            <div class="col-md-6">
                                <label for="nomor_rumah" class="form-label">
                                    Nomor Rumah <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="nomor_rumah" id="nomor_rumah"
                                    class="form-control @error('nomor_rumah') is-invalid @enderror"
                                    placeholder="Contoh: 1, 2, 101" value="{{ old('nomor_rumah') }}" required min="1"
                                    autofocus>
                            </div>

                            {{-- Status Rumah --}}
                            <div class="col-md-6">
                                <label for="id_status_rumah" class="form-label">
                                    Status Rumah <span class="text-danger">*</span>
                                </label>
                                <select name="id_status_rumah" id="id_status_rumah" class="form-select" required>
                                    <option value="">-- Pilih Status Rumah --</option>
                                    @foreach ($status_rumah as $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('id_status_rumah') == $status->id ? 'selected' : '' }}>
                                            {{ $status->nama_status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Alamat Lengkap --}}
                            <div class="col-12">
                                <label for="alamat_lengkap" class="form-label">
                                    Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="form-control"
                                    placeholder="Masukkan alamat lengkap rumah" required>{{ old('alamat_lengkap') }}</textarea>
                            </div>

                            {{-- Cluster --}}
                            <div class="col-md-6">
                                <label for="id_cluster" class="form-label">
                                    Cluster <span class="text-danger">*</span>
                                </label>
                                <select name="id_cluster" id="id_cluster" class="form-select" required>
                                    <option value="">-- Pilih Cluster --</option>
                                    @foreach ($clusters as $cluster)
                                        <option value="{{ $cluster->id }}"
                                            {{ old('id_cluster') == $cluster->id ? 'selected' : '' }}>
                                            {{ $cluster->namaCluster->nama_cluster ?? 'N/A' }} -
                                            RT {{ $cluster->rt->nomor_rt ?? '-' }} -
                                            Blok {{ $cluster->blok->nama_blok ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Pemilik Rumah --}}
                            <div class="col-md-6">
                                <label for="id_warga" class="form-label">
                                    Pemilik Rumah
                                </label>
                                <select name="id_warga" id="id_warga" class="form-select">
                                    <option value="">-- Pilih Pemilik Rumah --</option>
                                    @foreach ($warga as $w)
                                        <option value="{{ $w->id }}"
                                            {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                            {{ $w->nama_lengkap }} - {{ $w->nik }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Latitude --}}
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">
                                    Latitude <small class="text-muted">(Opsional)</small>
                                </label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    placeholder="Contoh: -6.200000" value="{{ old('latitude') }}">
                            </div>

                            {{-- Longitude --}}
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">
                                    Longitude <small class="text-muted">(Opsional)</small>
                                </label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    placeholder="Contoh: 106.816666" value="{{ old('longitude') }}">
                            </div>

                            {{-- Gambar --}}
                            <div class="col-12">
                                <label for="gambar" class="form-label">
                                    Gambar Rumah <small class="text-muted">(Opsional)</small>
                                </label>
                                <input type="file" name="gambar" id="gambar" class="form-control"
                                    accept="image/jpeg,image/jpg,image/png" onchange="previewImage(event)">

                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail"
                                        style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Tambah Penghuni --}}
                        <div class="col-12 mb-3 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tambah_penghuni" id="tambah_penghuni"
                                    value="1" checked>
                                <label class="form-check-label" for="tambah_penghuni">
                                    <strong>Langsung tambah penghuni</strong> setelah menyimpan data rumah
                                </label>
                            </div>
                            <small class="text-muted ms-4">Jika tidak dicentang, Anda akan kembali ke halaman daftar
                                rumah</small>
                        </div>

                        <div class="d-flex gap-2 pt-4 mt-4 border-top">
                            <a href="{{ route('admin.rumah.index') }}" class="btn-cancel">
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

    <script>
        // Preview Gambar
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
                document.getElementById('imagePreview').style.display = 'block';
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // Validasi nomor rumah minimal 1 (SweetAlert)
        document.getElementById('formRumah').addEventListener('submit', function(e) {
            const nomor = parseInt(document.getElementById('nomor_rumah').value);
            if (isNaN(nomor) || nomor < 1) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Nomor rumah tidak valid!',
                    text: 'Nomor rumah minimal adalah 1.',
                });
                document.getElementById('nomor_rumah').focus();
            }
        });
    </script>
@endsection
