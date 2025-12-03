@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/monitoring.css') }}">
@endpush

@section('title', 'Monitoring & Statistik')

@section('content')
@php
    $reports = $reports ?? collect();
    $summary = $summary ?? ['total'=>'—','active'=>'—','closed_today'=>'—','avg_response'=>'—'];
@endphp

<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR (sama seperti admin dashboard) --}}
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2 text-sm">
                @php
                    $menu = [
                        ['Beranda', 'admin.dashboard', 'fa-solid fa-house'],
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

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800 mb-1">Monitoring & Statistik</h1>
            <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Filter card --}}
        <section class="filter-card bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-wrap items-start gap-4">
                <div class="font-bold text-gray-900 text-lg pt-3">Filter</div>

                <div class="relative dropdown-wrapper">
                    <button class="dropdown-toggle px-5 py-3 bg-gray-50 text-left rounded-lg min-w-[240px] flex justify-between items-center text-sm font-medium text-gray-900 border border-gray-200 hover:bg-gray-100 transition">
                        <span id="selected-category">Semua Kategori</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <ul class="dropdown-menu hidden" aria-hidden="true">
                        <li data-val="infrastruktur">Infrastruktur</li>
                        <li data-val="keselamatan">Keselamatan</li>
                        <li data-val="sanitasi">Sanitasi</li>
                        <li data-val="taman">Taman & Ruang Publik</li>
                        <li data-val="aksesibilitas">Aksesibilitas</li>
                    </ul>
                </div>

                <div class="relative dropdown-wrapper">
                    <button class="dropdown-toggle px-5 py-3 bg-gray-50 text-left rounded-lg min-w-[240px] flex justify-between items-center text-sm font-medium text-gray-900 border border-gray-200 hover:bg-gray-100 transition">
                        <span id="selected-status">Semua Status</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <ul class="dropdown-menu hidden" aria-hidden="true">
                        <li data-val="open">Belum Selesai</li>
                        <li data-val="progress">Dalam Pengerjaan</li>
                        <li data-val="closed">Selesai</li>
                    </ul>
                </div>

                <div class="ml-auto flex gap-3">
                    <a href="#" class="export-btn export-pdf">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                        <span>Ekspor PDF</span>
                    </a>
                    <a href="#" class="export-btn export-excel">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                        <span>Ekspor EXCEL</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- Trend Chart (Full Width at Top) --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-8">
            <h3 class="text-base font-bold text-gray-900 mb-5">Tren Laporan per Bulan (2025)</h3>
            <div class="h-80">
                <canvas id="trendChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- Performance Charts Grid --}}
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
                                <th class="text-center font-bold text-gray-900 py-3 px-4">Rata rata Waktu (hari)</th>
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
                                <td class="py-3 px-4 font-medium text-gray-900">Aksebilitas</td>
                                <td class="py-3 px-4 text-center text-gray-700">54</td>
                                <td class="py-3 px-4 text-center text-gray-700">38</td>
                                <td class="py-3 px-4 text-center text-gray-700">70%</td>
                                <td class="py-3 px-4 text-center text-gray-700">7 Hari</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
  // Dropdown functionality
  document.querySelectorAll('.dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const wrapper = btn.closest('.dropdown-wrapper');
      const menu = wrapper.querySelector('.dropdown-menu');
      const isHidden = menu.classList.contains('hidden');
      
      // Close all other dropdowns
      document.querySelectorAll('.dropdown-menu').forEach(m => {
        m.classList.add('hidden');
      });
      
      // Toggle current dropdown
      if(isHidden) {
        menu.classList.remove('hidden');
      }
    });
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.dropdown-wrapper')) {
      document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.add('hidden'));
    }
  });

  // Dropdown item selection
  document.querySelectorAll('.dropdown-menu li').forEach(item => {
    item.addEventListener('click', function(e) {
      e.stopPropagation();
      const selectedText = this.textContent.trim();
      const wrapper = this.closest('.dropdown-wrapper');
      const dropdown = wrapper.querySelector('.dropdown-toggle span');
      dropdown.textContent = selectedText;
      wrapper.querySelector('.dropdown-menu').classList.add('hidden');
    });
  });

  // Trend Chart Configuration
  const trendCtx = document.getElementById('trendChart')?.getContext('2d');
  if(trendCtx) {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
          { 
            label: 'Diproses', 
            borderColor: '#fbbf24', 
            backgroundColor: '#fbbf24',
            data: [7,7,7,8,7,7,7,7,7,7,7,7],
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.4
          },
          { 
            label: 'Selesai', 
            borderColor: '#10b981', 
            backgroundColor: '#10b981',
            data: [38,46,42,53,47,50,54,52,60,35,33,30],
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.4
          },
          { 
            label: 'Total Laporan', 
            borderColor: '#3b82f6', 
            backgroundColor: '#3b82f6',
            data: [45,52,48,61,55,58,62,59,68,42,40,38],
            borderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.4
          }
        ]
      },
      options: { 
        responsive: true, 
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 13,
                weight: '600'
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 80,
            ticks: {
              stepSize: 20,
              font: { size: 12 }
            },
            grid: {
              color: '#f1f5f9',
              drawBorder: false
            }
          },
          x: {
            ticks: {
              font: { size: 12 }
            },
            grid: {
              display: false,
              drawBorder: false
            }
          }
        },
        interaction: {
          mode: 'index',
          intersect: false
        }
      }
    });
  }

  // Category Performance Chart
  const kategoriCtx = document.getElementById('kategoriChart')?.getContext('2d');
  if(kategoriCtx) {
    new Chart(kategoriCtx, {
      type: 'bar',
      data: {
        labels: ['Infrastruktur','Keselamatan','Sanitasi','Taman & Ruang Publik','Aksesibilitas'],
        datasets: [
          { 
            label: 'Selesai', 
            backgroundColor: '#10b981', 
            data: [98,89,76,58,38],
            borderRadius: 6,
            barPercentage: 0.7
          },
          { 
            label: 'Total Laporan', 
            backgroundColor: '#93c5fd', 
            data: [145,123,98,76,54],
            borderRadius: 6,
            barPercentage: 0.7
          }
        ]
      },
      options: { 
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 13,
                weight: '600'
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 160,
            ticks: {
              stepSize: 40,
              font: { size: 12 }
            },
            grid: {
              color: '#f1f5f9',
              drawBorder: false
            }
          },
          x: {
            ticks: {
              font: { size: 11 }
            },
            grid: {
              display: false,
              drawBorder: false
            }
          }
        }
      }
    });
  }
</script>
@endpush
@endsection
