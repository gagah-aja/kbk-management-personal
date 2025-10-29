@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-5">Daftar Cluster</h1>

<a href="{{ route('cluster.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Cluster</a>

@if(session('success'))
    <p class="text-green-500 mt-2">{{ session('success') }}</p>
@endif

<table class="table-auto w-full mt-4 border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Nama Cluster</th>
            <th class="border px-4 py-2">RT</th>
            <th class="border px-4 py-2">Blok</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clusters as $cluster)
        <tr class="text-center">
            <td class="border px-4 py-2">{{ $cluster->id }}</td>
            <td class="border px-4 py-2">{{ $cluster->id_nama_cluster }}</td>
            <td class="border px-4 py-2">{{ $cluster->rt->nomor_rt ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $cluster->blok->nama_blok ?? '-' }}</td>
            <td class="border px-4 py-2">
                <a href="{{ route('cluster.edit', $cluster->id) }}" class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('cluster.destroy', $cluster->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus cluster?')" class="text-red-500 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
