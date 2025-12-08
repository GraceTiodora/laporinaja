@extends('layouts.app')

@section('title', 'Messages - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
<style>
    .typing-indicator span {
        animation: typing 1.4s infinite;
        opacity: 0.3;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { opacity: 0.3; }
        30% { opacity: 1; }
    }
    .message-bubble {
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    <!-- 📱 LEFT SIDEBAR -->
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
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ]; 
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
                @endphp
                <a href="{{ $href }}"
                    class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all
                    {{ request()->routeIs($route) 
                        ? 'bg-blue-50 text-blue-600' 
                        : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="{{ $icon }} text-lg"></i>
                    <span>{{ $name }}</span>
                </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition font-semibold">
                <i class="fa-solid fa-plus-circle"></i> Laporan Baru
            </button>
        </div>

        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">{{ session('user.name','Guest') }}</p>
                <p class="text-xs text-gray-500">{{ session('user.email','user@mail.com') }}</p>
            </div>
        </div>
    </aside>

    <!-- 💬 CHAT LAYOUT -->
    <div class="flex flex-1 overflow-hidden">

        <!-- LEFT CHAT LIST -->
        <div class="w-[380px] border-r border-gray-200 bg-white flex flex-col shadow-sm">
            
            <div class="p-5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-inbox"></i>
                    Percakapan
                </h3>
                <div class="relative">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Cari percakapan..." 
                        class="w-full bg-white/90 px-10 py-3 rounded-full outline-none text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 transition">
                </div>
            </div>

            <div class="overflow-y-auto p-3 space-y-2">

                <!-- CHAT LIST ITEMS WITH ENHANCED DESIGN -->
                @foreach([
                    ['Jennie Kim', 'Online', 'Setuju. Thanks ya udah laporin, aku ju...', 'images/user1.jpg', true, 'online'],
                    ['Sabrina Carpenter', null, 'Eh aku juga lewat jalan itu..', 'images/user2.jpg', false, 'offline'],
                    ['Admin Kota', 'Online', 'Terimakasih atas laporan anda...', 'images/user3.jpg', false, 'online'],
                    ['Lara Raj', null, 'Malam tadi aku hampir jatuh gara2...', 'images/user4.jpg', false, 'offline'],
                    ['Kim Mingyu', null, 'Thanks.', 'images/user5.jpg', true, 'offline'],
                ] as $c)

                <div class="flex items-center gap-3 p-3 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all duration-300 group border border-transparent hover:border-gray-200 hover:shadow-sm {{ $c[4] ? 'bg-blue-50/50' : '' }}">
                    <div class="relative">
                        <img src="{{ asset($c[3]) }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-white group-hover:ring-gray-200 transition">
                        @if($c[5] == 'online')
                            <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-bold text-gray-900 group-hover:text-indigo-700 transition truncate">
                                {{ $c[0] }}
                            </p>
                            @if($c[4])
                                <span class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 truncate group-hover:text-gray-800">{{ $c[2] }}</p>
                        @if($c[1])
                            <p class="text-xs text-green-500 font-medium mt-0.5">● {{ $c[1] }}</p>
                        @endif
                    </div>

                    @if($c[4])
                        <span class="flex-shrink-0 w-6 h-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs font-bold flex items-center justify-center rounded-full shadow-lg">1</span>
                    @endif
                </div>

                @endforeach

            </div>

        </div>

        <!-- 💭 CHAT ROOM -->
        <div class="flex-1 bg-white flex flex-col">

            <!-- CHAT HEADER -->
            <div class="p-5 bg-white flex items-center justify-between border-b border-gray-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="{{ asset('images/user1.jpg') }}" class="w-14 h-14 rounded-full object-cover ring-4 ring-blue-100">
                        <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-lg">Jennie Kim</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <p class="text-green-600 text-sm font-medium">Online</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 text-gray-500">
                    <button class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-all duration-300 hover:text-indigo-600 hover:scale-110">
                        <i class="fa-solid fa-phone text-lg"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full hover:bg-purple-100 flex items-center justify-center transition-all duration-300 hover:text-purple-600 hover:scale-110">
                        <i class="fa-solid fa-video text-lg"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-all duration-300 hover:text-gray-800 hover:scale-110">
                        <i class="fa-solid fa-info-circle text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- CHAT MESSAGES -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-50">

                <div class="text-center">
                    <span class="inline-block bg-white/70 backdrop-blur-sm px-4 py-2 rounded-full text-gray-500 text-xs font-medium shadow-sm">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Kamis 22:46
                    </span>
                </div>

                <!-- LEFT MESSAGE (RECEIVED) -->
                <div class="flex gap-3 message-bubble">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0">
                    <div class="flex flex-col max-w-[60%]">
                        <div class="bg-white text-gray-900 px-5 py-3 rounded-3xl rounded-tl-md shadow-md border border-gray-100">
                            <p class="text-sm leading-relaxed">Aku tadi baca lapormu tentang jalan berlubang deket sekolah itu.</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 ml-3">22:46</span>
                    </div>
                </div>

                <!-- RIGHT MESSAGE (SENT) -->
                <div class="flex justify-end message-bubble">
                    <div class="flex flex-col max-w-[60%] items-end">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-3 rounded-3xl rounded-tr-md shadow-lg">
                            <p class="text-sm leading-relaxed">Iya, udah beberapa minggu nggak diperbaiki. Banyak motor yang hampir jatuh</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 mr-3 flex items-center gap-1">
                            22:48
                            <i class="fa-solid fa-check-double text-blue-500"></i>
                        </span>
                    </div>
                </div>

                <div class="text-center">
                    <span class="inline-block bg-white/70 backdrop-blur-sm px-4 py-2 rounded-full text-gray-500 text-xs font-medium shadow-sm">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Jumat 13:35
                    </span>
                </div>

                <div class="flex gap-3 message-bubble">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0">
                    <div class="flex flex-col max-w-[60%]">
                        <div class="bg-white text-gray-900 px-5 py-3 rounded-3xl rounded-tl-md shadow-md border border-gray-100">
                            <p class="text-sm leading-relaxed">Aku juga pernah hampir kepeleset pas hujan 😅. Emang harus cepat diperbaiki.</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 ml-3">13:35</span>
                    </div>
                </div>

                <div class="flex justify-end message-bubble">
                    <div class="flex flex-col max-w-[60%] items-end">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-3 rounded-3xl rounded-tr-md shadow-lg">
                            <p class="text-sm leading-relaxed">Makanya aku laporin di sini, biar banyak yang lihat dan kasih vote</p>
                        </div>
                        <span class="text-xs text-gray-400 mt-1 mr-3 flex items-center gap-1">
                            13:37
                            <i class="fa-solid fa-check-double text-blue-500"></i>
                        </span>
                    </div>
                </div>

                <!-- TYPING INDICATOR -->
                <div class="flex gap-3 message-bubble">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0">
                    <div class="bg-white px-5 py-3 rounded-3xl rounded-tl-md shadow-md border border-gray-100">
                        <div class="typing-indicator flex gap-1">
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- MESSAGE INPUT -->
            <div class="p-5 bg-white border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <button class="w-11 h-11 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center text-white hover:scale-110 transition-transform shadow-md">
                        <i class="fa-solid fa-plus text-lg"></i>
                    </button>
                    
                    <div class="flex-1 flex items-center gap-3 bg-gray-50 rounded-full px-5 py-3 border border-gray-200 focus-within:border-indigo-400 focus-within:ring-2 focus-within:ring-indigo-100 transition">
                        <button class="hover:scale-110 transition-transform">
                            <i class="fa-regular fa-face-smile text-xl text-gray-500 hover:text-yellow-500"></i>
                        </button>
                        <input type="text" placeholder="Ketik pesan..." 
                            class="flex-1 bg-transparent outline-none text-sm placeholder-gray-400">
                        <button class="hover:scale-110 transition-transform">
                            <i class="fa-solid fa-paperclip text-gray-500 hover:text-indigo-600"></i>
                        </button>
                        <button class="hover:scale-110 transition-transform">
                            <i class="fa-solid fa-image text-gray-500 hover:text-purple-600"></i>
                        </button>
                    </div>
                    
                    <button class="w-11 h-11 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center text-white hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
