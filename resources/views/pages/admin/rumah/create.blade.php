    @extends('layouts.admin.admin')
    @section('content')
        <div class="container py-4">
            <h2 class="fw-bold mb-4">Tambah Data Rumah</h2>

            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.rumah.index') }}" class="btn btn-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            {{-- ============================================================= --}}
            {{-- ALERTS DAN FEEDBACK --}}
            {{-- ============================================================= --}}

            {{-- Success Message (Jika ada) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Validation Errors (Jika ada kesalahan validasi) --}}
            @if ($errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                    <h5 class="alert-heading fs-6 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal
                        Menyimpan Data!</h5>
                    <p class="mb-0">Mohon periksa kembali input Anda. Beberapa kolom wajib diisi atau memiliki format yang
                        salah.</p>
                </div>
            @endif


            {{-- Form Tambah Rumah --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <form action="{{ route('admin.rumah.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nomor Rumah --}}
                        <div class="mb-3">
                            <label class="form-label">Nomor Rumah</label>
                            {{-- Tambahkan kelas is-invalid jika ada error, dan tampilkan old value --}}
                            <input type="text" name="nomor_rumah"
                                class="form-control @error('nomor_rumah') is-invalid @enderror"
                                value="{{ old('nomor_rumah') }}" required>
                            @error('nomor_rumah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror" rows="2"
                                required>{{ old('alamat_lengkap') }}</textarea>
                            @error('alamat_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia
                                </option>
                                <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="rusak" {{ old('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar Rumah --}}
                        <div class="mb-3">
                            <label class="form-label">Gambar Rumah</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror"
                                onchange="previewImage(event, 'preview-foto')">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="preview-foto-container" class="mt-2 d-none">
                                <img id="preview-foto" class="img-fluid border rounded-3 p-2 bg-light" src="#"
                                    alt="Preview Foto Warga" style="max-height: 200px; object-fit: contain;">
                            </div>
                        </div>

                        {{-- Lokasi (Latitude & Longitude) --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude"
                                    class="form-control @error('latitude') is-invalid @enderror"
                                    value="{{ old('latitude') }}" placeholder="-6.123456">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude"
                                    class="form-control @error('longitude') is-invalid @enderror"
                                    value="{{ old('longitude') }}" placeholder="108.123456">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Cluster --}}
                        <div class="mb-3">
                            <label class="form-label">Cluster</label>
                            <select name="id_cluster" class="form-select @error('id_cluster') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Cluster --</option>
                                @foreach ($clusters as $cluster)
                                    <option value="{{ $cluster->id }}"
                                        {{ old('id_cluster') == $cluster->id ? 'selected' : '' }}>
                                        {{ $cluster->id_nama_cluster }}</option>
                                @endforeach
                            </select>
                            @error('id_cluster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Warga --}}
                        <div class="mb-3">
                            <label class="form-label">Warga Penghuni</label>
                            <select name="id_warga" class="form-select @error('id_warga') is-invalid @enderror">
                                <option value="">-- Pilih Warga --</option>
                                @foreach ($warga as $w)
                                    <option value="{{ $w->id }}" {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('id_warga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="text-end">
                            <button type="submit" class="btn btn-dark px-4 py-2">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <script>
            function previewImage(event, previewId) {
                const fileInput = event.target;
                const previewImg = document.getElementById(previewId);
                const previewContainer = document.getElementById(previewId + '-container');

                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        // Menggunakan kelas d-block untuk menampilkan container (pure Bootstrap)
                        previewContainer.classList.remove('d-none');
                        previewContainer.classList.add('d-block');
                    }

                    reader.readAsDataURL(fileInput.files[0]);
                } else {
                    // Menggunakan kelas d-none untuk menyembunyikan container (pure Bootstrap)
                    previewImg.src = '#';
                    previewContainer.classList.remove('d-block');
                    previewContainer.classList.add('d-none');
                }
            }
        </script>
    @endsection
