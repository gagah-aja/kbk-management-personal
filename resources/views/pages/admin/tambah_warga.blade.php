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

            <!-- 🔔 ALERT VALIDASI ERROR (SEMUA ERROR DALAM SATU KOTAK) -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-x-circle-fill me-2"></i>Terjadi kesalahan input:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('admin.warga.tambah') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- BARIS 2: NIK & Nama Lengkap -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="nik" class="form-label fw-semibold">NIK</label>
                        <input type="text"
                            class="form-control py-2 rounded-3 shadow-sm @error('nik') is-invalid @enderror" id="nik"
                            name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK 16 digit" required>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text"
                            class="form-control py-2 rounded-3 shadow-sm @error('nama_lengkap') is-invalid @enderror"
                            id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email"
                            class="form-control py-2 rounded-3 shadow-sm @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email Anda">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="no_telp" class="form-label fw-semibold">No Telp</label>
                        <input type="number"
                            class="form-control py-2 rounded-3 shadow-sm @error('no_telp') is-invalid @enderror"
                            id="no_telp" name="no_telp" value="{{ old('no_telp') }}" placeholder="Masukkan No. Telp Anda">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Golongan darah & Agama -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="gol_darah" class="form-label fw-semibold">Golongan Darah</label>
                        <select class="form-select py-2 rounded-3 shadow-sm @error('gol_darah') is-invalid @enderror"
                            id="gol_darah" name="gol_darah">

                            <option value="" {{ old('gol_darah') == '' ? 'selected' : '' }}>Pilih Golongan Darah
                                (Opsional)</option>

                            {{-- Daftar Golongan Darah --}}
                            @php
                                $golonganDarah = ['A', 'B', 'AB', 'O'];
                            @endphp
                            @foreach ($golonganDarah as $darah)
                                <option value="{{ $darah }}" {{ old('gol_darah') == $darah ? 'selected' : '' }}>
                                    {{ $darah }}
                                </option>
                            @endforeach
                        </select>

                        @error('gol_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="agama" class="form-label fw-semibold">Agama</label>
                        <select class="form-select py-2 rounded-3 shadow-sm @error('agama') is-invalid @enderror"
                            id="agama" name="agama" required>

                            <option value="" disabled {{ old('agama') == '' ? 'selected' : '' }}>Pilih Agama</option>

                            {{-- Daftar Agama --}}
                            @php
                                $listAgama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
                            @endphp
                            @foreach ($listAgama as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>
                            @endforeach
                        </select>

                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    {{-- Kolom 1: Pendidikan Terakhir --}}
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan Terakhir</label>
                        <select
                            class="form-select py-2 rounded-3 shadow-sm @error('pendidikan_terakhir') is-invalid @enderror"
                            id="pendidikan_terakhir" name="pendidikan_terakhir">
                            <option value="" disabled {{ old('pendidikan_terakhir') == '' ? 'selected' : '' }}>
                                Pilih Pendidikan Terakhir
                            </option>

                            @php
                                $tingkatPendidikan = [
                                    'SD',
                                    'SMP',
                                    'SMA/SMK',
                                    'D1',
                                    'D2',
                                    'D3',
                                    'S1/D4',
                                    'S2',
                                    'S3',
                                    'Tidak Sekolah',
                                ];
                            @endphp

                            @foreach ($tingkatPendidikan as $pendidikan)
                                <option value="{{ $pendidikan }}"
                                    {{ old('pendidikan_terakhir') == $pendidikan ? 'selected' : '' }}>
                                    {{ $pendidikan }}
                                </option>
                            @endforeach
                        </select>

                        @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kolom 2: Gaji --}}
                    <div class="col-md-6">
                        <label for="gaji_display" class="form-label fw-semibold">Gaji</label>
                        <div class="input-group">
                            {{-- Tambahkan tulisan Rp di depan --}}
                            <span class="input-group-text py-2 rounded-3 shadow-sm">Rp</span>

                            {{-- Input tampilan --}}
                            <input type="text"
                                class="form-control py-2 rounded-3 shadow-sm @error('gaji') is-invalid @enderror"
                                id="gaji_display" value="{{ old('gaji') ? number_format(old('gaji'), 0, ',', '.') : '' }}"
                                placeholder="Masukkan Gaji anda" onkeyup="formatRupiah(this)">

                            {{-- Input hidden untuk dikirim ke controller --}}
                            <input type="hidden" name="gaji" id="gaji_hidden" value="{{ old('gaji') }}">
                        </div>

                        @error('gaji')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <!-- Jenis Kelamin & Tanggal Lahir -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                        <select class="form-select py-2 rounded-3 shadow-sm @error('jenis_kelamin') is-invalid @enderror"
                            id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date"
                            class="form-control py-2 rounded-3 shadow-sm @error('tanggal_lahir') is-invalid @enderror"
                            id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- BARIS 5: Pekerjaan & Pendidikan (Pendidikan dipertahankan dari gambar) -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                        <input type="text"
                            class="form-control py-2 rounded-3 shadow-sm  @error('pekerjaan') is-invalid @enderror"
                            id="pekerjaan" value="{{ old('pekerjaan') }}" name="pekerjaan"
                            placeholder="e.g. Pegawai Swasta, Ibu Rumah Tangga">
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="hubungan" class="form-label fw-semibold">Hubungan dalam Keluarga</label>
                        <input type="text"
                            class="form-control py-2 rounded-3 shadow-sm  @error('hubungan') is-invalid @enderror"
                            id="hubungan" value="{{ old('hubungan') }}" name="hubungan"
                            placeholder="e.g. Ayah,Ibu,dsb" required>
                        @error('hubungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Upload File -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="foto" class="form-label fw-semibold">Upload Foto Warga</label>
                        <input type="file"
                            class="form-control rounded-3 shadow-sm @error('foto') is-invalid @enderror" id="foto"
                            name="foto" accept="image/*" required onchange="previewImage(event, 'preview-foto')">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="preview-foto-container" class="mt-2 d-none">
                            <img id="preview-foto" class="img-fluid border rounded-3 p-2 bg-light" src="#"
                                alt="Preview Foto Warga" style="max-height: 200px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="foto_ktp" class="form-label fw-semibold">Upload Foto KTP</label>
                        <input type="file"
                            class="form-control rounded-3 shadow-sm @error('foto_ktp') is-invalid @enderror"
                            id="foto_ktp" name="foto_ktp" accept="image/*" required
                            onchange="previewImage(event, 'preview-foto-ktp')">
                        @error('foto_ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="preview-foto-ktp-container" class="mt-2 d-none">
                            <img id="preview-foto-ktp" class="img-fluid border rounded-3 p-2 bg-light" src="#"
                                alt="Preview Foto KTP" style="max-height: 200px; object-fit: contain;">
                        </div>
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
        {{-- Script format rupiah (pake JS biasa, aman di Blade) --}}
        <script>
            function formatRupiah(input) {
                // Hapus semua selain angka
                let angka = input.value.replace(/\D/g, '');

                // Format pakai titik ribuan
                let formatted = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                // Tampilkan format di input tampilan
                input.value = formatted;

                // Simpan angka mentah ke hidden input
                document.getElementById('gaji_hidden').value = angka;
            }
        </script>

    @endsection
