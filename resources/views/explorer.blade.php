@extends('layouts.app')

@section('title', 'Explore - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
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
                    <i class="fa-solid fa-plus-circle"></i> Laporan Baru
                </button>
            @else
                <button onclick="window.location.href='{{ route('login') }}'"
                        class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold">
                    <i class="fa-solid fa-plus-circle"></i> Laporan Baru
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
                </div>
            @endif
        </div>
    </aside>

    <!-- 📰 Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white">
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-bold text-gray-800">Pencarian</h1>
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
                    </button>
                    <div id="locationDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2 space-y-1">
                            @foreach(['Lumban Hariara', 'Panasala', 'Patujulu', 'Puba Lubis', 'Puntu Manda', 'Silalahi', 'Simuring'] as $loc)
                                <button onclick="filterByLocation('{{ $loc }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $loc }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="relative">
                    <button onclick="toggleDropdown('categoryDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-tag text-gray-500"></i>
                        <span>Category</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    <div id="categoryDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2 space-y-1">
                            @php
                                $categories = App\Models\Category::all();
                            @endphp
                            @foreach($categories as $cat)
                                <button onclick="filterByCategory('{{ $cat->name }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $cat->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="relative">
                    <button onclick="toggleDropdown('statusDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-circle-check text-gray-500"></i>
                        <span>Status</span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    <div id="statusDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2 space-y-1">
                            @foreach(['Baru', 'Dalam Pengerjaan', 'Selesai'] as $status)
                                <button onclick="filterByStatus('{{ $status }}')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $status }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-filter text-gray-500"></i>
                    <span>More Filters</span>
                </button>
            </div>

            <!-- Trending Reports -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-fire text-orange-500"></i> Trending Reports
                </h2>

                <div class="space-y-4" id="reportsList">
                    @forelse($reports as $report)
                        <a href="{{ route('reports.show', $report['id']) }}" class="block no-underline">
                            <article class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 report-card cursor-pointer"
                                 data-location="{{ $report['location'] ?? '' }}"
                                 data-category="{{ $report['category'] ?? '' }}"
                                 data-status="{{ $report['status'] ?? '' }}">
                                
                                @if($report['image'])
                                    <img src="{{ $report['image'] }}" alt="{{ $report['title'] }}" class="w-full h-48 object-cover">
                                @endif
                                 
                                <div class="p-4">
                                    <h3 class="text-base font-semibold text-gray-800 mb-2 hover:text-blue-600">{{ $report['title'] ?? '' }}</h3>

                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                                    <span>{{ $report['location'] ?? '—' }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="fa-solid fa-heart text-red-500"></i>
                                    <span>{{ $report['votes'] ?? 0 }} votes</span>
                                </div>

                                <div class="flex gap-2 mb-3 flex-wrap">
                                    <span class="px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">{{ $report['status'] ?? '' }}</span>
                                    @php
                                        $categoryColors = [
                                            'Infrastruktur' => 'bg-blue-100 text-blue-700',
                                            'Keamanan' => 'bg-red-100 text-red-700',
                                            'Sanitasi' => 'bg-purple-100 text-purple-700',
                                            'Taman' => 'bg-green-100 text-green-700',
                                            'Aksesibilitas' => 'bg-yellow-100 text-yellow-700',
                                        ];
                                        $categoryClass = $categoryColors[$report['category']] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium {{ $categoryClass }} rounded-full">{{ $report['category'] ?? 'Umum' }}</span>
                                </div>

                                @if(!empty($report['description']))
                                    <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">{{ Str::limit($report['description'], 150) }}</p>
                                @endif

                                <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-3 mt-3">
                                    <div class="flex gap-4">
                                        <button class="hover:text-blue-600 transition"><i class="fa-regular fa-comment"></i> {{ $report['comments'] ?? 0 }}</button>
                                        <button class="hover:text-red-500 transition"><i class="fa-solid fa-heart"></i> {{ $report['votes'] ?? 0 }}</button>
                                    </div>
                                    <a href="{{ route('reports.show', $report['id']) }}" class="text-xs text-blue-600 hover:underline">Lihat detail</a>
                                </div>
                            </div>
                        </article>
                        </a>
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
    <aside class="w-[340px] bg-white p-6 overflow-y-auto">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Penting
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
                    <span class="px-3 py-1 rounded-xl text-xs bg-pink-100 text-pink-700 font-medium">Penting</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700 font-medium">Sedang</span>
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