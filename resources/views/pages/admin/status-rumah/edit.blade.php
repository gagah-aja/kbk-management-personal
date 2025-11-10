@extends('layouts.admin.admin')

@section('title', 'Edit Status Rumah')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Status Rumah</h2>

    <form action="{{ route('admin.status-rumah.update', $status->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_status" class="form-label">Nama Status</label>
            <input type="text" name="nama_status" id="nama_status" class="form-control"
                   value="{{ old('nama_status', $status->nama_status) }}" required>
            @error('nama_status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.status-rumah.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
