@extends('layouts.app')

@section('title', 'Home - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

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
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
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

        <!-- Profile Bottom with Logout -->
        <div class="border-t border-gray-200 pt-4 space-y-2">
            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 font-medium
                          transition-all hover:bg-blue-50 hover:text-blue-600">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                    <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
                </div>
            </a>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 font-medium
                          transition-all hover:bg-red-50">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </button>
            </form>
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

        <div class="overflow-y-auto p-6 space-y-4">

            <!-- Post Input -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                    <input type="text" placeholder="Laporkan masalah di lingkunganmu..."
                           onclick="window.location.href='{{ route('reports.create') }}'"
                           class="flex-1 bg-gray-50 px-4 py-2 rounded-full border border-gray-200
                                  focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition text-sm">
                </div>

                <div class="flex justify-between px-3">
                    <div class="flex gap-4 text-gray-400">
                        <i class="fa-solid fa-camera cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-image cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-location-dot cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-tag cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-pen cursor-pointer hover:text-blue-600 transition"></i>
                    </div>
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition font-semibold text-sm">Post</button>
                </div>
            </div>

            <!-- FEED LIST -->
            @php
                $dbReports = $dbReports ?? [];
            @endphp

            @forelse ($dbReports as $report)
            <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-300">

                <!-- User Info -->
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-12 h-12 rounded-full object-cover">
                    <div class="flex-1">
                        <span class="font-semibold text-gray-900 text-sm">{{ $report['user']['name'] ?? 'Anonymous' }}</span>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $report['created_at'] ?? 'Baru saja' }} <span class="mx-1">•</span> {{ $report['location'] ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Title -->
                @if(!empty($report['title']))
                    <h3 class="font-semibold text-gray-900 text-base mb-2">{{ $report['title'] }}</h3>
                @endif

                <!-- Description -->
                <p class="text-gray-700 text-sm mb-4 leading-relaxed">
                    {{ Str::limit($report['description'] ?? '', 300) }}
                </p>

                <!-- Image -->
                @if(!empty($report['image']))
                    <div class="mb-4 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center" style="max-height: 500px;">
                        @if(filter_var($report['image'], FILTER_VALIDATE_URL))
                            <img src="{{ $report['image'] }}" class="w-full h-full object-contain" alt="Report image" loading="lazy">
                        @else
                            <img src="{{ asset('storage/' . $report['image']) }}" class="w-full h-full object-contain" alt="Report image" loading="lazy">
                        @endif
                    </div>
                @endif

                <!-- Status & Category Badges -->
                <div class="flex gap-2 mb-4 flex-wrap">
                    <span class="px-3 py-1.5 text-xs font-medium rounded-full bg-pink-100 text-pink-700">
                        {{ $report['status'] ?? 'Baru' }}
                    </span>
                    <span class="px-3 py-1.5 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700">
                        {{ $report['category'] ?? 'Umum' }}
                    </span>
                </div>

                <!-- Engagement Footer -->
                <div class="flex justify-between items-center text-sm border-t border-gray-100 pt-4">
                    <div class="flex gap-6">
                        <button class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition font-medium">
                            <i class="fa-regular fa-comment"></i> 
                            <span class="text-xs">{{ $report['comments'] ?? 0 }}</span>
                        </button>
                        <button class="flex items-center gap-2 text-gray-500 hover:text-red-500 transition font-medium">
                            <i class="fa-solid fa-heart"></i> 
                            <span class="text-xs">{{ $report['votes'] ?? 0 }}</span>
                        </button>
                    </div>
                    <a href="{{ route('reports.show', $report['id']) }}"
                       class="text-xs text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                        Lihat detail →
                    </a>
                </div>

            </article>
            @empty
            <div class="text-center py-16 text-gray-500">
                <i class="fa-solid fa-inbox text-5xl mb-4 block opacity-30"></i>
                <p class="text-lg font-semibold text-gray-700">Belum ada laporan</p>
                <p class="text-sm mt-2 text-gray-500">Jadilah yang pertama melaporkan masalah di sekitarmu!</p>
                <a href="{{ route('reports.create') }}" class="text-blue-600 hover:text-blue-700 mt-4 inline-block font-semibold hover:underline">
                    Buat laporan sekarang →
                </a>
            </div>
            @endforelse

        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-white p-6 overflow-y-auto">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Penting
            </h2>
            <ul class="space-y-3">
                @forelse($topReports as $report)
                <li class="flex justify-between items-center">
                    <a href="{{ route('reports.show', $report['id']) }}" class="flex-1 hover:opacity-80 transition">
                        <p class="font-medium text-gray-800">{{ $report['title'] ?? 'Laporan' }}</p>
                        <p class="text-xs text-gray-500">{{ $report['location'] ?? 'Lokasi tidak tersedia' }}</p>
                    </a>
                    <span class="text-sm font-semibold text-red-600 ml-2">{{ $report['votes'] ?? 0 }} Votes</span>
                </li>
                @empty
                <li class="text-xs text-gray-500 text-center py-3">Belum ada laporan penting</li>
                @endforelse
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-3">
                @forelse($trendingCategories as $trend)
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">{{ $trend['category'] ?? 'Kategori' }}</p>
                        <p class="text-xs text-gray-500">{{ $trend['total'] ?? 0 }} laporan</p>
                    </div>
                    @if($trend['total'] >= 5)
                        <span class="px-3 py-1 rounded-xl text-xs bg-red-100 text-red-700 font-medium">Urgent</span>
                    @elseif($trend['total'] >= 3)
                        <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700 font-medium">Medium</span>
                    @else
                        <span class="px-3 py-1 rounded-xl text-xs bg-green-100 text-green-700 font-medium">Low</span>
                    @endif
                </li>
                @empty
                <li class="text-xs text-gray-500 text-center py-3">Belum ada kategori trending</li>
                @endforelse
            </ul>
        </section>
    </aside>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection
