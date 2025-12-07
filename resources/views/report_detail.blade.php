@extends('layouts.app')

@section('title', 'Detail Laporan - LaporinAja')

@push('styles')
    {{-- optional, kalau nanti mau custom css --}}
    <link rel="stylesheet" href="{{ asset('css/report_detail.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    {{-- 🧭 LEFT SIDEBAR (SAMA SEPERTI HOMEPAGE) --}}
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
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
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600
                              font-medium transition-all hover:bg-blue-50 hover:text-blue-600">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
                           text-white py-3 rounded-full shadow-md transition-all font-semibold">
                <i class="fa-solid fa-plus-circle"></i> Laporan Baru
            </button>
        </div>

        {{-- Profile Section bawah sidebar --}}
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">
                    {{ session('user.name', 'Guest') }}
                </span>
                <span class="text-xs text-gray-500">
                    {{ session('user.email', 'user@mail.com') }}
                </span>
            </div>
        </div>
    </aside>

 <!-- 📰 Main Content -->
<main class="flex-[1.7] flex flex-col border-r border-gray-200 bg-white p-6 overflow-y-auto">

    <div class="max-w-[1200px] mx-auto">
        
        <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">
            ← Kembali
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
            
            <!-- Header -->
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-12 h-12 rounded-full">
                <div>
                    <h2 class="font-semibold text-gray-800">{{ $report['user']['name'] }}</h2>
                    <p class="text-xs text-gray-500">{{ $report['created_at'] }} • {{ $report['location'] }}</p>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-lg font-bold text-gray-900 mb-3">{{ $report['title'] }}</h1>

            <!-- Image -->
            <img src="{{ asset($report['image']) }}" 
                 class="rounded-xl mb-4 w-full max-h-[520px] object-cover">

            <!-- Desc -->
            <p class="text-gray-700 leading-relaxed mb-4">{{ $report['description'] }}</p>

            <!-- Tags -->
            <div class="flex gap-3 mb-6">
                <span class="px-3 py-1 text-xs rounded-full bg-pink-100 text-pink-700">{{ $report['status'] }}</span>
                <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ $report['category'] }}</span>
            </div>

            <!-- Voting -->
            <div class="border border-gray-200 rounded-xl p-4 mb-6">
                <p class="text-sm font-semibold text-gray-800 mb-3">
                    Apakah menurutmu ini penting?
                </p>
                <div class="flex gap-4">
                    <button class="flex-1 bg-green-100 text-green-700 py-2 rounded-xl hover:bg-green-200 transition">
                        Penting
                    </button>
                    <button class="flex-1 bg-red-100 text-red-700 py-2 rounded-xl hover:bg-red-200 transition">
                        Tidak Penting
                    </button>
                </div>
            </div>

            <!-- Komentar Section -->
            <div class="border border-gray-200 rounded-xl p-4">
                <p class="font-semibold text-gray-800 mb-3">Komentar (3)</p>

                <!-- Input -->
                <input type="text" placeholder="Tambahkan komentar..."
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 mb-5">

                <!-- Comment List -->
                @foreach ([1,2,3] as $i)
                <div class="flex gap-3 mb-4 pb-4 border-b last:border-0">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-semibold text-gray-800">Jennie Kim • <span class="text-xs text-gray-500">2 jam lalu</span></p>
                        <p class="text-sm text-gray-700">
                            Saya juga sering lewat sini setiap pagi. Lubangnya makin dalam apalagi setelah hujan kemarin.
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

    </div>

</main>


    {{-- 📊 RIGHT SIDEBAR (kalau mau kosong juga boleh dihapus) --}}
    <aside class="w-[340px] bg-white p-6 overflow-y-auto border-l border-gray-200">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Penting
            </h2>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-[11px] text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-xs font-semibold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-[11px] text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-xs font-semibold text-red-600">96 Votes</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-[11px] text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-[11px] bg-pink-100 text-pink-700 font-medium">
                        Penting
                    </span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-[11px] text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-[11px] bg-yellow-100 text-yellow-700 font-medium">
                        Sedang
                    </span>
                </li>
            </ul>
        </section>
    </aside>
</div>

{{-- FontAwesome --}}
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection
