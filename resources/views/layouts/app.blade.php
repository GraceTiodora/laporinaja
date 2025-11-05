<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Laporin Aja')</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.5.4/dist/tailwind.min.css" rel="stylesheet">

    <!-- fallback/local -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="antialiased bg-gray-50">
    <div id="app">
        @yield('content')
    </div>

    <!-- interaktivitas kecil -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>