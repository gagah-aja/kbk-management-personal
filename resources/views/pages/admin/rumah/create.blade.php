@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Tambah Data Rumah</h2>
            <p>Tambahkan data rumah baru</p>
        </div>
        <a href="{{ route('admin.rumah.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
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

    <div class="row">
        <div class="col-12">
            <div class="form-card">
                <form action="{{ route('admin.rumah.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        {{-- Nomor Rumah --}}
                        <div class="col-md-6">
                            <label for="nomor_rumah" class="form-label">
                                Nomor Rumah <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nomor_rumah" 
                                   id="nomor_rumah"
                                   class="form-control @error('nomor_rumah') is-invalid @enderror" 
                                   placeholder="Contoh: A-01, B-123"
                                   value="{{ old('nomor_rumah') }}"
                                   required
                                   autofocus>
                            @error('nomor_rumah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ✅ Status Rumah (ambil dari tabel status_rumah) --}}
                        <div class="col-md-6">
                            <label for="id_status_rumah" class="form-label">
                                Status Rumah <span class="text-danger">*</span>
                            </label>
                            <select name="id_status_rumah" 
                                    id="id_status_rumah" 
                                    class="form-select @error('id_status_rumah') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Status Rumah --</option>
                                @foreach($status_rumah as $status)
                                    <option value="{{ $status->id }}" {{ old('id_status_rumah') == $status->id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_status_rumah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div class="col-12">
                            <label for="alamat_lengkap" class="form-label">
                                Alamat Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat_lengkap" 
                                      id="alamat_lengkap" 
                                      rows="3"
                                      class="form-control @error('alamat_lengkap') is-invalid @enderror" 
                                      placeholder="Masukkan alamat lengkap rumah"
                                      required>{{ old('alamat_lengkap') }}</textarea>
                            @error('alamat_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cluster --}}
                        <div class="col-md-6">
                            <label for="id_cluster" class="form-label">
                                Cluster <span class="text-danger">*</span>
                            </label>
                            <select name="id_cluster" 
                                    id="id_cluster" 
                                    class="form-select @error('id_cluster') is-invalid @enderror" 
                                    required>
                                <option value="">-- Pilih Cluster --</option>
                                
                                @foreach($clusters as $cluster)
                                    <option value="{{ $cluster->id }}" {{ old('id_cluster') == $cluster->id ? 'selected' : '' }}>
                                        {{ $cluster->namaCluster->nama_cluster ?? 'N/A' }} - 
                                        RT {{ $cluster->rt->nomor_rt ?? '-' }} - 
                                        Blok {{ $cluster->blok->nama_blok ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_cluster')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Penghuni (Warga) --}}
                        <div class="col-md-6">
                            <label for="id_warga" class="form-label">
                                Penghuni <small class="text-muted">(Opsional)</small>
                            </label>
                            <select name="id_warga" 
                                    id="id_warga" 
                                    class="form-select @error('id_warga') is-invalid @enderror">
                                <option value="">-- Pilih Penghuni --</option>
                                @foreach($warga as $w)
                                    <option value="{{ $w->id }}" {{ old('id_warga') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_lengkap}} - {{ $w->nik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_warga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-info-circle"></i>
                                Kosongkan jika belum ada penghuni
                            </div>
                        </div>

                        {{-- Latitude --}}
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">
                                Latitude <small class="text-muted">(Opsional)</small>
                            </label>
                            <input type="text" 
                                   name="latitude" 
                                   id="latitude"
                                   class="form-control @error('latitude') is-invalid @enderror" 
                                   placeholder="Contoh: -6.200000"
                                   value="{{ old('latitude') }}">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">
                                Longitude <small class="text-muted">(Opsional)</small>
                            </label>
                            <input type="text" 
                                   name="longitude" 
                                   id="longitude"
                                   class="form-control @error('longitude') is-invalid @enderror" 
                                   placeholder="Contoh: 106.816666"
                                   value="{{ old('longitude') }}">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar --}}
                        <div class="col-12">
                            <label for="gambar" class="form-label">
                                Gambar Rumah <small class="text-muted">(Opsional)</small>
                            </label>
                            <input type="file" 
                                   name="gambar" 
                                   id="gambar"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   accept="image/jpeg,image/jpg,image/png"
                                   onchange="previewImage(event)">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-info-circle"></i>
                                Format: JPG, JPEG, PNG. Maksimal 2MB
                            </div>
                            
                            {{-- Preview Gambar --}}
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
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
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        preview.src = reader.result;
        previewDiv.style.display = 'block';
    }
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
