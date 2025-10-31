@extends('layouts.admin.admin')

@section('content')
<div class="p-2 p-md-2">

    {{-- Header Halaman --}}
    <div class="mb-4">
        <h2 class="fw-bold">🏠 Data Rumah</h2>
        <p class="text-muted mb-3">Kelola data rumah di RT</p>

        {{-- 🔽 Tombol Tambah Rumah (dipindahkan ke bawah teks) --}}
        <a href="{{ route('admin.rumah.create') }}" class="btn btn-dark rounded-3 px-4 py-2 shadow">
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
                            <th class="px-4 py-3 text-uppercase small text-secondary">No</th>
                            <th class="px-4 py-3 text-uppercase small text-secondary">Gambar</th>
                            <th class="px-4 py-3 text-uppercase small text-secondary">No. Rumah</th>
                            <th class="px-4 py-3 text-uppercase small text-secondary">Alamat Lengkap</th>
                            <th class="px-4 py-3 text-uppercase small text-secondary">Status</th>
                            <th class="px-4 py-3 text-uppercase small text-secondary">Cluster</th>
                            <th class="px-4 py-3 text-uppercase small text-secondary">Warga</th>
                            <th class="py-3 text-uppercase small text-secondary text-center">Aksi</th>
                        </tr>
                    </thead>

                    {{-- ISI DATA --}}
                    <tbody>
                        @forelse ($rumah as $index => $rumahs)
                            <tr>
                                <td class="fw-bold px-4">{{ $index + 1 }}</td>

                                {{-- Gambar Rumah --}}
                                <td class="px-4">
                                    @if($rumahs->gambar)
                                        <img src="{{ asset('storage/' . $rumahs->gambar) }}"
                                            alt="Gambar Rumah"
                                            width="70" height="50"
                                            class="rounded-3 shadow-sm">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="fw-bold px-4">{{ $rumahs->nomor_rumah }}</td>
                                <td class="px-4">{{ $rumahs->alamat_lengkap }}</td>

                                {{-- Status --}}
                                <td class="px-4">
                                    @php
                                        $badgeColor = match($rumahs->status) {
                                            'Tersedia' => 'success',
                                            'Terisi' => 'info',
                                            'Rusak' => 'warning',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge rounded-pill bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }}-emphasis fw-bold p-2">
                                        {{ $rumahs->status }}
                                    </span>
                                </td>

                        

                                {{-- Relasi Cluster --}}
                                <td class="px-4">
                                    {{ $rumahs->cluster->id_nama_cluster ?? '-' }}
                                </td>

                                {{-- Relasi Warga --}}
                                <td class="px-4">
                                    {{ $rumahs->warga->nama_lengkap ?? '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center px-2">
                                    <div class="d-inline-flex gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.rumah.edit', $rumahs->id) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.rumah.destroy', $rumahs->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="bi bi-inboxes display-6"></i>
                                    <p class="mt-2 mb-0">Belum ada data rumah.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
@endsection
