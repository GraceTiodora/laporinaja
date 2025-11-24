@extends('layouts.app')

@section('title', 'Monitoring & Statistik')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/monitoring.css') }}">
@endpush

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

        <h1 class="text-2xl font-bold text-gray-800 mb-1">Monitoring & Statistik</h1>
        <p class="text-sm text-gray-500 mb-8">Selamat datang di sistem manajemen laporan masyarakat</p>

        {{-- Filter Section --}}
        <div class="filter-container">
            <div class="filter-wrapper">
                <span class="filter-label">Filter</span>
                
                {{-- Dropdown Kategori --}}
                <div class="filter-dropdown">
                    <select id="filterKategori" class="filter-select">
                        <option value="">Semua Kategori</option>
                        <option value="infrastruktur">Infrastruktur</option>
                        <option value="keselamatan">Keselamatan</option>
                        <option value="sanitasi">Sanitasi</option>
                        <option value="taman">Taman</option>
                        <option value="aksesibilitas">Aksesibilitas</option>
                    </select>
                    <i class="fa-solid fa-chevron-down filter-dropdown-icon"></i>
                </div>

                {{-- Dropdown Status --}}
                <div class="filter-dropdown">
                    <select id="filterStatus" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="dalam-pengerjaan">Dalam Pengerjaan</option>
                        <option value="menunggu">Menunggu</option>
                    </select>
                    <i class="fa-solid fa-chevron-down filter-dropdown-icon"></i>
                </div>

                {{-- Export Buttons --}}
                <div class="export-buttons">
                    <button onclick="alert('Export PDF feature coming soon')" class="export-btn export-btn-pdf">
                        <i class="fa-solid fa-download"></i>
                        Ekspor PDF
                    </button>
                    <button onclick="alert('Export Excel feature coming soon')" class="export-btn export-btn-excel">
                        <i class="fa-solid fa-download"></i>
                        Export EXCEL
                    </button>
                </div>
            </div>
        </div>

        {{-- Line Chart - Tren Laporan --}}
        <div class="chart-container">
            <h3 class="chart-title">Tren Laporan Bulanan</h3>
            <canvas id="trenLaporanChart"></canvas>
        </div>

        {{-- Charts Grid --}}
        <div class="charts-grid">
            
            {{-- Bar Chart - Performa Penanganan --}}
            <div class="chart-container">
                <h3 class="chart-title">Performa Penanganan per Kategori</h3>
                <canvas id="performaChart"></canvas>
            </div>

            {{-- Doughnut Chart - User Engagement --}}
            <div class="chart-container">
                <h3 class="chart-title">User Engagement</h3>
                <canvas id="engagementChart"></canvas>
            </div>

        </div>

        {{-- Category Performance Table --}}
        <div class="table-container">
            <h3 class="table-title">Category Performance Summary</h3>

            <div class="table-wrapper">
                <table class="performance-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th class="text-center">Total Laporan</th>
                            <th class="text-center">Selesai</th>
                            <th class="text-center">Persentase Selesai</th>
                            <th class="text-center">Rata-rata Waktu (hari)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $categories = [
                                ['Infrastruktur', 145, 98, 68, 5.2],
                                ['Keselamatan', 123, 89, 89, 4.8],
                                ['Sanitasi', 98, 76, 76, 3.5],
                                ['Taman', 76, 58, 76, 6.1],
                                ['Aksesibilitas', 54, 38, 70, 7.3],
                            ];
                        @endphp

                        @foreach ($categories as [$kategori, $total, $selesai, $persentase, $waktu])
                        <tr>
                            <td class="font-medium">{{ $kategori }}</td>
                            <td class="text-center">{{ $total }}</td>
                            <td class="text-center">{{ $selesai }}</td>
                            <td class="text-center">{{ $persentase }}%</td>
                            <td class="text-center">{{ $waktu }} days</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Line Chart - Tren Laporan
    new Chart(document.getElementById('trenLaporanChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
            datasets: [
                {
                    label: 'Total Laporan',
                    data: [45, 50, 48, 62, 55, 58, 60, 58, 65, 38],
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Selesai',
                    data: [38, 45, 42, 52, 48, 50, 53, 52, 60, 35],
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Diproses',
                    data: [7, 5, 6, 10, 7, 8, 7, 6, 5, 3],
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2.5,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 80
                }
            }
        }
    });

    // Bar Chart - Performa Penanganan
    new Chart(document.getElementById('performaChart'), {
        type: 'bar',
        data: {
            labels: ['Infrastruktur', 'Keselamatan', 'Sanitasi', 'Taman & Ruang Publik', 'Aksesibilitas'],
            datasets: [
                {
                    label: 'Total',
                    data: [145, 123, 98, 76, 54],
                    backgroundColor: '#93C5FD'
                },
                {
                    label: 'Selesai',
                    data: [98, 89, 76, 58, 38],
                    backgroundColor: '#10B981'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 160
                }
            }
        }
    });

    // Doughnut Chart - User Engagement
    new Chart(document.getElementById('engagementChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laporan Aktif', 'Komentar', 'Voting', 'Share'],
            datasets: [{
                data: [35, 25, 22, 18],
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });

    // Filter functionality
    document.getElementById('filterKategori').addEventListener('change', function() {
        console.log('Filter Kategori:', this.value);
        // Add your filter logic here
    });

    document.getElementById('filterStatus').addEventListener('change', function() {
        console.log('Filter Status:', this.value);
        // Add your filter logic here
    });
</script>

@endsection