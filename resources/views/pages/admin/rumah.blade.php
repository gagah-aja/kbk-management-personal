@extends('layouts.admin.admin')
@section('content')
    <div class=" p-2 p-md-2">

        {{-- Header Halaman dan Tombol Tambah --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Data Rumah</h2>
                <p class="text-muted">Kelola data rumah di RT</p>
            </div>
            <a href="#" class="btn btn-dark rounded-3 px-4 py-2 shadow">
                <i class="fas fa-plus me-2"></i> Tambah Rumah
            </a>
        </div>

        {{-- Kartu Data --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">

                        {{-- HEADER TABEL --}}
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-uppercase text-secondary small py-3 px-4">No. Rumah</th>
                                <th scope="col" class="text-uppercase text-secondary small py-3 px-4">Alamat Lengkap</th>
                                <th scope="col" class="text-uppercase text-secondary small py-3 px-4">Status</th>
                                <th scope="col" class="text-uppercase text-secondary small py-3 px-4">Penghuni</th>
                                <th scope="col" class="text-uppercase text-secondary small text-end py-3 px-4">Aksi</th>
                            </tr>
                        </thead>

                        {{-- ISI DATA --}}
                        <tbody>

                            {{-- Data Baris 1: Milik (Hijau) --}}
                            <tr>
                                <td class="fw-bold px-4">001</td>
                                <td class="px-4">Jl. Mawar No. 1, RT 01, Kelurahan Maju</td>
                                <td class="px-4"><span
                                        class="badge rounded-pill bg-success-subtle text-success-emphasis fw-bold p-2">Milik</span>
                                </td>
                                <td class="px-4">4 orang</td>
                                <td class="text-end px-4">
                                    <a href="#" class="btn btn-sm text-secondary me-2 p-0"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-sm text-danger p-0"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            {{-- Data Baris 2: Milik (Hijau) --}}
                            <tr>
                                <td class="fw-bold px-4">002</td>
                                <td class="px-4">Jl. Mawar No. 2, RT 01, Kelurahan Maju</td>
                                <td class="px-4"><span
                                        class="badge rounded-pill bg-success-subtle text-success-emphasis fw-bold p-2">Milik</span>
                                </td>
                                <td class="px-4">3 orang</td>
                                <td class="text-end px-4">
                                    <a href="#" class="btn btn-sm text-secondary me-2 p-0"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-sm text-danger p-0"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            {{-- Data Baris 3: Sewa (Biru/Info) --}}
                            <tr>
                                <td class="fw-bold px-4">003</td>
                                <td class="px-4">Jl. Melati No. 3, RT 01, Kelurahan Maju</td>
                                <td class="px-4"><span
                                        class="badge rounded-pill bg-info-subtle text-info-emphasis fw-bold p-2">Sewa</span>
                                </td>
                                <td class="px-4">5 orang</td>
                                <td class="text-end px-4">
                                    <a href="#" class="btn btn-sm text-secondary me-2 p-0"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-sm text-danger p-0"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            {{-- Data Baris 4: Milik (Hijau) --}}
                            <tr>
                                <td class="fw-bold px-4">004</td>
                                <td class="px-4">Jl. Melati No. 4, RT 01, Kelurahan Maju</td>
                                <td class="px-4"><span
                                        class="badge rounded-pill bg-success-subtle text-success-emphasis fw-bold p-2">Milik</span>
                                </td>
                                <td class="px-4">2 orang</td>
                                <td class="text-end px-4">
                                    <a href="#" class="btn btn-sm text-secondary me-2 p-0"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-sm text-danger p-0"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            {{-- Data Baris 5: Kontrak (Kuning/Warning) --}}
                            <tr>
                                <td class="fw-bold px-4">005</td>
                                <td class="px-4">Jl. Kenanga No. 5, RT 01, Kelurahan Maju</td>
                                <td class="px-4"><span
                                        class="badge rounded-pill bg-warning-subtle text-warning-emphasis fw-bold p-2">Kontrak</span>
                                </td>
                                <td class="px-4">3 orang</td>
                                <td class="text-end px-4">
                                    <a href="#" class="btn btn-sm text-secondary me-2 p-0"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-sm text-danger p-0"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
