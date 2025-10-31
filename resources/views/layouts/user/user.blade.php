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
        <div class="container-fluid px-4 px-lg-5 justify-space-between">

            {{-- Logo/Nama Sistem --}}
            <a class="navbar-brand fw-bold text-primary fs-5" href="/">
                <i class="bi bi-geo-alt-fill me-2"></i> Kota Baru Keandra
            </a>


            {{-- <div class="collapse navbar-collapse" id="mainNavbarCollapse">

                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->is('user/dashboard') ? 'active fw-bold text-primary' : 'text-dark fw-semibold' }}"
                            href="/">
                            <i class="bi bi-grid-1x2-fill me-1 d-lg-none"></i> Dashboard
                        </a>
                    </li>

                </ul>


            </div> --}}
        </div>
    </nav>


    @yield('content')
</body>

</html>
