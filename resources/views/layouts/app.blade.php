<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laporin Aja')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Custom Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom Tailwind Configuration & Additional Styles -->
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">

    @stack('styles')
</head>
<body class="antialiased bg-gray-50">
    <div id="app">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>