@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/homepage.auth.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    {{-- SIDEBAR --}}
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Dashboard', 'admin.dashboard', 'fa-solid fa-house'],
                        ['Verifikasi & Penanganan', 'admin.verifikasi', 'fa-solid fa-check-circle'],
                        ['Monitoring & Statistik', 'admin.monitoring', 'fa-solid fa-chart-line'],
                        ['Voting Publik', 'admin.voting', 'fa-solid fa-vote-yea'],
                        ['Pengaturan Akun', 'admin.pengaturan', 'fa-solid fa-gear'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ route($route) }}"
                       class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                              {{ request()->routeIs($route) ? 'active bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}
                              hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Profile --}}
        <div>
            <a href="{{ route('admin.pengaturan') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 hover:border-blue-400 bg-white hover:bg-blue-50 transition-all cursor-pointer mb-3 group ring-2 ring-gray-200 hover:ring-blue-400">
                <div class="relative">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-user.jpg') }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-white group-hover:ring-blue-300 transition-all">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Admin</p>
                </div>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 transition-all duration-300 group border-2 border-red-200 hover:border-red-400 hover:shadow-lg transform hover:scale-105">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 overflow-y-auto">

        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-house text-blue-600 text-xl"></i>
                    <h1 class="text-xl font-bold text-gray-800">Dashboard Admin</h1>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all p-2 hover:bg-blue-50 rounded-lg group hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <div>
                <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
            </div>

            {{-- Top Statistic Cards --}}
            <div class="grid grid-cols-4 gap-6">

                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-blue-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-inbox text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Laporan</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $stats['total_reports'] ?? 0 }}</h2>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-yellow-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-spinner text-yellow-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Sedang Diproses</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $stats['in_progress'] ?? 0 }}</h2>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-green-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Selesai</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $stats['completed'] ?? 0 }}</h2>
                        </div>
                    </div>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-red-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-bell text-red-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Perlu Verifikasi</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $stats['new_reports'] ?? 0 }}</h2>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Chart & Pie --}}
            <div class="grid grid-cols-2 gap-6">
                
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-base text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-chart-bar text-blue-500"></i>
                            Status Penanganan Laporan
                        </h3>
                    </div>
                    <canvas id="statusChart"></canvas>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-base text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-blue-500"></i>
                            Laporan Berdasarkan Kategori
                        </h3>
                    </div>
                    <canvas id="kategoriChart"></canvas>
                </div>

            </div>

            {{-- New Reports Table --}}
            <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300">

                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-blue-600 text-xl"></i>
                        <h3 class="font-bold text-lg text-gray-900">Laporan Terbaru</h3>
                    </div>
                    <span class="px-4 py-2 bg-gradient-to-r from-red-100 to-rose-100 text-red-700 text-sm font-bold rounded-full border-2 border-red-200 shadow-sm">
                        <i class="fa-solid fa-bell animate-pulse"></i> {{ $stats['new_reports'] ?? 0 }} Perlu Verifikasi
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse ($recentReports as $report)
                    <article class="bg-gradient-to-br from-slate-50 to-gray-50 border-2 border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-xl transition-all duration-500 hover:border-blue-400 hover:-translate-y-1 group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-100 to-orange-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                    @if($report->status == 'Baru')
                                        <i class="fa-solid fa-exclamation-triangle text-orange-600 text-xl"></i>
                                    @elseif($report->status == 'Dalam Pengerjaan')
                                        <i class="fa-solid fa-sync text-blue-600 text-xl"></i>
                                    @elseif($report->status == 'Selesai')
                                        <i class="fa-solid fa-check-circle text-green-600 text-xl"></i>
                                    @else
                                        <i class="fa-solid fa-times-circle text-red-600 text-xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full border border-blue-200">
                                            #{{ $report->id }}
                                        </span>
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full border border-purple-200">
                                            <i class="fa-solid fa-tag"></i> {{ $report->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </div>
                                    <p class="font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                        {{ Str::limit($report->title, 60) }}
                                    </p>
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fa-solid fa-user text-gray-400"></i> 
                                            <span class="font-medium">{{ $report->user->name ?? 'Unknown' }}</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fa-solid fa-clock text-gray-400"></i> 
                                            <span>{{ $report->created_at->diffForHumans() }}</span>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fa-solid fa-map-marker-alt text-gray-400"></i> 
                                            <span>{{ Str::limit($report->location ?? 'Tidak ada lokasi', 20) }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.verifikasi.detail', $report->id) }}" 
                               class="flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-blue-500 bg-white text-blue-600 font-bold text-sm hover:bg-blue-600 hover:text-white transition-all duration-300 group-hover:scale-105 shadow-sm hover:shadow-lg whitespace-nowrap">
                                <span>Lihat Detail</span>
                                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                    @empty
                    <div class="text-center py-16 text-gray-500">
                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-inbox text-5xl text-gray-400"></i>
                        </div>
                        <p class="text-lg font-semibold text-gray-600">Tidak ada laporan</p>
                        <p class="text-sm text-gray-500 mt-1">Belum ada laporan yang masuk saat ini</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>
</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: ['Baru', 'Dalam Pengerjaan', 'Selesai', 'Ditolak'],
            datasets: [{
                label: 'Jumlah Laporan',
                data: [{{ $stats['new_reports'] ?? 0 }}, {{ $stats['in_progress'] ?? 0 }}, {{ $stats['completed'] ?? 0 }}, {{ $stats['rejected'] ?? 0 }}],
                backgroundColor: ['#93C5FD', '#FDE68A', '#86EFAC', '#FCA5A5']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    new Chart(document.getElementById('kategoriChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryStats->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($categoryStats->pluck('reports_count')) !!},
                backgroundColor: ['#60A5FA','#F87171','#FBBF24','#34D399','#A78BFA','#FB923C','#EC4899']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection
