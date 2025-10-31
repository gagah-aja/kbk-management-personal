<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <style>
        /* Mengubah warna teks aktif default Bootstrap agar lebih menonjol */
        .navbar-nav .nav-link.active {
            color: var(--bs-primary) !important;
            border-bottom: 2px solid var(--bs-primary);
            /* Garis bawah pada menu aktif (Desktop) */
            padding-bottom: 0.5rem;
        }

        /* Efek hover yang lembut */
        .navbar-nav .nav-link:not(.active):hover {
            color: var(--bs-primary);
            background-color: var(--bs-light);
            border-radius: 0.25rem;
        }

        /* Reset gaya aktif untuk mobile */
        @media (max-width: 991.98px) {
            .navbar-nav .nav-link.active {
                border-bottom: none;
                background-color: var(--bs-primary-bg-subtle);
                border-radius: 0.5rem;
                margin-bottom: 0.5rem;
            }

            .navbar-nav .nav-link {
                padding-left: 1rem;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top py-3 border-bottom shadow-sm">
        <div class="container-fluid px-4 px-lg-5">

            {{-- Logo/Nama Sistem --}}
            <a class="navbar-brand fw-bold text-primary fs-5" href="/user/dashboard">
                <i class="bi bi-geo-alt-fill me-2"></i> Kota Baru Keandra
            </a>

            {{-- Tombol Toggler untuk Mobile --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbarCollapse" aria-controls="mainNavbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbarCollapse">

                {{-- Navigasi Utama (Di tengah) --}}
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        {{-- Ganti 'request()->is(...)' dengan logic Blade/Laravel Anda untuk penentuan aktif --}}
                        <a class="nav-link px-3 {{ request()->is('user/dashboard') ? 'active fw-bold text-primary' : 'text-dark fw-semibold' }}"
                            href="/user/dashboard">
                            <i class="bi bi-grid-1x2-fill me-1 d-lg-none"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->is('user/pengumuman*') ? 'active fw-bold text-primary' : 'text-dark fw-semibold' }}"
                            href="/user/pengumuman">
                            <i class="bi bi-megaphone-fill me-1 d-lg-none"></i> Pengumuman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->is('user/iuran*') ? 'active fw-bold text-primary' : 'text-dark fw-semibold' }}"
                            href="/user/iuran">
                            <i class="bi bi-wallet-fill me-1 d-lg-none"></i> Pembayaran Iuran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->is('user/laporan*') ? 'active fw-bold text-primary' : 'text-dark fw-semibold' }}"
                            href="/user/laporan">
                            <i class="bi bi-file-earmark-bar-graph-fill me-1 d-lg-none"></i> Laporan Saya
                        </a>
                    </li>
                </ul>

                {{-- Dropdown Profil & Logout (Di kanan) --}}
                <div class="d-flex align-items-center me-lg-2">

                    {{-- Nama Pengguna (Desktop Only) --}}
                    <span class="d-none d-lg-block text-secondary me-3 small">
                        Halo, <strong class="text-dark">User Name</strong>
                    </span>

                    {{-- Dropdown Akun --}}
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle rounded-pill p-2"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background-color: #f1f1f1;">
                            {{-- Placeholder Avatar --}}
                            <img src="https://placehold.co/32x32/0d6efd/ffffff?text=U" alt="Avatar" width="32"
                                height="32" class="rounded-circle border border-primary me-2">
                            <span class="d-lg-none fw-semibold">Akun Saya</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2"
                            aria-labelledby="userDropdown">
                            <li>
                                <h6 class="dropdown-header fw-bold">Bapak Jono - RT 01</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/user/profil"><i class="bi bi-person-circle me-2"></i>
                                    Profil & Data</a></li>
                            <li><a class="dropdown-item" href="/user/settings"><i class="bi bi-gear-fill me-2"></i>
                                    Pengaturan Akun</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger fw-semibold" href="{{ route('logout') }}"><i
                                        class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>


    @yield('content')
</body>

</html>
