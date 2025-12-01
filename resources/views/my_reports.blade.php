@extends('layouts.app')

@section('title', 'My Reports - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/my-reports.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    <!-- 🧭 LEFT SIDEBAR -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

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

            <nav class="space-y-2">
@foreach ($menu as [$name, $route, $icon])
    <a href="{{ $route === '#' ? '#' : (Route::has($route) ? route($route) : '#') }}"
       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all
              {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">

        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
        <span>{{ $name }}</span>
    </a>
@endforeach

            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition font-semibold">
                <i class="fa-solid fa-plus-circle"></i> Laporan Baru
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Justin Hubner') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 MAIN CONTENT -->
    <main class="flex-1 flex flex-col overflow-hidden bg-white">

        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Laporan Saya</h1>

            <div class="flex items-center gap-4">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-16 h-16 rounded-full object-cover">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ session('user.name', 'Justin Hubner') }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        @{{ session('user.username', 'hubnerjustin') }}
                    </p>
                </div>
            </div>
        </header>

        <!-- REPORT LIST -->
        <div class="flex-1 overflow-y-auto px-8 py-6 space-y-4">
            @forelse ($reports as $r)
                <a href="{{ route('reports.show', $r->id) }}" class="block no-underline">
                    <article class="report-card bg-white rounded-xl border shadow-sm hover:shadow-md transition overflow-hidden cursor-pointer">
                        
                        @if($r->image)
                            <img src="{{ asset($r->image) }}" alt="{{ $r->title }}" class="w-full h-40 object-cover">
                        @endif

                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 hover:text-blue-600">
                                {{ $r->title }}
                            </h3>

                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>{{ $r->location }}
                                </span>
                                <span>•</span>
                                <span>{{ $r->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="flex gap-2 mb-3">
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-medium">
                                    {{ ucfirst($r->status ?? 'pending') }}
                                </span>
                                @php
                                    $categoryColors = [
                                        'Infrastruktur' => 'bg-blue-100 text-blue-700',
                                        'Keamanan' => 'bg-red-100 text-red-700',
                                        'Sanitasi' => 'bg-purple-100 text-purple-700',
                                        'Taman' => 'bg-green-100 text-green-700',
                                        'Aksesibilitas' => 'bg-yellow-100 text-yellow-700',
                                    ];
                                    $categoryClass = $categoryColors[$r->category->name] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 text-xs rounded-full {{ $categoryClass }} font-medium">
                                    {{ $r->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            <div class="flex items-center gap-4 text-sm text-gray-500 pt-2 border-t border-gray-100">
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-star"></i> {{ $r->votes_count ?? 0 }} votes
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-comment"></i> {{ $r->comments_count ?? 0 }} komentar
                                </span>
                            </div>
                        </div>
                    </article>
                </a>
            @empty
                <div class="text-center py-16 text-gray-500">
                    <i class="fa-regular fa-clipboard text-6xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-semibold">Belum ada laporan</p>
                </div>
            @endforelse

        </div>
    </main>


</div>
@endsection
