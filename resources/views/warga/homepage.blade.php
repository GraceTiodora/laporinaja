@extends('layouts.app')

@section('title', 'Home - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white/95 backdrop-blur-sm border-r border-gray-200 p-6 flex flex-col justify-between">
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
                        ['Laporan Saya', 'reports', 'fa-solid fa-clipboard-list'],
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
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
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium
                              transition-all hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 
                              hover:shadow-md hover:scale-105 transform">
                        <i class="{{ $icon }} text-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                        <span class="group-hover:translate-x-1 transition-transform">{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all font-bold transform hover:scale-105 relative overflow-hidden group">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                <i class="fa-solid fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <!-- Profile Bottom -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4 hover:bg-gray-50 p-3 rounded-xl transition-all cursor-pointer group">
            <div class="relative">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
            </div>
            <div class="flex flex-col leading-tight flex-1">
                <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
            </div>
            <i class="fa-solid fa-chevron-right text-gray-400 opacity-0 group-hover:opacity-100 transition-all"></i>
        </div>
    </aside>

    <!-- 📰 Main Feed -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20">

        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10 shadow-sm">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Beranda</h1>
            <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg group">
                <i class="fa-solid fa-gear text-xl group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </header>

        <div class="overflow-y-auto p-6 space-y-5">

            <!-- Post Input -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-xl transition-all duration-300 hover:border-blue-200 group">
                <div class="flex items-center gap-3 mb-4">
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-12 h-12 rounded-full ring-2 ring-blue-100 group-hover:ring-blue-300 transition-all">
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <input type="text" placeholder="Ada masalah di sekitarmu? Yuk laporkan! 🚀"
                           onclick="window.location.href='{{ route('reports.create') }}'"
                           class="flex-1 bg-gradient-to-r from-gray-50 to-blue-50/30 px-4 py-3 rounded-full border border-gray-200
                                  hover:border-blue-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all cursor-pointer
                                  placeholder-gray-500 text-gray-800 font-medium">
                </div>

                <div class="flex justify-between items-center px-2">
                    <div class="flex gap-4 text-gray-400">
                        <button class="hover:text-blue-600 transition-all hover:scale-110 transform" title="Upload Foto">
                            <i class="fa-solid fa-camera text-lg"></i>
                        </button>
                        <button class="hover:text-green-600 transition-all hover:scale-110 transform" title="Upload Gambar">
                            <i class="fa-solid fa-image text-lg"></i>
                        </button>
                        <button class="hover:text-red-600 transition-all hover:scale-110 transform" title="Tambah Lokasi">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </button>
                    </div>
                    <button onclick="window.location.href='{{ route('reports.create') }}'" 
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-full 
                                   transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-105 flex items-center gap-2">
                        <span>Post</span>
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- FEED LIST -->
            @php
                $allReports = $dbReports ?? [];
            @endphp

            @foreach ($allReports as $report)
            <article class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-blue-300 hover:-translate-y-1 group">

                <!-- User Info -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full ring-2 ring-gray-100 group-hover:ring-blue-200 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-gray-900 text-sm">{{ $report['user']['name'] ?? 'Anonymous' }}</span>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span>{{ $report['created_at'] ?? 'Baru saja' }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-500"></i>
                                {{ $report['location'] ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Title/Judul Laporan -->
                <h3 class="text-gray-900 font-bold text-base mb-4 leading-snug group-hover:text-blue-700 transition">
                    {{ $report['title'] ?? $report['description'] ?? 'Tanpa Judul' }}
                </h3>

                @if(!empty($report['image']))
                    <div class="rounded-xl overflow-hidden mb-4 relative group/img">
                        <img src="{{ asset($report['image']) }}" class="w-full object-cover max-h-[450px] group-hover/img:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/0 group-hover/img:bg-black/10 transition-all"></div>
                    </div>
                @endif

                <div class="flex gap-2 mb-4">
                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-pink-100 to-red-100 text-pink-700 
                                 hover:from-pink-200 hover:to-red-200 transition-all cursor-default">
                        {{ $report['status'] ?? 'Baru' }}
                    </span>
                    <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-indigo-100 to-blue-100 text-indigo-700
                                 hover:from-indigo-200 hover:to-blue-200 transition-all cursor-default">
                        {{ $report['category'] ?? 'Umum' }}
                    </span>
                </div>

                <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-4">
                    <div class="flex gap-6">
                        <button onclick="window.location='{{ route('reports.show', $report['id']) }}'" 
                                class="flex items-center gap-2 hover:text-blue-600 transition-all group/btn cursor-pointer">
                            <i class="fa-regular fa-comment group-hover/btn:scale-125 transition-transform"></i>
                            <span class="font-medium">{{ $report['comments'] ?? 0 }}</span>
                        </button>
                        <button onclick="toggleVote({{ $report['id'] }}, this)" 
                                class="vote-btn flex items-center gap-2 hover:text-red-500 transition-all group/btn cursor-pointer"
                                data-report-id="{{ $report['id'] }}">
                            <i class="fa-solid fa-heart group-hover/btn:scale-125 transition-transform"></i>
                            <span class="font-medium vote-count">{{ $report['votes'] ?? 0 }}</span>
                        </button>
                    </div>

                    <a href="{{ route('reports.show', $report['id']) }}"
                       class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-all flex items-center gap-1 
                              hover:gap-2 group/link">
                        Lihat detail
                        <i class="fa-solid fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>

            </article>
            @endforeach

        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-white/95 backdrop-blur-sm p-6 overflow-y-auto border-l border-gray-200 space-y-6">
        <!-- Masalah Penting -->
        <section class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-5 border border-red-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500 animate-pulse"></i> 
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Masalah Penting</span>
            </h2>
            <ul class="space-y-3">
                @forelse($topReports ?? [] as $report)
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <a href="{{ route('reports.show', $report['id']) }}" class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">{{ Str::limit($report['title'], 30) }}</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                {{ Str::limit($report['location'] ?? 'Lokasi tidak diketahui', 20) }}
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">{{ $report['votes'] }}V</span>
                        </div>
                    </a>
                </li>
                @empty
                <li class="p-4 text-center text-gray-500 text-sm">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                    Belum ada laporan
                </li>
                @endforelse
            </ul>
        </section>

        <!-- Trending -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> 
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Kategori Trending</span>
            </h2>
            <ul class="space-y-3">
                @forelse($trendingCategories ?? [] as $index => $trend)
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition">{{ $trend['category'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fa-solid fa-arrow-trend-up text-green-500"></i>
                                {{ $trend['total'] }} laporan minggu ini
                            </p>
                        </div>
                        @if($index === 0)
                            <span class="px-2.5 py-1 rounded-full text-xs bg-gradient-to-r from-orange-400 to-red-500 text-white font-bold shadow-md">🔥 Hot</span>
                        @elseif($index === 1)
                            <span class="px-2.5 py-1 rounded-full text-xs bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold shadow-md">⚡ Warm</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs bg-gradient-to-r from-blue-400 to-indigo-500 text-white font-bold shadow-md">📈 Rising</span>
                        @endif
                    </div>
                </li>
                @empty
                <li class="p-4 text-center text-gray-500 text-sm">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                    Belum ada data trending
                </li>
                @endforelse
            </ul>
        </section>
    </aside>
</div>

<!-- CSRF Token Meta -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Vote/Like Functionality -->
            
            @php
                $totalReports = collect($dbReports ?? []);
                $baruCount = $totalReports->where('status', 'Baru')->count();
                $diprosesCount = $totalReports->where('status', 'Diproses')->count();
                $selesaiCount = $totalReports->where('status', 'Selesai')->count();
                $ditolakCount = $totalReports->where('status', 'Ditolak')->count();
                $total = $totalReports->count();
                
                $selesaiPercentage = $total > 0 ? round(($selesaiCount / $total) * 100) : 0;
            @endphp
            
            <!-- Total & Progress -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 mb-4 border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Total Laporan Masuk</span>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $total }}</span>
                </div>
                <div class="bg-gray-200 h-2.5 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-1000" style="width: {{ $selesaiPercentage }}%"></div>
                </div>
                <p class="text-xs text-gray-600 mt-1.5 text-right font-medium">{{ $selesaiPercentage }}% telah diselesaikan</p>
            </div>
            
            <!-- Status Breakdown -->
            <div class="space-y-3">
                <!-- Baru -->
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:shadow-md transition-all group cursor-pointer border border-blue-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-sparkles text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-blue-600">Laporan Baru</p>
                            <p class="text-sm text-gray-500 text-xs">Menunggu verifikasi</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-blue-700">{{ $baruCount }}</span>
                </div>
                
                <!-- Diproses -->
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-orange-100 rounded-xl hover:shadow-md transition-all group cursor-pointer border border-orange-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-spinner text-white animate-spin"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-orange-600">Sedang Diproses</p>
                            <p class="text-sm text-gray-500 text-xs">Dalam penanganan</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-orange-700">{{ $diprosesCount }}</span>
                </div>
                
                <!-- Selesai -->
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-100 rounded-xl hover:shadow-md transition-all group cursor-pointer border border-green-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-check-double text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-green-600">Selesai Ditangani</p>
                            <p class="text-sm text-gray-500 text-xs">Masalah teratasi</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-green-700">{{ $selesaiCount }}</span>
                </div>
                
                <!-- Ditolak -->
                @if($ditolakCount > 0)
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-red-50 to-rose-100 rounded-xl hover:shadow-md transition-all group cursor-pointer border border-red-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-rose-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-times text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-red-600">Ditolak</p>
                            <p class="text-sm text-gray-500 text-xs">Tidak memenuhi syarat</p>
                        </div>
                    </div>
                    <span class="text-2xl font-bold text-red-700">{{ $ditolakCount }}</span>
                </div>
                @endif
            </div>
            
            <!-- Response Time Info -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-xs text-gray-600">
                    <i class="fa-solid fa-clock text-blue-500"></i>
                    <span class="font-medium">Rata-rata waktu respon: <span class="font-bold text-blue-600">2-3 hari</span></span>
                </div>
            </div>
        </section>
        
        <!-- Masalah Penting -->
        <section class="bg-white rounded-2xl p-5 border-2 border-red-200 shadow-lg">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center animate-pulse">
                    <i class="fa-solid fa-fire text-white"></i>
                </div>
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Prioritas Tinggi</span>
            </h2>
            <ul class="space-y-3">
                @forelse($topReports ?? [] as $report)
                <li class="p-3 bg-gradient-to-br from-white to-red-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-red-300">
                    <a href="{{ route('reports.show', $report['id']) }}" class="block">
                        <div class="flex items-start justify-between mb-2">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition line-clamp-2 flex-1">{{ Str::limit($report['title'], 35) }}</p>
                            <span class="ml-2 px-2.5 py-1 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md whitespace-nowrap">
                                <i class="fa-solid fa-fire"></i> {{ $report['votes'] }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                            <i class="fa-solid fa-location-dot text-red-400"></i>
                            {{ Str::limit($report['location'] ?? 'Lokasi tidak diketahui', 25) }}
                        </p>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-400"><i class="fa-regular fa-clock"></i> {{ $report['created_at'] ?? 'Baru' }}</span>
                            <span class="text-blue-600 font-semibold group-hover:translate-x-1 transition-transform">Lihat →</span>
                        </div>
                    </a>
                </li>
                @empty
                <li class="p-5 text-center text-gray-500 text-sm">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                    <p class="font-medium">Belum ada laporan prioritas</p>
                </li>
                @endforelse
            </ul>
        </section>

        <!-- Trending -->
        <section class="bg-white rounded-2xl p-5 border-2 border-purple-200 shadow-lg">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-arrow-trend-up text-white"></i>
                </div>
                <span class="bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">Trending</span>
            </h2>
            <ul class="space-y-3">
                @forelse($topReports ?? [] as $report)
                <li class="p-3 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-purple-300">
                    <a href="{{ route('reports.show', $report['id']) }}" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-purple-700 transition mb-2 line-clamp-2">{{ Str::limit($report['title'], 40) }}</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-purple-400"></i>
                            {{ Str::limit($report['location'] ?? 'Lokasi tidak diketahui', 28) }}
                        </p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                <span class="font-bold text-gray-700">{{ $report['votes'] }}</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-comments text-blue-400"></i>
                                <span class="font-bold text-gray-700">{{ $report['comments'] ?? 0 }}</span>
                            </span>
                        </div>
                    </a>
                </li>
                @empty
                <li class="p-5 text-center text-gray-500 text-sm">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block text-gray-300"></i>
                    <p class="font-medium">Belum ada laporan trending</p>
                </li>
                @endforelse
            </ul>
        </section>
    </aside>
</div>

<!-- Vote/Like Functionality -->
<script>
function toggleVote(reportId, button) {
    @if(!session()->has('user'))
        window.location.href = "{{ route('login') }}";
        return;
    @endif

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/reports/${reportId}/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            upvote: true
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.upvotes !== undefined) {
            const voteCountElement = button.querySelector('.vote-count');
            voteCountElement.textContent = data.upvotes;
            
            // Add animation
            button.classList.add('text-red-500');
            const icon = button.querySelector('i');
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            
            // Pulse effect
            button.classList.add('animate-pulse');
            setTimeout(() => {
                button.classList.remove('animate-pulse');
            }, 500);
        }
    })
    .catch(error => {
        console.error('Error voting:', error);
        alert('Terjadi kesalahan saat voting. Silakan coba lagi.');
    });
}
</script>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection
