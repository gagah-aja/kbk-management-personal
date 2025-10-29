@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-xl shadow-lg">
            <h2 class="text-lg font-semibold">Total Warga</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalWarga }}</p>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg">
            <h2 class="text-lg font-semibold">Total Rumah</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalRumah }}</p>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-lg">
            <h2 class="text-lg font-semibold">Total Cluster</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalCluster }}</p>
        </div>

        <div class="bg-purple-500 text-white p-6 rounded-xl shadow-lg">
            <h2 class="text-lg font-semibold">Total RT</h2>
            <p class="text-3xl font-bold mt-2">{{ $totalRt }}</p>
        </div>
    </div>
</div>
@endsection
