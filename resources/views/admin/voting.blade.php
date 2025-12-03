@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/voting.css') }}">
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
            'image' => 'report-1.jpg',
            'total_votes' => 53,
            'urgent_votes' => 45,
            'not_urgent_votes' => 8,
            'urgent_percentage' => 85
        ]
    ]);
@endphp

<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR (sama seperti monitoring) --}}
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2 text-sm">
                @php
                    $menu = [
                        ['Beranda', 'admin.dashboard', 'fa-solid fa-house'],
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

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800 mb-1">Voting Publik</h1>
            <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Info Card --}}
        <div class="info-card bg-white rounded-2xl border border-gray-200 p-6 mb-8">
            <p class="text-gray-900 text-base leading-relaxed">
                Vote laporan untuk membantu kepala desa menentukan masalah mana yang harus ditangani lebih dulu
            </p>
        </div>

        {{-- Reports List --}}
        <div class="space-y-6">
            @forelse($reports as $report)
            <div class="report-card bg-white rounded-2xl border border-gray-200 p-6">
                {{-- User Info --}}
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/profile-user.jpg' . $report->user_avatar) }}" 
                         class="w-14 h-14 rounded-full object-cover"
                         alt="{{ $report->user_name }}">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $report->user_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $report->time_ago }}</p>
                    </div>
                </div>

                {{-- Report Image --}}
                <div class="mb-4 rounded-xl overflow-hidden">
                    <img src="{{ asset('images/jalan_berlubang.jpg' . $report->image) }}" 
                         class="w-full max-w-lg h-auto object-cover"
                         alt="Report image">
                </div>

                {{-- Location --}}
                <p class="text-base font-semibold text-gray-900 mb-3">{{ $report->location }}</p>

                {{-- Description --}}
                <p class="text-sm text-gray-700 leading-relaxed mb-5">{{ $report->description }}</p>

                {{-- Voting Section --}}
                <div class="voting-section">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">{{ $report->total_votes }}</span> warga telah memberikan penilaian
                        </p>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->urgent_percentage }}% menilai urgent
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button class="vote-btn vote-urgent">
                            Urgent ({{ $report->urgent_votes }})
                        </button>
                        <button class="vote-btn vote-not-urgent">
                            Tidak Urgent ({{ $report->not_urgent_votes }})
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-500">
                Belum ada laporan untuk divoting
            </div>
            @endforelse
        </div>

    </main>
</div>

@push('scripts')
<script>
  // Vote button interactions
  document.querySelectorAll('.vote-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const card = this.closest('.report-card');
      const allBtns = card.querySelectorAll('.vote-btn');
      
      // Remove active from all buttons in this card
      allBtns.forEach(b => b.classList.remove('active'));
      
      // Add active to clicked button
      this.classList.add('active');
      
      // Here you would send the vote to the backend
      const isUrgent = this.classList.contains('vote-urgent');
      console.log('Vote:', isUrgent ? 'Urgent' : 'Tidak Urgent');
      
      // Show feedback
      const feedback = document.createElement('div');
      feedback.className = 'vote-feedback';
      feedback.textContent = 'Vote berhasil disimpan!';
      this.appendChild(feedback);
      
      setTimeout(() => {
        feedback.remove();
      }, 2000);
    });
  });
</script>
@endpush
@endsection
