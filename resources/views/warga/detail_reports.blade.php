@extends('layouts.app')

@section('title', ($report['title'] ?? 'Detail Laporan') . ' - LaporinAja')

@section('content')
<style>
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
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .image-zoom {
        overflow: hidden;
    }
    
    .image-zoom img {
        transition: transform 0.5s ease;
    }
    
    .image-zoom:hover img {
        transform: scale(1.05);
    }
</style>

<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-xl">
        <div>
            <h2 class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300 relative text-gray-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 hover:translate-x-1 hover:shadow-sm">
                        <i class="{{ $icon }} text-lg group-hover:scale-125 transition-transform"></i>
                        <span class="font-semibold">{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 hover:from-blue-700 hover:via-purple-600 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-2xl
                           font-bold tracking-wide transition-all duration-300 hover:scale-105 hover:-translate-y-1">
                <i class="fa-solid fa-plus text-lg"></i>
                <span>Lapor Sekarang</span>
            </button>
        </div>
    </aside>

    <!-- 📱 Main Content Area -->
    <main class="flex-1 bg-gradient-to-br from-gray-50 to-blue-50 overflow-y-auto">
        <!-- Header with Back Button -->
        <header class="bg-white/80 backdrop-blur-lg border-b border-gray-200 px-8 py-4 sticky top-0 z-20 shadow-sm">
            <div class="max-w-7xl mx-auto">
                <a href="{{ route('explore') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-bold text-sm transition-all hover:gap-3">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </header>

        <!-- Content Container with 2-column layout -->
        <div class="p-4 lg:p-8 max-w-[1600px] mx-auto w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Main Content (8/12 width) -->
                <div class="lg:col-span-8 space-y-6">
            <!-- 📋 Report Card -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-lg shadow-md">
                            {{ substr($report['user']['name'] ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900">{{ $report['user']['name'] ?? 'Anonymous' }}</h4>
                            <p class="text-xs text-gray-500">@{{ $report['user']['username'] ?? 'user' }} • {{ $report['created_at'] ?? 'Baru saja' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $report['status'] === 'Selesai' ? 'bg-green-100 text-green-700' : 
                               ($report['status'] === 'Dalam Pengerjaan' ? 'bg-blue-100 text-blue-700' : 
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ $report['status'] ?? 'Baru' }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                        {{ $report['title'] ?? 'Laporan Tanpa Judul' }}
                    </h1>

                    <!-- Description -->
                    @if($report['description'] ?? false)
                        <p class="text-sm leading-relaxed text-gray-700 mb-4">
                            {{ $report['description'] }}
                        </p>
                    @endif
                </div>

                <!-- Image -->
                @if(!empty($report['image']))
                    <div class="relative">
                        <img src="{{ asset($report['image']) }}" alt="Report Image" class="w-full h-auto object-cover">
                        <div class="absolute top-3 right-3">
                            <button class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg hover:bg-white transition-colors">
                                <i class="fa-solid fa-expand text-gray-700"></i>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fa-solid fa-image text-gray-400 text-5xl mb-2"></i>
                            <p class="text-gray-500 text-sm">Tidak ada gambar</p>
                        </div>
                    </div>
                @endif

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 text-sm">
                            <i class="fa-solid fa-location-dot text-blue-600"></i>
                            <span class="font-medium">{{ $report['location'] ?? 'Tidak diketahui' }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-eye"></i>
                                {{ rand(100, 999) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-clock"></i>
                                {{ $report['created_at'] ?? 'Baru' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 👍 Voting Section -->
            <div class="bg-gradient-to-br from-white via-blue-50 to-indigo-50 rounded-xl shadow-md border border-blue-200 p-6">
                @php
                    $upvotes = $report['votes'] ?? 45;
                    $downvotes = $report['downvotes'] ?? 12;
                    $totalVotes = $upvotes + $downvotes;
                    $upvotePercent = $totalVotes > 0 ? round(($upvotes / $totalVotes) * 100) : 50;
                    $downvotePercent = $totalVotes > 0 ? round(($downvotes / $totalVotes) * 100) : 50;
                @endphp
                
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-bar text-blue-600"></i>
                        <span>Tingkat Kepentingan</span>
                    </h3>
                    <span class="text-xs font-semibold text-gray-500 bg-white px-3 py-1 rounded-full">
                        {{ $totalVotes }} suara
                    </span>
                </div>
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div class="bg-white rounded-lg p-4 border-2 border-green-200 hover:border-green-400 transition-colors cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <i class="fa-solid fa-thumbs-up text-green-600"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-600">Penting</span>
                            </div>
                            <span class="text-2xl font-bold text-green-600 upvote-percent">{{ $upvotePercent }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span class="upvote-count">{{ $upvotes }} orang</span>
                            <i class="fa-solid fa-arrow-up text-green-500"></i>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 border-2 border-red-200 hover:border-red-400 transition-colors cursor-pointer group">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                                    <i class="fa-solid fa-thumbs-down text-red-600"></i>
                                </div>
                                <span class="text-xs font-medium text-gray-600">Tidak</span>
                            </div>
                            <span class="text-2xl font-bold text-red-600 downvote-percent">{{ $downvotePercent }}%</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span class="downvote-count">{{ $downvotes }} orang</span>
                            <i class="fa-solid fa-arrow-down text-red-500"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Visual Progress Bar -->
                <div class="mb-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-medium text-gray-600">Distribusi Suara</span>
                    </div>
                    <div class="relative h-3 bg-gray-200 rounded-full overflow-hidden">
                        <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-green-500 to-green-400 transition-all duration-500 progress-bar-up" 
                             style="width: {{ $upvotePercent }}%"></div>
                        <div class="absolute top-0 right-0 h-full bg-gradient-to-l from-red-500 to-red-400 transition-all duration-500 progress-bar-down" 
                             style="width: {{ $downvotePercent }}%"></div>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span class="text-xs text-green-600 font-semibold">{{ $upvotePercent }}% Penting</span>
                        <span class="text-xs text-red-600 font-semibold">{{ $downvotePercent }}% Tidak</span>
                    </div>
                </div>
                
                <!-- Vote Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <form action="{{ route('reports.vote', $report['id']) }}" method="POST" class="vote-form">
                        @csrf
                        <input type="hidden" name="upvote" value="1">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all vote-btn-up">
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span>Penting</span>
                        </button>
                    </form>
                    <form action="{{ route('reports.vote', $report['id']) }}" method="POST" class="vote-form">
                        @csrf
                        <input type="hidden" name="upvote" value="0">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all vote-btn-down">
                            <i class="fa-solid fa-thumbs-down"></i>
                            <span>Tidak</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- 💬 Comments Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-comments text-blue-600"></i>
                    <span>Komentar ({{ $report['comments'] ?? 0 }})</span>
                </h3>

                <!-- Comment Form -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    @if(session()->has('user'))
                        <form action="{{ route('reports.comment', $report['id'] ?? 1) }}" method="POST">
                            @csrf
                            <textarea name="content" placeholder="Tulis komentar Anda..." 
                                class="w-full p-4 border border-gray-300 bg-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical min-h-[100px] text-sm transition-all" 
                                rows="3" required></textarea>
                            <button type="submit" class="mt-3 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-sm transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> 
                                <span>Kirim Komentar</span>
                            </button>
                        </form>
                    @else
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                            <p class="text-sm text-blue-700">
                                <i class="fa-solid fa-lock mr-2"></i>
                                <a href="{{ route('login') }}" class="font-semibold hover:underline">Login</a> untuk menambahkan komentar
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Comments List -->
                <div class="flex flex-col gap-4">
                    @if($reportModel->comments->count() > 0)
                        @foreach($reportModel->comments as $comment)
                            <div class="flex gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                    {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900 text-sm">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                        <span class="text-xs text-gray-400">• {{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-relaxed mb-2">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-comments text-3xl mb-3 opacity-50"></i>
                            <p class="text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                        </div>
                    @endif
                </div>
                
                <!-- Load More Comments -->
                <div class="mt-5 text-center">
                    <button class="px-5 py-2.5 text-blue-600 hover:text-blue-700 font-semibold rounded-lg hover:bg-blue-50 transition-all border border-blue-200 hover:border-blue-300 text-sm">
                        <i class="fa-solid fa-chevron-down mr-1"></i>
                        Muat Lebih Banyak
                    </button>
                </div>
            </div>
            
            </div>
            
            <!-- Sidebar (4/12 width) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Quick Info Card -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-5">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-info-circle text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Informasi Laporan</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <!-- Report ID -->
                        <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <span class="text-xs text-gray-600">ID Laporan</span>
                            <span class="text-xs font-bold text-gray-900">#{{ $report['id'] ?? '12' }}</span>
                        </div>
                        
                        <!-- Category -->
                        <div class="flex items-center justify-between p-2.5 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <span class="text-xs text-gray-600">Kategori</span>
                            <span class="text-xs font-bold text-blue-700">{{ $report['category']['name'] ?? 'Umum' }}</span>
                        </div>
                        
                        <!-- Status -->
                        <div class="flex items-center justify-between p-2.5 
                            {{ $report['status'] === 'Selesai' ? 'bg-green-50 hover:bg-green-100' : 
                               ($report['status'] === 'Dalam Pengerjaan' ? 'bg-blue-50 hover:bg-blue-100' : 
                               'bg-yellow-50 hover:bg-yellow-100') }} rounded-lg transition-colors">
                            <span class="text-xs text-gray-600">Status</span>
                            <span class="text-xs font-bold 
                                {{ $report['status'] === 'Selesai' ? 'text-green-700' : 
                                   ($report['status'] === 'Dalam Pengerjaan' ? 'text-blue-700' : 
                                   'text-yellow-700') }}">
                                {{ $report['status'] ?? 'Baru' }}
                            </span>
                        </div>
                        
                        <!-- Date -->
                        <div class="flex items-center justify-between p-2.5 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <span class="text-xs text-gray-600">Tanggal</span>
                            <span class="text-xs font-bold text-purple-700">{{ $report['created_at'] ?? '8 hours ago' }}</span>
                        </div>
                        
                        <!-- Views -->
                        <div class="flex items-center justify-between p-2.5 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <span class="text-xs text-gray-600">Dilihat</span>
                            <span class="text-xs font-bold text-green-700">{{ rand(100, 999) }}x</span>
                        </div>
                    </div>
                    
                    <!-- Share Button -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <button id="shareBtn" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-share-nodes"></i>
                            Bagikan Laporan
                        </button>
                    </div>
                </div>
                
                <!-- Related Reports -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl shadow-md border border-orange-200 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-fire text-orange-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Laporan Terkait</h3>
                    </div>
                    
                    <div class="space-y-3">
                        @php
                            $relatedReports = [
                                ['title' => 'Jalan Berlubang di Raya Cibaduyut', 'votes' => 24],
                                ['title' => 'Lampu Jalan Mati Sudah 3 Hari', 'votes' => 18],
                                ['title' => 'Saluran Air Tersumbat', 'votes' => 15],
                            ];
                        @endphp
                        @foreach($relatedReports as $related)
                            <a href="#" class="block p-3 bg-white hover:bg-orange-50 rounded-lg border border-orange-100 hover:border-orange-300 transition-all group">
                                <h4 class="font-medium text-xs text-gray-900 mb-1.5 group-hover:text-orange-600 line-clamp-2 leading-tight">{{ $related['title'] }}</h4>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1 text-xs text-orange-600">
                                        <i class="fa-solid fa-thumbs-up"></i>
                                        <span class="font-semibold">{{ $related['votes'] }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ rand(50, 200) }} views</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Help Card -->
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-lg p-5 text-white">
                    <div class="text-center">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-headset text-2xl"></i>
                        </div>
                        <h3 class="text-base font-bold mb-2">Butuh Bantuan?</h3>
                        <p class="text-xs opacity-90 mb-4">Tim kami siap membantu Anda 24/7</p>
                        <button class="w-full py-2.5 px-4 bg-white text-indigo-700 font-semibold rounded-lg hover:bg-gray-100 transition-all text-sm shadow-md">
                            <i class="fa-solid fa-comment-dots mr-1"></i>
                            Hubungi Kami
                        </button>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>

<script>
// Share functionality using Web Share API
document.getElementById('shareBtn')?.addEventListener('click', async function() {
    const shareData = {
        title: '{{ $report["title"] ?? "Laporan" }}',
        text: '{{ substr($report["description"] ?? "", 0, 100) }}...',
        url: window.location.href
    };

    if (navigator.share) {
        try {
            await navigator.share(shareData);
        } catch (err) {
            if (err.name !== 'AbortError') {
                console.error('Error sharing:', err);
            }
        }
    } else {
        // Fallback: copy to clipboard
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link telah disalin ke clipboard!');
        }).catch(err => {
            console.error('Failed to copy:', err);
        });
    }
});

// Vote forms - submit via AJAX
document.querySelectorAll('.vote-form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const upvote = formData.get('upvote') === '1';
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    upvote: upvote,
                    _token: document.querySelector('input[name="_token"]')?.value
                })
            });

            if (response.status === 401) {
                window.location.href = '{{ route("login") }}';
                return;
            }

            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            
            // Update vote display
            const upvotePercent = Math.round((data.upvotes / (data.upvotes + data.downvotes)) * 100) || 50;
            const downvotePercent = 100 - upvotePercent;

            // Update numbers and percentages
            const upvoteSpan = document.querySelector('.upvote-percent');
            const downvoteSpan = document.querySelector('.downvote-percent');
            const upvoteCount = document.querySelector('.upvote-count');
            const downvoteCount = document.querySelector('.downvote-count');
            const progressBarUp = document.querySelector('.progress-bar-up');
            const progressBarDown = document.querySelector('.progress-bar-down');

            if (upvoteSpan) upvoteSpan.textContent = upvotePercent + '%';
            if (downvoteSpan) downvoteSpan.textContent = downvotePercent + '%';
            if (upvoteCount) upvoteCount.textContent = data.upvotes;
            if (downvoteCount) downvoteCount.textContent = data.downvotes;
            if (progressBarUp) progressBarUp.style.width = upvotePercent + '%';
            if (progressBarDown) progressBarDown.style.width = downvotePercent + '%';

            // Visual feedback
            const btn = this.querySelector('button');
            btn.classList.add('scale-95');
            setTimeout(() => btn.classList.remove('scale-95'), 200);

        } catch (error) {
            console.error('Error:', error);
            alert('Gagal memproses voting. Silakan coba lagi.');
        }
    });
});

// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Add loading animation for images
document.querySelectorAll('img').forEach(img => {
    img.addEventListener('load', function() {
        this.style.opacity = '0';
        this.style.animation = 'fadeInUp 0.6s ease-out forwards';
    });
});
</script>

@endsection