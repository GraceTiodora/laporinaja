@extends('layouts.app')

@section('title', 'Explore - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">Laporin<span class="text-gray-900">Aja</span></h2>

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
                     class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300
                            {{ $isActive 
                                ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-200 scale-105' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                      <i class="{{ $icon }} text-lg {{ $isActive ? '' : 'group-hover:scale-125' }} transition-transform"></i>
                      <span class="font-semibold">{{ $name }}</span>
                      @if($isActive)
                          <i class="fa-solid fa-circle text-xs ml-auto animate-pulse"></i>
                      @endif
                  </a>
              @endforeach
            </nav>

            @if(session('user'))
                <button onclick="window.location.href='{{ route('reports.create') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 
                               bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                               text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                               transition-all duration-300 font-bold transform hover:scale-105 group">
                    <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                    <span>Laporan Baru</span>
                </button>
            @else
                <button onclick="window.location.href='{{ route('login') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 
                               bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                               text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                               transition-all duration-300 font-bold transform hover:scale-105 group">
                    <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                    <span>Laporan Baru</span>
                </button>
            @endif
        </div>

        <!-- Profile Section -->
        <div>
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 mb-3 hover:bg-blue-50 p-3 rounded-xl transition-all cursor-pointer group">
                @if(session('user'))
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-blue-100 group-hover:ring-4 group-hover:ring-blue-300 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ session('user.name') }}</p>
                        <p class="text-xs text-gray-500">@{{ session('user.username') }}</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                @else
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="w-11 h-11 rounded-full object-cover ring-2 ring-blue-100 group-hover:ring-4 group-hover:ring-blue-300 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Guest</p>
                        <p class="text-xs text-gray-500">user@mail.com</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
                @endif
            </div>
            
            @if(session('user'))
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 transition-all duration-300 group border-2 border-red-200 hover:border-red-400 hover:shadow-lg transform hover:scale-105">
                        <i class="fa-solid fa-right-from-bracket group-hover:translate-x-2 transition-transform text-lg"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endif
        </div>
    </aside>

    <!-- 📰 Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20">
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-hashtag text-blue-600 text-xl"></i>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Jelajahi Laporan</h1>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all p-2 hover:bg-blue-50 rounded-lg group hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 space-y-5">
            
            <!-- Search & Filters Header -->
            <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-xl transition-all duration-300 hover:border-blue-300">
                <!-- Search -->
                <div class="mb-4">
                    <div class="flex items-center gap-3 bg-gradient-to-r from-gray-50 to-blue-50/30 px-5 py-3.5 rounded-full border-2 border-gray-200 focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100 transition-all shadow-sm hover:shadow-md group">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg group-focus-within:text-blue-600 transition-colors"></i>
                        <input type="text" id="searchInput" placeholder="Cari masalah, lokasi, atau kata kunci..." 
                               class="flex-1 border-none outline-none text-sm text-gray-700 placeholder-gray-500 bg-transparent font-medium">
                        <i class="fa-solid fa-times text-gray-300 hover:text-red-500 cursor-pointer transition-colors text-sm" onclick="document.getElementById('searchInput').value=''; document.getElementById('searchInput').dispatchEvent(new Event('input'))" style="display:none" id="clearSearch"></i>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex gap-3 flex-wrap">
                    <!-- Location -->
                    <div class="relative">
                        <button onclick="toggleDropdown('locationDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-full hover:from-red-50 hover:to-red-100 hover:border-red-300 transition-all text-xs font-bold text-gray-700 hover:text-red-600 group shadow-sm hover:shadow-md transform hover:scale-105">
                            <i class="fa-solid fa-location-dot text-gray-500 group-hover:text-red-500 text-sm group-hover:scale-110 transition-transform"></i>
                            <span>Lokasi</span>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-red-500"></i>
                        </button>
                        <div id="locationDropdown" class="hidden absolute top-full left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                            <div class="p-2 space-y-1">
                                @foreach(['Lumban Hariara', 'Panasala', 'Patujulu', 'Puba Lubis', 'Puntu Manda', 'Silalahi', 'Simuring'] as $loc)
                                    <button onclick="filterByLocation('{{ $loc }}')" class="w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition">{{ $loc }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="relative">
                        <button onclick="toggleDropdown('categoryDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-full hover:from-blue-50 hover:to-blue-100 hover:border-blue-300 transition-all text-xs font-bold text-gray-700 hover:text-blue-600 group shadow-sm hover:shadow-md transform hover:scale-105">
                            <i class="fa-solid fa-tag text-gray-500 group-hover:text-blue-500 text-sm group-hover:scale-110 transition-transform"></i>
                            <span>Kategori</span>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-blue-500"></i>
                        </button>
                        <div id="categoryDropdown" class="hidden absolute top-full left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                            <div class="p-2 space-y-1">
                                @foreach(['Infrastruktur', 'Keamanan', 'Sanitasi', 'Taman', 'Aksesibilitas'] as $cat)
                                    <button onclick="filterByCategory('{{ $cat }}')" class="w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition">{{ $cat }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="relative">
                        <button onclick="toggleDropdown('statusDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-200 rounded-full hover:from-green-50 hover:to-green-100 hover:border-green-300 transition-all text-xs font-bold text-gray-700 hover:text-green-600 group shadow-sm hover:shadow-md transform hover:scale-105">
                            <i class="fa-solid fa-circle-check text-gray-500 group-hover:text-green-500 text-sm group-hover:scale-110 transition-transform"></i>
                            <span>Status</span>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-green-500"></i>
                        </button>
                        <div id="statusDropdown" class="hidden absolute top-full left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                            <div class="p-2 space-y-1">
                                @foreach(['Baru', 'Dalam Pengerjaan', 'Selesai'] as $status)
                                    <button onclick="filterByStatus('{{ $status }}')" class="w-full text-left px-3 py-2 text-xs text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition">{{ $status }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trending Reports -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2.5">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-fire text-white animate-pulse"></i>
                    </div>
                    <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">Laporan Trending</span>
                </h2>

                <div class="space-y-4" id="reportsList">
                    @forelse($reports as $report)
                        <article class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-500 hover:border-blue-400 hover:-translate-y-2 group report-card"
                             data-location="{{ $report['location'] ?? '' }}"
                             data-category="{{ $report['category'] ?? '' }}"
                             data-status="{{ $report['status'] ?? '' }}">
                             
                            <!-- Header dengan User Info -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100 group-hover:ring-blue-300 transition-all shadow-md">
                                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 text-lg group-hover:text-blue-700 transition-colors cursor-pointer" onclick="window.location='{{ route('reports.show', $report['id']) }}'">{{ $report['title'] ?? '' }}</h3>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                            <i class="fa-regular fa-clock text-blue-400"></i>
                                            @if(isset($report['created_at']))
                                                <span>{{ $report['created_at'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                @php
                                    $statusColors = [
                                        'Baru' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white',
                                        'Diproses' => 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white',
                                        'Selesai' => 'bg-gradient-to-r from-green-500 to-emerald-600 text-white',
                                        'Ditolak' => 'bg-gradient-to-r from-red-500 to-rose-600 text-white',
                                    ];
                                    $statusClass = $statusColors[$report['status'] ?? 'Baru'] ?? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white';
                                @endphp
                                <span class="{{ $statusClass }} px-4 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1.5">
                                    @if(($report['status'] ?? 'Baru') == 'Baru')
                                        <i class="fa-solid fa-sparkles"></i>
                                    @elseif(($report['status'] ?? 'Baru') == 'Diproses')
                                        <i class="fa-solid fa-sync animate-spin"></i>
                                    @elseif(($report['status'] ?? 'Baru') == 'Selesai')
                                        <i class="fa-solid fa-check-double"></i>
                                    @endif
                                    {{ $report['status'] ?? 'Baru' }}
                                </span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center gap-2 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">
                                    <i class="fa-solid fa-location-dot text-red-500"></i>
                                    <span class="text-sm font-semibold text-red-700">{{ $report['location'] ?? '—' }}</span>
                                </span>
                            </div>

                            <!-- Description -->
                            @if(!empty($report['description']))
                                <p class="text-gray-700 text-sm leading-relaxed mb-4 line-clamp-2">{{ $report['description'] }}</p>
                            @endif

                            <!-- Category Badge -->
                            <div class="flex gap-2 mb-5">
                                @php
                                    $categoryColors = [
                                        'Infrastruktur' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-blue-200',
                                        'Keamanan' => 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-red-200',
                                        'Sanitasi' => 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-purple-200',
                                        'Taman' => 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-green-200',
                                        'Aksesibilitas' => 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-yellow-200',
                                    ];
                                    $categoryClass = $categoryColors[$report['category'] ?? 'Umum'] ?? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-gray-200';
                                @endphp
                                <span class="{{ $categoryClass }} px-4 py-1.5 text-sm rounded-full font-bold shadow-lg hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-tag mr-1"></i>{{ $report['category'] ?? 'Umum' }}
                                </span>
                            </div>                            <!-- Interactive Stats and Action -->
                            <div class="flex items-center justify-between border-t-2 border-gray-100 pt-4">
                                <div class="flex gap-5">
                                    <button class="flex items-center gap-2 text-sm hover:bg-blue-50 px-3 py-2 rounded-lg transition-all group/stat">
                                        <i class="fa-solid fa-comments text-blue-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                        <span class="font-bold text-gray-700">{{ $report['comments'] ?? 0 }}</span>
                                        <span class="text-gray-500 font-medium">komentar</span>
                                    </button>
                                    <button class="flex items-center gap-2 text-sm hover:bg-red-50 px-3 py-2 rounded-lg transition-all group/stat">
                                        <div class="relative">
                                            <i class="fa-solid fa-heart text-red-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-400 rounded-full animate-ping"></span>
                                        </div>
                                        <span class="font-bold text-gray-700">{{ $report['votes'] ?? 0 }}</span>
                                        <span class="text-gray-500 font-medium">votes</span>
                                    </button>
                                </div>
                                <a href="{{ route('reports.show', $report['id']) }}" class="text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 px-5 py-2.5 rounded-full transition-all flex items-center gap-2 shadow-md hover:shadow-lg transform hover:scale-105 group/link">
                                    Lihat Detail
                                    <i class="fa-solid fa-arrow-right text-sm group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-12">
                            <i class="fa-regular fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-sm">Belum ada laporan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[360px] bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6 overflow-y-auto border-l border-gray-200 space-y-5 shadow-lg">
        
        <!-- Statistik Komunitas -->
        <section class="bg-white rounded-2xl p-5 border-2 border-blue-200 shadow-lg">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-chart-pie text-white"></i>
                </div>
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Statistik Laporan</span>
            </h2>
            
            @php
                $totalReports = collect($reports ?? []);
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
                <li class="p-3 bg-gradient-to-br from-white to-red-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-red-300">
                    <a href="#" class="block">
                        <div class="flex items-start justify-between mb-2">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition line-clamp-2 flex-1">Jalan Rusak</p>
                            <span class="ml-2 px-2.5 py-1 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md whitespace-nowrap">
                                <i class="fa-solid fa-fire"></i> 128
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                            <i class="fa-solid fa-location-dot text-red-400"></i>
                            Jl. Melati
                        </p>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-400"><i class="fa-regular fa-clock"></i> 2 hari lalu</span>
                            <span class="text-blue-600 font-semibold group-hover:translate-x-1 transition-transform">Lihat →</span>
                        </div>
                    </a>
                </li>
                <li class="p-3 bg-gradient-to-br from-white to-red-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-red-300">
                    <a href="#" class="block">
                        <div class="flex items-start justify-between mb-2">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition line-clamp-2 flex-1">Sampah Menumpuk</p>
                            <span class="ml-2 px-2.5 py-1 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md whitespace-nowrap">
                                <i class="fa-solid fa-fire"></i> 96
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                            <i class="fa-solid fa-location-dot text-red-400"></i>
                            Pasar Baru
                        </p>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-400"><i class="fa-regular fa-clock"></i> 3 hari lalu</span>
                            <span class="text-blue-600 font-semibold group-hover:translate-x-1 transition-transform">Lihat →</span>
                        </div>
                    </a>
                </li>
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
                <li class="p-3 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-purple-300">
                    <a href="#" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-purple-700 transition mb-2 line-clamp-2">Taman Berserak</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-purple-400"></i>
                            LAGUBOITI
                        </p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                <span class="font-bold text-gray-700">2</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-comments text-blue-400"></i>
                                <span class="font-bold text-gray-700">1</span>
                            </span>
                        </div>
                    </a>
                </li>
                <li class="p-3 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-purple-300">
                    <a href="#" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-purple-700 transition mb-2 line-clamp-2">Deserunt error totam recusandae laudanti...</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-purple-400"></i>
                            31672 Adela Overpass Apt...
                        </p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                <span class="font-bold text-gray-700">1</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-comments text-blue-400"></i>
                                <span class="font-bold text-gray-700">0</span>
                            </span>
                        </div>
                    </a>
                </li>
                <li class="p-3 bg-gradient-to-br from-white to-purple-50 rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border-2 border-transparent hover:border-purple-300">
                    <a href="#" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-purple-700 transition mb-2 line-clamp-2">Est consequatur iste in aperam.</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-purple-400"></i>
                            165 Runolfsdottir Island...
                        </p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                <span class="font-bold text-gray-700">1</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-comments text-blue-400"></i>
                                <span class="font-bold text-gray-700">0</span>
                            </span>
                        </div>
                    </a>
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

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection