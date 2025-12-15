@extends('layouts.app')

@section('title', 'Profile - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-r border-gray-200 p-6 flex flex-col justify-between sidebar-scroll shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">Laporin<span class="text-gray-900">Aja</span></h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
<<<<<<< Updated upstream
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'reports', 'fa-solid fa-clipboard-list'],
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
=======
                        // ...hapus menu Pesan...
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
>>>>>>> Stashed changes
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    @php
                        $href = '#';
                        if ($route !== '#') {
                            try {
                                $href = route($route);
                            } catch (\Exception $e) {
                                $href = '#';
                            }
                        }
                    @endphp
                    <a href="{{ $href }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl {{ $route == 'profile' ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-600' }} font-medium transition-all hover:bg-blue-50 hover:text-blue-600">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold">
                <i class="fa-solid fa-plus-circle"></i> New Report
            </button>
        </div>

        <!-- Profile Section -->
        <div>
<<<<<<< Updated upstream
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 mb-3">
                <img src="{{ $user->avatar ?? '/images/default-avatar.jpg' }}" class="w-10 h-10 rounded-full object-cover" onerror="this.src='/images/default-avatar.jpg'">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-medium text-gray-800">{{ $user->name ?? 'User' }}</span>
                    <span class="text-xs text-gray-500">@{{ $user->username ?? 'username' }}</span>
                </div>
            </div>
=======
            <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 hover:border-blue-400 bg-white hover:bg-blue-50 transition-all cursor-pointer mb-3 group ring-2 ring-gray-200 hover:ring-blue-400">
                <div class="relative">
                    <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-white" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}'">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500">@{{ auth()->user()->username ?? 'username' }}</p>
                </div>
            </a>
>>>>>>> Stashed changes
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-600 font-semibold bg-white/50 hover:bg-red-50 hover:text-red-700 transition-all group border border-red-200 hover:border-red-300">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 📰 Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white feed-scroll overflow-y-auto">
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 z-10">
            <h1 class="text-xl font-bold text-gray-800">Profil</h1>
        </header>

        <div class="p-6">
            <!-- Profile Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-start gap-6">
<<<<<<< Updated upstream
                    <img src="{{ $user->avatar ?? '/images/default-avatar.jpg' }}" 
                         alt="{{ $user->name ?? 'User' }}" 
                         class="w-24 h-24 rounded-full object-cover"
                         onerror="this.src='/images/default-avatar.jpg'">
=======
                    <div class="relative">
                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $user->name ?? 'User' }}"
                                class="w-32 h-32 rounded-2xl object-cover ring-4 ring-blue-200 group-hover:ring-blue-400 transition-all shadow-lg"
                                onerror="this.src='{{ asset('images/default-avatar.jpg') }}'">
                        <div class="absolute -bottom-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                    </div>
>>>>>>> Stashed changes
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name ?? 'User' }}</h2>
                        <p class="text-gray-600 mt-2">{{ $user->bio ?? 'Community advocate passionate about making our neighborhood safer and cleaner.' }}</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-4 gap-6 mt-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['reports_sent'] ?? 23 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Laporan Dikirimkan</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-600">{{ $stats['issues_resolved'] ?? 18 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Masalah Terselesaikan</p>
                    </div>
<<<<<<< Updated upstream
                    <div class="text-center">
                        <p class="text-3xl font-bold text-orange-600">{{ $stats['community_posts'] ?? 25 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Komunitas Post</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['vote_helps'] ?? 89 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Bantuan Vote</p>
=======
                    <div class="text-center p-4 rounded-xl bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-100 transition-all cursor-pointer group/stat border-2 border-transparent hover:border-blue-300 shadow-sm hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 mb-3 group-hover/stat:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-heart text-white text-xl"></i>
                        </div>
                        <p class="text-3xl font-extrabold text-blue-600">{{ $stats['vote_helps'] ?? 5 }}</p>
                        <p class="text-sm font-semibold text-gray-600 mt-1">Jumlah Vote</p>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex gap-8">
                    <button class="tab-btn active pb-4 px-2 font-semibold text-gray-900 border-b-2 border-gray-900 transition-all" data-tab="laporan">
                        Laporan Saya
                    </button>
                    <button class="tab-btn pb-4 px-2 font-semibold text-gray-500 hover:text-gray-900 border-b-2 border-transparent transition-all" data-tab="komentar">
                        Komentar
                    </button>
                    <button class="tab-btn pb-4 px-2 font-semibold text-gray-500 hover:text-gray-900 border-b-2 border-transparent transition-all" data-tab="vote">
                        Vote
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="laporan-content" class="tab-content space-y-4">
                @forelse($reports ?? [] as $report)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition-all">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2">Pada: {{ $report->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot"></i>
                                    {{ $report->location }}
                                </span>
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            @if($report->description)
                            <p class="text-gray-700 text-sm mb-3">{{ $report->description }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                                <span>{{ $report->votes_count ?? 0 }} vote bermanfaat</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $report->status === 'Penting' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $report->status ?? 'Penting' }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i class="fa-regular fa-folder-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada laporan</p>
                </div>
                @endforelse
            </div>

            <div id="komentar-content" class="tab-content hidden">
                <div class="text-center py-12">
                    <i class="fa-regular fa-comments text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada komentar</p>
                </div>
            </div>

            <div id="vote-content" class="tab-content hidden">
                <div class="text-center py-12">
                    <i class="fa-regular fa-heart text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada vote</p>
                </div>
            </div>
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 p-6 overflow-y-auto sidebar-scroll shadow-lg">
        <!-- Urgent Issues -->
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Penting
            </h2>
            <ul class="space-y-4">
                @foreach($urgentIssues ?? [
                    (object)['title' => 'Jalan Rusak', 'location' => 'Jl. Melati', 'votes' => 128],
                    (object)['title' => 'Sampah Menumpuk', 'location' => 'Pasar Baru', 'votes' => 96],
                ] as $issue)
                <li class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $issue->title }}</p>
                        <p class="text-xs text-gray-500">{{ $issue->location }}</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">{{ $issue->votes }} Votes</span>
                </li>
                @endforeach
            </ul>
        </section>

        <!-- Trending Issues -->
        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-4">
                @foreach($trendingIssues ?? [
                    (object)['title' => 'Infrastruktur Jalan', 'subtitle' => '5 laporan hari ini', 'priority' => 'Penting'],
                    (object)['title' => 'Sampah Menumpuk', 'subtitle' => 'Pasar Baru', 'priority' => 'Sedang'],
                ] as $issue)
                <li class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $issue->title }}</p>
                        <p class="text-xs text-gray-500">{{ $issue->subtitle }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium
                        {{ $issue->priority === 'Penting' ? 'bg-pink-100 text-pink-700' : '' }}
                        {{ $issue->priority === 'Sedang' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    ">
                        {{ $issue->priority }}
                    </span>

                </li>
                @endforeach
            </ul>
        </section>
    </aside>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;

            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-gray-900', 'text-gray-900');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Add active class to clicked button
            this.classList.add('active', 'border-gray-900', 'text-gray-900');
            this.classList.remove('border-transparent', 'text-gray-500');

            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected tab content
            document.getElementById(`${tabName}-content`).classList.remove('hidden');
        });
    });
});
</script>
@endsection