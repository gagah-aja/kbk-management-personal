
@extends('layouts.admin.admin')

@section('content')
<div class="container mt-5">
    <h1>Daftar Nama Cluster</h1>

    @if (session('success'))
        <div style="background: #d1e7dd; color:#0f5132; padding:10px; border-radius:5px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.nama_cluster.create') }}" style="background:#007bff;color:white;padding:8px 15px;border-radius:5px;text-decoration:none;">+ Tambah Nama Cluster</a>

    <table border="1" width="100%" cellspacing="0" cellpadding="10" style="margin-top:15px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Cluster</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($namaClusters as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_cluster }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('admin.nama_cluster.edit', $item->id) }}">Edit</a> |
                        <form action="{{ route('admin.nama_cluster.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
