@extends('layouts.app')

<<<<<<< HEAD
@section('title', 'Explore - LaporinAja')
=======
@section('title', 'Explore - Laporin Aja')
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
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
        ['Messages', 'messages', 'fa-regular fa-envelope'],
        ['My Reports', 'my.reports', 'fa-solid fa-clipboard-list'],
        ['Communities', '#', 'fa-solid fa-users'],
        ['Profile', '#', 'fa-regular fa-user'],
        ['More', '#', 'fa-solid fa-ellipsis-h'],
    ];
@endphp


              @foreach ($menu as [$name, $route, $icon])
    <a href="{{ $route == '#' ? '#' : route($route) }}"
       class="group flex items-center gap-4 px-4 py-3 rounded-xl 
              text-gray-600 font-medium transition-all 
              hover:bg-blue-50 hover:text-blue-600">
        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
        <span>{{ $name }}</span>
    </a>
@endforeach
            </nav>

            @if(session('user'))
                <button onclick="window.location.href='{{ route('reports.create') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold">
                    <i class="fa-solid fa-plus-circle"></i> New Report
                </button>
            @else
                <button onclick="window.location.href='{{ route('login') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold">
                    <i class="fa-solid fa-plus-circle"></i> New Report
                </button>
            @endif
        </div>

        <!-- Profile Section -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            @if(session('user'))
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-medium text-gray-800">{{ session('user.name') }}</span>
                    <span class="text-xs text-gray-500">@{{ session('user.username') }}</span>
                </div>
            @else
                <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-medium text-gray-800">Guest</span>
                    <span class="text-xs text-gray-500">user@mail.com</span>
=======
<div class="flex h-screen max-w-[1920px] mx-auto">

    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-200 p-5 flex flex-col overflow-y-auto sidebar-scroll">
        <div class="mb-7">
            <h2 class="text-2xl font-bold text-blue-500">LaporinAja</h2>
        </div>

        <nav class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">🏠</span>
                <span>Home</span>
            </a>

            <a href="{{ route('explore') }}" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">#</span>
                <span>Explore</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">🔔</span>
                <span>Notification</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">💬</span>
                <span>Messages</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">📋</span>
                <span>My Reports</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">👥</span>
                <span>Communities</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">👤</span>
                <span>Profile</span>
            </a>

            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center text-xl leading-none">⚙️</span>
                <span>More</span>
            </a>
        </nav>

        @if(session('user'))
            <button onclick="window.location.href='{{ route('reports.create') }}'" class="mt-5 bg-blue-500 text-white px-6 py-3.5 rounded-3xl font-semibold hover:bg-blue-600 transition">
                + New Report
            </button>
        @else
            <button onclick="window.location.href='{{ route('login') }}'" class="mt-5 bg-blue-500 text-white px-6 py-3.5 rounded-3xl font-semibold hover:bg-blue-600 transition">
                + New Report
            </button>
        @endif

        <div class="mt-auto pt-5 border-t border-gray-200 flex items-center gap-3">
            @if(session('user'))
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ session('user.name') }}</p>
                    <p class="text-[13px] text-gray-500">@{{ session('user.username') }}</p>
                </div>
            @else
                <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-sm text-gray-800">User</p>
                    <p class="text-[13px] text-gray-500">username</p>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                </div>
            @endif
        </div>
    </aside>

<<<<<<< HEAD
    <!-- 📰 Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white">
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-bold text-gray-800">Explore</h1>
            <button class="text-gray-400 hover:text-blue-600 transition">
                <i class="fa-solid fa-gear text-xl"></i>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6 space-y-5">
            
            <!-- Search -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-3 px-4 py-3">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search for issues, locations, or keywords.." 
                           class="flex-1 border-none outline-none text-sm text-gray-700 placeholder-gray-400">
                </div>
            </div>

            <!-- Filters -->
            <div class="flex gap-3 flex-wrap">
                <!-- Location -->
                <div class="relative">
                    <button onclick="toggleDropdown('locationDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-location-dot text-gray-500"></i>
                        <span>Location</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
=======
    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden border-r border-gray-200">
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Explore</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-6 bg-gray-50 feed-scroll">
            
            <!-- Search -->
            <div class="mb-6">
                <input type="text" id="searchInput" placeholder="Search for issues, locations, or keywords.." 
                       class="w-full px-6 py-4 bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            </div>

            <!-- Filters -->
            <div class="flex gap-3 mb-6">
                <!-- Location -->
                <div class="relative">
                    <button onclick="toggleDropdown('locationDropdown')" class="flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <span>Location</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                    </button>
                    <div id="locationDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2 space-y-1">
                            @foreach(['Lumban Hariara', 'Panasala', 'Patujulu', 'Puba Lubis', 'Puntu Manda', 'Silalahi', 'Simuring'] as $loc)
<<<<<<< HEAD
                                <button onclick="filterByLocation('{{ $loc }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $loc }}</button>
=======
                                <button onclick="filterByLocation('{{ $loc }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">{{ $loc }}</button>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="relative">
<<<<<<< HEAD
                    <button onclick="toggleDropdown('categoryDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-tag text-gray-500"></i>
                        <span>Category</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
=======
                    <button onclick="toggleDropdown('categoryDropdown')" class="flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <span>Category</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                    </button>
                    <div id="categoryDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2 space-y-1">
                            @foreach(['Infrastruktur', 'Keamanan', 'Sanitasi', 'Taman', 'Aksesibilitas'] as $cat)
<<<<<<< HEAD
                                <button onclick="filterByCategory('{{ $cat }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $cat }}</button>
