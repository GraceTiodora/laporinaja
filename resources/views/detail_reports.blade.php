@extends('layouts.app')

@section('title', ($report['title'] ?? 'Detail Laporan') . ' - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail_reports.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto" style="background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);">

    <!-- Left Sidebar -->
    <aside class="backdrop-blur-sm border-r border-gray-200 p-6 flex flex-col justify-between" style="width: 270px; background: linear-gradient(to bottom, rgba(255,255,255,0.98) 0%, rgba(248,250,252,0.98) 100%);">
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
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
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
        @if(session('user'))
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <div class="relative">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold ring-2 ring-gray-200">
                    {{ substr(session('user.name', 'U'), 0, 1) }}
                </div>
                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
            </div>
            <div class="flex flex-col leading-tight flex-1">
                <span class="text-sm font-bold text-gray-800">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">{{ session('user.email', '') }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-2 hover:bg-red-50 rounded-lg">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
        @endif
    </aside> 

    <!-- Main Content -->
    <main class="flex-1 flex flex-col border-r border-gray-200 overflow-y-auto" style="background: linear-gradient(to bottom right, #f0f9ff 0%, #dbeafe 50%, #ffffff 100%);">
        
        <!-- Header -->
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10 shadow-sm">
            <a href="javascript:history.back()" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> 
                <span>Kembali</span>
            </a>
        </header>

        <div class="p-6 space-y-6">
            <!-- Report Section -->
            <div class="report-section">
                <div class="report-author">
                    <div class="author-avatar">{{ substr($report['user']['name'] ?? 'U', 0, 1) }}</div>
                    <div class="author-info">
                        <h4>{{ $report['user']['name'] ?? 'Anonymous' }}</h4>
                        <p class="author-meta">{{ $report['created_at'] ?? 'Baru saja' }}</p>
                    </div>
                </div>

                <h1 class="report-title">{{ $report['title'] ?? 'Laporan' }}</h1>

                <div class="report-description">
                    <p class="report-description-text">{{ $report['description'] ?? 'Tidak ada deskripsi' }}</p>
                </div>

                @if(!empty($report['image']))
                    <img src="{{ asset($report['image']) }}" alt="Report Image" class="report-image">
                @else
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='400'%3E%3Crect fill='%23ccc' width='600' height='400'/%3E%3C/svg%3E" alt="Report Image" class="report-image">
                @endif

                <div class="report-meta">
                    <div class="meta-item">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $report['location'] ?? 'Tidak diketahui' }}
                    </div>
                    @php
                        $categoryColors = [
                            'Infrastruktur' => 'background: #dbeafe; color: #1e40af;',
                            'Keamanan' => 'background: #fee2e2; color: #b91c1c;',
                            'Sanitasi' => 'background: #f3e8ff; color: #6b21a8;',
                            'Taman' => 'background: #dcfce7; color: #166534;',
                            'Aksesibilitas' => 'background: #fef3c7; color: #92400e;',
                        ];
                        $categoryStyle = $categoryColors[$report['category']] ?? 'background: #f3f4f6; color: #374151;';
                    @endphp
                    <span class="meta-item" style="{{ $categoryStyle }}">{{ $report['category'] ?? 'Umum' }}</span>
                    <span class="meta-status-badge">{{ $report['status'] ?? 'Baru' }}</span>
                </div>
            </div>

            <!-- Voting Section -->
            @php
                $totalVotes = ($report['votes'] ?? 0) + ($report['downvotes'] ?? 0);
                $pentingPercentage = $totalVotes > 0 ? round(($report['votes'] ?? 0) / $totalVotes * 100) : 0;
                $tidakPentingPercentage = $totalVotes > 0 ? round(($report['downvotes'] ?? 0) / $totalVotes * 100) : 0;
            @endphp
            
            <div class="voting-section">
                <div class="voting-header">
                    <div class="voting-title">
                        <i class="fa-solid fa-poll-h"></i> 
                        <span>Pendapat Masyarakat</span>
                    </div>
                    <div class="total-votes">
                        <i class="fa-solid fa-users"></i> {{ $totalVotes }} Suara
                    </div>
                </div>

                <div class="voting-question">
                    Apakah menurut Anda laporan ini penting untuk ditindaklanjuti?
                </div>

                <!-- Vote Statistics -->
                <div class="vote-stats">
                    <div class="vote-stat-item penting-stat">
                        <div class="stat-header">
                            <div class="stat-label">
                                <i class="fa-solid fa-thumbs-up"></i>
                                <span>Penting</span>
                            </div>
                            <div class="stat-percentage">{{ $pentingPercentage }}%</div>
                        </div>
                        <div class="stat-bar">
                            <div class="stat-bar-fill penting-fill" style="width: {{ $pentingPercentage }}%"></div>
                        </div>
                        <div class="stat-count">{{ $report['votes'] ?? 0 }} orang</div>
                    </div>

                    <div class="vote-stat-item tidak-penting-stat">
                        <div class="stat-header">
                            <div class="stat-label">
                                <i class="fa-solid fa-thumbs-down"></i>
                                <span>Tidak Penting</span>
                            </div>
                            <div class="stat-percentage">{{ $tidakPentingPercentage }}%</div>
                        </div>
                        <div class="stat-bar">
                            <div class="stat-bar-fill tidak-penting-fill" style="width: {{ $tidakPentingPercentage }}%"></div>
                        </div>
                        <div class="stat-count">{{ $report['downvotes'] ?? 0 }} orang</div>
                    </div>
                </div>

                <!-- Vote Buttons -->
                <div class="vote-buttons">
                    <form action="{{ route('reports.vote', $report['id']) }}" method="POST" class="vote-form" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="upvote" value="1">
                        <button type="submit" class="vote-btn vote-btn-penting">
                            <div class="vote-btn-icon">
                                <i class="fa-solid fa-thumbs-up"></i>
                            </div>
                            <div class="vote-btn-text">
                                <span class="vote-btn-label">Penting</span>
                                <span class="vote-btn-sublabel">Perlu segera ditangani</span>
                            </div>
                        </button>
                    </form>
                    
                    <form action="{{ route('reports.vote', $report['id']) }}" method="POST" class="vote-form" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="upvote" value="0">
                        <button type="submit" class="vote-btn vote-btn-tidak-penting">
                            <div class="vote-btn-icon">
                                <i class="fa-solid fa-thumbs-down"></i>
                            </div>
                            <div class="vote-btn-text">
                                <span class="vote-btn-label">Tidak Penting</span>
                                <span class="vote-btn-sublabel">Bisa ditangani nanti</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="comments-section">
                <h3 class="comments-title">
                    <i class="fa-solid fa-comments"></i> Komentar ({{ $report['comments'] ?? 0 }})
                </h3>

                @if(session('user'))
                    <form action="{{ route('reports.comment', $report['id']) }}" method="POST" class="comment-form">
                        @csrf
                        <textarea 
                            name="content"
                            placeholder="Berikan komentar Anda..." 
                            class="comment-input"
                            required
                        ></textarea>
                        <button type="submit">
                            <i class="fa-solid fa-paper-plane"></i> Kirim
                        </button>
                    </form>
                @else
                    <div style="margin-bottom: 24px; padding: 16px; background: #fffbeb; border-radius: 8px; color: #92400e; font-size: 14px;">
                        <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Login</a> untuk menambahkan komentar.
                    </div>
                @endif

                <div class="comments-list">
                    @forelse($reportModel->comments as $comment)
                        <div class="comment-item">
                            <div class="comment-avatar">{{ substr($comment->user->name ?? 'U', 0, 1) }}</div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                    <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="comment-text">{{ $comment->content }}</p>
                                <div class="comment-likes">
                                    <i class="fa-solid fa-thumbs-up"></i> 0
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-comments">
                            <i class="fa-regular fa-comments"></i>
                            <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const voteForms = document.querySelectorAll('.vote-form');
    
    voteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const url = form.action;
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update vote counts
                const totalVotes = data.upvotes + data.downvotes;
                const pentingPercentage = totalVotes > 0 ? Math.round((data.upvotes / totalVotes) * 100) : 0;
                const tidakPentingPercentage = totalVotes > 0 ? Math.round((data.downvotes / totalVotes) * 100) : 0;
                
                // Update UI
                document.querySelector('.total-votes').innerHTML = `<i class="fa-solid fa-users"></i> ${totalVotes} Suara`;
                
                // Update Penting stats
                document.querySelector('.penting-stat .stat-percentage').textContent = pentingPercentage + '%';
                document.querySelector('.penting-fill').style.width = pentingPercentage + '%';
                document.querySelector('.penting-stat .stat-count').textContent = data.upvotes + ' orang';
                
                // Update Tidak Penting stats
                document.querySelector('.tidak-penting-stat .stat-percentage').textContent = tidakPentingPercentage + '%';
                document.querySelector('.tidak-penting-fill').style.width = tidakPentingPercentage + '%';
                document.querySelector('.tidak-penting-stat .stat-count').textContent = data.downvotes + ' orang';
                
                // Visual feedback
                const btn = form.querySelector('.vote-btn');
                btn.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    btn.style.transform = '';
                }, 200);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat voting. Silakan coba lagi.');
            });
        });
    });
});
</script>
@endpush