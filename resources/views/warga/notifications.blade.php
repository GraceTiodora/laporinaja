@extends('layouts.app')

@section('title', 'Notifications - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- LEFT SIDEBAR -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">

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
            <div class="flex items-center gap-3">
                <i class="fa-regular fa-bell text-xl text-blue-600"></i>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Notifikasi</h1>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="markAllAsRead()" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 rounded-full transition-all hover:shadow-md">
                    <i class="fa-solid fa-check-double mr-1"></i>
                    Tandai Semua Dibaca
                </button>
                <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg group">
                    <i class="fa-solid fa-gear text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>
        </header>

        <!-- NOTIFICATION LIST -->
        <div class="flex-1 overflow-y-auto p-6 space-y-5">

            @if(!empty($notifications))

                <div class="space-y-4">

                    @foreach ($notifications as $notif)

                        @php
                            $types = [
                                'vote' => ['fa-solid fa-heart', 'bg-gradient-to-r from-red-500 to-pink-600 text-white'],
                                'comment' => ['fa-solid fa-comment', 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white'],
                                'status' => ['fa-solid fa-clipboard-check', 'bg-gradient-to-r from-green-500 to-emerald-600 text-white'],
                                'trending' => ['fa-solid fa-fire', 'bg-gradient-to-r from-orange-500 to-red-600 text-white'],
                            ];
                            $icon  = $types[$notif['type']][0] ?? 'fa-regular fa-bell';
                            $color = $types[$notif['type']][1] ?? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white';
                        @endphp

                        <div class="group p-6 rounded-2xl border-2 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 cursor-pointer relative
                            {{ $notif['read'] ? 'bg-white border-gray-200 hover:border-blue-300' : 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-400 hover:border-blue-500 unread shadow-lg' }}"
                             data-id="{{ $notif['id'] }}">

                            <div class="flex items-start gap-4">

                                <div class="p-3.5 rounded-xl {{ $color }} group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                                    <i class="{{ $icon }} text-xl"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-bold text-gray-900 text-base group-hover:text-blue-600 transition-colors">{{ $notif['title'] }}</p>
                                    <p class="text-sm text-gray-600 mt-1.5 leading-relaxed">{{ $notif['message'] }}</p>
                                    <div class="flex items-center gap-4 mt-3">
                                        <p class="text-xs text-gray-500 flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-blue-500"></i>
                                            {{ $notif['time'] }}
                                        </p>
                                        @if(!$notif['read'])
                                            <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                                                <i class="fa-solid fa-sparkles"></i> Baru
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if(!$notif['read'])
                                    <div class="absolute top-4 right-4">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                                        </span>
                                    </div>
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
            this.classList.remove('unread', 'bg-gradient-to-br', 'from-blue-50', 'to-indigo-50', 'border-blue-400', 'shadow-lg');
            this.classList.add('bg-white', 'border-gray-200');
        });
    });
});

function markAllAsRead() {
    document.querySelectorAll('.unread').forEach(card => {
        card.classList.remove('unread', 'bg-gradient-to-br', 'from-blue-50', 'to-indigo-50', 'border-blue-400', 'shadow-lg');
        card.classList.add('bg-white', 'border-gray-200');
    });
}
</script>

@endsection
