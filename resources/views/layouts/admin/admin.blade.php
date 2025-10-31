<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard dengan Fixed Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

        /* CSS Khusus untuk Sidebar Fixed */
        #sidebar {
            width: 250px;
            height: 100vh;
            z-index: 1000;
        }

        /* Margin untuk konten utama agar tidak tertutup sidebar */
        #main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Contoh untuk membuat konten utama bisa di-scroll */
        .scrollable-content {
            height: 200vh;
            background-color: #f8f9fa;
        }
        #sidebar{
            font-weight: 600;
            color: gray
        }
    </style>
</head>

<body>
    <x-alert></x-alert>

    <div class="d-flex">

        <div id="sidebar" class="d-flex flex-column p-3 bg-white border-end vh-100 position-fixed"
            style="width: 250px;">
            <h5 class="fw-bold text-primary mb-1">Sistem RT</h5>
            <p class="text-muted mb-4 border-bottom pb-2">Pendataan Warga</p>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="{{route('admin.dashboard')}}"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/dashboard') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/dashboard') ? 'background-color: #eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-grid-fill me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="{{ route('admin.rumah.index') }}"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/rumah*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/rumah*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-house-door-fill me-2"></i> Data Rumah
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/admin/data-cluster"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/data-cluster*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/data-cluster*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-diagram-3-fill me-2"></i> Data Cluster
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="{{ route('admin.warga.index') }}"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/warga*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/warga*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Data Warga
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/admin/nama-cluster"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/nama-cluster*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/nama-cluster*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Nama Cluster
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/admin/data-rw"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/data-rw*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/data-rw*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-geo-alt-fill me-2"></i> Data RW
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/admin/data-rt"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/data-rt*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/data-rt*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-geo-fill me-2"></i> Data RT
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/admin/nama-blok"
                        class="nav-link d-flex align-items-center px-3 py-2 rounded {{ request()->is('admin/nama-blok*') ? 'active' : 'text-dark' }}"
                        style="{{ request()->is('admin/nama-blok*') ? 'background-color:#eaf2ff; color:#0d6efd; font-weight:600;' : 'color:#333;' }}">
                        <i class="bi bi-megaphone-fill me-2"></i> Blok
                    </a>
                </li>

                <li class="nav-item mt-2">
                    <a href="{{ route('logout') }}"
                        class="nav-link text-danger d-flex align-items-center px-3 py-2 rounded">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <div id="main-content" class="flex-grow-1 ">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efek hover lembut
        document.querySelectorAll('#sidebar .nav-link').forEach(link => {
            link.addEventListener('mouseenter', () => {
                if (!link.classList.contains('active')) {
                    link.style.backgroundColor = '#f5f7ff';
                }
            });
            link.addEventListener('mouseleave', () => {
                if (!link.classList.contains('active')) {
                    link.style.backgroundColor = 'transparent';
                }
            });
        });
    </script>

</body>

</html>
