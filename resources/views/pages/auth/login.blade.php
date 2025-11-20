@extends('layouts.auth.auth')

@section('content')
<div class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-sm-8 col-md-5 col-lg-4">
            <div class="card border-0 login-card p-4">

                {{-- Header with Icon --}}
                <div class="card-header bg-white border-0 text-center pb-0 pt-3">
                    <div class="header-icon">
                        <i class="bi bi-person-circle text-white" style="font-size: 36px;"></i>
                    </div>
                    <h4 class="fw-bold card-title mb-0">MASUK AKUN</h4>
                    <p class="text-muted small mt-2 mb-0">Silakan masukkan detail akun Anda.</p>
                </div>

                <div class="card-body pt-4">
                    {{-- Pesan sukses logout --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth_login') }}">
                        @csrf
                        
                        {{-- Email --}}
                        <div class="mb-3">
                            <div class="input-icon">
                                <i class="bi bi-envelope-fill"></i>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus placeholder="Alamat Email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <div class="input-icon">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-login btn-lg text-white fw-bold">
                                MASUK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('error'))
        Swal.fire({
            icon: 'warning',
            title: '⚠️ Oops...',
            text: "{{ session('error') }}",
            confirmButtonText: 'Login Sekarang',
            confirmButtonColor: '#667eea',
            background: '#fefefe',
            color: '#333',
            iconColor: '#ffc107',
            showClass: {
                popup: `
                    animate__animated
                    animate__fadeInDown
                `
            },
            hideClass: {
                popup: `
                    animate__animated
                    animate__fadeOutUp
                `
            }
        });
    @endif
</script>

<!-- Animasi dari animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

@endsection