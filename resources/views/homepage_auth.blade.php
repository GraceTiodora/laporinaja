@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Home - LaporinAja')
=======
@section('title', 'Home - Laporin Aja')
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
@endpush

@section('content')
<<<<<<< HEAD
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
        ['Notification', 'notifications', 'fa-regular fa-bell'],   // <-- FIX !!!
        ['Messages', '#', 'fa-regular fa-envelope'],
        ['My Reports', '#', 'fa-solid fa-clipboard-list'],
        ['Communities', '#', 'fa-solid fa-users'],
        ['Profile', '#', 'fa-regular fa-user'],
        ['More', '#', 'fa-solid fa-ellipsis-h'],
    ];
@endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600">
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
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Main Feed -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white">
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-bold text-gray-800">Beranda</h1>
            <button class="text-gray-400 hover:text-blue-600 transition">
                <i class="fa-solid fa-gear text-xl"></i>
            </button>
        </header>

        <div class="overflow-y-auto p-6 space-y-5">
            <!-- Post Input -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                    <input type="text" placeholder="Laporkan masalah di lingkunganmu..."
                           onclick="window.location.href='{{ route('reports.create') }}'"
                           class="flex-1 bg-gray-50 px-3 py-2 rounded-full border border-transparent focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition">
                </div>
                <div class="flex justify-between px-2">
                    <div class="flex gap-3 text-gray-400">
                        <i class="fa-solid fa-camera cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-image cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-location-dot cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-tag cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-pen cursor-pointer hover:text-blue-600 transition"></i>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition font-semibold">Post</button>
                </div>
            </div>

            <!-- Feed Example -->
            @foreach ([[
                'name'=>'Audrey Stark', 'time'=>'2 jam', 'lokasi'=>'Jl. Melati',
                'text'=>'Jalan berlubang besar dekat sekolah sangat berbahaya untuk dilewati',
                'img'=>'images/jalan_berlubang.jpg', 'kategori'=>'Infrastruktur', 'votes'=>128, 'komen'=>3
            ],[
                'name'=>'David Blend', 'time'=>'12 menit', 'lokasi'=>'Jl. Ahmad Yani',
                'text'=>'Pohon besar tumbang menutupi jalan raya, menyebabkan kemacetan parah.',
                'img'=>'images/pohon-tumbang.jpg', 'kategori'=>'Bencana Alam', 'votes'=>54, 'komen'=>1
            ]] as $report)
                <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                        <div>
                            <div class="flex gap-2 items-center">
                                <span class="font-semibold text-gray-800">{{ $report['name'] }}</span>
                                <span class="text-xs text-gray-500">{{ $report['time'] }} • {{ $report['lokasi'] }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-3">{{ $report['text'] }}</p>
                    <img src="{{ asset($report['img']) }}" class="rounded-lg mb-3 object-cover max-h-[400px] w-full">
                    <div class="flex gap-2 mb-3">
                        <span class="px-3 py-1 text-xs rounded-full bg-pink-100 text-pink-700">Baru</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ $report['kategori'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-3">
                        <div class="flex gap-4">
                            <button class="hover:text-blue-600 transition"><i class="fa-regular fa-comment"></i> {{ $report['komen'] }}</button>
                            <button class="hover:text-red-500 transition"><i class="fa-solid fa-heart"></i> {{ $report['votes'] }}</button>
                        </div>
                        <button class="text-xs text-blue-600 hover:underline">Lihat detail</button>
                    </div>
                </article>
            @endforeach
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
=======
<div class="flex h-screen max-w-[1920px] mx-auto">
    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white p-5 flex flex-col overflow-y-auto sidebar-scroll">
        <div class="mb-7">
            <h2 class="text-2xl font-bold text-blue-500">LaporinAja</h2>
        </div>
        
        <nav class="flex flex-col gap-1">
            <a href="{{ route('home') }}" class="nav-item active flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-solid fa-house w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">Home</span>
            </a>
            <a href="{{ route('explore') }}" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-solid fa-hashtag w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">Explore</span>
            </a>
            <a href="{{ route('notifications') }}" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-regular fa-bell w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">Notification</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-regular fa-comment-dots w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">Messages</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-regular fa-flag w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">My Reports</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-solid fa-user-group w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">Communities</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-regular fa-user w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">Profile</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-2.5 rounded-lg text-[19px] font-normal text-gray-800 transition-all duration-200 hover:bg-gray-100">
                <i class="fa-solid fa-ellipsis w-5 h-5 flex items-center justify-center flex-shrink-0 text-[20px]"></i>
                <span class="nav-text leading-none">More</span>
            </a>
        </nav>
        
        <button onclick="window.location.href='{{ route('reports.create') }}'" class="mt-5 bg-blue-500 text-white border-none px-6 py-3.5 rounded-3xl text-base font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600 btn-new-report">
            <span class="btn-text">+ New Report</span>
        </button>
        
        <div class="mt-auto pt-5">
            <div class="flex items-center gap-3 p-3 rounded-[20px] hover:bg-gray-50 transition-all cursor-pointer shadow-sm border border-gray-100 mb-3">
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-semibold text-gray-800">{{ session('user.name', 'User') }}</span>
                    <span class="text-xs text-gray-400">{{ session('user.username', 'username') }}</span>
                </div>
            </div>
            <div class="hidden">
                <form action="{{ route('profile.update') }}" method="POST" class="flex-1">
                    @csrf
                    <div class="flex flex-col gap-1">
                        <input name="username" value="{{ old('username', session('user.username')) }}"
                               class="w-full text-[13px] text-gray-500 bg-transparent border border-transparent focus:border-gray-200 rounded px-2 py-1"
                               placeholder="Username" />

                        <input name="email" value="{{ old('email', session('user.email', '')) }}"
                               class="w-full text-[13px] text-gray-500 bg-transparent border border-transparent focus:border-gray-200 rounded px-2 py-1"
                               placeholder="Email (optional)" />
                    </div>
                </form>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-gray-500 hover:text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Logout
                </button>
            </form>
        </div> 
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">Home</h1>
        </header>
 
        <div class="flex-1 overflow-y-auto p-5 feed-scroll">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Post Input -->
            <div class="bg-white rounded-[20px] shadow-sm p-4 mb-3 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
                    <input type="text" placeholder="Laporkan masalah di lingkunganmu..." class="flex-1 border-none outline-none text-sm text-gray-400 cursor-pointer bg-gray-50 px-3 py-2 rounded-full" onclick="window.location.href='{{ route('reports.create') }}'">
                </div>
            </div>
            
            <div class="bg-white rounded-[20px] shadow-sm px-4 py-3 flex gap-2 items-center mb-5 hover:shadow-md transition-all">
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">📷</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">🖼</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">📍</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">🏷</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">✏</button>
                <button onclick="window.location.href='{{ route('reports.create') }}'" class="ml-auto bg-blue-500 text-white border-none px-5 py-2 rounded-2xl text-sm font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600">Post</button>
            </div>

            <!-- Recent Report 1 -->
            <article class="bg-white rounded-[20px] shadow-sm p-4 mb-5 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/profile-audrey.jpg') }}" alt="Audrey Stark" class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-[15px] text-gray-800">Audrey Stark</span>
                            <span class="text-[13px] text-gray-500">2 jam • Jl. Melati</span>
                        </div>
                    </div>
                </div>
                
                <p class="text-sm text-gray-700 mb-3 leading-relaxed">Jalan berlubang besar dekat sekolah sangat berbahaya untuk dilewati</p>
                
                <img src="{{ asset('images/jalan_berlubang.jpg') }}" alt="Jalan Berlubang" class="w-full rounded-lg mb-3 object-cover max-h-[400px]">
                
                <div class="flex gap-2 mb-3">
                    <span class="px-3 py-1 rounded-2xl text-xs font-medium bg-pink-100 text-pink-700">Baru</span>
                    <span class="px-3 py-1 rounded-2xl text-xs font-medium bg-indigo-100 text-indigo-700">Infrastruktur</span>
                </div>
                
                <div class="flex justify-between items-center pt-3">
                    <div class="flex gap-4 text-sm text-gray-500">
                        <button class="hover:text-blue-500 transition">💬 3</button>
                        <button class="hover:text-red-500 transition">❤ 10</button>
                    </div>
                </div>
            </article>

            <!-- Recent Report 2 -->
            <article class="bg-white rounded-[20px] shadow-sm p-4 mb-5 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/profile-david.jpg') }}" alt="David Blend" class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-[15px] text-gray-800">David Blend</span>
                            <span class="text-[13px] text-gray-500">12 menit • Jl. Ahmad Yani</span>
                        </div>
                    </div>
                </div>
                
                <p class="text-sm text-gray-700 mb-3 leading-relaxed">Sebuah pohon besar tumbang menutupi jalan raya, menyebabkan kemacetan parah. Mohon segera ditangani agar jalan bisa dilewati kembali.</p>
                
                <img src="{{ asset('images/pohon-tumbang.jpg') }}" alt="Pohon Tumbang" class="w-full rounded-lg mb-3 object-cover max-h-[400px]">
                
                <div class="flex gap-2 mb-3">
                    <span class="px-3 py-1 rounded-2xl text-xs font-medium bg-pink-100 text-pink-700">Baru</span>
                    <span class="px-3 py-1 rounded-2xl text-xs font-medium bg-indigo-100 text-indigo-700">Bencana Alam</span>
                </div>
                
                <div class="flex justify-between items-center pt-3">
                    <div class="flex gap-4 text-sm text-gray-500">
                        <button class="hover:text-blue-500 transition">💬 1</button>
                        <button class="hover:text-red-500 transition">❤ 5</button>
                    </div>
                </div>
            </article>
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
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                </li>
            </ul>
        </section>
    </aside>
</div>
<<<<<<< HEAD

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
=======
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
@endsection