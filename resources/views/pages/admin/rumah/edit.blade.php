@extends('layouts.admin.admin')

@section('title', 'Edit Data Rumah')

@section('content')

<style>
/* ---- RESPONSIVE ---- */
@media (max-width: 768px) {

    .page-header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .form-card {
        padding: 15px !important;
        border-radius: 12px;
    }

    .info-box .row > div {
        margin-bottom: 15px;
        text-align: center;
    }

    .info-box-value {
        font-size: 1rem !important;
        display: block;
    }

    .img-thumbnail {
        max-height: 130px !important;
        width: auto;
    }

    #imagePreview img {
        max-width: 100% !important;
        height: auto !important;
    }

    .btn-cancel, .btn-submit {
        width: 100% !important;
    }
}
</style>

<div class="container-fluid py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2>Edit Data Rumah</h2>
            <p>Perbarui data rumah sesuai kebutuhan</p>
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
                
                {{-- Informasi singkat --}}
                <div class="info-box mb-4">
                    <div class="row text-center text-md-start">
                        <div class="col-md-3">
                            <div class="info-box-label">Nomor Rumah</div>
                            <div class="info-box-value">{{ $rumah->nomor_rumah }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box-label">Status</div>
                            <div class="info-box-value">{{ $rumah->statusRumah->nama_status ?? '-' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box-label">Cluster</div>
                            <div class="info-box-value">{{ $rumah->cluster->namaCluster->nama_cluster ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box-label">Penghuni</div>
                            <div class="info-box-value">{{ $rumah->warga->nama ?? 'Belum ada' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('admin.rumah.update', $rumah->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Nomor Rumah --}}
                        <div class="col-md-6 col-12">
                            <label for="nomor_rumah" class="form-label">Nomor Rumah <span class="text-danger">*</span></label>
                            <input type="text" 
                                name="nomor_rumah" 
                                id="nomor_rumah"
                                class="form-control @error('nomor_rumah') is-invalid @enderror" 
                                value="{{ old('nomor_rumah', $rumah->nomor_rumah) }}" 
                                placeholder="Contoh: A-01, B-123"
                                required>
                            @error('nomor_rumah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Rumah --}}
                        <div class="col-md-6 col-12">
                            <label for="id_status_rumah" class="form-label">Status Rumah <span class="text-danger">*</span></label>
                            <select name="id_status_rumah" id="id_status_rumah"
                                    class="form-select @error('id_status_rumah') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Status --</option>
                                @foreach($status_rumah as $status)
                                    <option value="{{ $status->id }}" 
                                        {{ old('id_status_rumah', $rumah->id_status_rumah) == $status->id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_status_rumah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label for="alamat_lengkap" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3"
                                class="form-control @error('alamat_lengkap') is-invalid @enderror"
                                placeholder="Masukkan alamat lengkap rumah" required>{{ old('alamat_lengkap', $rumah->alamat_lengkap) }}</textarea>
                            @error('alamat_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Cluster --}}
                        <div class="col-md-6 col-12">
                            <label for="id_cluster" class="form-label">Cluster <span class="text-danger">*</span></label>
                            <select name="id_cluster" id="id_cluster"
                                    class="form-select @error('id_cluster') is-invalid @enderror" required>
                                <option value="">-- Pilih Cluster --</option>
                                @foreach($clusters as $cluster)
                                    <option value="{{ $cluster->id }}" 
                                        {{ old('id_cluster', $rumah->id_cluster) == $cluster->id ? 'selected' : '' }}>
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

                        {{-- Penghuni --}}
                        <div class="col-md-6 col-12">
                            <label for="id_warga" class="form-label">Pemilik Rumah</label>
                            <select name="id_warga" id="id_warga"
                                    class="form-select @error('id_warga') is-invalid @enderror">
                                <option value="">-- Pilih Pemilik Rumah --</option>
                                @foreach($warga as $w)
                                    <option value="{{ $w->id }}" 
                                        {{ old('id_warga', $rumah->id_warga) == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_lengkap }} - {{ $w->nik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_warga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Latitude --}}
                        <div class="col-md-6 col-12">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude"
                                class="form-control @error('latitude') is-invalid @enderror"
                                value="{{ old('latitude', $rumah->latitude) }}"
                                placeholder="Contoh: -6.200000">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6 col-12">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                class="form-control @error('longitude') is-invalid @enderror"
                                value="{{ old('longitude', $rumah->longitude) }}"
                                placeholder="Contoh: 106.816666">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar --}}
                        <div class="col-12">
                            <label for="gambar" class="form-label">Gambar Rumah</label>
                            @if($rumah->gambar)
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2">Gambar Saat Ini:</small>
                                    <img src="{{ asset('storage/' . $rumah->gambar) }}" alt="Gambar Rumah"
                                         class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" name="gambar" id="gambar"
                                class="form-control @error('gambar') is-invalid @enderror"
                                accept="image/jpeg,image/jpg,image/png"
                                onchange="previewImage(event)">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" class="mt-3" style="display:none;">
                                <small class="text-muted d-block mb-2">Preview Gambar Baru:</small>
                                <img id="preview" src="" alt="Preview" class="img-thumbnail">
                            </div>
                        </div>

                    </div>

                    <div class="d-flex gap-2 pt-4 mt-4 border-top flex-wrap">
                        <a href="{{ route('admin.rumah.index') }}" class="btn-cancel">
                            <i class="bi bi-x"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check"></i> Update Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const container = document.getElementById('imagePreview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    container.style.display = "block";
}
</script>

@endsection
