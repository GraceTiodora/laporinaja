@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Notifications - LaporinAja')
=======
@section('title', 'Notifications - Laporin Aja')
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<<<<<<< HEAD
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- LEFT SIDEBAR -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">

        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            @php
                $menu = [
                    ['Home', 'home', 'fa-solid fa-house'],
                    ['Explore', 'explore', 'fa-solid fa-hashtag'],
                    ['Notification', 'notifications', 'fa-regular fa-bell'],
                    ['Messages', 'messages', 'fa-regular fa-envelope'],
                    ['My Reports', 'my.reports', 'fa-solid fa-clipboard-list'],
                    ['Communities', '#', 'fa-solid fa-users'],
                    ['Profile', '#', 'fa-regular fa-user'],
                    ['More', '#', 'fa-solid fa-ellipsis-h'],
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
=======
<div class="flex h-screen max-w-[1920px] mx-auto">
    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-200 p-5 flex flex-col overflow-y-auto sidebar-scroll">
        <div class="mb-7">
            <h2 class="text-2xl font-bold text-blue-500">LaporinAja</h2>
        </div>
        
        <nav class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">🏠</span>
                <span class="nav-text leading-none">Home</span>
            </a>
            <a href="{{ route('explore') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">#</span>
                <span class="nav-text leading-none">Explore</span>
            </a>
            <a href="{{ route('notifications') }}" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">🔔</span>
                <span class="nav-text leading-none">Notification</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">💬</span>
                <span class="nav-text leading-none">Messages</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">📋</span>
                <span class="nav-text leading-none">My Reports</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">👥</span>
                <span class="nav-text leading-none">Communities</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">👤</span>
                <span class="nav-text leading-none">Profile</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">⚙️</span>
                <span class="nav-text leading-none">More</span>
            </a>
        </nav>
        
        <button onclick="window.location.href='{{ route('reports.create') }}'" class="mt-5 bg-blue-500 text-white border-none px-6 py-3.5 rounded-3xl text-base font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600 btn-new-report">
            <span class="btn-text">+ New Report</span>
        </button>
        
        <div class="mt-auto pt-5 border-t border-gray-200 flex items-center gap-3">
            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex-1 user-info">
                <p class="font-semibold text-sm text-gray-800">{{ session('user.name') }}</p>
                <p class="text-[13px] text-gray-500">@{{ session('user.username') }}</p>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
            </div>
        </div>
    </aside>

<<<<<<< HEAD
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
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Urgent</h2>
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
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Trending</h2>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-pink-100 text-pink-700">Urgent</span>
                </li>

                <li class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700">Medium</span>
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
=======
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden border-r border-gray-200">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-6 bg-gray-50 feed-scroll">
            @if(isset($notifications) && count($notifications) > 0)
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="notification-card {{ $notification['read'] ? '' : 'unread' }}" data-id="{{ $notification['id'] }}">
                            <!-- Notification Icon -->
                            <div class="notification-icon {{ $notification['type'] }}">
                                @if($notification['type'] === 'vote')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                @elseif($notification['type'] === 'comment')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                                    </svg>
                                @elseif($notification['type'] === 'status')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                                    </svg>
                                @elseif($notification['type'] === 'trending')
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                @endif
                            </div>

                            <!-- Notification Content -->
                            <div class="notification-content">
                                <h3 class="notification-title">{{ $notification['title'] }}</h3>
                                <p class="notification-message">{{ $notification['message'] }}</p>
                                <span class="notification-time">{{ $notification['time'] }}</span>
                            </div>

                            <!-- Unread Badge -->
                            @if(!$notification['read'])
                                <div class="unread-badge"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Notifikasi</h3>
                    <p class="text-gray-500">Notifikasi Anda akan muncul di sini</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="w-80 bg-white p-6 overflow-y-auto sidebar-scroll sidebar-right">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Urgent</h2>
            <ul class="list-none">
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800 mb-0.5">Jalan Rusak</p>
                        <p class="text-[13px] text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800 mb-0.5">Sampah Menumpuk</p>
                        <p class="text-[13px] text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">96 Votes</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800 mb-0.5">Lampu Jalan Mati</p>
                        <p class="text-[13px] text-gray-500">RT 05</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">54 Votes</span>
                </li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Trending</h2>
            <ul class="list-none">
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800 mb-0.5">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-pink-100 text-pink-700">Urgent</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800 mb-0.5">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-amber-100 text-amber-800">Medium</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800 mb-0.5">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-blue-100 text-blue-800">Low</span>
                </li>
            </ul>
        </section>
    </aside>
</div>

<script>
document.querySelectorAll('.notification-card').forEach(card => {
    card.addEventListener('click', function() {
        if (this.classList.contains('unread')) {
            const id = this.dataset.id;
            fetch("{{ route('notifications.read', ['id' => '__ID__']) }}".replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            }).then(r => {
                if (r.ok) {
                    this.classList.remove('unread');
                    const badge = this.querySelector('.unread-badge');
                    if (badge) badge.style.display = 'none';
                }
            }).catch(()=>{ /* ignore */ });
        }
    });
});
</script>
@endsection
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
