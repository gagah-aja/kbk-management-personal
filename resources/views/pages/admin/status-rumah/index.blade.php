@extends('layouts.admin.admin')
@section('title', 'Status Rumah')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Status Rumah</h3>

        <div class="d-flex gap-2">
            {{-- Form Search --}}
            <form action="{{ route('admin.status-rumah.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama status..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary ms-2">Cari</button>
            </form>

            <a href="{{ route('admin.status-rumah.create') }}" class="btn btn-dark">
                Tambah Status
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
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

    {{-- Tabel --}}
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
                                <td>{{ $statuses->firstItem() + $index }}</td>
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

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small>
                            Menampilkan {{ $statuses->firstItem() }} - {{ $statuses->lastItem() }}
                            dari {{ $statuses->total() }} data
                        </small>
                    </div>
                    <div>
                        {{ $statuses->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
