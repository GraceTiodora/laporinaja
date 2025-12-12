@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/homepage.auth.css') }}">
@endpush

@section('title', 'Voting Publik')

@section('content')
@php
    $reports = $reports ?? collect([
        (object)[
            'id' => 1,
            'user_name' => 'Budi Santoso',
            'user_avatar' => 'profile-user.jpg',
            'time_ago' => '2 jam yang lalu',
            'location' => 'Jl. Sudirman No. 45, Jakarta Pusat',
            'description' => 'Jalan berlubang besar di Jl. Sudirman menyebabkan beberapa pengendara motor terjatuh. Diameter lubang sekitar 2 meter dengan kedalaman 30cm. Sangat berbahaya terutama saat malam hari',
            'image' => 'jalan_berlubang.jpg',
            'total_votes' => 53,
            'urgent_votes' => 45,
            'not_urgent_votes' => 8,
            'urgent_percentage' => 85
        ] 
    ]);
@endphp

<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    {{-- SIDEBAR --}}
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
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

        {{-- Profile --}}
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

    {{-- MAIN CONTENT --}}
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 overflow-y-auto">
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-vote-yea text-blue-600 text-xl"></i>
                    <h1 class="text-xl font-bold text-gray-800">Voting Publik</h1>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all p-2 hover:bg-blue-50 rounded-lg group hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <div>
                <p class="text-sm text-gray-500">Pantau hasil voting laporan masyarakat</p>
            </div>

            <div class="space-y-5">
            @forelse($reports as $report)
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:border-blue-300">
                {{-- User Info --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ asset('images/' . $report->user_avatar) }}" 
                                 class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100"
                                 alt="{{ $report->user_name }}">
                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">{{ $report->user_name }}</h3>
                            <p class="text-xs text-gray-500">{{ $report->time_ago }}</p>
                        </div>
                    </div>
                    <span class="px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                        {{ $report->total_votes }} votes
                    </span>
                </div>

                {{-- Report Image --}}
                @if(!empty($report->image))
                <div class="mb-4 rounded-2xl overflow-hidden group/img">
                    <img src="{{ asset('images/' . $report->image) }}" 
                         class="w-full h-auto max-h-96 object-cover group-hover/img:scale-105 transition-transform duration-300"
                         alt="Report image">
                </div>
                @endif

                {{-- Location --}}
                <div class="flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-location-dot text-red-500"></i>
                    <p class="text-sm font-semibold text-red-700 bg-red-50 px-3 py-1.5 rounded-lg">{{ $report->location }}</p>
                </div>

                {{-- Description --}}
                <p class="text-sm text-gray-700 leading-relaxed mb-5">{{ $report->description }}</p>

                {{-- Voting Section --}}
                <div class="border-t border-gray-200 pt-5">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-gray-700">
                            <span class="font-bold">{{ $report->total_votes }}</span> warga telah memberikan penilaian
                        </p>
                        <p class="text-sm font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full">
                            {{ $report->urgent_percentage }}% menilai urgent
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl p-4 hover:shadow-md transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <i class="fa-solid fa-exclamation text-white text-lg font-bold"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 font-medium">Urgent</p>
                                    <p class="text-lg font-bold text-red-700">{{ $report->urgent_votes }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-4 hover:shadow-md transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <i class="fa-solid fa-check text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 font-medium">Tidak Urgent</p>
                                    <p class="text-lg font-bold text-green-700">{{ $report->not_urgent_votes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-16 text-gray-500">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-inbox text-4xl text-gray-400"></i>
                </div>
                <p class="text-lg font-semibold">Belum ada laporan untuk divoting</p>
                <p class="text-sm text-gray-400 mt-2">Laporan voting akan muncul di sini</p>
            </div>
            @endforelse
            </div>
        </div>

    </main>
</div>

@push('scripts')
<script>
  // Admin view - voting is read-only, no interaction
  console.log('Voting results displayed in read-only mode for admin');
</script>
@endpush
@endsection