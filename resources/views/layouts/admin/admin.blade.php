<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard dengan Fixed Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Sidebar Fixed */
        #sidebar {
            width: 250px;
            /* Lebar Sidebar */
            height: 100vh;
            /* Tinggi penuh viewport */
            /* Gunakan bg-light atau warna lain dari Bootstrap */
            /* Tambahkan border atau shadow jika perlu */
            z-index: 1000;
            /* Pastikan sidebar di atas konten lain */
        }

        /* Margin untuk konten utama agar tidak tertutup sidebar */
        #main-content {
            margin-left: 250px;
            /* Harus sama dengan lebar sidebar */
            padding: 20px;
            /* Padding untuk konten */
        }

        /* Contoh untuk membuat konten utama bisa di-scroll */
        .scrollable-content {
            height: 200vh;
            /* Contoh tinggi agar bisa di-scroll */
            background-color: #f8f9fa;
            /* Warna latar belakang kontras */
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
                    <a class="nav-link active bg-light text-dark rounded" href="/cluster"><i
                            class="bi bi-grid-fill me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/"><i class="bi bi-house-door-fill me-2"></i> Data
                        Rumah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/rt"><i class="bi bi-people-fill me-2"></i> Data
                        rt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-person-lines-fill me-2"></i> Data
                        Warga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-megaphone-fill me-2"></i> Kejadian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i>
                        Laporan</a>
                </li>
            </ul>

            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        </div>

        <div id="main-content" class="flex-grow-1">
            @yield('content')

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
