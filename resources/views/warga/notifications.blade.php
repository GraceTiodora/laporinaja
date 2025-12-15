@extends('layouts.app')

@section('title', 'Notifications - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- LEFT SIDEBAR -->
    <aside class="w-[270px] bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">

        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>
            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                    $unreadNotifications = $unreadNotifications ?? ($unreadCount ?? 0);
                @endphp
                @foreach ($menu as [$name, $route, $icon])
                    @php
                        $href = '#';
                        if ($route !== '#') {
                            try {
                                $href = route($route);
                            } catch (\Exception $e) {
                                $href = '#';
                            }
                        }
<<<<<<< Updated upstream
                    @endphp
                    <a href="{{ $href }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium
                              transition-all hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 
                              hover:shadow-md hover:scale-105 transform">
                        <i class="{{ $icon }} text-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                        <span class="group-hover:translate-x-1 transition-transform">{{ $name }}</span>
=======
                        $isActive = request()->routeIs($route);
                        $showBadge = $route === 'notifications' && ($unreadNotifications ?? $unreadCount ?? 0) > 0;
                        $notifCount = $unreadNotifications ?? $unreadCount ?? 0;
                    @endphp
                    <a href="{{ $href }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300 relative
                              {{ $isActive 
                                  ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' 
                                  : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                        @if($isActive)
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        @endif
                        <i class="{{ $icon }} text-lg group-hover:scale-125 transition-transform"></i>
                        <span class="font-semibold">{{ $name }}</span>
                        @if($showBadge)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full min-w-[20px] text-center">
                                {{ $notifCount > 99 ? '99+' : $notifCount }}
                            </span>
                        @endif
>>>>>>> Stashed changes
                    </a>
                @endforeach
            </nav>
            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all duration-300 font-bold transform hover:scale-105 group">
                <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <div>
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 hover:bg-white/50 p-3 rounded-xl transition-all cursor-pointer group mb-3">
                <div class="relative">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div class="flex flex-col leading-tight flex-1">
                    <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition">{{ session('user.name', 'Guest') }}</span>
                    <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 opacity-0 group-hover:opacity-100 transition-all"></i>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-600 font-semibold bg-white/50 hover:bg-red-50 hover:text-red-700 transition-all group border border-red-200 hover:border-red-300">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 overflow-hidden">

        <!-- HEADER -->
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10 shadow-sm">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Notifikasi</h1>
            <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg group">
                <i class="fa-solid fa-gear text-xl group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </header>

        <!-- NOTIFICATION LIST -->
        <div class="flex-1 overflow-y-auto p-6 space-y-5">

            @if(!empty($notifications))

                <div class="space-y-4">

                    @foreach ($notifications as $notif)

                        @php
                            $types = [
                                'vote' => ['fa-regular fa-heart', 'bg-red-100 text-red-600'],
                                'comment' => ['fa-regular fa-comment', 'bg-blue-100 text-blue-600'],
                                'status' => ['fa-solid fa-clipboard-check', 'bg-green-100 text-green-600'],
                                'trending' => ['fa-solid fa-chart-line', 'bg-orange-100 text-orange-600'],
                            ];
                            $icon  = $types[$notif['type']][0] ?? 'fa-regular fa-bell';
                            $color = $types[$notif['type']][1] ?? 'bg-gray-100 text-gray-600';
                        @endphp

                        <div class="group p-6 rounded-2xl shadow-md border transition-all duration-300 hover:shadow-xl hover:scale-[1.02] cursor-pointer relative
                            {{ $notif['read'] ? 'bg-white border-gray-200 hover:border-gray-300' : 'bg-gradient-to-r from-blue-50 to-purple-50 border-blue-400 hover:border-blue-500 unread' }}"
                             data-id="{{ $notif['id'] }}">

                            <div class="flex items-start gap-4">

                                <div class="p-3 rounded-xl {{ $color }} group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                    <i class="{{ $icon }} text-xl"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 text-base group-hover:text-blue-600 transition-colors">{{ $notif['title'] }}</p>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $notif['message'] }}</p>
                                    <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $notif['time'] }}
                                    </p>
                                </div>

                                @if(!$notif['read'])
                                    <span class="w-3 h-3 bg-blue-600 rounded-full absolute top-5 right-5 animate-pulse shadow-lg"></span>
                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else
                <div class="text-center py-20">
                    <div class="inline-block p-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 mb-6">
                        <i class="fa-regular fa-bell-slash text-6xl text-gray-400"></i>
                    </div>
                    <p class="text-lg font-semibold text-gray-600">Tidak ada notifikasi</p>
                    <p class="text-sm text-gray-400 mt-2">Notifikasi baru akan muncul di sini</p>
                </div>
            @endif

        </div>

    </main>

<<<<<<< Updated upstream
    <!-- RIGHT SIDEBAR -->
    <aside class="w-[340px] bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 p-6 overflow-y-auto shadow-lg">

        <section class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> 
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Masalah Penting</span>
            </h2>
            <ul class="space-y-3">
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition mb-1">Jalan Rusak</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                Jl. Melati
                            </p>
                        </div>
                        <span class="text-sm font-bold text-red-600">128 Votes</span>
                    </div>
                </li>

                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition mb-1">Sampah Menumpuk</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                Pasar Baru
                            </p>
                        </div>
                        <span class="text-sm font-bold text-red-600">96 Votes</span>
                    </div>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-arrow-trend-up text-blue-500"></i> 
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Trending</span>
            </h2>
            <ul class="space-y-3">
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Infrastruktur Jalan</p>
                    <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-blue-400"></i>
                        5 laporan hari ini
                    </p>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-heart text-red-400"></i>
                        <span class="text-xs text-gray-500">85 votes</span>
                    </div>
                </li>
                
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Sampah Menumpuk</p>
                    <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-blue-400"></i>
                        Pasar Baru
                    </p>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-heart text-red-400"></i>
                        <span class="text-xs text-gray-500">72 votes</span>
                    </div>
                </li>
                
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Lampu Jalan Mati</p>
                    <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                        <i class="fa-solid fa-location-dot text-blue-400"></i>
                        Jl. Merdeka
                    </p>
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-heart text-red-400"></i>
                        <span class="text-xs text-gray-500">58 votes</span>
                    </div>
                </li>
            </ul>
        </section>
    </aside>
=======

>>>>>>> Stashed changes

</div>

<script>
document.querySelectorAll('.unread').forEach(card => {
    card.addEventListener('click', function () {
        const id = this.dataset.id;
        fetch("{{ url('/notifications/read') }}/" + id, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        }).then(() => {
            this.classList.remove('unread');
        });
    });
});
</script>

@endsection
