@extends('layouts.app')

@section('title', ($report['title'] ?? 'Detail Laporan') . ' - LaporinAja')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/detail_reports.css') }}">
@endpush

@section('content')
<div style="display: flex; min-height: 100vh; background: white;">
    <!-- Sidebar -->
    <aside style="width: 250px; background: white; padding: 24px; border-right: 1px solid #e5e7eb; overflow-y: auto;">
        <div style="font-size: 24px; font-weight: 700; margin-bottom: 32px; color: #1f2937;">
            <span style="color: #3b82f6;">Laporin</span>Aja
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

            <!-- Voting Section -->
            <div style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; border: 1px solid #e5e7eb;">
                <div style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">
                    <i class="fa-solid fa-thumbs-up"></i> Apakah menurut anda ini penting?
                </div>

                <div style="display: flex; gap: 12px;">
                    <form action="{{ route('reports.vote', $report['id']) }}" method="POST" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="upvote" value="1">
                        <button type="submit" style="width: 100%; padding: 12px 16px; border: 2px solid #86efac; background: #f0fdf4; border-radius: 20px; cursor: pointer; font-weight: 600; font-size: 15px; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; color: #15803d;" onmouseover="this.style.background='#dcfce7';" onmouseout="this.style.background='#f0fdf4';"><i class="fa-solid fa-thumbs-up"></i> Penting ({{ $report['votes'] ?? 0 }})</button>
                    </form>
                    <form action="{{ route('reports.vote', $report['id']) }}" method="POST" style="flex: 1;">
                        @csrf
                        <input type="hidden" name="upvote" value="0">
                        <button type="submit" style="width: 100%; padding: 12px 16px; border: 2px solid #fca5a5; background: #fef2f2; border-radius: 20px; cursor: pointer; font-weight: 600; font-size: 15px; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; color: #991b1b;" onmouseover="this.style.background='#fee2e2';" onmouseout="this.style.background='#fef2f2';"><i class="fa-solid fa-thumbs-down"></i> Tidak Penting ({{ $report['downvotes'] ?? 0 }})</button>
                    </form>
                </div>
            </div>

            <!-- Comments Section -->
            <div style="background: white; border-radius: 12px; padding: 24px; border: 1px solid #e5e7eb;">
                <h3 style="font-size: 16px; font-weight: 600; color: #1f2937; margin-bottom: 16px; margin-top: 0;">
                    <i class="fa-solid fa-comments"></i> Komentar ({{ $report['comments'] ?? 0 }})
                </h3>

                @if(session('user'))
                    <form action="{{ route('reports.comment', $report['id']) }}" method="POST" style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                        @csrf
                        <textarea 
                            name="content"
                            placeholder="Berikan komentar Anda..." 
                            style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; min-height: 80px;" 
                            required
                            onmouseover="this.style.borderColor='#3b82f6';" 
                            onmouseout="this.style.borderColor='#d1d5db';"
                        ></textarea>
                        <button type="submit" style="margin-top: 8px; padding: 8px 16px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.3s ease;" onmouseover="this.style.background='#2563eb';" onmouseout="this.style.background='#3b82f6';"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </form>
                @else
                    <div style="margin-bottom: 24px; padding: 16px; background: #fffbeb; border-radius: 8px; color: #92400e; font-size: 14px;">
                        <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Login</a> untuk menambahkan komentar.
                    </div>
                @endif

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse($reportModel->comments as $comment)
                        <div style="display: flex; gap: 12px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; flex-shrink: 0;">{{ substr($comment->user->name ?? 'U', 0, 1) }}</div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                    <span style="font-weight: 600; color: #1f2937; font-size: 14px;">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                    <span style="font-size: 12px; color: #9ca3af;">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="font-size: 14px; color: #374151; line-height: 1.5; margin: 0;">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 32px; color: #9ca3af;">
                            <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>
@endsection