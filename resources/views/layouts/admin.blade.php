<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Halaman dashboard admin' }}</title>
</head>

<body>
    <div class="page-content">
         @include('layouts.partial.sidebar')
        @yield('content')
    </div>
</body>

</html>
