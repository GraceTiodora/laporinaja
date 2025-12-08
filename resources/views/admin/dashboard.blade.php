@extends('layouts.app') 
{{-- Jika kamu ingin layout khusus admin, nanti kita buatkan. tetapi untuk sementara pakai layout umum --}}

@section('title', 'Admin Dashboard')

@section('content')
<style>
/* Stat Cards dengan Gradient */
.stat-card {
    position: relative;
    overflow: hidden;
    background: white;
    border-radius: 1rem;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    transition: height 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.stat-card:hover::before {
    height: 100%;
    opacity: 0.05;
}

.stat-card-blue::before { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.stat-card-yellow::before { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
.stat-card-green::before { background: linear-gradient(135deg, #10b981, #059669); }
.stat-card-red::before { background: linear-gradient(135deg, #ef4444, #dc2626); }

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.stat-card-blue .stat-icon { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
.stat-card-yellow .stat-icon { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
.stat-card-green .stat-icon { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
.stat-card-red .stat-icon { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
}

/* Chart Cards */
.chart-card {
    background: white;
    border-radius: 1rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.chart-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    border-color: #3b82f6;
}

/* Report Cards */
.reports-card {
    background: white;
    border-radius: 1rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.report-item {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.report-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 3px;
    height: 100%;
    background: linear-gradient(180deg, #3b82f6, #2563eb);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.report-item:hover::before {
    transform: scaleY(1);
}

.report-item:hover {
    background: white;
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    transform: translateX(4px);
}

.report-badge {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 16px;
    transition: all 0.3s ease;
}

.report-item:hover .report-badge {
    transform: rotate(10deg) scale(1.1);
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
}

.report-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    border: 2px solid #3b82f6;
    background: white;
    color: #2563eb;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.report-action-btn:hover {
    background: #3b82f6;
    color: white;
    transform: translateX(4px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
}

.report-action-btn i {
    transition: transform 0.3s ease;
}

.report-action-btn:hover i {
    transform: translateX(4px);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card, .chart-card, .reports-card {
    animation: fadeInUp 0.5s ease forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>

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

        <h1 class="text-xl font-bold text-gray-800 mb-1">Beranda</h1>
        <p class="text-sm text-gray-500 mb-6">Selamat datang di sistem manajemen laporan masyarakat</p>

        {{-- Top Statistic Cards --}}
        <div class="grid grid-cols-4 gap-6 mb-10">

            <div class="stat-card stat-card-blue">
                <div class="stat-icon">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Laporan Masuk</p>
                    <h2 class="text-3xl font-extrabold text-gray-900">156</h2>
                </div>
            </div>

            <div class="stat-card stat-card-yellow">
                <div class="stat-icon">
                    <i class="fa-solid fa-spinner"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Sedang Diproses</p>
                    <h2 class="text-3xl font-extrabold text-gray-900">42</h2>
                </div>
            </div>

            <div class="stat-card stat-card-green">
                <div class="stat-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Selesai</p>
                    <h2 class="text-3xl font-extrabold text-gray-900">98</h2>
                </div>
            </div>

            <div class="stat-card stat-card-red">
                <div class="stat-icon">
                    <i class="fa-solid fa-bell"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Perlu Verifikasi</p>
                    <h2 class="text-3xl font-extrabold text-gray-900">16</h2>
                </div>
            </div>

        </div>

        {{-- Chart & Pie --}}
        <div class="grid grid-cols-2 gap-8 mb-10">
            
            <div class="chart-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-base text-gray-900">Status Penanganan Laporan</h3>
                    <i class="fa-solid fa-chart-bar text-blue-500"></i>
                </div>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="chart-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-base text-gray-900">Laporan Berdasarkan Kategori</h3>
                    <i class="fa-solid fa-chart-pie text-blue-500"></i>
                </div>
                <canvas id="kategoriChart"></canvas>
            </div>

        </div>

        {{-- New Reports Table --}}
        <div class="reports-card">

            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-blue-600"></i>
                    <h3 class="font-bold text-base text-gray-900">Laporan Baru Perlu Verifikasi</h3>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">3 Baru</span>
            </div>

            <div class="space-y-3">
                @foreach ([1,2,3] as $i)
                <div class="report-item">
                    <div class="flex items-start gap-3">
                        <div class="report-badge">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 mb-1">LP-2025-15{{ $i }} <span class="text-xs font-normal text-gray-500">(Infrastruktur)</span></p>
                            <p class="text-sm text-gray-700 mb-2">Jalan berlubang di Jl. Merdeka</p>
                            <p class="text-xs text-gray-500">
                                <i class="fa-solid fa-user text-gray-400"></i> Budi Santoso • 
                                <i class="fa-solid fa-clock text-gray-400"></i> 2 jam lalu
                            </p>
                        </div>
                    </div>
                    <a href="#" class="report-action-btn">
                        <span>Lihat Detail</span>
                        <i class="fa-solid fa-arrow-right"></i>
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
