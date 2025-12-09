<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laporin Aja')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

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

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-50 space-y-3 max-w-md"></div>

    <!-- Success/Error Messages Handler -->
    @if(session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
        });
    </script>
    @endif

    <!-- Toast Notification System -->
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const toastId = 'toast-' + Date.now();
            toast.id = toastId;
            
            // Icon and color based on type
            let icon, bgColor, iconBg, borderColor, progressColor;
            if (type === 'success') {
                icon = 'fa-check-circle';
                bgColor = 'bg-white';
                iconBg = 'bg-green-500';
                borderColor = 'border-green-200';
                progressColor = 'bg-green-500';
            } else if (type === 'error') {
                icon = 'fa-exclamation-circle';
                bgColor = 'bg-white';
                iconBg = 'bg-red-500';
                borderColor = 'border-red-200';
                progressColor = 'bg-red-500';
            } else if (type === 'warning') {
                icon = 'fa-exclamation-triangle';
                bgColor = 'bg-white';
                iconBg = 'bg-yellow-500';
                borderColor = 'border-yellow-200';
                progressColor = 'bg-yellow-500';
            } else {
                icon = 'fa-info-circle';
                bgColor = 'bg-white';
                iconBg = 'bg-blue-500';
                borderColor = 'border-blue-200';
                progressColor = 'bg-blue-500';
            }
            
            toast.className = `${bgColor} ${borderColor} border-2 rounded-xl shadow-2xl p-4 flex items-start gap-4 transform transition-all duration-300 translate-x-0 opacity-100 min-w-[320px] max-w-md overflow-hidden relative`;
            toast.style.animation = 'slideInRight 0.3s ease-out';
            
            toast.innerHTML = `
                <div class="${iconBg} w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                    <i class="fa-solid ${icon} text-white text-lg"></i>
                </div>
                <div class="flex-1 pt-0.5">
                    <p class="text-gray-800 font-semibold text-sm leading-relaxed">${message}</p>
                </div>
                <button onclick="removeToast('${toastId}')" class="text-gray-400 hover:text-gray-600 transition-colors flex-shrink-0 hover:scale-110 transform">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
                <div class="absolute bottom-0 left-0 h-1 ${progressColor} rounded-full transition-all duration-[3000ms] ease-linear" style="width: 100%;" id="${toastId}-progress"></div>
            `;
            
            container.appendChild(toast);
            
            // Start progress bar animation
            setTimeout(() => {
                const progress = document.getElementById(`${toastId}-progress`);
                if (progress) progress.style.width = '0%';
            }, 100);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                removeToast(toastId);
            }, 3000);
        }
        
        function removeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.animation = 'slideOutRight 0.3s ease-in';
                toast.style.transform = 'translateX(120%)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }
    </script>

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(120%);
                opacity: 0;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html> 