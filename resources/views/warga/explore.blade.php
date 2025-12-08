@extends('layouts.app')

@section('title', 'Explore - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">Laporin<span class="text-gray-900">Aja</span></h2>

            <nav class="space-y-2">
            @php
    $menu = [
        ['Beranda', 'home', 'fa-solid fa-house'],
        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],   // <-- FIX !!!
        ['Pesan', 'messages', 'fa-regular fa-envelope'],
        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
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
                      $isActive = request()->routeIs($route);
                  @endphp
                  <a href="{{ $href }}"
                     class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all 
                            {{ $isActive ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 shadow-md' : 'text-gray-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 hover:shadow-md hover:scale-105' }} 
                            transform">
                      <i class="{{ $icon }} text-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                      <span class="group-hover:translate-x-1 transition-transform">{{ $name }}</span>
                  </a>
              @endforeach
            </nav>

            @if(session('user'))
                <button onclick="window.location.href='{{ route('reports.create') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 
                               bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                               text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                               transition-all font-bold transform hover:scale-105 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                    <i class="fa-solid fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i> 
                    <span>Laporan Baru</span>
                </button>
            @else
                <button onclick="window.location.href='{{ route('login') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 
                               bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                               text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                               transition-all font-bold transform hover:scale-105 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                    <i class="fa-solid fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i> 
                    <span>Laporan Baru</span>
                </button>
            @endif
        </div>

        <!-- Profile Section -->
        <div>
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 mb-3 hover:bg-white/50 p-3 rounded-xl transition-all cursor-pointer group">
                @if(session('user'))
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div class="flex flex-col leading-tight flex-1">
                        <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition">{{ session('user.name') }}</span>
                        <span class="text-xs text-gray-500">@{{ session('user.username') }}</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400 opacity-0 group-hover:opacity-100 transition-all"></i>
                @else
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div class="flex flex-col leading-tight flex-1">
                        <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition">Guest</span>
                        <span class="text-xs text-gray-500">user@mail.com</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400 opacity-0 group-hover:opacity-100 transition-all"></i>
                @endif
            </div>
            
            @if(session('user'))
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-600 font-semibold bg-white/50 hover:bg-red-50 hover:text-red-700 transition-all group border border-red-200 hover:border-red-300">
                        <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @endif
        </div>
    </aside>

    <!-- 📰 Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20">
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10 shadow-sm">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Jelajahi Laporan</h1>
            <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg group">
                <i class="fa-solid fa-gear text-xl group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6 space-y-5">
            
            <!-- Search & Filters Header -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition-all">
                <!-- Search -->
                <div class="mb-4">
                    <div class="flex items-center gap-3 bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 focus-within:border-blue-300 focus-within:ring-2 focus-within:ring-blue-100 transition">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
                        <input type="text" id="searchInput" placeholder="Cari masalah, lokasi, atau kata kunci..." 
                               class="flex-1 border-none outline-none text-sm text-gray-700 placeholder-gray-400 bg-transparent">
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex gap-2 flex-wrap">
                    <!-- Location -->
                    <div class="relative">
                        <button onclick="toggleDropdown('locationDropdown')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-xs font-medium text-gray-700 group">
                            <i class="fa-solid fa-location-dot text-gray-500 group-hover:text-blue-600 text-sm"></i>
                            <span>Lokasi</span>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-blue-600"></i>
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
                        <button onclick="toggleDropdown('categoryDropdown')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-xs font-medium text-gray-700 group">
                            <i class="fa-solid fa-tag text-gray-500 group-hover:text-blue-600 text-sm"></i>
                            <span>Kategori</span>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-blue-600"></i>
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
                        <button onclick="toggleDropdown('statusDropdown')" class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-xs font-medium text-gray-700 group">
                            <i class="fa-solid fa-circle-check text-gray-500 group-hover:text-blue-600 text-sm"></i>
                            <span>Status</span>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-blue-600"></i>
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
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-orange-500"></i> Laporan Trending
                </h2>

                <div class="space-y-4" id="reportsList">
                    @forelse($reports as $report)
                        <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-lg transition-all duration-300 report-card hover:border-blue-200"
                             data-location="{{ $report['location'] ?? '' }}"
                             data-category="{{ $report['category'] ?? '' }}"
                             data-status="{{ $report['status'] ?? '' }}">
                             
                            <!-- Header dengan User Info -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 text-sm">{{ $report['title'] ?? '' }}</h3>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                            <i class="fa-solid fa-location-dot text-gray-400"></i>
                                            <span>{{ $report['location'] ?? '—' }}</span>
                                            @if(isset($report['created_at']))
                                                <span class="ml-2">{{ $report['created_at'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if(!empty($report['description']))
                                <p class="text-gray-700 text-sm leading-relaxed mb-4 line-clamp-3">{{ $report['description'] }}</p>
                            @endif

            <!-- Badges -->
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="px-3 py-2 text-sm font-semibold rounded-full 
                    @if($report['status'] === 'Baru')
                        bg-red-100 text-red-700
                    @elseif($report['status'] === 'Dalam Pengerjaan')
                        bg-yellow-100 text-yellow-700
                    @elseif($report['status'] === 'Selesai')
                        bg-green-100 text-green-700
                    @else
                        bg-gray-100 text-gray-700
                    @endif
                ">
                    {{ $report['status'] ?? 'Baru' }}
                </span>
                <span class="px-3 py-2 text-sm font-semibold bg-blue-100 text-blue-700 rounded-full">
                    {{ $report['category'] ?? 'Umum' }}
                </span>
            </div>                            <!-- Stats and Action -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <div class="flex gap-6 text-sm">
                                    <button class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition group">
                                        <i class="fa-regular fa-comment text-base text-gray-400 group-hover:text-blue-600"></i>
                                        <span>{{ $report['comments'] ?? 0 }}</span>
                                    </button>
                                    <button class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition group">
                                        <i class="fa-solid fa-heart text-base text-gray-400 group-hover:text-red-500"></i>
                                        <span>{{ $report['votes'] ?? 0 }}</span>
                                    </button>
                                </div>
                                <a href="{{ route('reports.show', $report['id']) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition flex items-center gap-1">
                                    Lihat detail
                                    <i class="fa-solid fa-arrow-right text-sm"></i>
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
    <aside class="w-[340px] bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 p-6 overflow-y-auto shadow-lg border-l border-gray-200 space-y-6">
        <!-- Masalah Penting -->
        <section class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-5 border border-red-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500 animate-pulse"></i> 
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Masalah Penting</span>
            </h2>
            <ul class="space-y-3">
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <a href="#" class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">Jalan Rusak</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                Jl. Melati
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">128V</span>
                        </div>
                    </a>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <a href="#" class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">Sampah Menumpuk</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                Pasar Baru
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">96V</span>
                        </div>
                    </a>
                </li>
            </ul>
        </section>

        <!-- Trending -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-arrow-trend-up text-blue-500"></i> 
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Trending</span>
            </h2>
            <ul class="space-y-3">
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <a href="#" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Taman Berserak</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            LAGUBOITI
                        </p>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <i class="fa-solid fa-heart text-red-400"></i>
                            <span>2 votes</span>
                        </div>
                    </a>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <a href="#" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Deserunt error totam recusandae laudanti...</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            31672 Adela Overpass Apt...
                        </p>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <i class="fa-solid fa-heart text-red-400"></i>
                            <span>1 votes</span>
                        </div>
                    </a>
                </li>
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <a href="#" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">Est consequatur iste in aperam.</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            165 Runolfsdottir Island...
                        </p>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <i class="fa-solid fa-heart text-red-400"></i>
                            <span>1 votes</span>
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