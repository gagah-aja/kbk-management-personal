@extends('layouts.admin.admin')

@section('content')
    <div class="container py-4">
        <h2 class="fw-bold mb-3">✏️ Edit Data Rumah</h2>
        <p class="text-muted mb-4">Perbarui informasi rumah berikut.</p>

        {{-- Pesan Feedback dan Error Validation --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                <h5 class="alert-heading fs-6 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal
                    Menyimpan Perubahan!</h5>
                <p class="mb-0">Mohon periksa kembali input Anda.</p>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="{{ route('admin.rumah.update', $rumah->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- WAJIB: Gunakan PUT method untuk update di Laravel --}}
                    
                {{-- Nomor Rumah --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor Rumah</label>
                    <input type="text" name="nomor_rumah"
                        class="form-control @error('nomor_rumah') is-invalid @enderror"
                        value="{{ old('nomor_rumah', $rumah->nomor_rumah) }}" required>
                    @error('nomor_rumah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3" class="form-control @error('alamat_lengkap') is-invalid @enderror"
                        required>{{ old('alamat_lengkap', $rumah->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Tersedia" {{ old('status', $rumah->status) == 'Tersedia' ? 'selected' : '' }}>
                            Tersedia</option>
                        <option value="Terisi" {{ old('status', $rumah->status) == 'Terisi' ? 'selected' : '' }}>Terisi
                        </option>
                        <option value="Rusak" {{ old('status', $rumah->status) == 'Rusak' ? 'selected' : '' }}>Rusak
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Cluster --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cluster</label>
                    <select name="id_cluster" class="form-select @error('id_cluster') is-invalid @enderror" required>
                        <option value="">-- Pilih Cluster --</option>
                        @foreach ($clusters as $cluster)
                            <option value="{{ $cluster->id }}"
                                {{ old('id_cluster', $rumah->id_cluster) == $cluster->id ? 'selected' : '' }}>
                                {{ $cluster->id_nama_cluster }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_cluster')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Warga --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Warga (Opsional)</label>
                    <select name="id_warga" class="form-select @error('id_warga') is-invalid @enderror">
                        <option value="">-- Belum Ditempati --</option>
                        @foreach ($warga as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_warga', $rumah->id_warga) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_warga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gambar Rumah (Perbaikan Pratinjau) --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Rumah (Biarkan kosong jika tidak ingin diubah)</label>

                    {{-- Input Hidden untuk menyimpan path gambar lama jika tidak ada upload baru --}}
                    @if ($rumah->gambar)
                        <input type="hidden" name="old_gambar" value="{{ $rumah->gambar }}">
                    @endif

                    {{-- Kontainer Pratinjau --}}
                    <div class="mt-2 border p-2 rounded-3 text-center" style="max-width: 300px;">
                        <img id="gambar_preview"
                             src="{{ $rumah->gambar ? asset('storage/' . $rumah->gambar) : '#' }}"
                             alt="Pratinjau Gambar"
                             style="max-width: 100%; height: auto; border-radius: 0.5rem; object-fit: cover; {{ $rumah->gambar ? 'display: block;' : 'display: none;' }}">

                        <p id="placeholder_text" class="text-muted mb-0 {{ $rumah->gambar ? 'd-none' : '' }}">
                            @if ($rumah->gambar)
                                Gambar lama
                            @else
                                Tidak ada gambar yang dipilih
                            @endif
                        </p>
                    </div>

                    {{-- Tambahkan ID untuk JavaScript --}}
                    <input type="file" name="gambar" id="gambar_input" class="form-control mt-2 @error('gambar') is-invalid @enderror">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Koordinat --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Latitude</label>
                        {{-- Menggunakan type number untuk koordinat --}}
                        <input type="number" step="any" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ old('latitude', $rumah->latitude) }}">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Longitude</label>
                        {{-- Menggunakan type number untuk koordinat --}}
                        <input type="number" step="any" name="longitude" class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ old('longitude', $rumah->longitude) }}">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.rumah.index') }}" class="btn btn-secondary px-4">Kembali</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputGambar = document.getElementById('gambar_input');
            const previewGambar = document.getElementById('gambar_preview');
            const placeholderText = document.getElementById('placeholder_text');

            // Simpan URL gambar lama untuk referensi
            const oldImageUrl = previewGambar.src;

            inputGambar.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewGambar.src = e.target.result;
                            previewGambar.style.display = 'block';
                            placeholderText.style.display = 'none';
                        };

                        reader.readAsDataURL(file);
                    } else {
                        // Jika file yang dipilih bukan gambar, kembalikan ke gambar lama/placeholder
                        previewGambar.src = oldImageUrl !== window.location.href ? oldImageUrl : '#';
                        previewGambar.style.display = oldImageUrl !== window.location.href ? 'block' : 'none';
                        placeholderText.style.display = 'block';
                        placeholderText.textContent = 'File yang dipilih bukan gambar.';
                    }
                } else {
                    // Jika input file dikosongkan (cancel/clear)
                    previewGambar.src = oldImageUrl !== window.location.href ? oldImageUrl : '#';
                    previewGambar.style.display = oldImageUrl !== window.location.href ? 'block' : 'none';
                    placeholderText.style.display = oldImageUrl !== window.location.href ? 'none' : 'block';
                    placeholderText.textContent = oldImageUrl !== window.location.href ? 'Gambar lama' : 'Tidak ada gambar yang dipilih';
                }
            });
        });
    </script>
@endsection
