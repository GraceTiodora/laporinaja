@extends('layouts.app')

@section('title', 'Profile - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                        // ...hapus menu Pesan...
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
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
                        $isActive = request()->routeIs($route);
                    @endphp
                    <a href="{{ $href }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300 relative
                              {{ $isActive 
                                  ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' 
                                  : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                        @if($isActive)
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        @endif
                        <i class="{{ $icon }} text-lg group-hover:scale-125 transition-transform"></i>
                        <span class="font-semibold">{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all duration-300 font-bold transform hover:scale-105 group">
                <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <!-- Profile Bottom -->
        <div>
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
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 transition-all duration-300 group border-2 border-red-200 hover:border-red-400 hover:shadow-lg transform hover:scale-105">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-2 transition-transform text-lg"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 📰 Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 feed-scroll overflow-y-auto">
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b-2 border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-3">
                    <i class="fa-solid fa-user-circle text-blue-600"></i>
                    Profil
                </h1>
                <button class="p-3 rounded-full hover:bg-gray-100 transition-all group">
                    <i class="fa-solid fa-gear text-xl text-gray-600 group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
            </div>
        </header>

        <div class="p-6">
            <!-- Profile Header -->
            <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border-2 border-blue-200 p-8 mb-6 group hover:shadow-2xl transition-all duration-300">
                <div class="flex items-start gap-6">
                    <div class="relative">
                            <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/default-avatar.jpg') }}"
                                alt="{{ $user->name ?? 'User' }}"
                                class="w-32 h-32 rounded-2xl object-cover ring-4 ring-blue-200 group-hover:ring-blue-400 transition-all shadow-lg"
                                onerror="this.src='{{ asset('images/default-avatar.jpg') }}'">
                        <div class="absolute -bottom-2 -right-2 bg-green-500 w-8 h-8 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">{{ $user->name ?? 'User' }}</h2>
                        <p class="text-gray-600 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-at text-blue-500"></i>
                            <span class="font-semibold">{{ $user->username ?? 'username' }}</span>
                        </p>
                        <p class="text-gray-700 leading-relaxed">{{ $user->bio ?? 'Community advocate passionate about making our neighborhood safer and cleaner.' }}</p>
                        <div class="flex gap-3 mt-4">
                            <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center gap-2">
                                <i class="fa-solid fa-pen"></i>
                                Edit Profil
                            </a>
                            <button class="px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 rounded-full font-bold border-2 border-gray-200 hover:border-blue-400 shadow-md hover:shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
                                <i class="fa-solid fa-share-nodes"></i>
                                Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-8 pt-8 border-t-2 border-blue-100">
                    <div class="text-center p-4 rounded-xl bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all cursor-pointer group/stat border-2 border-transparent hover:border-purple-300 shadow-sm hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 mb-3 group-hover/stat:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-paper-plane text-white text-xl"></i>
                        </div>
                        <p class="text-3xl font-extrabold text-purple-600">{{ $stats['reports_sent'] ?? 7 }}</p>
                        <p class="text-sm font-semibold text-gray-600 mt-1">Laporan Dikirimkan</p>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-green-100 transition-all cursor-pointer group/stat border-2 border-transparent hover:border-green-300 shadow-sm hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 mb-3 group-hover/stat:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-check-double text-white text-xl"></i>
                        </div>
                        <p class="text-3xl font-extrabold text-green-600">{{ $stats['issues_resolved'] ?? 0 }}</p>
                        <p class="text-sm font-semibold text-gray-600 mt-1">Masalah Terselesaikan</p>
                    </div>
                    <div class="text-center p-4 rounded-xl bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-100 transition-all cursor-pointer group/stat border-2 border-transparent hover:border-blue-300 shadow-sm hover:shadow-lg">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 mb-3 group-hover/stat:scale-110 transition-transform shadow-lg">
                            <i class="fa-solid fa-heart text-white text-xl"></i>
                        </div>
                        <p class="text-3xl font-extrabold text-blue-600">{{ $stats['vote_helps'] ?? 5 }}</p>
                        <p class="text-sm font-semibold text-gray-600 mt-1">Bantuan Vote</p>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-2 mb-6">
                <nav class="flex gap-2">
                    <button class="tab-btn active flex-1 py-3 px-6 font-bold rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg transition-all transform hover:scale-105" data-tab="laporan">
                        <i class="fa-solid fa-clipboard-list mr-2"></i>
                        Laporan Saya
                    </button>
                    <button class="tab-btn flex-1 py-3 px-6 font-bold rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all transform hover:scale-105" data-tab="komentar">
                        <i class="fa-solid fa-comments mr-2"></i>
                        Komentar
                    </button>
                    <button class="tab-btn flex-1 py-3 px-6 font-bold rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all transform hover:scale-105" data-tab="vote">
                        <i class="fa-solid fa-heart mr-2"></i>
                        Vote
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="laporan-content" class="tab-content space-y-4">
                @forelse($reports ?? [] as $report)
                <a href="{{ route('reports.show', $report->id) }}" class="block bg-white border-2 border-gray-200 rounded-2xl shadow-md hover:shadow-2xl hover:border-blue-300 p-6 transition-all duration-300 group transform hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $report->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                <span class="flex items-center gap-2 bg-purple-50 px-3 py-1.5 rounded-lg border border-purple-100">
                                    <i class="fa-solid fa-layer-group text-purple-500"></i>
                                    <span class="font-semibold text-purple-700">{{ $report->category->name ?? 'Umum' }}</span>
                                </span>
                                <span class="flex items-center gap-2 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">
                                    <i class="fa-solid fa-location-dot text-red-500"></i>
                                    <span class="font-semibold text-red-700">{{ $report->location }}</span>
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-blue-500"></i>
                                    <span class="font-medium text-gray-600">{{ $report->created_at->diffForHumans() }}</span>
                                </span>
                            </div>
                            @if($report->description)
                            <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ $report->description }}</p>
                            @endif
                            <div class="flex items-center gap-4 pt-3 border-t-2 border-gray-100">
                                <div class="flex items-center gap-2 text-sm hover:bg-red-50 px-3 py-2 rounded-lg transition-all group/stat">
                                    <div class="relative">
                                        <i class="fa-solid fa-heart text-red-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                    </div>
                                    <span class="font-bold text-gray-700">{{ $report->upvotes ?? 0 }}</span>
                                    <span class="text-gray-500 font-medium">votes</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm hover:bg-blue-50 px-3 py-2 rounded-lg transition-all group/stat">
                                    <i class="fa-solid fa-comments text-blue-500 text-lg group-hover/stat:scale-125 transition-transform"></i>
                                    <span class="font-bold text-gray-700">{{ $report->comments->count() ?? 0 }}</span>
                                    <span class="text-gray-500 font-medium">komentar</span>
                                </div>
                            </div>
                        </div>
                        @php
                            $statusColors = [
                                'Baru' => 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-blue-200',
                                'Dalam Pengerjaan' => 'bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-yellow-200',
                                'Selesai' => 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-green-200',
                                'Ditolak' => 'bg-gradient-to-r from-red-500 to-rose-600 text-white shadow-red-200',
                            ];
                            $statusClass = $statusColors[$report->status ?? 'Baru'] ?? 'bg-gradient-to-r from-gray-500 to-gray-600 text-white';
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-bold {{ $statusClass }} shadow-lg flex items-center gap-2">
                            @if($report->status == 'Baru')
                                <i class="fa-solid fa-sparkles animate-pulse"></i>
                            @elseif($report->status == 'Dalam Pengerjaan')
                                <i class="fa-solid fa-sync animate-spin"></i>
                            @elseif($report->status == 'Selesai')
                                <i class="fa-solid fa-check-double"></i>
                            @else
                                <i class="fa-solid fa-fire"></i>
                            @endif
                            {{ $report->status ?? 'Baru' }}
                        </span>
                    </div>
                </a>
                @empty
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 mb-6 shadow-lg">
                        <i class="fa-regular fa-folder-open text-5xl text-blue-500 animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada laporan</h3>
                    <p class="text-gray-500 mb-6">Mulai laporkan masalah di sekitarmu!</p>
                    <button onclick="window.location.href='{{ route('reports.create') }}'"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-full font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <i class="fa-solid fa-plus-circle"></i>
                        Buat Laporan Pertama
                    </button>
                </div>
                @endforelse
            </div>

            <div id="komentar-content" class="tab-content hidden">
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 mb-6 shadow-lg">
                        <i class="fa-regular fa-comments text-5xl text-purple-500 animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada komentar</h3>
                    <p class="text-gray-500">Komentar Anda akan muncul di sini</p>
                </div>
            </div>

            <div id="vote-content" class="tab-content hidden">
                <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-300">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-red-100 to-rose-200 mb-6 shadow-lg">
                        <i class="fa-regular fa-heart text-5xl text-red-500 animate-pulse"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada vote</h3>
                    <p class="text-gray-500">Vote Anda akan muncul di sini</p>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<script>
// Tab functionality dengan animasi smooth
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;

            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-600');
            });

            // Add active class to clicked button
            this.classList.add('active', 'bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-lg');
            this.classList.remove('text-gray-600');

            // Hide all tab contents with fade effect
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show selected tab content with fade effect
            document.getElementById(`${tabName}-content`).classList.remove('hidden');
        });
    });
});
</script>
@endsection