@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid py-4">
        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold">Data Warga</h2>
                <p class="text-secondary">Kelola data anggota keluarga di RT</p>
            </div>
            <a href="{{ route('admin.warga.index') }}"
                class="btn btn-primary fw-semibold rounded-3 shadow-sm d-flex align-items-center py-2 px-3">
                <i class="bi bi-plus"></i>
                Kembali
            </a>

        </div>
        <form action="{{ route('admin.warga.tambah') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- BARIS 2: NIK & Nama Lengkap -->
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="nik" class="form-label fw-semibold">NIK</label>
                    <input type="text" class="form-control py-2 rounded-3 shadow-sm" id="nik" name="nik"
                        placeholder="Masukkan Nomor Induk Kependudukan" required>
                </div>
                <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control py-2 rounded-3 shadow-sm" id="nama_lengkap"
                        name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                </div>
            </div>

            <!-- BARIS 3: Jenis Kelamin & Tanggal Lahir (Tanggal Lahir dipertahankan dari gambar) -->
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                    <!-- Dropdown Jenis Kelamin, meniru gambar -->
                    <select class="form-select py-2 rounded-3 shadow-sm" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                    <!-- Input Tanggal dengan Ikon Calendar (menggunakan input-group) -->
                    <div class="input-group rounded-3 shadow-sm">
                        <input type="text" class="form-control border-end-0 py-2" id="tanggal_lahir"
                            placeholder="dd/mm/yyyy" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                        <span class="input-group-text bg-white border-start-0">
                            <i class="fas fa-calendar-alt text-muted"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- BARIS 4: Hubungan dalam Keluarga -->
            <div class="row mb-3">
                <div class="col-12">
                    <label for="hubungan" class="form-label fw-semibold">Hubungan dalam Keluarga</label>
                    <select class="form-select py-2 rounded-3 shadow-sm" id="hubungan" name="hubungan" required>
                        <option value="" disabled selected>Pilih hubungan dalam keluarga</option>
                        <option value="ayah">Ayah</option>
                        <option value="ibu">Ibu</option>
                        <option value="anak">Anak</option>
                    </select>
                </div>
            </div>

            <!-- BARIS 5: Pekerjaan & Pendidikan (Pendidikan dipertahankan dari gambar) -->
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                    <input type="text" class="form-control py-2 rounded-3 shadow-sm" id="pekerjaan" name="pekerjaan"
                        placeholder="e.g. Pegawai Swasta, Ibu Rumah Tangga" required>
                </div>
                <div class="col-md-6">
                    <label for="pendidikan" class="form-label fw-semibold">Pendidikan Terakhir</label>
                    <input type="text" class="form-control py-2 rounded-3 shadow-sm" id="pendidikan" name="pendidikan"
                        placeholder="e.g. SMA, S1, dll." required>
                </div>
            </div>

            <!-- BARIS 6: Upload File (Foto & Foto KTP) -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="foto" class="form-label fw-semibold">Upload Foto Warga</label>
                    <input class="form-control rounded-3 shadow-sm" type="file" id="foto" name="foto"
                        accept="image/*" required onchange="previewImage(event, 'preview-foto')">
                    <div class="form-text">File yang diterima: JPG, PNG.</div>
                    <div id="preview-foto-container" class="mt-2 d-none">
                        <img id="preview-foto" class="img-fluid border rounded-3 p-2 bg-light" src="#"
                            alt="Preview Foto Warga" style="max-height: 200px; object-fit: contain;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="foto_ktp" class="form-label fw-semibold">Upload Foto KTP</label>
                    <input class="form-control rounded-3 shadow-sm" type="file" id="foto_ktp" name="foto_ktp"
                        accept="image/*" required onchange="previewImage(event, 'preview-foto-ktp')">
                    <div class="form-text">Pastikan KTP terbaca jelas.</div>
                    <div id="preview-foto-ktp-container" class="mt-2 d-none">
                        <img id="preview-foto-ktp" class="img-fluid border rounded-3 p-2 bg-light" src="#"
                            alt="Preview Foto KTP" style="max-height: 200px; object-fit: contain;">
                    </div>
                </div>
                <!-- BARIS 4: Hubungan dalam Keluarga -->

                <div class="row mb-3">
                    <div class="col-md-12">

                        <label for="id_rumah" class="form-label fw-semibold">Rumah</label>
                        <select class="form-select py-2 rounded-3 shadow-sm" id="id_rumah" name="id_rumah">
                            <option value="" disabled selected>Pilih Rumah</option>
                            <option value="0">Tidak Punya Rumah</option>
                        </select>
                    </div>
                </div>
                <!-- FOOTER MODAL (Tombol Simpan) -->
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="ms-2 btn btn-primary rounded-3">Simpan Data Warga</button>
                </div>
        </form>
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
