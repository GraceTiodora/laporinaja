@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/monitoring.css') }}">
@endpush

@section('title', 'Monitoring & Statistik')

@section('content')
@php
    $reports = $reports ?? collect();
    $summary = $summary ?? ['total'=>'—','active'=>'—','closed_today'=>'—','avg_response'=>'—'];

    // Kategori & status konsisten dengan sisi warga
    $categories = [
        ['val' => 'all', 'label' => 'Semua Kategori'],
        ['val' => 'infrastruktur', 'label' => 'Infrastruktur'],
        ['val' => 'keselamatan', 'label' => 'Keselamatan'],
        ['val' => 'sanitasi', 'label' => 'Sanitasi'],
        ['val' => 'taman', 'label' => 'Taman & Ruang Publik'],
        ['val' => 'aksesibilitas', 'label' => 'Aksesibilitas'],
    ];
    $statuses = [
        ['val' => 'all', 'label' => 'Semua Status'],
        ['val' => 'open', 'label' => 'Belum Selesai'],
        ['val' => 'progress', 'label' => 'Dalam Pengerjaan'],
        ['val' => 'closed', 'label' => 'Selesai'],
    ];
@endphp

<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    {{-- SIDEBAR --}}
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>
            <nav class="space-y-2 text-sm">
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
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl 
                              {{ request()->routeIs($route) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}
                              hover:bg-blue-50 hover:text-blue-600 transition-all">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
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

    {{-- MAIN --}}
<<<<<<< Updated upstream
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800 mb-1">Monitoring & Statistik</h1>
            <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
=======
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 overflow-y-auto">
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-chart-line text-blue-600 text-xl"></i>
                    <h1 class="text-xl font-bold text-gray-800">Monitoring & Statistik</h1>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all p-2 hover:bg-blue-50 rounded-lg group hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <div>
                <p class="text-sm text-gray-500">Pantau performa dan statistik penanganan laporan masyarakat</p>
            </div>

            {{-- Trend chart --}}
            <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-blue-600"></i>
                    Tren Laporan per Bulan (2025)
                </h3>
                <div class="h-80">
                    <canvas id="trendChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Performance --}}
            <div class="grid md:grid-cols-1 gap-6">
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-chart-bar text-blue-600"></i>
                        Performa Penanganan per Kategori
                    </h3>
                    <div class="h-80">
                        <canvas id="kategoriChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-table text-blue-600"></i>
                        Ringkasan Kinerja Kategori
                    </h3>
                    <div class="category-table-wrapper overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b-2 border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50">
                                    <th class="text-left font-bold text-gray-700 py-4 px-4 uppercase tracking-wider text-xs">Kategori</th>
                                    <th class="text-center font-bold text-gray-700 py-4 px-4 uppercase tracking-wider text-xs">Total Laporan</th>
                                    <th class="text-center font-bold text-gray-700 py-4 px-4 uppercase tracking-wider text-xs">Selesai</th>
                                    <th class="text-center font-bold text-gray-700 py-4 px-4 uppercase tracking-wider text-xs">Persentase Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($categoryPerformance) && is_array($categoryPerformance) && count($categoryPerformance) > 0)
                                    @foreach($categoryPerformance as $cat)
                                    <tr class="border-b border-gray-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300">
                                        <td class="py-4 px-4 font-bold text-gray-900">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid fa-tag text-blue-500"></i>
                                                {{ $cat['kategori'] ?? 'N/A' }}
                                            </span>
                                            <div class="mt-1">
                                                {{-- Route detail tidak tersedia, bisa diarahkan ke halaman laporan dengan filter kategori --}}
                                                <a href="{{ route('admin.reports', ['category' => $cat['kategori'] ?? null]) }}" class="text-xs text-blue-600 hover:underline">Lihat detail laporan</a>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-1 bg-blue-100 text-blue-700 font-bold rounded-full text-xs">
                                                {{ $cat['total'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-1 bg-green-100 text-green-700 font-bold rounded-full text-xs">
                                                {{ $cat['selesai'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full transition-all" style="width: {{ $cat['persentase'] ?? 0 }}%"></div>
                                                </div>
                                                <span class="font-bold text-gray-700">{{ $cat['persentase'] ?? 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="py-12 px-4 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <i class="fa-solid fa-inbox text-5xl text-gray-300"></i>
                                            <p class="text-gray-500 font-medium">Belum ada data</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Unduh PDF Button - Bottom Right of Table --}}
                    <div class="flex justify-end mt-6">
                        <form method="GET" action="{{ route('admin.monitoring.pdf') }}" target="_blank">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:animate-bounce">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                <span>Unduh PDF</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

>>>>>>> Stashed changes
        </div>

        {{-- Trend chart --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-8">
            <h3 class="text-base font-bold text-gray-900 mb-5">Tren Laporan per Bulan (2025)</h3>
            <div class="h-80">
                <canvas id="trendChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- Performance --}}
        <div class="grid md:grid-cols-1 gap-6 mb-8">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5">Performa Penanganan per Kategori</h3>
                <div class="h-80">
                    <canvas id="kategoriChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5">Ringkasan Kinerja Kategori</h3>
                <div class="category-table-wrapper overflow-x-auto">
                    <table class="category-table w-full text-sm">
                        <thead>
                            <tr>
                                <th class="text-left font-bold text-gray-900 py-3 px-4">Kategori</th>
                                <th class="text-center font-bold text-gray-900 py-3 px-4">Total Laporan</th>
                                <th class="text-center font-bold text-gray-900 py-3 px-4">Selesai</th>
                                <th class="text-center font-bold text-gray-900 py-3 px-4">Persentase Selesai</th>
                                <th class="text-center font-bold text-gray-900 py-3 px-4">Rata-rata Waktu (hari)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-4 font-medium text-gray-900">Infrastruktur</td>
                                <td class="py-3 px-4 text-center text-gray-700">145</td>
                                <td class="py-3 px-4 text-center text-gray-700">98</td>
                                <td class="py-3 px-4 text-center text-gray-700">68%</td>
                                <td class="py-3 px-4 text-center text-gray-700">5 Hari</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-4 font-medium text-gray-900">Keselamatan</td>
                                <td class="py-3 px-4 text-center text-gray-700">123</td>
                                <td class="py-3 px-4 text-center text-gray-700">89</td>
                                <td class="py-3 px-4 text-center text-gray-700">89%</td>
                                <td class="py-3 px-4 text-center text-gray-700">4 Hari</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-4 font-medium text-gray-900">Sanitasi</td>
                                <td class="py-3 px-4 text-center text-gray-700">98</td>
                                <td class="py-3 px-4 text-center text-gray-700">76</td>
                                <td class="py-3 px-4 text-center text-gray-700">76%</td>
                                <td class="py-3 px-4 text-center text-gray-700">3 Hari</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 px-4 font-medium text-gray-900">Taman</td>
                                <td class="py-3 px-4 text-center text-gray-700">76</td>
                                <td class="py-3 px-4 text-center text-gray-700">58</td>
                                <td class="py-3 px-4 text-center text-gray-700">76%</td>
                                <td class="py-3 px-4 text-center text-gray-700">6 Hari</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-medium text-gray-900">Aksesibilitas</td>
                                <td class="py-3 px-4 text-center text-gray-700">54</td>
                                <td class="py-3 px-4 text-center text-gray-700">38</td>
                                <td class="py-3 px-4 text-center text-gray-700">70%</td>
                                <td class="py-3 px-4 text-center text-gray-700">7 Hari</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                {{-- Unduh PDF Button - Bottom Right of Table --}}
                <div class="flex justify-end mt-6">
                    <a href="#" class="unduh-pdf-btn flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl hover:scale-105">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        <span>Unduh PDF</span>
                    </a>
                </div>
            </div>
        </div>

    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
<<<<<<< Updated upstream
=======
  // Prepare real data from controller
    @php
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $trendData = collect($trenData ?? []);
        $categoryData = collect($categoryPerformance ?? []);
        // Trend data untuk chart
        $trendTotalData = [];
        $trendSelesaiData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $trendData->where('bulan', $i)->first();
            $trendTotalData[] = $monthData['total'] ?? 0;
            $trendSelesaiData[] = $monthData['selesai'] ?? 0;
        }
        // Category data
        $categoryLabels = $categoryData->pluck('kategori')->toArray();
        $categoryTotalData = $categoryData->pluck('total')->toArray();
        $categorySelesaiData = $categoryData->pluck('selesai')->toArray();
    @endphp

>>>>>>> Stashed changes
  // Trend chart
  const trendCtx = document.getElementById('trendChart')?.getContext('2d');
  if(trendCtx) {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
          { label: 'Diproses', borderColor: '#fbbf24', backgroundColor: '#fbbf24', data: [7,7,7,8,7,7,7,7,7,7,7,7], borderWidth: 3, pointRadius: 5, pointHoverRadius: 7, tension: 0.4 },
          { label: 'Selesai', borderColor: '#10b981', backgroundColor: '#10b981', data: [38,46,42,53,47,50,54,52,60,35,33,30], borderWidth: 3, pointRadius: 5, pointHoverRadius: 7, tension: 0.4 },
          { label: 'Total Laporan', borderColor: '#3b82f6', backgroundColor: '#3b82f6', data: [45,52,48,61,55,58,62,59,68,42,40,38], borderWidth: 3, pointRadius: 5, pointHoverRadius: 7, tension: 0.4 },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true, padding: 20, font: { size: 13, weight: '600' } }
          }
        },
        scales: {
          y: { beginAtZero: true, max: 80, ticks: { stepSize: 20, font: { size: 12 } }, grid: { color: '#f1f5f9', drawBorder: false } },
          x: { ticks: { font: { size: 12 } }, grid: { display: false, drawBorder: false } }
        },
        interaction: { mode: 'index', intersect: false }
      }
    });
  }

  // Category chart
  const kategoriCtx = document.getElementById('kategoriChart')?.getContext('2d');
  if(kategoriCtx) {
    new Chart(kategoriCtx, {
      type: 'bar',
      data: {
        labels: ['Infrastruktur','Keselamatan','Sanitasi','Taman & Ruang Publik','Aksesibilitas'],
        datasets: [
          { label: 'Selesai', backgroundColor: '#10b981', data: [98,89,76,58,38], borderRadius: 6, barPercentage: 0.7 },
          { label: 'Total Laporan', backgroundColor: '#93c5fd', data: [145,123,98,76,54], borderRadius: 6, barPercentage: 0.7 },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 13, weight: '600' } } }
        },
        scales: {
          y: { beginAtZero: true, max: 160, ticks: { stepSize: 40, font: { size: 12 } }, grid: { color: '#f1f5f9', drawBorder: false } },
          x: { ticks: { font: { size: 11 } }, grid: { display: false, drawBorder: false } }
        }
      }
    });
  }
</script>
@endpush
@endsection