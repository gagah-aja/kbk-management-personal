<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard dengan Fixed Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>

    <div class="d-flex">

        <div id="sidebar" class="bg-white p-3 border-end position-fixed top-0 start-0">
            <h4 class="text-primary mb-4">Sistem RT</h4>
            <p class="text-muted border-bottom pb-2">Pendataan Warga</p>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active bg-light text-dark rounded" href="/cluster">
                        <i class="bi bi-grid-fill me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/">
                        <i class="bi bi-house-door-fill me-2"></i> Data Rumah
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/Bencana">
                        <i class="bi bi-people-fill me-2"></i> Data Bencana
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.warga.index') }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Data Warga
                    </a>
                    <a class="nav-link text-dark" href="/admin/nama-cluster">
                        <i class="bi bi-person-lines-fill me-2"></i> Nama Cluster
                    </a>
                    <a class="nav-link text-dark" href="/admin/data-rw">
                        <i class="bi bi-geo-alt-fill me-2"></i> Data RW
                    </a>
                    <a class="nav-link text-dark" href="/admin/data-rt">
                        <i class="bi bi-geo-fill me-2"></i> Data RT
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/admin/nama-blok">
                        <i class="bi bi-megaphone-fill me-2"></i> Blok
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#">
                        <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Laporan
                    </a>
                </li>
            </ul>

        </div>

        <div id="main-content" class="flex-grow-1">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
