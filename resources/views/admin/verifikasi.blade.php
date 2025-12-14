@extends('layouts.app')

@section('title', 'Verifikasi & Penanganan')

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
                    <i class="fa-solid fa-check-circle text-blue-600 text-xl"></i>
                    <h1 class="text-xl font-bold text-gray-800">Verifikasi & Penanganan</h1>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all p-2 hover:bg-blue-50 rounded-lg group hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <div>
                <p class="text-sm text-gray-500">Kelola dan verifikasi laporan masyarakat yang masuk ke sistem</p>
            </div>

            {{-- Top Statistic Cards --}}
            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-blue-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-inbox text-blue-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-1">Total Laporan</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $totalReports ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-yellow-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-spinner text-yellow-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-1">Sedang Diproses</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $inProgress ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-green-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-1">Selesai</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $completed ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-red-400 hover:-translate-y-2 group cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fa-solid fa-bell text-red-600 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-1">Perlu Verifikasi</p>
                            <h2 class="text-3xl font-extrabold text-gray-900">{{ $waitingVerification ?? 0 }}</h2>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Reports Table --}}
            <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-blue-600"></i>
                            Daftar Laporan Baru
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Kelola dan verifikasi laporan masyarakat yang masuk ke sistem</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50">
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">ID Laporan</th>
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Pelapor</th>
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">Lokasi</th>
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports ?? [] as $report)
                            <tr class="border-b border-gray-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 group">
                                <td class="py-4 px-4">
                                    <span class="text-sm font-bold text-gray-900 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                        LP-2025-{{ str_pad($report->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($report->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ $report->user->name ?? 'Tidak Diketahui' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $categoryColors = [
                                            'Infrastruktur' => 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 border-blue-300',
                                            'Keamanan' => 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-700 border-yellow-300',
                                            'Sanitasi' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 border-green-300',
                                            'Taman' => 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-700 border-purple-300',
                                            'Aksesibilitas' => 'bg-gradient-to-r from-pink-100 to-pink-200 text-pink-700 border-pink-300',
                                        ];
                                        $categoryName = $report->category->name ?? 'Umum';
                                        $colorClass = $categoryColors[$categoryName] ?? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold {{ $colorClass }} rounded-full border-2 shadow-sm group-hover:scale-105 transition-transform">
                                        <i class="fa-solid fa-tag"></i>
                                        {{ $categoryName }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-1 text-sm text-gray-700">
                                        <i class="fa-solid fa-map-marker-alt text-red-500 text-xs"></i>
                                        <span class="truncate max-w-[200px]">{{ Str::limit($report->location ?? '-', 30) }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-1 text-sm text-gray-700">
                                        <i class="fa-solid fa-calendar text-blue-500 text-xs"></i>
                                        {{ $report->created_at ? $report->created_at->format('d/m/Y') : '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $statusColors = [
                                            'Baru' => 'bg-gradient-to-r from-emerald-100 to-green-200 text-emerald-700 border-emerald-300',
                                            'Dalam Pengerjaan' => 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border-gray-300',
                                            'Selesai' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 border-green-300',
                                            'Ditolak' => 'bg-gradient-to-r from-red-100 to-red-200 text-red-700 border-red-300',
                                        ];
                                        $statusLabels = [
                                            'Baru' => 'Menunggu Verifikasi',
                                            'Dalam Pengerjaan' => 'Valid - Diproses',
                                            'Selesai' => 'Selesai',
                                            'Ditolak' => 'Ditolak',
                                        ];
                                        $statusClass = $statusColors[$report->status] ?? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 border-gray-300';
                                        $statusLabel = $statusLabels[$report->status] ?? ucfirst($report->status);
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold {{ $statusClass }} rounded-full border-2 shadow-sm group-hover:scale-105 transition-transform">
                                        @if($report->status == 'Baru')
                                            <i class="fa-solid fa-clock"></i>
                                        @elseif($report->status == 'Dalam Pengerjaan')
                                            <i class="fa-solid fa-spinner"></i>
                                        @elseif($report->status == 'Selesai')
                                            <i class="fa-solid fa-check-circle"></i>
                                        @else
                                            <i class="fa-solid fa-times-circle"></i>
                                        @endif
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('admin.verifikasi.detail', $report->id) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-blue-600 bg-white border-2 border-blue-500 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg group-hover:scale-105">
                                        <i class="fa-solid fa-eye text-sm"></i> 
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-16 px-4">
                                    <div class="text-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-inbox text-5xl text-gray-400"></i>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-600">Belum ada laporan yang masuk</p>
                                        <p class="text-sm text-gray-500 mt-1">Laporan yang masuk akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
