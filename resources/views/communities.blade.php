@extends('layouts.app')

@section('title', 'Communities - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/communities.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- ====================== LEFT SIDEBAR ====================== --}}
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

        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ session('user.name', 'Justin Hubner') }}</p>
                <p class="text-xs text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</p>
            </div>
        </div>
    </aside>

    {{-- ====================== COMMUNITIES LIST PANEL ====================== --}}
    <aside class="w-[380px] bg-white border-r border-gray-200 flex flex-col">

        {{-- SEARCH + TITLE --}}
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-800 mb-4">Komunitas</h1>

            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Cari Komunitas..."
                    class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- COMMUNITY ITEMS --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3">
            @php
                $communities = [
                    ['name' => 'RT 01 / RW 05', 'members' => '120 orang', 'active' => false],
                    ['name' => 'RT 02 / RW 05', 'members' => '234 Members', 'active' => false],
                    ['name' => 'RT 03 / RW 05', 'members' => '187 orang', 'active' => false],
                    ['name' => 'Medan Tembung', 'members' => '1.309 orang', 'active' => false],
                    ['name' => 'Medan', 'members' => '3.000 orang', 'active' => true],
                ];
            @endphp

            @foreach($communities as $community)
                <div class="community-card cursor-pointer p-4 rounded-xl border
                    {{ $community['active'] ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200 hover:bg-gray-50' }}">
                    <p class="font-semibold text-gray-800">{{ $community['name'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-user-group text-xs"></i>
                        {{ $community['members'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </aside>

    {{-- ====================== FEED AREA ====================== --}}
    <main class="flex-1 flex flex-col bg-white overflow-hidden">

        <header class="border-b border-gray-200 px-8 py-6">
            <h2 class="text-2xl font-bold text-gray-800">Laporan Medan</h2>
        </header>

        <div class="flex-1 overflow-y-auto px-12 py-8 space-y-6">

            @php
                $posts = [
                    [
                        'author' => 'Audrey Stark',
                        'time' => '2 jam',
                        'location' => 'Jl. Melati',
                        'text' => 'Jalan berlubang besar dekat sekolah…',
                        'image' => 'jalan_berlubang.jpg',
                        'tags' => ['Baru', 'Infrastruktur'],
                        'comments' => 3,
                        'votes' => 10
                    ],
                ];
            @endphp

            @foreach ($posts as $post)
                <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-300 max-w-[720px]">

                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $post['author'] }}</p>
                            <p class="text-xs text-gray-500">{{ $post['time'] }} • {{ $post['location'] }}</p>
                        </div>
                    </div>

                    <p class="text-gray-700 text-sm mb-3">{{ $post['text'] }}</p>

                    <img src="{{ asset('images/' . $post['image']) }}"
                        class="rounded-xl w-full max-h-[420px] object-cover mb-4">

                    <div class="flex gap-2 mb-3">
                        @foreach ($post['tags'] as $tag)
                            <span class="px-3 py-1 text-xs rounded-full
                                {{ $tag == 'Baru' ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-700 border border-gray-300' }}">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>

                    <div class="flex gap-6 text-gray-500 text-sm mt-2">
                        <button class="hover:text-blue-600 flex items-center gap-1">
                            <i class="fa-regular fa-comment"></i> {{ $post['comments'] }}
                        </button>

                        <button class="hover:text-red-500 flex items-center gap-1">
                            <i class="fa-solid fa-heart"></i> {{ $post['votes'] }}
                        </button>
                    </div>
                </article>
            @endforeach

        </div>
    </main>

</div>
@endsection
