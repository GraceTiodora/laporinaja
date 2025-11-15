@extends('layouts.app')

@section('title', 'My Reports - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/my-reports.css') }}">
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
                        ['My Reports', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Communities', '#', 'fa-solid fa-users'],
                        ['Profile', '#', 'fa-regular fa-user'],
                        ['More', '#', 'fa-solid fa-ellipsis-h'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600 {{ $route == 'my-reports' ? 'bg-blue-50 text-blue-600' : '' }}">
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
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Justin Hubner') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden bg-white">
        <!-- Header with Profile -->
        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">My Reports</h1>
            
            <!-- User Profile Card -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-16 h-16 rounded-full object-cover">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ session('user.name', 'Justin Hubner') }}</h2>
                    <p class="text-sm text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</p>
                </div>
            </div>
        </header>

        <!-- Reports List -->
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

            @forelse($reports as $report)
                <article class="report-card">
                    <div class="report-header">
                        <h3 class="report-title">{{ $report['title'] }}</h3>
                    </div>

                    <div class="report-meta">
                        <span class="flex items-center gap-1.5 text-gray-600">
                            <i class="fa-solid fa-location-dot text-sm"></i>
                            {{ $report['location'] }}
                        </span>
                        <span class="text-gray-500">{{ $report['time'] }}</span>
                    </div>

                    <div class="report-tags">
                        @if($report['status_color'] == 'yellow')
                            <span class="tag tag-yellow">{{ $report['status'] }}</span>
                        @elseif($report['status_color'] == 'red')
                            <span class="tag tag-red">{{ $report['status'] }}</span>
                        @elseif($report['status_color'] == 'green')
                            <span class="tag tag-green">{{ $report['status'] }}</span>
                        @endif
                        <span class="tag tag-category">{{ $report['category'] }}</span>
                    </div>

                    <div class="report-stats">
                        <button class="stat-item">
                            <i class="fa-regular fa-star"></i>
                            <span>{{ $report['votes'] }} votes</span>
                        </button>
                        <button class="stat-item">
                            <i class="fa-regular fa-comment"></i>
                            <span>{{ $report['comments'] }} komentar</span>
                        </button>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <i class="fa-regular fa-clipboard text-gray-300 text-8xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Laporan</h3>
                    <p class="text-gray-500 mb-6">Mulai buat laporan pertama Anda</p>
                    <button onclick="window.location.href='{{ route('reports.create') }}'" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition font-semibold">
                        <i class="fa-solid fa-plus-circle mr-2"></i> Buat Laporan
                    </button>
                </div>
            @endforelse
        </div>
    </main>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection