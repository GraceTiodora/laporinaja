@extends('layouts.app')

@section('title', 'Profile - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">Laporin<span class="text-gray-900">Aja</span></h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Home', 'home', 'fa-solid fa-house'],
                        ['Explore', 'explore', 'fa-solid fa-hashtag'],
                        ['Notification', 'notifications', 'fa-regular fa-bell'],
                        ['Messages', 'messages', 'fa-regular fa-envelope'],
                        ['My Reports', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Communities', 'communities', 'fa-solid fa-users'],
                        ['Profile', 'profile', 'fa-regular fa-user'],
                        ['More', '#', 'fa-solid fa-ellipsis-h'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600 {{ $route == 'profile' ? 'bg-blue-50 text-blue-600' : '' }}">
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
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Justin Hubner') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Main Profile Content -->
    <main class="flex-1 flex flex-col bg-white overflow-hidden">
        <!-- Profile Header -->
        <header class="border-b border-gray-200 px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Profile</h1>
            
            <!-- Profile Card -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-start gap-5">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-24 h-24 rounded-full object-cover">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Justin Hubner</h2>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            Community advocate passionate about making our neighborhood safer and cleaner. Environmental science graduate.
                        </p>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-4 gap-4 mt-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600 mb-1">23</div>
                                <div class="text-xs text-gray-500">Laporan<br>Dikirimkan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600 mb-1">18</div>
                                <div class="text-xs text-gray-500">Masalah<br>Terselesaikan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-orange-600 mb-1">25</div>
                                <div class="text-xs text-gray-500">Komunitas Post</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-indigo-600 mb-1">89</div>
                                <div class="text-xs text-gray-500">Bantuan Vote</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 px-8">
            <div class="flex gap-8">
                <button class="tab-button active">Laporan Saya</button>
                <button class="tab-button">Komentar</button>
                <button class="tab-button">Vote</button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto px-8 py-6">
            <!-- Tab Content: Laporan Saya -->
            <div class="tab-content active" id="laporan-saya">
                <div class="space-y-4">
                    @php
                        $myReports = [
                            ['title' => 'Lampu Jalan Mati di RT 05', 'location' => 'Jl. Mawar', 'time' => '2 hari yang lalu', 'status' => 'Sedang Diproses', 'status_color' => 'yellow', 'category' => 'Keamanan', 'votes' => 18, 'comments' => 6],
                            ['title' => 'Sampah Menumpuk di Pasar Baru', 'location' => 'Jl. Kenanga', 'time' => '5 hari yang lalu', 'status' => 'Baru', 'status_color' => 'red', 'category' => 'Sanitasi', 'votes' => 3, 'comments' => 1],
                            ['title' => 'Pohon Tumbang di Depan Halte', 'location' => 'Jl. Sudirman', 'time' => '1 minggu yang lalu', 'status' => 'Selesai', 'status_color' => 'green', 'category' => 'Infrastruktur', 'votes' => 34, 'comments' => 12],
                        ];
                    @endphp

                    @foreach($myReports as $report)
                        <article class="report-card-mini">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-base font-semibold text-gray-800 mb-2">{{ $report['title'] }}</h3>
                                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                                        <i class="fa-solid fa-location-dot text-xs"></i>
                                        <span>{{ $report['location'] }}</span>
                                        <span>•</span>
                                        <span>{{ $report['time'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mb-3">
                                        @if($report['status_color'] == 'yellow')
                                            <span class="tag tag-yellow">{{ $report['status'] }}</span>
                                        @elseif($report['status_color'] == 'red')
                                            <span class="tag tag-red">{{ $report['status'] }}</span>
                                        @elseif($report['status_color'] == 'green')
                                            <span class="tag tag-green">{{ $report['status'] }}</span>
                                        @endif
                                        <span class="tag tag-category">{{ $report['category'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-star"></i> {{ $report['votes'] }} votes
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-comment"></i> {{ $report['comments'] }} komentar
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- Tab Content: Komentar -->
            <div class="tab-content" id="komentar">
                <div class="space-y-4">
                    @php
                        $comments = [
                            ['report' => 'Lampu Jalan Mati di RT 05', 'comment' => 'Aku juga sering lewat jalan itu malam hari, dan memang gelap banget. Semoga segera diperbaiki.', 'time' => '1 hari yang lalu', 'votes' => 11],
                            ['report' => 'Sampah Menumpuk di Pasar Baru', 'comment' => 'Setuju banget, bau dan pemandangannya udah ganggu pengunjung. Mungkin bisa ditambah jadwal pengangkutan sampah.', 'time' => '2 hari yang lalu', 'votes' => 9],
                        ];
                    @endphp

                    @foreach($comments as $comment)
                        <article class="comment-card">
                            <div class="font-semibold text-sm text-gray-600 mb-2">Pada: {{ $comment['report'] }}</div>
                            <p class="text-gray-700 text-sm mb-3 leading-relaxed">{{ $comment['comment'] }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span>{{ $comment['time'] }}</span>
                                <span>{{ $comment['votes'] }} vote bermanfaat</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- Tab Content: Vote -->
            <div class="tab-content" id="vote">
                <div class="space-y-4">
                    @php
                        $votes = [
                            ['title' => 'Kursi Halte Dirusak', 'location' => 'Terminal Utama', 'time' => '2 jam yang lalu', 'status' => 'Penting'],
                            ['title' => 'Coretan di Dinding Kantor Kelurahan', 'location' => 'Kantor Kelurahan', 'time' => '1 hari yang lalu', 'status' => 'Penting'],
                            ['title' => 'Tutup Got Lepas di Jalan Industri', 'location' => 'Kawasan Industri', 'time' => '2 jam yang lalu', 'status' => 'Penting'],
                        ];
                    @endphp

                    @foreach($votes as $vote)
                        <article class="vote-card">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-base font-semibold text-gray-800 mb-2">Pada: {{ $vote['title'] }}</h3>
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <i class="fa-solid fa-location-dot text-xs"></i>
                                        <span>{{ $vote['location'] }}</span>
                                        <span>•</span>
                                        <span>{{ $vote['time'] }}</span>
                                    </div>
                                </div>
                                <span class="tag tag-green">{{ $vote['status'] }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-white p-6 overflow-y-auto border-l border-gray-200">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Urgent
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-xs text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">96 Votes</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">54 Votes</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-pink-100 text-pink-700 font-medium">Urgent</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700 font-medium">Medium</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-blue-100 text-blue-800 font-medium">Low</span>
                </li>
            </ul>
        </section>
    </aside>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<script>
// Tab switching functionality
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons and contents
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked button
        this.classList.add('active');
        
        // Show corresponding content
        const tabName = this.textContent.trim().toLowerCase().replace(' ', '-');
        const contentMap = {
            'laporan-saya': 'laporan-saya',
            'komentar': 'komentar',
            'vote': 'vote'
        };
        document.getElementById(contentMap[tabName])?.classList.add('active');
    });
});
</script>
@endsection