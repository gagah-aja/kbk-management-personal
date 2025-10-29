@extends('layouts.auth.auth')

@section('content')
{{-- Kontainer Full-Screen Centered --}}
<div class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        {{-- Mengurangi lebar kolom untuk tampilan yang lebih minimalis --}}
        <div class="col-sm-8 col-md-5 col-lg-4">
            <div class="card border-0 shadow-lg p-3"> {{-- border-0: menghilangkan border default, p-3: padding card body --}}

                {{-- Header Minimalis --}}
                <div class="card-header bg-white border-0 text-center pb-0 pt-4">
                    <h4 class="fw-bold text-dark mb-0">MASUK AKUN</h4>
                    <p class="text-muted small mt-2">Silakan masukkan detail akun Anda.</p>
                </div>

                <div class="card-body pt-3">
                    {{-- Menampilkan pesan Flash/Sesi (misal: sukses logout) --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="/login">
                        @csrf

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label visually-hidden">Alamat Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror" {{-- form-control-lg untuk input yang lebih besar --}}
                                value="{{ old('email') }}" required autofocus placeholder="Alamat Email">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-3">
                            <label for="password" class="form-label visually-hidden">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                required placeholder="Password">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Remember Me Checkbox dan Link Lupa Password (Opsional) --}}
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                                <label class="form-check-label small" for="remember">Ingat Saya</label>
                            </div>
                            {{-- Jika Anda memiliki fitur lupa password: --}}
                            {{-- <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa Password?</a> --}}
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold"> {{-- btn-lg dan fw-bold untuk penekanan --}}
                                MASUK
                            </button>
                        </div>

                        {{-- Opsi Register (Opsional) --}}
                        <p class="text-center small text-muted">Belum punya akun? <a href="#" class="text-decoration-none">Daftar Sekarang</a></p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
