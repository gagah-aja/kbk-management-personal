<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        /* Active nav item */
        .navbar-nav .nav-link.active {
            color: var(--bs-primary) !important;
            border-bottom: 2px solid var(--bs-primary);
            padding-bottom: 0.5rem;
        }

        /* Hover */
        .navbar-nav .nav-link:not(.active):hover {
            color: var(--bs-primary);
            background-color: var(--bs-light);
            border-radius: 0.25rem;
        }

        /* Mobile aktif */
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
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top py-3 border-bottom shadow-sm">
        <div class="container-fluid px-4 px-lg-5">

            <a class="navbar-brand fw-bold text-primary fs-5" href="#">
                <i class="bi bi-geo-alt-fill me-2"></i> Kota Baru Keandra
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold text-dark" href="#statistik">Data Pokok</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold text-dark" href="#pengurus-warga">Pengurus Warga (RW/RT)</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3 fw-semibold text-dark" href="#maps">Peta Lokasi</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- SCRIPT: AUTO ACTIVE NAV -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll("section");
            const navLinks = document.querySelectorAll(".nav-link");

            function setActiveLink() {
                let current = "";

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 80;
                    if (window.scrollY >= sectionTop) {
                        current = section.getAttribute("id");
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove("active");
                    if (link.getAttribute("href") === `#${current}`) {
                        link.classList.add("active");
                    }
                });
            }

            window.addEventListener("scroll", setActiveLink);
        });
    </script>

</body>

</html>
