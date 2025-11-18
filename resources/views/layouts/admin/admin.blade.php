<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem RT - Dashboard Modern</title>

    {{-- Icons & Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/crud-minimal.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar */
        #sidebar {
            width: 280px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 20px;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        #sidebar::-webkit-scrollbar { width: 6px; }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.3);
            border-radius: 10px;
        }

        /* Header Sidebar */
        .sidebar-header {
            margin-bottom: 35px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            animation: fadeInDown 0.6s ease;
        }

        .sidebar-header h5 {
            font-size: 26px;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 13px;
            color: #888;
            font-weight: 600;
            margin: 0;
        }

        /* Nav Item */
        .nav-item { margin-bottom: 6px; }

        .nav-link {
            padding: 14px 18px;
            border-radius: 14px;
            color: #666;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link i {
            font-size: 18px;
            margin-right: 14px;
            min-width: 20px;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
        }

        .nav-link.logout-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            margin-top: 20px;
        }

        .nav-link.logout-btn:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 24px rgba(245, 87, 108, 0.4);
        }

        /* Main Content */
        #main-content {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1001;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .mobile-toggle i { font-size: 24px; color: #667eea; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; padding: 20px; }
            .mobile-toggle { display: flex; }
            .mobile-overlay {
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }
            .mobile-overlay.show { display: block; }
        }
    </style>
</head>

<body>

    {{-- SweetAlert Notifications --}}
    <x-alert></x-alert>

    {{-- Mobile Sidebar Toggle --}}
    <div class="mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </div>
    <div class="mobile-overlay" onclick="toggleSidebar()"></div>

    <div class="d-flex">
        {{-- Sidebar --}}
        <div id="sidebar">
            <div class="sidebar-header">
                <h5>Sistem KBK</h5>
                <p>Pendataan Warga</p>
            </div>

            <ul class="nav flex-column mb-auto">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.rumah.index') }}" class="nav-link {{ request()->is('admin/rumah*') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill"></i> Data Rumah
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.cluster.index') }}" class="nav-link {{ request()->is('admin/cluster*') ? 'active' : '' }}">
                        <i class="bi bi-diagram-3-fill"></i> Data Cluster
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.warga.index') }}" class="nav-link {{ request()->is('admin/warga*') ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i> Data Warga
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.nama-cluster.index') }}" class="nav-link {{ request()->is('admin/nama-cluster*') ? 'active' : '' }}">
                        <i class="bi bi-collection-fill"></i> Nama Cluster
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.rw.index') }}" class="nav-link {{ request()->is('admin/rw*') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt-fill"></i> Data RW
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.rt.index') }}" class="nav-link {{ request()->is('admin/rt*') ? 'active' : '' }}">
                        <i class="bi bi-geo-fill"></i> Data RT
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.blok.index') }}" class="nav-link {{ request()->is('admin/blok*') ? 'active' : '' }}">
                        <i class="bi bi-megaphone-fill"></i> Blok
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.status-rumah.index') }}" class="nav-link {{ request()->is('admin/status-rumah*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text-fill"></i> Status Rumah
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.setting.index') }}" class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}">
                        <i class="bi bi-gear-fill"></i> Setting
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="#" class="nav-link logout-btn" id="logoutButton">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>

                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        {{-- Main Content --}}
        <div id="main-content" class="flex-grow-1">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JS --}}
    <script>
        // Mobile Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        if (window.innerWidth <= 768) {
            document.querySelectorAll('#sidebar .nav-link').forEach(link => {
                link.addEventListener('click', () => toggleSidebar());
            });
        }

        // Logout Confirmation
        document.getElementById('logoutButton').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Kamu akan keluar dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>

</body>
</html>
