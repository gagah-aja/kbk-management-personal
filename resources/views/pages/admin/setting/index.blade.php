@extends('layouts.admin.admin')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-gradient">Halaman Setting</h2>
        <p class="text-muted">Atur tampilan landing page sistem</p>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card Gambar Landing Page --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mx-auto" style="max-width: 900px;">
        <div class="card-header text-white text-center py-3"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0 fw-semibold">Landing Page Preview</h5>
        </div>

        <div class="card-body text-center p-4 bg-light">
            @if ($landingPage && $landingPage->value)
                <img src="{{ asset('storage/' . $landingPage->value) }}"
                    alt="Landing Page"
                    class="img-fluid rounded-4 shadow-sm mb-3"
                    style="max-height: 400px; object-fit: cover;">
            @else
                <p class="text-muted mb-3">Belum ada gambar landing page yang diunggah.</p>
            @endif

            <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="landing_page" class="form-control" accept="image/*" onchange="previewImage(event)">
                    @error('landing_page')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-upload"></i> Upload Gambar Baru
                </button>
            </form>

            {{-- Preview sebelum upload --}}
            <div class="mt-3" id="preview-container" style="display: none;">
                <p class="text-muted small mb-2">Preview gambar baru:</p>
                <img id="preview-image" src="#" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

<script>
function previewImage(event) {
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    previewImage.src = URL.createObjectURL(event.target.files[0]);
    previewContainer.style.display = 'block';
}
</script>
@endsection
