@extends('layouts.app')

@section('title', 'Explore - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/explore.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto">
    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-200 p-5 flex flex-col overflow-y-auto sidebar-scroll">
        <div class="mb-7">
            <h2 class="text-2xl font-bold text-blue-500">LaporinAja</h2>
        </div>
        
        <nav class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">🏠</span>
                <span class="nav-text leading-none">Home</span>
            </a>
            <a href="{{ route('explore') }}" class="nav-item active flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
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
        
        @if(session('user'))
            <button onclick="window.location.href='{{ route('reports.create') }}'" class="mt-5 bg-blue-500 text-white border-none px-6 py-3.5 rounded-3xl text-base font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600 btn-new-report">
                <span class="btn-text">+ New Report</span>
            </button>
        @else
            <button onclick="window.location.href='{{ route('login') }}'" class="mt-5 bg-blue-500 text-white border-none px-6 py-3.5 rounded-3xl text-base font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600 btn-new-report">
                <span class="btn-text">+ New Report</span>
            </button>
        @endif
        
        <div class="mt-auto pt-5 border-t border-gray-200 flex items-center gap-3">
            @if(session('user'))
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1 user-info">
                    <p class="font-semibold text-sm text-gray-800">{{ session('user.name') }}</p>
                    <p class="text-[13px] text-gray-500">@{{ session('user.username') }}</p>
                </div>
            @else
                <img src="{{ asset('images/profile-user.jpg') }}" alt="User" class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1 user-info">
                    <p class="font-semibold text-sm text-gray-800">User</p>
                    <p class="text-[13px] text-gray-500">username</p>
                </div>
            @endif
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden border-r border-gray-200">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-900">Explore</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-6 bg-gray-50 feed-scroll">
            <!-- Search Bar -->
            <div class="mb-6">
                <input type="text" 
                    id="searchInput"
                    placeholder="Search for issues, locations, or keywords.." 
                    class="w-full px-6 py-4 bg-white border border-gray-200 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-3 mb-6">
                <!-- Location Filter -->
                <div class="relative">
                    <button onclick="toggleDropdown('locationDropdown')" class="flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl text-base text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <span>Location</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div id="locationDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2">
                            <button onclick="filterByLocation('Downtown')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Downtown</button>
                            <button onclick="filterByLocation('Westside')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Westside</button>
                            <button onclick="filterByLocation('Eastside')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Eastside</button>
                            <button onclick="filterByLocation('Northside')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Northside</button>
                        </div>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="relative">
                    <button onclick="toggleDropdown('categoryDropdown')" class="flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl text-base text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <span>Category</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div id="categoryDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2">
                            <button onclick="filterByCategory('Infrastructure')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Infrastructure</button>
                            <button onclick="filterByCategory('Safety')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Safety</button>
                            <button onclick="filterByCategory('Sanitation')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Sanitation</button>
                            <button onclick="filterByCategory('Parks')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Parks</button>
                            <button onclick="filterByCategory('Accessibility')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Accessibility</button>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative">
                    <button onclick="toggleDropdown('statusDropdown')" class="flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 rounded-xl text-base text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <span>Status</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div id="statusDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                        <div class="p-2">
                            <button onclick="filterByStatus('New')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">New</button>
                            <button onclick="filterByStatus('In Progress')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">In Progress</button>
                            <button onclick="filterByStatus('Resolved')" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">Resolved</button>
                        </div>
                    </div>
                </div>

                <!-- More Filters -->
                <button class="px-5 py-3 bg-white border border-gray-200 rounded-xl text-base text-gray-700 hover:bg-gray-50 transition shadow-sm">
                    More Filters
                </button>
            </div>

            <!-- Trending Reports Section -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
                    </svg>
                    Trending Reports
                </h2>

                <div class="space-y-4" id="reportsList">
                    <!-- Report Card 1 -->
                    <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition report-card" data-location="Jl. Melati" data-category="Infrastruktur" data-status="New">
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Jalan Berlubang Besar Dekat Sekolah...</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Jl. Melati</span>
                            <span class="mx-2">•</span>
                            <span>45 votes</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">New</span>
                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full border border-gray-300">Infrastruktur</span>
                        </div>
                    </div>

                    <!-- Report Card 2 -->
                    <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition report-card" data-location="Jl. Gunung Kelud" data-category="Aksesibilitas" data-status="New">
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Jembatan Rusak di Persimpangan Pasar</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Jl. Gunung Kelud</span>
                            <span class="mx-2">•</span>
                            <span>25 votes</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-full">New</span>
                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full border border-gray-300">Aksesibilitas</span>
                        </div>
                    </div>
                </div>
            </div>
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

<script>
// Toggle Dropdown
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('[id$="Dropdown"]');
    
    allDropdowns.forEach(d => {
        if (d.id !== id) {
            d.classList.add('hidden');
        }
    });
    
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const isDropdownButton = event.target.closest('button[onclick^="toggleDropdown"]');
    if (!isDropdownButton) {
        document.querySelectorAll('[id$="Dropdown"]').forEach(d => d.classList.add('hidden'));
    }
});

// Filter Functions
function filterByLocation(location) {
    console.log('Filter by location:', location);
    const cards = document.querySelectorAll('.report-card');
    cards.forEach(card => {
        if (card.dataset.location.includes(location)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    toggleDropdown('locationDropdown');
}

function filterByCategory(category) {
    console.log('Filter by category:', category);
    const cards = document.querySelectorAll('.report-card');
    cards.forEach(card => {
        if (card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    toggleDropdown('categoryDropdown');
}

function filterByStatus(status) {
    console.log('Filter by status:', status);
    const cards = document.querySelectorAll('.report-card');
    cards.forEach(card => {
        if (card.dataset.status === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    toggleDropdown('statusDropdown');
}

// Search Function
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.report-card');
    
    cards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const location = card.dataset.location.toLowerCase();
        
        if (title.includes(searchTerm) || location.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection