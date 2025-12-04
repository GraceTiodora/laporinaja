@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- SIDEBAR -->
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            <nav class="space-y-2">
                @php
                    $adminMenu = [
                        ['Dashboard', 'admin.dashboard', 'fa-solid fa-chart-line'],
                        ['Verifikasi', 'admin.verifikasi', 'fa-solid fa-check-circle'],
                        ['Monitoring', 'admin.monitoring', 'fa-solid fa-signal'],
                        ['Voting Publik', 'admin.voting', 'fa-solid fa-poll'],
                        ['Pengaturan', 'admin.pengaturan', 'fa-solid fa-cog'],
                    ];
                @endphp

                @foreach($adminMenu as [$name, $route, $icon])
                    <a href="{{ route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all
                              {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-600' : 'hover:bg-blue-50 hover:text-blue-600' }}">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 text-red-600 hover:text-red-700 px-4 py-3 rounded-lg hover:bg-red-50 transition">
                <i class="fa-solid fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col">
        <!-- TOP BAR -->
        <header class="bg-white border-b border-gray-200 px-8 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">{{ session('user.name', 'Admin') }}</span>
                <img src="{{ asset('images/profile-user.jpg') }}" alt="Profile" class="w-10 h-10 rounded-full">
            </div>
        </header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
            <p class="text-gray-600 text-sm">Selamat datang di sistem manajemen laporan masyarakat</p>

            <!-- STATISTICS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Laporan Masuk</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">{{ $stats['total_reports'] ?? 0 }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fa-solid fa-file text-xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Sedang Diproses</p>
                            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] ?? 0 }}</p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <i class="fa-solid fa-clock text-xl text-yellow-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Selesai</p>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['resolved'] ?? 0 }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fa-solid fa-check-circle text-xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Perlu Verifikasi</p>
                            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $stats['in_progress'] ?? 0 }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="fa-solid fa-tasks text-xl text-purple-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total User</p>
                            <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $stats['total_users'] ?? 0 }}</p>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-lg">
                            <i class="fa-solid fa-users text-xl text-indigo-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT REPORTS -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-gray-600 font-semibold">Judul</th>
                                <th class="text-left py-3 px-4 text-gray-600 font-semibold">Pelapor</th>
                                <th class="text-left py-3 px-4 text-gray-600 font-semibold">Status</th>
                                <th class="text-left py-3 px-4 text-gray-600 font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReports ?? [] as $report)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ Str::limit($report->title, 30) }}</td>
                                    <td class="py-3 px-4">{{ $report->user->name ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs font-medium
                                            @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($report->status == 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($report->status == 'resolved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-500">{{ $report->created_at->format('d M Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 px-4 text-center text-gray-500">
                                        Belum ada laporan
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
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">

                <div>
                    <p class="text-sm font-semibold">Justin Hubner</p>
                    <p class="text-xs text-gray-500">@adminhubner</p>
                </div>
            </div>

            <form action="#" method="POST" class="mt-4">
                @csrf
                <button class="text-red-500 text-sm font-semibold hover:underline flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto">

        <h1 class="text-xl font-bold text-gray-800 mb-1">Dashboard</h1>
        <p class="text-sm text-gray-500 mb-6">Selamat datang di sistem manajemen laporan masyarakat</p>

        {{-- Top Statistic Cards --}}
        <div class="grid grid-cols-4 gap-6 mb-10">

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <p class="text-sm text-gray-500 mb-2">Laporan Masuk</p>
                <h2 class="text-3xl font-extrabold">156</h2>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <p class="text-sm text-gray-500 mb-2">Sedang Diproses</p>
                <h2 class="text-3xl font-extrabold">42</h2>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <p class="text-sm text-gray-500 mb-2">Selesai</p>
                <h2 class="text-3xl font-extrabold">98</h2>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <p class="text-sm text-gray-500 mb-2">Perlu Verifikasi</p>
                <h2 class="text-3xl font-extrabold">16</h2>
            </div>

        </div>

        {{-- Chart & Pie --}}
        <div class="grid grid-cols-2 gap-8 mb-10">
            
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <h3 class="font-semibold text-sm text-gray-700 mb-3">Status Penanganan Laporan</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <h3 class="font-semibold text-sm text-gray-700 mb-3">Laporan Berdasarkan Kategori</h3>
                <canvas id="kategoriChart"></canvas>
            </div>

        </div>

        {{-- New Reports Table --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">

            <h3 class="font-semibold text-sm text-gray-700 mb-4">Laporan Baru Perlu Verifikasi</h3>

            <div class="space-y-4">
                @foreach ([1,2,3] as $i)
                <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">LP-2025-15{{ $i }} <span class="text-xs text-gray-500">(Infrastruktur)</span></p>
                        <p class="text-sm text-gray-700">Jalan berlubang di Jl. Merdeka</p>
                        <p class="text-xs text-gray-500">Pelapor: Budi Santoso • 2 jam lalu</p>
                    </div>

                    <a href="#" class="px-3 py-1 rounded-lg border border-blue-600 text-blue-600 text-sm hover:bg-blue-50">
                        Lihat Detail
                    </a>
                </div>
                @endforeach
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
            labels: ['Masuk', 'Diproses', 'Selesai'],
            datasets: [{
                data: [156, 42, 98],
                backgroundColor: ['#93C5FD', '#FDE68A', '#86EFAC']
            }]
        }
    });

    new Chart(document.getElementById('kategoriChart'), {
        type: 'pie',
        data: {
            labels: ['Infrastruktur', 'Sosial', 'Aksesibilitas', 'Keamanan', 'Sampah'],
            datasets: [{
                data: [25, 21, 19, 24, 11],
                backgroundColor: ['#60A5FA','#F87171','#FBBF24','#34D399','#A78BFA']
            }]
        }
    });
</script>

@endsection
