<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Konten utama -->
    <main class="flex-1 p-6 overflow-auto">
        @yield('content')
    </main>

</body>
</html>
