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
        <div class="mt-6 border-t border-gray-200 pt-4">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">@{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</p>
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
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800 mb-1">Monitoring & Statistik</h1>
            <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
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
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($categoryPerformance) && is_array($categoryPerformance) && count($categoryPerformance) > 0)
                                @foreach($categoryPerformance as $cat)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $cat['kategori'] ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-center text-gray-700">{{ $cat['total'] ?? 0 }}</td>
                                    <td class="py-3 px-4 text-center text-gray-700">{{ $cat['selesai'] ?? 0 }}</td>
                                    <td class="py-3 px-4 text-center text-gray-700">{{ $cat['persentase'] ?? 0 }}%</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="py-3 px-4 text-center text-gray-500">Belum ada data</td>
                            </tr>
                            @endif
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