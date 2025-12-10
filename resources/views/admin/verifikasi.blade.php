@extends('layouts.app')

@section('title', 'Verifikasi & Penanganan')

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR --}}
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        
        <div>
            <h2 class="text-xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2 text-sm">
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
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl 
                              {{ request()->routeIs($route) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}
                              hover:bg-blue-50 hover:text-blue-600 transition-all">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Profile --}}
        <div class="mt-6 border-t border-gray-200 pt-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">

                <div>
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">@{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</p>
                </div>
            </div>

            <form action="#" method="POST">
                @csrf
                <button class="text-red-500 text-sm font-semibold hover:underline flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800 mb-2">Verifikasi & Penanganan</h1>
            <p class="text-sm text-gray-600">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Top Statistic Cards --}}
        <div class="grid grid-cols-3 gap-6 mb-8">

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Menunggu Verifikasi</p>
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-file-lines text-blue-600 text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">4</h2>
                <p class="text-xs text-gray-500">Laporan baru yang perlu ditinjau</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Sedang Diproses</p>
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">1</h2>
                <p class="text-xs text-gray-500">Laporan yang valid dan sedang ditangani</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Total Hari Ini</p>
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">5</h2>
                <p class="text-xs text-gray-500">Laporan yang masuk hari ini</p>
            </div>

        </div>

        {{-- Reports Table --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">

            <h3 class="font-bold text-base text-gray-900 mb-1">Daftar Laporan Baru</h3>
            <p class="text-sm text-gray-600 mb-6">Kelola dan verifikasi laporan masyarakat yang masuk ke sistem</p>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">ID Laporan</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Nama Pelapor</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Kategori</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Lokasi</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Tanggal</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports ?? [] as $report)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4 text-sm font-semibold text-gray-900">LP-2025-{{ str_pad($report->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-4 text-sm text-gray-700">{{ $report->user->name ?? 'Tidak Diketahui' }}</td>
                            <td class="py-4 px-4">
                                @php
                                    $categoryColors = [
                                        'Infrastruktur' => 'bg-blue-100 text-blue-700',
                                        'Safety' => 'bg-yellow-100 text-yellow-700',
                                        'Sanitasi' => 'bg-green-100 text-green-700',
                                        'Taman' => 'bg-purple-100 text-purple-700',
                                        'Aksesibilitas' => 'bg-pink-100 text-pink-700',
                                    ];
                                    $categoryName = $report->category->name ?? 'Umum';
                                    $colorClass = $categoryColors[$categoryName] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-block px-3 py-1 text-xs font-medium {{ $colorClass }} rounded-full">{{ $categoryName }}</span>
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-700">{{ $report->location ?? '-' }}</td>
                            <td class="py-4 px-4 text-sm text-gray-700">{{ $report->created_at ? $report->created_at->format('d/m/Y') : '-' }}</td>
                            <td class="py-4 px-4">
                                @php
                                    $statusColors = [
                                        'Baru' => 'bg-emerald-100 text-emerald-700',
                                        'Dalam Pengerjaan' => 'bg-gray-100 text-gray-700',
                                        'Selesai' => 'bg-green-100 text-green-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusLabels = [
                                        'Baru' => 'Menunggu Verifikasi',
                                        'Dalam Pengerjaan' => 'Valid - Diproses',
                                        'Selesai' => 'Selesai',
                                        'Ditolak' => 'Ditolak',
                                    ];
                                    $statusClass = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700';
                                    $statusLabel = $statusLabels[$report->status] ?? ucfirst($report->status);
                                @endphp
                                <span class="inline-block px-3 py-1 text-xs font-medium {{ $statusClass }} rounded-full">{{ $statusLabel }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <a href="{{ route('admin.verifikasi.detail', $report->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                    <i class="fa-solid fa-eye text-sm"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-sm text-gray-500">
                                Belum ada laporan yang masuk
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</div>
@endsection
