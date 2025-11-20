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
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/crud-minimal.css') }}">

    {{-- Additional Styles from Pages --}}
    @stack('styles')
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

    {{-- Custom Scripts --}}
    <script src="{{ asset('js/admin-layout.js') }}"></script>

    {{-- Additional Scripts from Pages --}}
    @stack('scripts')
</body>
</html>