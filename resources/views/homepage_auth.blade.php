@extends('layouts.app')

@section('title', 'Home - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto">
    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-200 p-5 flex flex-col overflow-y-auto sidebar-scroll">
        <div class="mb-7">
            <h2 class="text-2xl font-bold text-blue-500">LaporinAja</h2>
        </div>
        
        <nav class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">🏠</span>
                <span class="nav-text leading-none">Home</span>
            </a>
            <a href="{{ route('explore') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">#</span>
                <span class="nav-text leading-none">Explore</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
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
        
        <div class="mt-auto pt-5 border-t border-gray-200">
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
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
    <main class="flex-1 flex flex-col overflow-hidden border-r border-gray-200">
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">Home</h1>
        </header>
 
        <div class="flex-1 overflow-y-auto p-5 feed-scroll">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Post Input -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 mb-3 flex items-center gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
                <input type="text" placeholder="Laporkan masalah di lingkunganmu..." class="flex-1 border-none outline-none text-sm text-gray-400 cursor-pointer" onclick="window.location.href='{{ route('reports.create') }}'">
            </div>
            
            <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl px-4 py-3 flex gap-2 items-center mb-5 -mt-3">
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">📷</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">🖼️</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">📍</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">🏷️</button>
                <button class="bg-transparent border-none text-lg cursor-pointer p-2 rounded-md transition-colors duration-200 hover:bg-gray-100">✏️</button>
                <button onclick="window.location.href='{{ route('reports.create') }}'" class="ml-auto bg-blue-500 text-white border-none px-5 py-2 rounded-2xl text-sm font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600">Post</button>
            </div>

            <!-- Recent Report 1 -->
            <article class="bg-white border border-gray-200 rounded-xl p-4 mb-5 shadow-sm">
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
                
                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                    <div class="flex gap-4 text-sm text-gray-500">
                        <button class="hover:text-blue-500 transition">💬 3</button>
                        <button class="hover:text-red-500 transition">❤️ 10</button>
                    </div>
                </div>
            </article>

            <!-- Recent Report 2 -->
            <article class="bg-white border border-gray-200 rounded-xl p-4 mb-5 shadow-sm">
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
                
                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                    <div class="flex gap-4 text-sm text-gray-500">
                        <button class="hover:text-blue-500 transition">💬 1</button>
                        <button class="hover:text-red-500 transition">❤️ 5</button>
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
                </li>
            </ul>
        </section>
    </aside>
</div>
@endsection