@extends('layouts.app')

@section('title', 'Notifications - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">Laporin<span class="text-gray-900">Aja</span></h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Home', 'home', 'fa-solid fa-house'],
                        ['Explore', 'explore', 'fa-solid fa-hashtag'],
                        ['Notification', 'notifications', 'fa-regular fa-bell'],
                        ['Messages', '#', 'fa-regular fa-envelope'],
                        ['My Reports', '#', 'fa-solid fa-clipboard-list'],
                        ['Communities', '#', 'fa-solid fa-users'],
                        ['Profile', '#', 'fa-regular fa-user'],
                        ['More', '#', 'fa-solid fa-ellipsis-h'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600 {{ $route == 'notifications' ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold">
                <i class="fa-solid fa-plus-circle"></i> New Report
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Main Content Area -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white">
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-bold text-gray-800">Notifications</h1>
            <button class="text-gray-400 hover:text-blue-600 transition">
                <i class="fa-solid fa-gear text-xl"></i>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            @if(isset($notifications) && count($notifications) > 0)
                @foreach($notifications as $notification)
                    <div class="notification-card {{ $notification['read'] ? '' : 'unread' }}" data-id="{{ $notification['id'] }}">
                        <!-- Left Badge Icon -->
                        <div class="notification-badge {{ $notification['type'] }}">
                            @if($notification['type'] === 'vote')
                                <i class="fa-solid fa-heart"></i>
                            @elseif($notification['type'] === 'comment')
                                <i class="fa-regular fa-comment"></i>
                            @elseif($notification['type'] === 'status')
                                <i class="fa-solid fa-circle-check"></i>
                            @elseif($notification['type'] === 'trending')
                                <i class="fa-solid fa-fire"></i>
                            @else
                                <i class="fa-solid fa-bell"></i>
                            @endif
                        </div>

                        <!-- Notification Content -->
                        <div class="notification-content">
                            <h3 class="notification-title">{{ $notification['title'] }}</h3>
                            <p class="notification-message">{{ $notification['message'] }}</p>
                            <span class="notification-time">{{ $notification['time'] }}</span>
                        </div>

                        <!-- Unread Dot Badge -->
                        @if(!$notification['read'])
                            <div class="unread-dot"></div>
                        @endif
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fa-regular fa-bell-slash text-gray-300 text-8xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Notifikasi</h3>
                    <p class="text-gray-500">Notifikasi Anda akan muncul di sini</p>
                </div>
            @endif
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-white p-6 overflow-y-auto">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Urgent
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-xs text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">96 Votes</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">54 Votes</span>
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
                    <span class="px-3 py-1 rounded-xl text-xs bg-pink-100 text-pink-700 font-medium">Urgent</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700 font-medium">Medium</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-blue-100 text-blue-800 font-medium">Low</span>
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

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection