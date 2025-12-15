@extends('layouts.app')

@section('title', ($report['title'] ?? 'Detail Laporan') . ' - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail_reports.css') }}">
@endpush

@section('content')
<<<<<<< Updated upstream
<div style="display: flex; min-height: 100vh; background: white;">
    <!-- Sidebar -->
    <aside style="width: 250px; background: white; padding: 24px; border-right: 1px solid #e5e7eb; overflow-y: auto;">
        <div style="font-size: 24px; font-weight: 700; margin-bottom: 32px; color: #1f2937;">
            <span style="color: #3b82f6;">Laporin</span>Aja
=======
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
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    @php
                        $href = '#';
                        if ($route !== '#') {
                            try {
                                $href = \Route::has($route) ? route($route) : '#';
                            } catch (\Exception $e) {
                                $href = '#';
                            }
                        }
                    @endphp
                    <a href="{{ $href }}"
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
>>>>>>> Stashed changes
        </div>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 12px;"><a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-solid fa-house"></i> Home</a></li>
            <li style="margin-bottom: 12px;"><a href="{{ route('explore') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-solid fa-hashtag"></i> Explore</a></li>
            <li style="margin-bottom: 12px;"><a href="{{ route('notifications') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-regular fa-bell"></i> Notification</a></li>
            <li style="margin-bottom: 12px;"><a href="{{ route('messages') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-regular fa-envelope"></i> Messages</a></li>
            <li style="margin-bottom: 12px;"><a href="{{ route('my-reports') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-solid fa-clipboard-list"></i> My Reports</a></li>
            <li style="margin-bottom: 12px;"><a href="{{ route('communities') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-solid fa-users"></i> Communities</a></li>
            <li style="margin-bottom: 12px;"><a href="{{ route('profile') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #6b7280; text-decoration: none; border-radius: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'; this.style.color='#1f2937';" onmouseout="this.style.background=''; this.style.color='#6b7280';"><i class="fa-regular fa-user"></i> Profile</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main style="flex: 1; background-color: #f9fafb;">
        <!-- Header -->
        <header style="background: white; padding: 16px 32px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10;">
            <a href="{{ route('explore') }}" style="display: flex; align-items: center; gap: 8px; color: #3b82f6; text-decoration: none; font-weight: 600; font-size: 14px; transition: color 0.3s ease;" onmouseover="this.style.color='#2563eb';" onmouseout="this.style.color='#3b82f6';"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        </header>

        <!-- Content -->
        <div style="padding: 32px; max-width: 1000px; margin: 0 auto;">
            <!-- Report Section -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; border: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px;">{{ substr($report['user']['name'] ?? 'U', 0, 1) }}</div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin: 0;">{{ $report['user']['name'] ?? 'Anonymous' }}</h4>
                        <p style="font-size: 12px; color: #9ca3af; margin: 0;">@{{ $report['user']['username'] ?? 'user' }} • {{ $report['created_at'] ?? 'Baru saja' }}</p>
                    </div>
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #4b5563; margin-bottom: 16px;">{{ $report['description'] ?? 'Tidak ada deskripsi' }}</p>

                @if(!empty($report['image']))
                    <img src="{{ asset($report['image']) }}" alt="Report Image" style="width: 100%; max-height: 400px; border-radius: 8px; object-fit: cover; margin-bottom: 16px;">
                @else
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='600' height='400'%3E%3Crect fill='%23ccc' width='600' height='400'/%3E%3C/svg%3E" alt="Report Image" style="width: 100%; max-height: 400px; border-radius: 8px; object-fit: cover; margin-bottom: 16px;">
                @endif

                <div style="display: flex; gap: 16px; flex-wrap: wrap; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280;">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $report['location'] ?? 'Tidak diketahui' }}
                    </div>
                    <div>
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ $report['status'] ?? 'Baru' }}</span>
                    </div>
                </div>
            </div>

<<<<<<< Updated upstream
            <!-- Voting Section -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; border: 1px solid #e5e7eb;">
                <div style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">
                    <i class="fa-solid fa-thumbs-up"></i> Apakah menurut anda ini penting?
=======
            <!-- Google Maps Display -->
            @include('components.google-maps-display', ['location' => $report['location'] ?? null])

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
>>>>>>> Stashed changes
                </div>

                <div style="display: flex; gap: 12px;">
                    <button style="flex: 1; padding: 12px 16px; border: 2px solid #86efac; background: #f0fdf4; border-radius: 20px; cursor: pointer; font-weight: 600; font-size: 15px; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; color: #15803d;" onmouseover="this.style.background='#dcfce7';" onmouseout="this.style.background='#f0fdf4';"><i class="fa-solid fa-thumbs-up"></i> Penting ({{ $report['votes'] ?? 0 }})</button>
                    <button style="flex: 1; padding: 12px 16px; border: 2px solid #fca5a5; background: #fef2f2; border-radius: 20px; cursor: pointer; font-weight: 600; font-size: 15px; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; color: #991b1b;" onmouseover="this.style.background='#fee2e2';" onmouseout="this.style.background='#fef2f2';"><i class="fa-solid fa-thumbs-down"></i> Tidak Penting</button>
                </div>
            </div>

            <!-- Comments Section -->
            <div style="background: white; border-radius: 12px; padding: 24px; border: 1px solid #e5e7eb;">
                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 16px; margin-top: 0;">
                    <i class="fa-solid fa-comments"></i> Komentar ({{ $report['comments'] ?? 0 }})
                </h3>

                <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                    <textarea placeholder="Berikan komentar Anda..." style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 80px;" onmouseover="this.style.borderColor='#3b82f6';" onmouseout="this.style.borderColor='#d1d5db';"></textarea>
                    <button style="margin-top: 8px; padding: 8px 16px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.3s ease;" onmouseover="this.style.background='#2563eb';" onmouseout="this.style.background='#3b82f6';"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @php
                        $dummyComments = [
                            [
                                'author' => 'Jerinta Kim',
                                'time' => '3 jam',
                                'text' => 'Saya juga pernah lewat sini setidak raja... Lubang tersebut memang sangat besar dan sungguh membahayakan. Mohon juga segerakan proses perbaikan agar tidak terjadi kecelakaan.',
                                'likes' => 1
                            ],
                            [
                                'author' => 'Jerinta Kim',
                                'time' => '3 jam',
                                'text' => 'Saya juga pernah lewat sini setidak raja... Lubang tersebut memang sangat besar dan sungguh membahayakan. Mohon juga segerakan proses perbaikan agar tidak terjadi kecelakaan.',
                                'likes' => 1
                            ],
                            [
                                'author' => 'Jerinta Kim',
                                'time' => '3 jam',
                                'text' => 'Saya juga pernah lewat sini setidak raja... Lubang tersebut memang sangat besar dan sungguh membahayakan. Mohon juga segerakan proses perbaikan agar tidak terjadi kecelakaan.',
                                'likes' => 1
                            ]
                        ];
                    @endphp
                    @foreach($dummyComments as $comment)
                        <div style="display: flex; gap: 12px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; flex-shrink: 0;">{{ substr($comment['author'], 0, 1) }}</div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                    <span style="font-weight: 600; color: #1f2937; font-size: 14px;">{{ $comment['author'] }}</span>
                                    <span style="font-size: 12px; color: #9ca3af;">{{ $comment['time'] }}</span>
                                </div>
                                <p style="font-size: 14px; color: #374151; line-height: 1.5; margin: 0;">{{ $comment['text'] }}</p>
                                <div style="font-size: 12px; color: #9ca3af; margin-top: 8px;"><i class="fa-solid fa-thumbs-up"></i> {{ $comment['likes'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
<<<<<<< Updated upstream
=======
            
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
                               ($report['status'] === 'Ditolak' ? 'bg-red-50 hover:bg-red-100' : 'bg-yellow-50 hover:bg-yellow-100')) }} rounded-lg transition-colors">
                            <span class="text-xs text-gray-600">Status</span>
                            <span class="text-xs font-bold 
                                {{ $report['status'] === 'Selesai' ? 'text-green-700' : 
                                   ($report['status'] === 'Dalam Pengerjaan' ? 'text-blue-700' : 
                                   ($report['status'] === 'Ditolak' ? 'text-red-700' : 'text-yellow-700')) }}">
                                @if($report['status'] === 'Dalam Pengerjaan')
                                    Sedang Diproses
                                @else
                                    {{ $report['status'] ?? 'Baru' }}
                                @endif
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
                
                <!-- Related Reports - Laporan dengan kategori dan lokasi yang sama -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl shadow-md border border-orange-200 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-fire text-orange-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Laporan Terkait</h3>
                    </div>
                    
                    <div class="space-y-3">
                        @php
                            // Cari laporan lain dengan kategori dan lokasi yang sama
                            $relatedReports = [];
                            if($reportModel) {
                                $relatedReports = App\Models\Report::where('category_id', $reportModel->category_id)
                                    ->where('location', 'LIKE', substr($reportModel->location ?? '', 0, 5) . '%')
                                    ->where('id', '!=', $reportModel->id)
                                    ->with('user')
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get();
                            }
                        @endphp
                        
                        @forelse($relatedReports as $related)
                            <a href="{{ route('reports.show', $related->id) }}" class="block p-3 bg-white hover:bg-orange-50 rounded-lg border border-orange-100 hover:border-orange-300 transition-all group">
                                <h4 class="font-medium text-xs text-gray-900 mb-1.5 group-hover:text-orange-600 line-clamp-2 leading-tight">{{ $related->title }}</h4>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-1 text-xs text-orange-600">
                                        <i class="fa-solid fa-thumbs-up"></i>
                                        <span class="font-semibold">{{ $related->votes()->where('is_upvote', 1)->count() }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">{{ $related->comments->count() }} komentar</span>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-xs text-gray-500 py-4">
                                <i class="fa-solid fa-inbox text-2xl mb-2 block opacity-50"></i>
                                Tidak ada laporan terkait
                            </p>
                        @endforelse
                    </div>
                </div>
                
            </div>
            
>>>>>>> Stashed changes
        </div>
    </main>
</div>
@endsection