@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        
        <div>
            <h2 class="admin-logo">
                Laporin<span>Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="admin-nav">
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
                       class="admin-nav-item {{ request()->routeIs($route) ? 'active' : '' }}">
                        <i class="{{ $icon }}"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Profile --}}
        <div class="admin-profile">
            <div class="admin-profile-info">
                <img src="{{ asset('images/profile-user.jpg') }}" class="admin-profile-img" alt="Admin Profile">

                <div>
                    <p class="admin-profile-name">Justin Hubner</p>
                    <p class="admin-profile-username">@adminhubner</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="admin-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="admin-main">

        <div class="admin-header">
            <h1 class="admin-title">Dashboard</h1>
            <p class="admin-subtitle">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Top Statistic Cards --}}
        <div class="stats-grid">

            <div class="stat-card">
                <p class="stat-label">Laporan Masuk</p>
                <h2 class="stat-value">156</h2>
            </div>

            <div class="stat-card">
                <p class="stat-label">Sedang Diproses</p>
                <h2 class="stat-value">42</h2>
            </div>

            <div class="stat-card">
                <p class="stat-label">Selesai</p>
                <h2 class="stat-value">98</h2>
            </div>

            <div class="stat-card">
                <p class="stat-label">Perlu Verifikasi</p>
                <h2 class="stat-value">16</h2>
            </div>

        </div>

        {{-- Chart & Pie --}}
        <div class="charts-grid">
            
            <div class="chart-card">
                <h3 class="chart-title">Status Penanganan Laporan</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">Laporan Berdasarkan Kategori</h3>
                <canvas id="kategoriChart"></canvas>
            </div>

        </div>

        {{-- New Reports Table --}}
        <div class="reports-card">

            <h3 class="reports-title">Laporan Baru Perlu Verifikasi</h3>

            <div class="reports-list">
                @foreach ([1,2,3] as $i)
                <div class="report-item">
                    <div>
                        <p class="report-info-title">
                            LP-2025-15{{ $i }} 
                            <span class="category">(Infrastruktur)</span>
                        </p>
                        <p class="report-info-desc">Jalan berlubang di Jl. Merdeka</p>
                        <p class="report-info-meta">Pelapor: Budi Santoso • 2 jam lalu</p>
                    </div>

                    <a href="#" class="report-action-btn">
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
    // Status Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: ['Masuk', 'Diproses', 'Selesai'],
            datasets: [{
                data: [156, 42, 98],
                backgroundColor: ['#93C5FD', '#FDE68A', '#86EFAC']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Kategori Chart
    new Chart(document.getElementById('kategoriChart'), {
        type: 'pie',
        data: {
            labels: ['Infrastruktur', 'Sosial', 'Aksesibilitas', 'Keamanan', 'Sampah'],
            datasets: [{
                data: [25, 21, 19, 24, 11],
                backgroundColor: ['#60A5FA','#F87171','#FBBF24','#34D399','#A78BFA']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>

@endsection