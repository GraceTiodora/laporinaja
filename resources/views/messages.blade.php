@extends('layouts.app')

@section('title', 'Messages - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- SIDEBAR -->
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
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                <a href="{{ $route == '#' ? '#' : route($route) }}"
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
            <div>
                <p class="text-sm font-medium text-gray-800">{{ session('user.name','Guest') }}</p>
                <p class="text-xs text-gray-500">{{ session('user.email','user@mail.com') }}</p>
            </div>
        </div>
    </aside>

    <!-- CHAT LAYOUT -->
    <div class="flex flex-1 overflow-hidden">

        <!-- LEFT CHAT LIST -->
        <div class="w-[380px] border-r border-gray-200 bg-white flex flex-col">
            
            <div class="p-4">
                <input type="text" placeholder="Search conversations..."
                    class="w-full bg-gray-100 px-4 py-2.5 rounded-xl outline-none text-sm">
            </div>

            <div class="overflow-y-auto p-2 space-y-2">

                <!-- SAMPLE CHAT LIST ITEM -->
                @foreach([
                    ['Jennie Kim', 'Online', 'Setuju. Thanks ya udah laporin, aku ju...', 'images/user1.jpg', true],
                    ['Sabrina Carpenter', null, 'Eh aku juga lewat jalan itu..', 'images/user2.jpg', false],
                    ['Admin Kota', 'Online', 'Terimakasih atas laporan anda...', 'images/user3.jpg', false],
                    ['Lara Raj', null, 'Malam tadi aku hampir jatuh gara2...', 'images/user4.jpg', false],
                    ['Kim Mingyu', null, 'Thanks.', 'images/user5.jpg', true],
                ] as $c)

                <div class="flex items-center gap-3 p-3 rounded-xl cursor-pointer hover:bg-gray-100 transition">
                    <img src="{{ asset($c[3]) }}" class="w-12 h-12 rounded-full object-cover">

                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 flex items-center gap-2">
                            {{ $c[0] }}
                            @if($c[1])
                                <span class="text-green-500 text-xs">●</span>
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 truncate">{{ $c[2] }}</p>
                    </div>

                    @if($c[4])
                        <span class="w-5 h-5 bg-blue-600 text-white text-xs flex items-center justify-center rounded-full">1</span>
                    @endif
                </div>

                @endforeach

            </div>

        </div>

        <!-- CHAT ROOM -->
        <div class="flex-1 bg-gray-50 flex flex-col">

            <!-- CHAT HEADER -->
            <div class="p-5 bg-white flex items-center justify-between border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-semibold text-gray-900">Jennie Kim</p>
                        <p class="text-green-500 text-sm">Online</p>
                    </div>
                </div>

                <div class="flex gap-6 text-gray-500 text-xl">
                    <i class="fa-solid fa-phone cursor-pointer hover:text-blue-600"></i>
                    <i class="fa-solid fa-video cursor-pointer hover:text-blue-600"></i>
                    <i class="fa-solid fa-info-circle cursor-pointer hover:text-blue-600"></i>
                </div>
            </div>

            <!-- CHAT MESSAGES -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">

                <div class="text-center text-gray-400 text-sm">Kamis 22:46</div>

                <!-- LEFT MESSAGE -->
                <div class="flex">
                    <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-2xl max-w-[60%]">
                        Aku tadi baca lapormu tentang jalan berlubang deket sekolah itu.
                    </div>
                </div>

                <!-- RIGHT MESSAGE -->
                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-[60%]">
                        Iya, udah beberapa minggu nggak diperbaiki. Banyak motor yang hampir jatuh
                    </div>
                </div>

                <div class="text-center text-gray-400 text-sm">Jumat 13:35</div>

                <div class="flex">
                    <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-2xl max-w-[60%]">
                        Aku juga pernah hampir kepeleset pas hujan 😅. Emang harus cepat diperbaiki.
                    </div>
                </div>


                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-[60%]">
                        Makanya aku laporin di sini, biar banyak yang lihat dan kasih vote
                    </div>
                </div>

            </div>

            <!-- MESSAGE INPUT -->
            <div class="p-4 bg-white border-t border-gray-200">
                <div class="flex items-center gap-3 bg-gray-100 rounded-full px-4 py-2">
                    <i class="fa-regular fa-face-smile text-xl text-gray-500"></i>
                    <input type="text" placeholder="Pesan..." class="flex-1 bg-transparent outline-none">
                    <i class="fa-solid fa-paperclip text-gray-500"></i>
                    <i class="fa-solid fa-paper-plane text-blue-600 cursor-pointer"></i>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
