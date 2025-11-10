@extends('layouts.admin.admin')
@section('title', 'Status Rumah')

@section('content')
<div class="container mt-4">
    {{-- 🔹 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Status Rumah</h3>
        <a href="{{ route('admin.status-rumah.create') }}" class="btn btn-primary">
            Tambah Status
        </a>
    </div>

    {{-- 🔹 Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 🔹 Card Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if ($statuses->isEmpty())
                <p class="text-muted text-center mb-0">
                    Belum ada data status rumah. Silakan tambahkan terlebih dahulu.
                </p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th class="text-center">Nama Status</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $index => $s)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $s->nama_status }}</td>
                                <td>
                                    <a href="{{ route('admin.status-rumah.edit', $s->id) }}" 
                                       class="btn btn-sm btn-warning me-1">
                                       Edit
                                    </a>
                                    <form action="{{ route('admin.status-rumah.destroy', $s->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus status ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
