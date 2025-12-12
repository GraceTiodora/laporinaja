@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/homepage.auth.css') }}">
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

<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">
    {{-- SIDEBAR --}}
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>
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

    {{-- MAIN --}}
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
                        <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:animate-bounce">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            <span>Unduh PDF</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
  // Prepare real data from controller
  @php
    $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $trendData = $trenData ?? collect();
    $categoryData = $categoryPerformance ?? collect();
    
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

  // Trend chart
  const trendCtx = document.getElementById('trendChart')?.getContext('2d');
  if(trendCtx) {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: {!! json_encode($months) !!},
        datasets: [
          { label: 'Selesai', borderColor: '#10b981', backgroundColor: '#10b981', data: {!! json_encode($trendSelesaiData) !!}, borderWidth: 3, pointRadius: 5, pointHoverRadius: 7, tension: 0.4 },
          { label: 'Total Laporan', borderColor: '#3b82f6', backgroundColor: '#3b82f6', data: {!! json_encode($trendTotalData) !!}, borderWidth: 3, pointRadius: 5, pointHoverRadius: 7, tension: 0.4 },
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
          y: { beginAtZero: true, ticks: { stepSize: 10, font: { size: 12 } }, grid: { color: '#f1f5f9', drawBorder: false } },
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
        labels: {!! json_encode($categoryLabels) !!},
        datasets: [
          { label: 'Selesai', backgroundColor: '#10b981', data: {!! json_encode($categorySelesaiData) !!}, borderRadius: 6, barPercentage: 0.7 },
          { label: 'Total Laporan', backgroundColor: '#93c5fd', data: {!! json_encode($categoryTotalData) !!}, borderRadius: 6, barPercentage: 0.7 },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 13, weight: '600' } } }
        },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 20, font: { size: 12 } }, grid: { color: '#f1f5f9', drawBorder: false } },
          x: { ticks: { font: { size: 11 } }, grid: { display: false, drawBorder: false } }
        }
      }
    });
  }
</script>
@endpush
@endsection