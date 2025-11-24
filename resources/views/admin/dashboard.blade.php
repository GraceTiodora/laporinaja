@extends('layouts.app') 
{{-- Jika kamu ingin layout khusus admin, nanti kita buatkan. tetapi untuk sementara pakai layout umum --}}

@section('title', 'Admin Dashboard')

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