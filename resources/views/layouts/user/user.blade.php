<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- ============================
         CUSTOM CSS
    ============================ -->
    <style>
        html {
            scroll-behavior: smooth;
        }

        /* ============================
           NAVBAR STYLING
        ============================ */

        /* Base nav-link */
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        /* Underline animation */
        .navbar-nav .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background-color: var(--bs-primary);
            transition: width 0.3s ease;
        }

        /* Hover effect */
        .navbar-nav .nav-link:hover {
            color: var(--bs-primary) !important;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Active state */
        .navbar-nav .nav-link.active {
            color: var(--bs-primary) !important;
            padding-bottom: 0.5rem;
        }

        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        /* Hover background (optional) */
        .navbar-nav .nav-link:not(.active):hover {
            background-color: var(--bs-light);
            border-radius: 0.25rem;
        }

        /* ============================
           MOBILE NAVBAR
        ============================ */
        @media (max-width: 991.98px) {

            /* Remove underline on mobile */
            .navbar-nav .nav-link::after {
                display: none;
            }

            /* Active background */
            .navbar-nav .nav-link.active {
                background-color: var(--bs-primary-bg-subtle);
                border-radius: 0.5rem;
                margin-bottom: 0.5rem;
                padding-bottom: 0.5rem;
            }

            .navbar-nav .nav-link {
                padding-left: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- ============================
         NAVBAR
    ============================ -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top py-3 border-bottom shadow-sm">
        <div class="container-fluid px-4 px-lg-5">

            <!-- Logo -->
            <a class="navbar-brand fw-bold text-primary fs-5 d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="bi bi-geo-alt-fill me-2"></i> Kota Baru Keandra
            </a>

            <!-- Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="mainNavbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold text-dark" href="{{ route('dashboard') }}#statistik">Data
                            Pokok</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold text-dark" href="{{ route('dashboard') }}#pengurus-warga">
                            Pengurus Warga (RW/RT)
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold text-dark" href="{{ route('dashboard') }}#maps">Peta
                            Lokasi</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT BERASAL DARI HALAMAN CHILD -->
    @yield('content')

    <!-- ============================
         ACTIVE ON SCROLL SCRIPT
    ============================ -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const sections = document.querySelectorAll(
                "section[id], [id='statistik'], [id='pengurus-warga'], [id='maps']");
            const navLinks = document.querySelectorAll(".nav-link");

            function setActiveLink() {
                let current = "";

                sections.forEach(section => {
                    const offset = section.offsetTop - 140;
                    if (window.scrollY >= offset) {
                        current = section.getAttribute("id");
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove("active");
                    const href = link.getAttribute("href");

                    // Check if link matches current section
                    if (href && (href === `#${current}` || href.endsWith(`#${current}`))) {
                        link.classList.add("active");
                    }
                });
            }

            window.addEventListener("scroll", setActiveLink);
            setActiveLink();
        });
    </script>

</body>

</html>
