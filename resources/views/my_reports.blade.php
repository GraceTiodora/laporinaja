@extends('layouts.app')

@section('title', 'My Reports - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/my-reports.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    <!-- 🧭 LEFT SIDEBAR -->
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

        <!-- Profile Bottom -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-hidden border-r border-gray-200 bg-white">

        <!-- Header -->
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-5 z-10">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-14 h-14 rounded-full object-cover ring-4 ring-blue-50 shadow-md">
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Laporan Saya</h1>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <i class="fa-solid fa-user text-xs"></i>
                            {{ session('user.name', 'Guest') }}
                        </p>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-2xl"></i>
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                @php
                    $totalReports = count($reports);
                    $baruCount = $reports->where('status', 'Baru')->count();
                    $diprosesCount = $reports->where('status', 'Diproses')->count();
                    $selesaiCount = $reports->where('status', 'Selesai')->count();
                @endphp
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-blue-600 mb-1">Total</p>
                            <h3 class="text-2xl font-bold text-blue-700">{{ $totalReports }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-clipboard-list text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 rounded-xl border border-yellow-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-yellow-600 mb-1">Baru</p>
                            <h3 class="text-2xl font-bold text-yellow-700">{{ $baruCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-exclamation text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-xl border border-orange-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-orange-600 mb-1">Diproses</p>
                            <h3 class="text-2xl font-bold text-orange-700">{{ $diprosesCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-spinner text-white text-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-green-600 mb-1">Selesai</p>
                            <h3 class="text-2xl font-bold text-green-700">{{ $selesaiCount }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-check text-white text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex items-center gap-3 overflow-x-auto pb-2" id="statusFilter">
                <button onclick="filterReports('semua')" class="filter-btn active px-5 py-2.5 rounded-full font-semibold text-sm whitespace-nowrap transition-all">
                    <i class="fa-solid fa-list mr-2"></i>Semua
                </button>
                <button onclick="filterReports('Baru')" class="filter-btn px-5 py-2.5 rounded-full font-semibold text-sm whitespace-nowrap transition-all">
                    <i class="fa-solid fa-circle-dot mr-2"></i>Baru
                </button>
                <button onclick="filterReports('Diproses')" class="filter-btn px-5 py-2.5 rounded-full font-semibold text-sm whitespace-nowrap transition-all">
                    <i class="fa-solid fa-clock mr-2"></i>Diproses
                </button>
                <button onclick="filterReports('Selesai')" class="filter-btn px-5 py-2.5 rounded-full font-semibold text-sm whitespace-nowrap transition-all">
                    <i class="fa-solid fa-check-circle mr-2"></i>Selesai
                </button>
                <button onclick="filterReports('Ditolak')" class="filter-btn px-5 py-2.5 rounded-full font-semibold text-sm whitespace-nowrap transition-all">
                    <i class="fa-solid fa-times-circle mr-2"></i>Ditolak
                </button>
            </div>
        </header>

        <!-- REPORT LIST -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4" id="reportList">
            @forelse ($reports as $r)
                <article class="report-item bg-white rounded-2xl border-2 border-gray-100 shadow-sm hover:shadow-2xl hover:border-blue-300 transition-all duration-500 overflow-hidden group cursor-pointer transform hover:-translate-y-1"
                         data-status="{{ $r->status ?? 'Baru' }}"
                         onclick="window.location.href='{{ route('reports.show', $r->id) }}'">
                    
                    <div class="flex {{ $r->image ? '' : 'flex-col' }} relative">
                        <!-- Ribbon Status -->
                        @php
                            $ribbonColors = [
                                'Baru' => 'bg-gradient-to-r from-blue-500 to-blue-600',
                                'Diproses' => 'bg-gradient-to-r from-yellow-500 to-orange-500',
                                'Selesai' => 'bg-gradient-to-r from-green-500 to-emerald-600',
                                'Ditolak' => 'bg-gradient-to-r from-red-500 to-rose-600',
                            ];
                            $ribbonClass = $ribbonColors[$r->status ?? 'Baru'] ?? 'bg-gradient-to-r from-gray-500 to-gray-600';
                        @endphp
                        <div class="absolute top-4 right-4 {{ $ribbonClass }} text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-lg z-10 flex items-center gap-1.5">
                            @if($r->status == 'Baru')
                                <i class="fa-solid fa-sparkles"></i>
                            @elseif($r->status == 'Diproses')
                                <i class="fa-solid fa-sync animate-spin"></i>
                            @elseif($r->status == 'Selesai')
                                <i class="fa-solid fa-check-double"></i>
                            @else
                                <i class="fa-solid fa-times"></i>
                            @endif
                            {{ $r->status ?? 'Baru' }}
                        </div>

                        @if($r->image)
                            <div class="w-56 h-56 flex-shrink-0 relative overflow-hidden">
                                <img src="{{ asset($r->image) }}" alt="{{ $r->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @endif

                        <div class="flex-1 p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-2 pr-4">
                                    {{ $r->title }}
                                </h3>
                            </div>

                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-2 bg-red-50 px-3 py-1.5 rounded-lg">
                                    <i class="fa-solid fa-location-dot text-red-500"></i>
                                    <span class="font-semibold text-red-700">{{ $r->location }}</span>
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-blue-400"></i>
                                    <span class="font-medium">{{ $r->created_at->diffForHumans() }}</span>
                                </span>
                            </div>

                            <div class="flex gap-2 mb-5">
                                @php
                                    $categoryColors = [
                                        'Infrastruktur' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-blue-200',
                                        'Keamanan' => 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-red-200',
                                        'Sanitasi' => 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-purple-200',
                                        'Taman' => 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-green-200',
                                        'Aksesibilitas' => 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-yellow-200',
                                    ];
                                    $categoryClass = $categoryColors[$r->category->name] ?? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-gray-200';
                                @endphp
                                <span class="px-4 py-1.5 text-sm rounded-full {{ $categoryClass }} font-bold shadow-lg hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-tag mr-1"></i>{{ $r->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            <!-- Interactive Stats -->
                            <div class="flex items-center gap-6 pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-sm hover:bg-yellow-50 px-3 py-2 rounded-lg transition-all group/stat cursor-pointer">
                                    <div class="relative">
                                        <i class="fa-solid fa-star text-yellow-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-400 rounded-full animate-ping"></span>
                                    </div>
                                    <span class="font-bold text-gray-700">{{ $r->votes_count ?? 0 }}</span>
                                    <span class="text-gray-500 font-medium">votes</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm hover:bg-blue-50 px-3 py-2 rounded-lg transition-all group/stat cursor-pointer">
                                    <i class="fa-solid fa-comments text-blue-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                    <span class="font-bold text-gray-700">{{ $r->comments_count ?? 0 }}</span>
                                    <span class="text-gray-500 font-medium">komentar</span>
                                </div>
                                @if($r->solutions_count ?? 0 > 0)
                                <div class="flex items-center gap-2 text-sm hover:bg-green-50 px-3 py-2 rounded-lg transition-all group/stat cursor-pointer">
                                    <i class="fa-solid fa-lightbulb text-green-500 text-lg group-hover/stat:scale-125 group-hover/stat:rotate-12 transition-all"></i>
                                    <span class="font-bold text-gray-700">{{ $r->solutions_count }}</span>
                                    <span class="text-gray-500 font-medium">solusi</span>
                                </div>
                                @endif
                            </div>

                            <!-- Progress Bar (for Diproses status) -->
                            @if($r->status == 'Diproses')
                            <div class="mt-4 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-full rounded-full animate-pulse" style="width: 60%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-hourglass-half"></i>
                                Sedang dalam proses penanganan...
                            </p>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-24">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 mb-6 animate-bounce">
                        <i class="fa-regular fa-clipboard text-5xl text-blue-500"></i>
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

<script>
// Filter Reports by Status
function filterReports(status) {
    const reports = document.querySelectorAll('.report-item');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('.filter-btn').classList.add('active');
    
    // Filter reports with animation
    reports.forEach((report, index) => {
        const reportStatus = report.getAttribute('data-status');
        
        if (status === 'semua' || reportStatus === status) {
            setTimeout(() => {
                report.style.display = 'block';
                report.style.animation = 'slideInUp 0.5s ease forwards';
            }, index * 50);
        } else {
            report.style.animation = 'slideOutDown 0.3s ease forwards';
            setTimeout(() => {
                report.style.display = 'none';
            }, 300);
        }
    });
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideOutDown {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(20px);
        }
    }
    
    .filter-btn {
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
    }
    
    .filter-btn:hover {
        background: #f9fafb;
        color: #3b82f6;
        border-color: #3b82f6;
        transform: translateY(-2px);
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
`;
document.head.appendChild(style);
</script>
@endsection
