
@extends('layouts.app')

@section('title', 'Notifications - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
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
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp 

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium
                              transition-all hover:bg-blue-50 hover:text-blue-600">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
                           text-white py-3 rounded-full shadow-md transition-all font-semibold">
                <i class="fa-solid fa-plus-circle"></i> Laporan Baru
            </button>
        </div>

        <!-- Profile Bottom -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 MAIN CONTENT -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 overflow-hidden">

        <!-- HEADER -->
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10 shadow-sm">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Notifikasi</h1>
            <div class="flex items-center gap-3">
                <button onclick="markAllAsRead()" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition hover:bg-blue-50 px-4 py-2 rounded-lg flex items-center gap-2">
                    <i class="fa-solid fa-check-double"></i>
                    <span>Tandai Semua Dibaca</span>
                </button>
                <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg group">
                    <i class="fa-solid fa-gear text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>
        </header>

        <!-- NOTIFICATION LIST -->
        <div class="flex-1 overflow-y-auto p-6">

            @if(!empty($notifications))

                <div class="space-y-3">

                    @foreach ($notifications as $notif)

                        @php
                            $types = [
                                'vote' => ['fa-heart', 'bg-gradient-to-br from-red-50 to-pink-50', 'text-red-600', 'border-red-200'],
                                'comment' => ['fa-comment', 'bg-gradient-to-br from-blue-50 to-indigo-50', 'text-blue-600', 'border-blue-200'],
                                'status' => ['fa-clipboard-check', 'bg-gradient-to-br from-green-50 to-emerald-50', 'text-green-600', 'border-green-200'],
                                'trending' => ['fa-fire', 'bg-gradient-to-br from-orange-50 to-amber-50', 'text-orange-600', 'border-orange-200'],
                            ];
                            $icon  = $types[$notif['type']][0] ?? 'fa-bell';
                            $bgColor = $types[$notif['type']][1] ?? 'bg-gray-50';
                            $textColor = $types[$notif['type']][2] ?? 'text-gray-600';
                            $borderColor = $types[$notif['type']][3] ?? 'border-gray-200';
                        @endphp

                        <div class="group p-5 rounded-2xl shadow-sm border transition-all duration-300 cursor-pointer relative overflow-hidden
                            {{ $notif['read'] ? 'bg-white border-gray-200 hover:shadow-lg hover:border-gray-300' : 'bg-gradient-to-r from-blue-50 via-white to-blue-50 border-blue-300 hover:shadow-xl unread' }} hover:-translate-y-1"
                             data-id="{{ $notif['id'] }}"
                             onclick="markAsRead({{ $notif['id'] }})">

                            <!-- Unread Indicator -->
                            @if(!$notif['read'])
                                <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-blue-500 to-blue-600"></div>
                                <div class="absolute top-5 right-5">
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-start gap-4">

                                <!-- Icon -->
                                <div class="p-3 rounded-xl {{ $bgColor }} {{ $textColor }} border {{ $borderColor }} group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                    <i class="fa-solid {{ $icon }} text-lg"></i>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 pr-8">
                                    <p class="font-bold text-gray-900 text-sm mb-1 group-hover:text-blue-600 transition">{{ $notif['title'] }}</p>
                                    <p class="text-sm text-gray-600 leading-relaxed mb-2">{{ $notif['message'] }}</p>
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <i class="fa-regular fa-clock"></i>
                                        <span>{{ $notif['time'] }}</span>
                                    </div>
                                </div>

                                <!-- Action Arrow -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else
                <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                    <div class="relative mb-6">
                        <i class="fa-regular fa-bell-slash text-8xl opacity-20"></i>
                        <div class="absolute -top-2 -right-2">
                            <span class="relative flex h-6 w-6">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gray-300 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-6 w-6 bg-gray-400 items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-xs"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <p class="text-lg font-semibold text-gray-500 mb-2">Tidak ada notifikasi</p>
                    <p class="text-sm text-gray-400">Anda sudah membaca semua notifikasi</p>
                </div>
            @endif

        </div>

    </main>

    <!-- 📊 RIGHT SIDEBAR -->
    <aside class="w-[340px] bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 p-6 overflow-y-auto border-l border-gray-200 space-y-6 shadow-lg">
        <!-- Masalah Penting -->
        <section class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-5 border border-red-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500 animate-pulse"></i> 
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Masalah Penting</span>
            </h2>
            <ul class="space-y-3">
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">Taman Berserak</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                LAGUBOTI
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">2V</span>
                        </div>
                    </div>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">Deserunt error totam recusanda...</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                31672 Adella Overpass
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">1V</span>
                        </div>
                    </div>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">Est consequatur iste in aperia...</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                165 Runolfsdottir Island
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">1V</span>
                        </div>
                    </div>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">sdcsdcsasdes</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                adssadv
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">1V</span>
                        </div>
                    </div>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">Jalan Raya Bolong</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                Jalan Manukwari no 1...
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">1V</span>
                        </div>
                    </div>
                </li>
            </ul>
        </section>

        <!-- Trending -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-arrow-trend-up text-blue-500"></i> 
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Trending</span>
            </h2>
            <ul class="space-y-3">
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <div class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Taman Berserak</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            LAGUBOTI
                        </p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                2 votes
                            </span>
                        </div>
                    </div>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <div class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Deserunt error totam recusandae laudanti...</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            31672 Adella Overpass Apt...
                        </p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                1 votes
                            </span>
                        </div>
                    </div>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <div class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Est consequatur iste in aperiam.</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            165 Runolfsdottir Island...
                        </p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                1 votes
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </section>
    </aside>

</div>

<script>
function markAsRead(id) {
    fetch("{{ url('/notifications/read') }}/" + id, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        const card = document.querySelector(`[data-id="${id}"]`);
        if (card) {
            card.classList.remove('unread', 'bg-gradient-to-r', 'from-blue-50', 'via-white', 'to-blue-50', 'border-blue-300');
            card.classList.add('bg-white', 'border-gray-200');
            
            // Remove blue indicator
            const indicator = card.querySelector('.absolute.top-0.left-0');
            if (indicator) indicator.remove();
            
            // Remove pulse dot
            const pulseDot = card.querySelector('.absolute.top-5.right-5');
            if (pulseDot) pulseDot.remove();
        }
    })
    .catch(error => console.error('Error:', error));
}

function markAllAsRead() {
    fetch("{{ url('/notifications/read-all') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    })
    .then(response => response.json())
    .then(data => {
        // Refresh page to update UI
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
</script>

@endsection