=======
                                <button onclick="filterByCategory('{{ $cat }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">{{ $cat }}</button>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="relative">
<<<<<<< HEAD
                    <button onclick="toggleDropdown('statusDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-circle-check text-gray-500"></i>
                        <span>Status</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
=======
                    <button onclick="toggleDropdown('statusDropdown')" class="flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <span>Status</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                    </button>
                    <div id="statusDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2 space-y-1">
                            @foreach(['Baru', 'Dalam Pengerjaan', 'Selesai'] as $status)
<<<<<<< HEAD
                                <button onclick="filterByStatus('{{ $status }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $status }}</button>
=======
                                <button onclick="filterByStatus('{{ $status }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">{{ $status }}</button>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                            @endforeach
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <button class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-filter text-gray-500"></i>
                    <span>More Filters</span>
=======
                <button class="px-5 py-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                    More Filters
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                </button>
            </div>

            <!-- Trending Reports -->
<<<<<<< HEAD
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-orange-500"></i> Trending Reports
=======
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                    </svg>
                    Trending Reports
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                </h2>

                <div class="space-y-4" id="reportsList">
                    @forelse($reports as $report)
<<<<<<< HEAD
                        <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition-all duration-300 report-card"
=======
                        <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition report-card"
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                             data-location="{{ $report['location'] ?? '' }}"
                             data-category="{{ $report['category'] ?? '' }}"
                             data-status="{{ $report['status'] ?? '' }}">
                             
<<<<<<< HEAD
                            <h3 class="text-base font-semibold text-gray-800 mb-2">{{ $report['title'] ?? '' }}</h3>

                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                <span>{{ $report['location'] ?? '—' }}</span>
                                <span class="mx-2">•</span>
                                <i class="fa-solid fa-heart text-red-500"></i>
                                <span>{{ $report['votes'] ?? 0 }} votes</span>
                            </div>

                            <div class="flex gap-2 mb-3">
                                <span class="px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">{{ $report['status'] ?? '' }}</span>
                                <span class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-700 rounded-full">{{ $report['category'] ?? '' }}</span>
                            </div>

                            @if(!empty($report['description']))
                                <p class="text-gray-700 text-sm leading-relaxed">{{ Str::limit($report['description'], 200) }}</p>
                            @endif

                            <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-3 mt-3">
                                <div class="flex gap-4">
                                    <button class="hover:text-blue-600 transition"><i class="fa-regular fa-comment"></i> {{ $report['comments'] ?? 0 }}</button>
                                    <button class="hover:text-red-500 transition"><i class="fa-solid fa-heart"></i> {{ $report['votes'] ?? 0 }}</button>
                                </div>
                                <button class="text-xs text-blue-600 hover:underline">Lihat detail</button>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-12">
                            <i class="fa-regular fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-sm">Belum ada laporan.</p>
                        </div>
=======
                            <h3 class="text-base font-semibold text-gray-900 mb-2">{{ $report['title'] ?? '' }}</h3>

                            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $report['location'] ?? '—' }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $report['votes'] ?? 0 }} votes</span>
                            </div>

                            <div class="flex gap-2">
                                <span class="px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">{{ $report['status'] ?? '' }}</span>
                                <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full border">{{ $report['category'] ?? '' }}</span>
                            </div>

                            @if(!empty($report['description']))
                                <p class="mt-3 text-gray-700 text-sm">{{ Str::limit($report['description'], 200) }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada laporan.</p>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                    @endforelse
                </div>
            </div>
        </div>
    </main>

<<<<<<< HEAD
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
=======
    <!-- Right Sidebar -->
    <aside class="w-80 bg-white p-6 overflow-y-auto sidebar-scroll sidebar-right">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Urgent</h2>
            <ul>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-[13px] text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-[13px] text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">96 Votes</span>
                </li>
                <li class="flex justify-between items-center py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-[13px] text-gray-500">RT 05</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">54 Votes</span>
                </li>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
            </ul>
        </section>

        <section>
<<<<<<< HEAD
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
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Trending</h2>
            <ul>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-pink-100 text-pink-700">Urgent</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-amber-100 text-amber-800">Medium</span>
                </li>
                <li class="flex justify-between items-center py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-blue-100 text-blue-800">Low</span>
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
                </li>
            </ul>
        </section>
    </aside>
</div>

<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        document.querySelectorAll('[id$="Dropdown"]').forEach(d => {
            if (d.id !== id) d.classList.add('hidden');
        });
        dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', e => {
        if (!e.target.closest('button[onclick^="toggleDropdown"]')) {
            document.querySelectorAll('[id$="Dropdown"]').forEach(d => d.classList.add('hidden'));
        }
    });

    function filterByLocation(location) {
        document.querySelectorAll('.report-card').forEach(card => {
            card.style.display = card.dataset.location.includes(location) ? 'block' : 'none';
        });
        toggleDropdown('locationDropdown');
    }

    function filterByCategory(category) {
        document.querySelectorAll('.report-card').forEach(card => {
            card.style.display = card.dataset.category === category ? 'block' : 'none';
        });
        toggleDropdown('categoryDropdown');
    }

    function filterByStatus(status) {
        document.querySelectorAll('.report-card').forEach(card => {
            card.style.display = card.dataset.status === status ? 'block' : 'none';
        });
        toggleDropdown('statusDropdown');
    }

    document.getElementById('searchInput').addEventListener('input', e => {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.report-card').forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const location = card.dataset.location.toLowerCase();
            card.style.display = title.includes(term) || location.includes(term) ? 'block' : 'none';
        });
    });
</script>
<<<<<<< HEAD

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection
=======
@endsection
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
