@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Tambah Data Rumah</h2>

    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.rumah.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    {{-- Form Tambah Rumah --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <form action="{{ route('admin.rumah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Rumah --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Rumah</label>
                    <input type="text" name="nomor_rumah" class="form-control" required>
                </div>

                {{-- Alamat Lengkap --}}
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control" rows="2" required></textarea>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="terisi">Terisi</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>

                {{-- Gambar Rumah --}}
                <div class="mb-3">
                    <label class="form-label">Gambar Rumah</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                {{-- Lokasi (Latitude & Longitude) --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control" placeholder="-6.123456">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control" placeholder="108.123456">
                    </div>
                </div>

                {{-- Cluster --}}
                <div class="mb-3">
                    <label class="form-label">Cluster</label>
                    <select name="id_cluster" class="form-select" required>
                        <option value="">-- Pilih Cluster --</option>
                        @foreach ($clusters as $cluster)
                            <option value="{{ $cluster->id }}">{{ $cluster->id_nama_cluster }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Warga --}}
                <div class="mb-3">
                    <label class="form-label">Warga Penghuni</label>
                    <select name="id_warga" class="form-select">
                        <option value="">-- Pilih Warga --</option>
                        @foreach ($warga as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_lengkap }}</option>
                        @endforeach
                    </select>
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
@endsection
