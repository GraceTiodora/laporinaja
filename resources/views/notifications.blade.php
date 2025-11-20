@extends('layouts.app')

@section('title', 'Notifications - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- LEFT SIDEBAR -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">

        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            @php
                $menu = [
                    ['Beranda', 'home', 'fa-solid fa-house'],
                    ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                    ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                    ['Pesan', 'messages', 'fa-regular fa-envelope'],
                    ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                    ['Komunitas', 'communities', 'fa-solid fa-users'],
                    ['Profil', 'profile', 'fa-regular fa-user'],
                ];
            @endphp


            <nav class="space-y-2">
                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all
                              {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-600' 
                                 : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition font-semibold">
                <i class="fa-solid fa-plus-circle"></i> New Report
            </button>
        </div>

        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ session('user.name','Guest') }}</p>
                <p class="text-xs text-gray-500">{{ session('user.email','user@mail.com') }}</p>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white overflow-hidden">

        <!-- HEADER -->
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-xl font-bold text-gray-800">Notifications</h1>
        </header>

        <!-- NOTIFICATION LIST -->
        <div class="flex-1 overflow-y-auto p-6 bg-gray-50">

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

                        <div class="p-5 rounded-xl shadow-sm border transition hover:shadow-md relative
                            {{ $notif['read'] ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-300 unread' }}"
                             data-id="{{ $notif['id'] }}">

                            <div class="flex items-start gap-4">

                                <div class="p-2 rounded-full {{ $color }}">
                                    <i class="{{ $icon }}"></i>
                                </div>

                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $notif['title'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $notif['message'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notif['time'] }}</p>
                                </div>

                                @if(!$notif['read'])
                                    <span class="w-3 h-3 bg-blue-600 rounded-full absolute top-4 right-4"></span>
                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else
                <div class="text-center py-16 text-gray-500">
                    <i class="fa-regular fa-bell-slash text-6xl mb-4"></i>
                    <p>Tidak ada notifikasi</p>
                </div>
            @endif

        </div>

    </main>

    <!-- RIGHT SIDEBAR (SAMA SEPERTI HOME / EXPLORE) -->
    <aside class="w-[340px] bg-white p-6 overflow-y-auto">

        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Penting
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-xs text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">128 Votes</span>
                </li>

                <li class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">96 Votes</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-pink-100 text-pink-700 font-medium">Penting</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700 font-medium">Sedang</span>
                </li>
            </ul>
        </section>

    </aside>

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
