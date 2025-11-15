@extends('layouts.app')

@section('title', 'Messages - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
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
                        ['Messages', 'messages', 'fa-regular fa-envelope'],
                        ['My Reports', '#', 'fa-solid fa-clipboard-list'],
                        ['Communities', '#', 'fa-solid fa-users'],
                        ['Profile', '#', 'fa-regular fa-user'],
                        ['More', '#', 'fa-solid fa-ellipsis-h'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600 {{ $route == 'messages' ? 'bg-blue-50 text-blue-600' : '' }}">
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

    <!-- 💬 Conversation List -->
    <aside class="w-[380px] bg-white border-r border-gray-200 flex flex-col">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-200">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Search conversations..." 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <!-- Conversations List -->
        <div class="flex-1 overflow-y-auto">
            @php
                $conversations = [
                    ['id' => 1, 'name' => 'Jennie Kim', 'message' => 'Setuju. Thanks ya udah laporin, aku ju...', 'time' => '10:30', 'unread' => 2, 'online' => true, 'avatar' => 'profile-user.jpg'],
                    ['id' => 2, 'name' => 'Sabrina Carpenter', 'message' => 'Eh aku juga lewat jalan itu, emang luba..', 'time' => '09:15', 'unread' => 0, 'online' => false, 'avatar' => 'profile-user.jpg'],
                    ['id' => 3, 'name' => 'Admin Kota', 'message' => 'Terimakasih atas laporan anda. Masal...', 'time' => 'Kemarin', 'unread' => 0, 'online' => true, 'avatar' => 'profile-user.jpg'],
                    ['id' => 4, 'name' => 'Lara Raj', 'message' => 'Malam tadi aku hampir jatuh gara-gar...', 'time' => 'Kemarin', 'unread' => 0, 'online' => false, 'avatar' => 'profile-user.jpg'],
                    ['id' => 5, 'name' => 'Kim Mingyu', 'message' => 'Thanks.', 'time' => '2 hari', 'unread' => 1, 'online' => false, 'avatar' => 'profile-user.jpg'],
                ];
            @endphp

            @foreach($conversations as $conv)
                <div class="conversation-item {{ $loop->first ? 'active' : '' }}" data-conversation-id="{{ $conv['id'] }}">
                    <div class="relative">
                        <img src="{{ asset('images/' . $conv['avatar']) }}" class="w-12 h-12 rounded-full object-cover">
                        @if($conv['online'])
                            <span class="online-indicator"></span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $conv['name'] }}</h3>
                            <span class="text-xs text-gray-500 ml-2 flex-shrink-0">{{ $conv['time'] }}</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">{{ $conv['message'] }}</p>
                    </div>
                    @if($conv['unread'] > 0)
                        <span class="unread-badge">{{ $conv['unread'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </aside>

    <!-- 📰 Chat Area -->
    <main class="flex-1 flex flex-col bg-white">
        <!-- Chat Header -->
        <header class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full object-cover">
                    <span class="online-indicator-large"></span>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-800">Jennie Kim</h2>
                    <span class="text-sm text-green-600 font-medium">Online</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fa-solid fa-phone text-xl"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fa-solid fa-video text-xl"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fa-solid fa-circle-info text-xl"></i>
                </button>
            </div>
        </header>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            <!-- Received Message -->
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                <div class="flex flex-col gap-2 max-w-[70%]">
                    <div class="message-bubble received">
                        <p>Aku tadi baca laporanmu tentang jalan berlubang deket sekolah itu.</p>
                    </div>
                    <span class="text-xs text-gray-500">Kamis 22:46</span>
                </div>
            </div>

            <!-- Sent Messages -->
            <div class="flex items-end justify-end">
                <div class="flex flex-col gap-2 max-w-[70%] items-end">
                    <div class="message-bubble sent">
                        <p>Iya, udah beberapa minggu nggak diperbaiki. Banyak motor yang hampir jatuh</p>
                    </div>
                    <span class="text-xs text-gray-500">Jumat 13:35</span>
                </div>
            </div>

            <!-- Received Message -->
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                <div class="flex flex-col gap-2 max-w-[70%]">
                    <div class="message-bubble received">
                        <p>Aku juga pernah hampir kepleset pas hujan 😅. Emang harus cepat diperbaiki.</p>
                    </div>
                </div>
            </div>

            <!-- Sent Messages -->
            <div class="flex items-end justify-end">
                <div class="flex flex-col gap-2 max-w-[70%] items-end">
                    <div class="message-bubble sent">
                        <p>Makanya aku laporin di sini, biar banyak yang lihat dan kasih vote</p>
                    </div>
                    <span class="text-xs text-gray-500">2 pesan belum dibaca</span>
                </div>
            </div>

            <!-- Received Messages -->
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                <div class="flex flex-col gap-2 max-w-[70%]">
                    <div class="message-bubble received">
                        <p>OMG</p>
                    </div>
                    <div class="message-bubble received">
                        <p>Setuju. Thanks ya udah laporin, aku juga udah vote biar cepat ditangani..</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <button class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fa-regular fa-face-smile text-2xl"></i>
                </button>
                <input type="text" placeholder="Pesan..." 
                       class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fa-regular fa-image text-2xl"></i>
                </button>
                <button class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fa-solid fa-microphone text-2xl"></i>
                </button>
            </div>
        </div>
    </main>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<script>
// Handle conversation selection
document.querySelectorAll('.conversation-item').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.conversation-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        // Load conversation based on data-conversation-id
        const convId = this.dataset.conversationId;
        // Add your logic to load messages here
    });
});
</script>
@endsection