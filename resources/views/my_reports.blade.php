@extends('layouts.app')

@section('title', 'My Reports - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/my-reports.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- 🧭 LEFT SIDEBAR -->
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
    <a href="{{ $route === '#' ? '#' : (Route::has($route) ? route($route) : '#') }}"
       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all
              {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">

        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
        <span>{{ $name }}</span>
    </a>
@endforeach

            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition font-semibold">
                <i class="fa-solid fa-plus-circle"></i> New Report
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Justin Hubner') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-hidden bg-white">

        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">My Reports</h1>

            <div class="flex items-center gap-4">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-16 h-16 rounded-full object-cover">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ session('user.name', 'Justin Hubner') }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        @{{ session('user.username', 'hubnerjustin') }}
                    </p>
                </div>
            </div>
        </header>

        <!-- REPORT LIST -->
        <div class="flex-1 overflow-y-auto px-8 py-6 space-y-4">

            @php
                $reports = [
                    [
                        'title' => 'Lampu Jalan Mati di RT 05',
                        'location' => 'Jl. Mawar',
                        'time' => '2 hari yang lalu',
                        'status' => 'Sedang Diproses',
                        'status_color' => 'yellow',
                        'category' => 'Keamanan',
                        'votes' => 18,
                        'comments' => 6
                    ],
                    [
                        'title' => 'Sampah Menumpuk di Pasar Baru',
                        'location' => 'Jl. Kenanga',
                        'time' => '5 hari yang lalu',
                        'status' => 'Baru',
                        'status_color' => 'red',
                        'category' => 'Sanitasi',
                        'votes' => 3,
                        'comments' => 1
                    ],
                    [
                        'title' => 'Pohon Tumbang di Depan Halte',
                        'location' => 'Jl. Sudirman',
                        'time' => '1 minggu yang lalu',
                        'status' => 'Selesai',
                        'status_color' => 'green',
                        'category' => 'Infrastruktur',
                        'votes' => 34,
                        'comments' => 12
                    ],
                ];
            @endphp

            @forelse ($reports as $r)
                <article class="report-card bg-white p-6 rounded-xl border shadow-sm hover:shadow-md transition">

                    <h3 class="text-lg font-semibold text-gray-800 mb-2">
                        {{ $r['title'] }}
                    </h3>

                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-gray-400"></i>{{ $r['location'] }}
                        </span>
                        <span>•</span>
                        <span>{{ $r['time'] }}</span>
                    </div>

                    <div class="flex gap-2 mb-3">
                        @if($r['status_color'] == 'yellow')
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                {{ $r['status'] }}
                            </span>
                        @elseif($r['status_color'] == 'red')
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                {{ $r['status'] }}
                            </span>
                        @elseif($r['status_color'] == 'green')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                {{ $r['status'] }}
                            </span>
                        @endif

                        <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                            {{ $r['category'] }}
                        </span>
                    </div>

                    <div class="flex items-center gap-4 text-sm text-gray-500 pt-2 border-t border-gray-100">
                        <span class="flex items-center gap-1">
                            <i class="fa-regular fa-star"></i> {{ $r['votes'] }} votes
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-regular fa-comment"></i> {{ $r['comments'] }} komentar
                        </span>
                    </div>

                </article>
            @empty
                <div class="text-center py-16 text-gray-500">
                    <i class="fa-regular fa-clipboard text-6xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-semibold">Belum ada laporan</p>
                </div>
            @endforelse

        </div>
    </main>


</div>
@endsection
