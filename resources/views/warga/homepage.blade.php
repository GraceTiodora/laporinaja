@extends('layouts.app')

@section('title', 'Home - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'reports', 'fa-solid fa-clipboard-list'],
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
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
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium
                              transition-all hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:text-blue-600 
                              hover:shadow-md hover:scale-105 transform">
                        <i class="{{ $icon }} text-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                        <span class="group-hover:translate-x-1 transition-transform">{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all font-bold transform hover:scale-105 relative overflow-hidden group">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                <i class="fa-solid fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <!-- Profile Bottom -->
        <div>
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 hover:bg-white/50 p-3 rounded-xl transition-all cursor-pointer group mb-3">
                <div class="relative">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div class="flex flex-col leading-tight flex-1">
                    <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition">{{ session('user.name', 'Guest') }}</span>
                    <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 opacity-0 group-hover:opacity-100 transition-all"></i>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-600 font-semibold bg-white/50 hover:bg-red-50 hover:text-red-700 transition-all group border border-red-200 hover:border-red-300">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 📰 Main Feed -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20">

        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10 shadow-sm">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Beranda</h1>
            <button class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-lg group">
                <i class="fa-solid fa-gear text-xl group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </header>

        <div class="overflow-y-auto p-6 space-y-5">

            <!-- Post Input -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-xl transition-all duration-300 hover:border-blue-200 group">
                <div class="flex items-center gap-3 mb-4">
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-12 h-12 rounded-full ring-2 ring-blue-100 group-hover:ring-blue-300 transition-all">
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <input type="text" placeholder="Ada masalah di sekitarmu? Yuk laporkan! 🚀"
                           onclick="window.location.href='{{ route('reports.create') }}'"
                           class="flex-1 bg-gradient-to-r from-gray-50 to-blue-50/30 px-4 py-3 rounded-full border border-gray-200
                                  hover:border-blue-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition-all cursor-pointer
                                  placeholder-gray-500 text-gray-800 font-medium">
                </div>

                <div class="flex justify-between items-center px-2">
                    <div class="flex gap-4 text-gray-400">
                        <button class="hover:text-blue-600 transition-all hover:scale-110 transform" title="Upload Foto">
                            <i class="fa-solid fa-camera text-lg"></i>
                        </button>
                        <button class="hover:text-green-600 transition-all hover:scale-110 transform" title="Upload Gambar">
                            <i class="fa-solid fa-image text-lg"></i>
                        </button>
                        <button class="hover:text-red-600 transition-all hover:scale-110 transform" title="Tambah Lokasi">
                            <i class="fa-solid fa-location-dot text-lg"></i>
                        </button>
                    </div>
                    <button onclick="window.location.href='{{ route('reports.create') }}'" 
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-full 
                                   transition-all font-semibold shadow-md hover:shadow-lg transform hover:scale-105 flex items-center gap-2">
                        <span>Post</span>
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- FEED LIST -->
            @php
                $allReports = $dbReports ?? [];
            @endphp

            @foreach ($allReports as $report)
            <article class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-2xl transition-all duration-500 hover:border-blue-300 hover:-translate-y-1 group">

                <!-- User Info -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="relative">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full ring-2 ring-gray-100 group-hover:ring-blue-200 transition-all">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-gray-900 text-sm">{{ $report['user']['name'] ?? 'Anonymous' }}</span>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span>{{ $report['created_at'] ?? 'Baru saja' }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-500"></i>
                                {{ $report['location'] ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Title/Judul Laporan -->
                <h3 class="text-gray-900 font-bold text-base mb-4 leading-snug group-hover:text-blue-700 transition">
                    {{ $report['title'] ?? $report['description'] ?? 'Tanpa Judul' }}
                </h3>

                @if(!empty($report['image']))
                    <div class="rounded-xl overflow-hidden mb-4 relative group/img">
                        <img src="{{ asset($report['image']) }}" class="w-full object-cover max-h-[450px] group-hover/img:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/0 group-hover/img:bg-black/10 transition-all"></div>
                    </div>
                @endif

                <div class="flex gap-2 mb-4">
                    <span class="px-4 py-2 text-sm font-bold rounded-full bg-gradient-to-r from-pink-100 to-red-100 text-pink-700 
                                 hover:from-pink-200 hover:to-red-200 transition-all cursor-default">
                        {{ $report['status'] ?? 'Baru' }}
                    </span>
                    <span class="px-4 py-2 text-sm font-bold rounded-full bg-gradient-to-r from-indigo-100 to-blue-100 text-blue-700 
                                 hover:from-indigo-200 hover:to-blue-200 transition-all cursor-default">
                        {{ $report['category'] ?? 'Umum' }}
                    </span>
                </div>

                <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-4">
                    <div class="flex gap-6">
                        <button onclick="window.location='{{ route('reports.show', $report['id']) }}'" 
                                class="flex items-center gap-2 hover:text-blue-600 transition-all group/btn cursor-pointer">
                            <i class="fa-regular fa-comment text-base group-hover/btn:scale-125 transition-transform"></i>
                            <span class="font-medium">{{ $report['comments'] ?? 0 }}</span>
                        </button>
                        <button onclick="toggleVote({{ $report['id'] }}, this)" 
                                class="vote-btn flex items-center gap-2 hover:text-red-500 transition-all group/btn cursor-pointer"
                                data-report-id="{{ $report['id'] }}">
                            <i class="fa-solid fa-heart text-base group-hover/btn:scale-125 transition-transform"></i>
                            <span class="font-medium vote-count">{{ $report['votes'] ?? 0 }}</span>
                        </button>
                    </div>

                    <a href="{{ route('reports.show', $report['id']) }}"
                       class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-all flex items-center gap-1 
                              hover:gap-2 group/link">
                        Lihat detail
                        <i class="fa-solid fa-arrow-right text-sm group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>

            </article>
            @endforeach

        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 p-6 overflow-y-auto border-l border-gray-200 space-y-6 shadow-lg">
        <!-- Masalah Penting -->
        <section class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-5 border border-red-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500 animate-pulse"></i> 
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">Masalah Penting</span>
            </h2>
            <ul class="space-y-3">
                @forelse($topReports ?? [] as $report)
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-red-300">
                    <a href="{{ route('reports.show', $report['id']) }}" class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm group-hover:text-red-700 transition">{{ Str::limit($report['title'], 30) }}</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-red-400"></i>
                                {{ Str::limit($report['location'] ?? 'Lokasi tidak diketahui', 20) }}
                            </p>
                        </div>
                        <div class="flex flex-col items-center ml-2">
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full shadow-md">{{ $report['votes'] }}V</span>
                        </div>
                    </a>
                </li>
                @empty
                <li class="p-4 text-center text-gray-500 text-sm">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                    Belum ada laporan
                </li>
                @endforelse
            </ul>
        </section>

        <!-- Trending -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-arrow-trend-up text-blue-500"></i> 
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Trending</span>
            </h2>
            <ul class="space-y-3">
                @forelse($topReports ?? [] as $report)
                <li class="p-3 bg-white rounded-xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-transparent hover:border-blue-300">
                    <a href="{{ route('reports.show', $report['id']) }}" class="block">
                        <p class="font-bold text-gray-900 text-sm group-hover:text-blue-700 transition mb-1">{{ Str::limit($report['title'], 40) }}</p>
                        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-blue-400"></i>
                            {{ Str::limit($report['location'] ?? 'Lokasi tidak diketahui', 25) }}
                        </p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-heart text-red-400"></i>
                                {{ $report['votes'] }} votes
                            </span>
                        </div>
                    </a>
                </li>
                @empty
                <li class="p-4 text-center text-gray-500 text-sm">
                    <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                    Belum ada laporan trending
                </li>
                @endforelse
            </ul>
        </section>
    </aside>
</div>

<!-- Vote/Like Functionality -->
<script>
function toggleVote(reportId, button) {
    @if(!session()->has('user'))
        window.location.href = "{{ route('login') }}";
        return;
    @endif

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        alert('Error: CSRF token tidak ditemukan');
        return;
    }
    
    console.log('Voting on report:', reportId);
    
    fetch(`/reports/${reportId}/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            upvote: true
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Vote response:', data);
        if (data.upvotes !== undefined) {
            const voteCountElement = button.querySelector('.vote-count');
            voteCountElement.textContent = data.upvotes;
            
            // Add animation
            button.classList.add('text-red-500');
            const icon = button.querySelector('i');
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            
            // Pulse effect
            button.classList.add('animate-pulse');
            setTimeout(() => {
                button.classList.remove('animate-pulse');
            }, 500);
        }
    })
    .catch(error => {
        console.error('Error voting:', error);
        alert('Terjadi kesalahan saat voting: ' + error.message);
    });
}
</script>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection
