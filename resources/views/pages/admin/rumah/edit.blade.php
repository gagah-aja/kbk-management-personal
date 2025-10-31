@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-3">✏️ Edit Data Rumah</h2>
    <p class="text-muted mb-4">Perbarui informasi rumah berikut.</p>

    <div class="card border-0 shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.rumah.update', $rumah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nomor Rumah --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor Rumah</label>
                <input type="text" name="nomor_rumah" class="form-control" 
                       value="{{ old('nomor_rumah', $rumah->nomor_rumah) }}" required>
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" rows="3" class="form-control" required>{{ old('alamat_lengkap', $rumah->alamat_lengkap) }}</textarea>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Tersedia" {{ old('status', $rumah->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Terisi" {{ old('status', $rumah->status) == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                    <option value="Rusak" {{ old('status', $rumah->status) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            {{-- Cluster --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Cluster</label>
                <select name="id_cluster" class="form-select" required>
                    <option value="">-- Pilih Cluster --</option>
                    @foreach($clusters as $cluster)
                        <option value="{{ $cluster->id }}" 
                            {{ old('id_cluster', $rumah->id_cluster) == $cluster->id ? 'selected' : '' }}>
                            {{ $cluster->id_nama_cluster }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Warga --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Warga (Opsional)</label>
                <select name="id_warga" class="form-select">
                    <option value="">-- Belum Ditempati --</option>
                    @foreach($warga as $item)
                        <option value="{{ $item->id }}" 
                            {{ old('id_warga', $rumah->id_warga) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Gambar Rumah --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Gambar Rumah</label><br>
                @if($rumah->gambar)
                    <img src="{{ asset('storage/' . $rumah->gambar) }}" alt="Gambar Rumah" width="100" class="rounded mb-2">
                @endif
                <input type="file" name="gambar" class="form-control">
            </div>

            {{-- Koordinat --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Latitude</label>
                    <input type="text" name="latitude" class="form-control" 
                           value="{{ old('latitude', $rumah->latitude) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Longitude</label>
                    <input type="text" name="longitude" class="form-control" 
                           value="{{ old('longitude', $rumah->longitude) }}">
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
@endsection
