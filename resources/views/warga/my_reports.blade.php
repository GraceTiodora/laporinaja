@extends('layouts.app')

@section('title', 'My Reports - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/my-reports.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
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
                        $isActive = request()->routeIs($route);
                    @endphp
                    <a href="{{ $href }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300 relative
                              {{ $isActive 
                                  ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' 
                                  : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                        @if($isActive)
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        @endif
                        <i class="{{ $icon }} text-lg group-hover:scale-125 transition-transform"></i>
                        <span class="font-semibold">{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all duration-300 font-bold transform hover:scale-105 group">
                <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <!-- Profile Bottom -->
        <div>
            <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 hover:border-blue-400 bg-white hover:bg-blue-50 transition-all cursor-pointer mb-3 group ring-2 ring-gray-200 hover:ring-blue-400">
                <div class="relative">
                    <img src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-white">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ session('user')['name'] ?? 'User' }}</p>
                    <p class="text-xs text-gray-500">@{{ session('user')['username'] ?? 'username' }}</p>
                </div>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-red-50 hover:bg-red-100 hover:text-red-700 transition-all group border-2 border-red-200 hover:border-red-400 shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform text-lg"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 📰 MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-hidden bg-white">

        <!-- Header -->
        <header class="bg-white/95 backdrop-blur-md border-b-2 border-gray-200 px-8 py-6 space-y-6 sticky top-0 z-10 shadow-sm">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-3">
                    <i class="fa-solid fa-clipboard-list text-blue-600"></i>
                    Laporan Saya
                </h1>
                <button class="p-3 rounded-full hover:bg-gray-100 transition-all group">
                    <i class="fa-solid fa-gear text-xl text-gray-600 group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-4">
                @php
                    $totalCount = count($reports);
                    $baruCount = collect($reports)->where('status', 'Baru')->count();
                    $diprosesCount = collect($reports)->where('status', 'Sedang Diproses')->count();
                    $selesaiCount = collect($reports)->where('status', 'Selesai')->count();
                @endphp

                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-4 rounded-xl border-2 border-blue-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-blue-600 mb-1">Total Laporan</p>
                            <h3 class="text-2xl font-bold text-blue-700">{{ $totalCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-clipboard-list text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-cyan-50 to-blue-100 p-4 rounded-xl border-2 border-cyan-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-cyan-600 mb-1">Laporan Baru</p>
                            <h3 class="text-2xl font-bold text-cyan-700">{{ $baruCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-sparkles text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-yellow-100 p-4 rounded-xl border-2 border-orange-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-orange-600 mb-1">Sedang Diproses</p>
                            <h3 class="text-2xl font-bold text-orange-700">{{ $diprosesCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-yellow-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-sync text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-4 rounded-xl border-2 border-green-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-green-600 mb-1">Selesai Ditangani</p>
                            <h3 class="text-2xl font-bold text-green-700">{{ $selesaiCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-check-double text-white text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- REPORT LIST -->
        <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">

            @forelse ($reports as $report)
                <a href="{{ route('reports.show', $report->id) }}" class="block report-card bg-white rounded-2xl border-2 border-gray-200 shadow-md hover:shadow-2xl hover:border-blue-300 transition-all duration-300 overflow-hidden group cursor-pointer transform hover:-translate-y-2 p-6">

                    <!-- Status Ribbon -->
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors flex-1 pr-4">
                            {{ $report->title }}
                        </h3>
                        
                        @if($report->status == 'Dalam Pengerjaan')
                            <span class="px-4 py-2 text-xs rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold shadow-lg flex items-center gap-2 flex-shrink-0">
                                <i class="fa-solid fa-sync animate-spin"></i>
                                {{ $report->status }}
                            </span>
                        @elseif($report->status == 'Baru')
                            <span class="px-4 py-2 text-xs rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold shadow-lg flex items-center gap-2 flex-shrink-0">
                                <i class="fa-solid fa-sparkles animate-pulse"></i>
                                {{ $report->status }}
                            </span>
                        @elseif($report->status == 'Selesai')
                            <span class="px-4 py-2 text-xs rounded-full bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg flex items-center gap-2 flex-shrink-0">
                                <i class="fa-solid fa-check-double"></i>
                                {{ $report->status }}
                            </span>
                        @elseif($report->status == 'Ditolak')
                            <span class="px-4 py-2 text-xs rounded-full bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold shadow-lg flex items-center gap-2 flex-shrink-0">
                                <i class="fa-solid fa-times"></i>
                                {{ $report->status }}
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-2 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">
                            <i class="fa-solid fa-location-dot text-red-500"></i>
                            <span class="font-semibold text-red-700">{{ $report->location }}</span>
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-blue-500"></i>
                            <span class="font-medium text-gray-600">{{ $report->created_at->diffForHumans() }}</span>
                        </span>
                    </div>

                    <div class="flex gap-2 mb-5">
                        @php
                            $categoryColors = [
                                'Infrastruktur' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-blue-200',
                                'Keamanan' => 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-red-200',
                                'Sanitasi' => 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-purple-200',
                                'Taman' => 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-green-200',
                            ];
                            $categoryClass = $categoryColors[$report->category->name ?? 'Umum'] ?? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-gray-200';
                        @endphp
                        <span class="px-4 py-1.5 text-sm rounded-full {{ $categoryClass }} font-bold shadow-lg hover:scale-105 transition-transform">
                            <i class="fa-solid fa-tag mr-1"></i>{{ $report->category->name ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- Interactive Stats -->
                    <div class="flex items-center gap-6 pt-4 border-t-2 border-gray-100">
                        <div class="flex items-center gap-2 text-sm hover:bg-red-50 px-3 py-2 rounded-lg transition-all group/stat cursor-pointer">
                            <div class="relative">
                                <i class="fa-solid fa-heart text-red-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-400 rounded-full animate-ping"></span>
                            </div>
                            <span class="font-bold text-gray-700">{{ $report->upvotes ?? 0 }}</span>
                            <span class="text-gray-500 font-medium">votes</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm hover:bg-blue-50 px-3 py-2 rounded-lg transition-all group/stat cursor-pointer">
                            <i class="fa-solid fa-comments text-blue-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                            <span class="font-bold text-gray-700">{{ $report->comments->count() ?? 0 }}</span>
                            <span class="text-gray-500 font-medium">komentar</span>
                        </div>
                    </div>

                    <!-- Progress Bar (for status Dalam Pengerjaan) -->
                    @if($report->status == 'Dalam Pengerjaan')
                    <div class="mt-4 bg-gray-200 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-full rounded-full animate-pulse shadow-lg" style="width: 60%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-2 flex items-center gap-1.5 font-medium">
                        <i class="fa-solid fa-hourglass-half text-orange-500"></i>
                        Sedang dalam proses penanganan...
                    </p>
                    @endif
                </a>
            @empty
                <div class="text-center py-24">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 mb-6 shadow-lg">
                        <i class="fa-regular fa-clipboard text-5xl text-blue-500 animate-pulse"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum ada laporan</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Mulai laporkan masalah di sekitarmu dan bantu tingkatkan kualitas lingkungan!</p>
                    <button onclick="window.location.href='{{ route('reports.create') }}'"
                            class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full font-bold transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fa-solid fa-plus-circle text-xl"></i>
                        <span>Buat Laporan Pertama</span>
                    </button>
                </div>
            @endforelse

        </div>
    </main>


</div>
@endsection
