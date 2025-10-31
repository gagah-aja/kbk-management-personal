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

        {{-- Form action diarahkan ke route update dengan parameter ID --}}
        <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="nik" class="form-label fw-semibold">NIK</label>
                    <input type="text" class="form-control py-2 rounded-3 shadow-sm @error('nik') is-invalid @enderror"
                        id="nik" name="nik" value="{{ old('nik', $warga->nik) }}"
                        placeholder="Masukkan NIK 16 digit" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text"
                        class="form-control py-2 rounded-3 shadow-sm @error('nama_lengkap') is-invalid @enderror"
                        id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}"
                        required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control py-2 rounded-3 shadow-sm @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email', $warga->email) }}"
                        placeholder="Masukkan Email Anda">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="no_telp" class="form-label fw-semibold">No Telp</label>
                    <input type="number"
                        class="form-control py-2 rounded-3 shadow-sm @error('no_telp') is-invalid @enderror" id="no_telp"
                        name="no_telp" value="{{ old('no_telp', $warga->no_telp) }}" placeholder="Masukkan No. Telp Anda">
                    @error('no_telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">

                {{-- Kolom 1: Golongan Darah (Select Option) --}}
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="gol_darah" class="form-label fw-semibold">Golongan Darah</label>
                    <select class="form-select py-2 rounded-3 shadow-sm @error('gol_darah') is-invalid @enderror"
                        id="gol_darah" name="gol_darah">

                        {{-- Nilai default: old('gol_darah') atau $warga->gol_darah --}}
                        @php
                            $selectedGolDarah = old('gol_darah', $warga->gol_darah);
                            $golonganDarah = ['', 'A', 'B', 'AB', 'O']; // Opsi kosong untuk Opsional
                        @endphp

                        <option value="" {{ $selectedGolDarah == '' ? 'selected' : '' }}>Pilih Golongan Darah
                            (Opsional)</option>

                        @foreach ($golonganDarah as $darah)
                            @if ($darah != '')
                                <option value="{{ $darah }}" {{ $selectedGolDarah == $darah ? 'selected' : '' }}>
                                    {{ $darah }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    @error('gol_darah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kolom 2: Agama (Select Option) --}}
                <div class="col-md-6">
                    <label for="agama" class="form-label fw-semibold">Agama</label>
                    <select class="form-select py-2 rounded-3 shadow-sm @error('agama') is-invalid @enderror" id="agama"
                        name="agama" required>

                        {{-- Nilai default: old('agama') atau $warga->agama --}}
                        @php
                            $selectedAgama = old('agama', $warga->agama);
                            $listAgama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
                        @endphp

                        <option value="" disabled {{ $selectedAgama == '' ? 'selected' : '' }}>Pilih Agama</option>

                        @foreach ($listAgama as $agama)
                            <option value="{{ $agama }}" {{ $selectedAgama == $agama ? 'selected' : '' }}>
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
                {{-- Kolom 1: Pendidikan Terakhir (Diubah menjadi Select Option) --}}
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan Terakhir</label>
                    <select class="form-select py-2 rounded-3 shadow-sm @error('pendidikan_terakhir') is-invalid @enderror"
                        id="pendidikan_terakhir" name="pendidikan_terakhir">

                        {{-- Nilai yang dipilih: old('field') atau $warga->field --}}
                        @php
                            $selectedPendidikan = old('pendidikan_terakhir', $warga->pendidikan_terakhir);
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

                        <option value="" disabled {{ $selectedPendidikan == '' ? 'selected' : '' }}>Pilih Pendidikan
                            Terakhir</option>

                        @foreach ($tingkatPendidikan as $pendidikan)
                            <option value="{{ $pendidikan }}"
                                {{ $selectedPendidikan == $pendidikan ? 'selected' : '' }}>
                                {{ $pendidikan }}
                            </option>
                        @endforeach
                    </select>

                    @error('pendidikan_terakhir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kolom 2: Gaji (Ditambahkan Formatting Rupiah) --}}
                <div class="col-md-6">
                    <label for="gaji_display" class="form-label fw-semibold">Gaji</label>
                    <div class="input-group">
                        {{-- Tampilan RP --}}
                        <span class="input-group-text py-2 rounded-3 shadow-sm">Rp</span>

                        {{-- Input Tampilan (Display) dengan Pemisah Ribuan --}}
                        @php
                            // Ambil nilai gaji lama atau old, default ke 0 jika null/kosong, lalu format untuk display
                            $gajiValue = old('gaji', $warga->gaji) ?? 0;
                            $gajiFormatted = number_format($gajiValue, 0, ',', '.');
                        @endphp

                        <input type="text"
                            class="form-control py-2 rounded-3 shadow-sm @error('gaji') is-invalid @enderror"
                            id="gaji_display" value="{{ $gajiFormatted }}" placeholder="Masukkan Gaji anda"
                            onkeyup="formatRupiah(this)">

                        {{-- Input Sebenarnya (Hidden) tanpa format untuk dikirim ke Controller --}}
                        <input type="hidden" name="gaji" id="gaji_hidden" value="{{ $gajiValue }}">
                    </div>

                    @error('gaji')
                        {{-- d-block diperlukan karena input berada di dalam div.input-group --}}
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                    <select class="form-select py-2 rounded-3 shadow-sm @error('jenis_kelamin') is-invalid @enderror"
                        id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="" disabled>Pilih Jenis Kelamin</option>
                        {{-- Gunakan ternary operator untuk memilih nilai lama --}}
                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
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
                        id="tanggal_lahir" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}" required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                    <input type="text"
                        class="form-control py-2 rounded-3 shadow-sm @error('pekerjaan') is-invalid @enderror"
                        id="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" name="pekerjaan"
                        placeholder="e.g. Pegawai Swasta, Ibu Rumah Tangga">
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="hubungan" class="form-label fw-semibold">Hubungan dalam Keluarga</label>
                    <input type="text"
                        class="form-control py-2 rounded-3 shadow-sm @error('hubungan') is-invalid @enderror"
                        id="hubungan" value="{{ old('hubungan', $warga->hubungan) }}" name="hubungan"
                        placeholder="e.g. Ayah,Ibu,dsb" required>
                    @error('hubungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="row mb-4">
                {{-- FOTO WARGA --}}
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="foto" class="form-label fw-semibold">Upload Foto Warga (Opsional)</label>
                    {{-- Input Hidden untuk menyimpan path foto lama --}}
                    <input type="hidden" name="old_foto" value="{{ $warga->foto }}">

                    <input type="file" class="form-control rounded-3 shadow-sm @error('foto') is-invalid @enderror"
                        id="foto" name="foto" accept="image/*" onchange="previewImage(event, 'preview-foto')">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Bagian Preview Foto --}}
                    <div id="preview-foto-container"
                        class="mt-2 @if (empty($warga->foto)) d-none @else d-block @endif">
                        {{-- Gunakan asset() untuk menampilkan gambar lama --}}
                        <img id="preview-foto" class="img-fluid border rounded-3 p-2 bg-light"
                            src="{{ asset('storage/' . $warga->foto) }}" alt="Preview Foto Warga"
                            style="max-height: 200px; object-fit: contain;">
                    </div>
                </div>

                {{-- FOTO KTP --}}
                <div class="col-md-6">
                    <label for="foto_ktp" class="form-label fw-semibold">Upload Foto KTP (Opsional)</label>
                    {{-- Input Hidden untuk menyimpan path foto KTP lama --}}
                    <input type="hidden" name="old_foto_ktp" value="{{ $warga->foto_ktp }}">

                    <input type="file"
                        class="form-control rounded-3 shadow-sm @error('foto_ktp') is-invalid @enderror" id="foto_ktp"
                        name="foto_ktp" accept="image/*" onchange="previewImage(event, 'preview-foto-ktp')">
                    @error('foto_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Bagian Preview Foto KTP --}}
                    <div id="preview-foto-ktp-container"
                        class="mt-2 @if (empty($warga->foto_ktp)) d-none @else d-block @endif">
                        {{-- Gunakan asset() untuk menampilkan gambar lama --}}
                        <img id="preview-foto-ktp" class="img-fluid border rounded-3 p-2 bg-light"
                            src="{{ asset('storage/' . $warga->foto_ktp) }}" alt="Preview Foto KTP"
                            style="max-height: 200px; object-fit: contain;">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="id_rumah" class="form-label fw-semibold">Rumah</label>
                    <select class="form-select py-2 rounded-3 shadow-sm" id="id_rumah" name="id_rumah">
                        <option value="" disabled>Pilih Rumah</option>
                        {{-- Pilihan Rumah Asumsi (Anda perlu mengisi dengan data Rumah dari DB) --}}
                        <option value="0" {{ old('id_rumah', $warga->id_rumah) == '0' ? 'selected' : '' }}>Tidak
                            Punya Rumah</option>
                        {{-- Loop untuk pilihan rumah dari DB --}}
                        {{-- @foreach ($rumahs as $rumah)
                    <option value="{{ $rumah->id }}" {{ old('id_rumah', $warga->id_rumah) == $rumah->id ? 'selected' : '' }}>
                        {{ $rumah->nama_rumah }}
                    </option>
                @endforeach --}}
                    </select>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="ms-2 btn btn-success rounded-3">Perbarui Data Warga</button>
            </div>
        </form>
    </div>
    <script>
        /**
         * Fungsi untuk memperbarui pratinjau gambar saat ada file baru diunggah.
         * Ini sudah memenuhi kebutuhan:
         * 1. Menampilkan gambar lama saat pertama kali load (dilakukan oleh Blade di atas).
         * 2. Mengganti pratinjau jika file input berubah (dilakukan oleh fungsi ini).
         */
        function previewImage(event, previewId) {
            const fileInput = event.target;
            const previewImg = document.getElementById(previewId);
            const previewContainer = document.getElementById(previewId + '-container');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    // Tampilkan container
                    previewContainer.classList.remove('d-none');
                    previewContainer.classList.add('d-block');
                }

                reader.readAsDataURL(fileInput.files[0]);
            } else {
                // Logika ini penting saat pengguna mengosongkan input file (jika memungkinkan)
                // Namun, dalam kasus edit, kita biarkan gambar lama terlihat jika input dikosongkan.
                // Logika di bawah akan dijalankan jika input file dihapus/dikosongkan.

                // Cari input hidden untuk mendapatkan path file lama
                const oldFileName = document.querySelector(`input[name="old_${fileInput.name}"]`).value;

                if (oldFileName) {
                    // Jika ada gambar lama, tampilkan gambar lama
                    // Perlu diperhatikan: asumsikan base URL asset sama dengan saat pertama load
                    const oldImageUrl = `{{ asset('storage') }}/${oldFileName}`;
                    previewImg.src = oldImageUrl;
                    previewContainer.classList.remove('d-none');
                    previewContainer.classList.add('d-block');
                } else {
                    // Sembunyikan jika memang tidak ada file lama dan input file dikosongkan
                    previewImg.src = '#';
                    previewContainer.classList.remove('d-block');
                    previewContainer.classList.add('d-none');
                }
            }
        }
    </script>
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
