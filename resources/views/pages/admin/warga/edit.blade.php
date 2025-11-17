@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Edit Data Warga</h2>
            <p>Perbarui data warga</p>
        </div>
    </div>

    {{-- Errors --}}
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

    {{-- Info Box --}}
    <div class="info-box mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="info-box-label">NIK</div>
                <div class="info-box-value">{{ $warga->nik }}</div>
            </div>
            <div class="col-md-3">
                <div class="info-box-label">Nama</div>
                <div class="info-box-value">{{ $warga->nama_lengkap }}</div>
            </div>
            <div class="col-md-3">
                <div class="info-box-label">Jenis Kelamin</div>
                <div class="info-box-value">{{ $warga->jenis_kelamin }}</div>
            </div>
            <div class="col-md-3">
                <div class="info-box-label">Agama</div>
                <div class="info-box-value">{{ $warga->agama }}</div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Kolom Kiri --}}
            <div class="col-lg-6">
                {{-- Data Pribadi --}}
                <div class="form-card mb-4">
                    <div class="form-card-header"><i class="bi bi-person-badge"></i> Data Pribadi</div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" maxlength="16"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik', $warga->nik) }}" required autofocus>
                                @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required>
                                @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="Laki-laki"
                                            {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                        <span><i class="bi bi-gender-male text-info"></i> Laki-laki</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            value="Perempuan"
                                            {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                        <span><i class="bi bi-gender-female text-danger"></i> Perempuan</span>
                                    </label>
                                </div>
                                @error('jenis_kelamin') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}" required>
                                @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select id="agama" name="agama" class="form-select @error('agama') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                        <option value="{{ $ag }}" {{ old('agama', $warga->agama) == $ag ? 'selected' : '' }}>
                                            {{ $ag }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="gol_darah" class="form-label">Golongan Darah</label>
                                <select id="gol_darah" name="gol_darah" class="form-select @error('gol_darah') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['A','B','AB','O'] as $gd)
                                        <option value="{{ $gd }}" {{ old('gol_darah', $warga->gol_darah) == $gd ? 'selected' : '' }}>
                                            {{ $gd }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gol_darah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Upload Foto --}}
                <div class="form-card mb-4">
                    <div class="form-card-header"><i class="bi bi-camera"></i> Upload Foto</div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Foto Warga</label>
                                <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewFoto(event)">
                                <div class="form-hint">Kosongkan jika tidak ingin mengubah</div>
                                <img id="preview_foto" src="{{ $warga->foto ? asset('storage/'.$warga->foto) : '' }}" class="img-thumbnail mt-2" style="max-width:150px; {{ $warga->foto ? '' : 'display:none' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Foto KTP</label>
                                <input type="file" name="foto_ktp" id="foto_ktp" class="form-control" accept="image/*" onchange="previewKTP(event)">
                                <div class="form-hint">Kosongkan jika tidak ingin mengubah</div>
                                <img id="preview_ktp" src="{{ $warga->foto_ktp ? asset('storage/'.$warga->foto_ktp) : '' }}" class="img-thumbnail mt-2" style="max-width:150px; {{ $warga->foto_ktp ? '' : 'display:none' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-6">
                {{-- Data Keluarga & Rumah --}}
                <div class="form-card mb-4">
                    <div class="form-card-header"><i class="bi bi-house"></i> Data Keluarga & Rumah</div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="hubungan" class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                                <input type="text" id="hubungan" name="hubungan"
                                    class="form-control @error('hubungan') is-invalid @enderror"
                                    value="{{ old('hubungan', $warga->hubungan) }}" required>
                                @error('hubungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="id_rumah" class="form-label">Pilih Rumah</label>
                                <select name="id_rumah" id="id_rumah" class="form-select" required>
                                    <option value="">-- Pilih Rumah --</option>
                                    @foreach ($rumahList->unique('id') as $r)
                                        <option value="{{ $r->id }}" {{ old('id_rumah', $warga->id_rumah) == $r->id ? 'selected' : '' }}>
                                            Pemilik Rumah: {{ $r->warga->nama_lengkap ?? 'Tidak ada pemilik' }} - Blok: {{ $r->cluster->blok->nama_blok }} - Nama Cluster: {{ $r->cluster->namaCluster->nama_cluster }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Kontak --}}
                <div class="form-card mb-4">
                    <div class="form-card-header"><i class="bi bi-telephone"></i> Data Kontak</div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp',$warga->no_telp) }}">
                                @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$warga->email) }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Pekerjaan & Pendidikan --}}
                <div class="form-card mb-4">
                    <div class="form-card-header"><i class="bi bi-briefcase"></i> Data Pekerjaan & Pendidikan</div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <select id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-select @error('pendidikan_terakhir') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SD','SMP','SMA','D3','S1','S2','S3'] as $p)
                                        <option value="{{ $p }}" {{ old('pendidikan_terakhir',$warga->pendidikan_terakhir)==$p?'selected':'' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                                @error('pendidikan_terakhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" id="pekerjaan" name="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan',$warga->pekerjaan) }}">
                                @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="gaji" class="form-label">Gaji/Penghasilan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="gaji" name="gaji" class="form-control @error('gaji') is-invalid @enderror" value="{{ old('gaji', $warga->gaji ? number_format($warga->gaji,0,',','.') : '') }}" placeholder="0">
                                </div>
                                @error('gaji') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2 pt-3 border-top">
            <a href="{{ route('admin.warga.index') }}" class="btn-cancel"><i class="bi bi-x"></i> Batal</a>
            <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Update Data</button>
        </div>
    </form>
</div>

{{-- Scripts --}}
<script>
function previewFoto(e){
    let p = document.getElementById('preview_foto');
    p.src = URL.createObjectURL(e.target.files[0]);
    p.style.display = 'block';
}
function previewKTP(e){
    let p = document.getElementById('preview_ktp');
    p.src = URL.createObjectURL(e.target.files[0]);
    p.style.display = 'block';
}

// Format ribuan untuk gaji
document.getElementById('gaji').addEventListener('input', function(){
    let val = this.value.replace(/\D/g,'');
    this.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});
</script>

{{-- Styles --}}
<style>
.form-card-header {
    background: linear-gradient(135deg,#667eea,#764ba2);
    color: #fff;
    padding: .875rem 1.25rem;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
    font-size: .95rem;
}
.form-card-body { padding: 1.5rem 1.25rem; }
.form-hint { font-size: .8rem; color: #6b7280; margin-top: .25rem; }
</style>
@endsection
