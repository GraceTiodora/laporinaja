@extends('layouts.app')

@section('title', 'Communities - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/communities.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">Laporin<span class="text-gray-900">Aja</span></h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Home', 'home', 'fa-solid fa-house'],
                        ['Explore', 'explore', 'fa-solid fa-hashtag'],
                        ['Notification', 'notifications', 'fa-regular fa-bell'],
                        ['Messages', 'messages', 'fa-regular fa-envelope'],
                        ['My Reports', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Communities', 'communities', 'fa-solid fa-users'],
                        ['Profile', '#', 'fa-regular fa-user'],
                        ['More', '#', 'fa-solid fa-ellipsis-h'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600 {{ $route == 'communities' ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold">
                <i class="fa-solid fa-plus-circle"></i> New Report
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Justin Hubner') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username', 'hubnerjustin') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Communities List -->
    <aside class="w-[420px] bg-white border-r border-gray-200 flex flex-col">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Communities</h1>
            
            <!-- Search Bar -->
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" placeholder="Cari Komunitas..." 
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <!-- Communities List -->
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
                <div class="community-card {{ $community['active'] ? 'active' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="community-avatar">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="community-name">{{ $community['name'] }}</h3>
                            <p class="community-members">
                                <i class="fa-solid fa-user-group text-xs"></i>
                                {{ $community['members'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </aside>

    <!-- 📰 Community Feed -->
    <main class="flex-1 flex flex-col bg-white overflow-hidden">
        <!-- Community Header -->
        <header class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-bold text-gray-800">Laporan Medan</h2>
            <p class="text-sm text-gray-500 mt-1">
                <i class="fa-solid fa-user-group text-xs"></i> 3.000 anggota
            </p>
        </header>

        <!-- Feed -->
        <div class="flex-1 overflow-y-auto p-6 space-y-5">
            @php
                $posts = [
                    [
                        'author' => 'Audrey Stark',
                        'time' => '2 jam',
                        'location' => 'Jl. Melati',
                        'text' => 'Jalan berlubang besar dekat sekolah...',
                        'image' => 'jalan_berlubang.jpg',
                        'tags' => ['Baru', 'Infrastruktur'],
                        'comments' => 3,
                        'votes' => 10
                    ],
                    [
                        'author' => 'Audrey Stark',
                        'time' => '2 jam',
                        'location' => 'Jl. Melati',
                        'text' => 'Jalan berlubang besar dekat sekolah...',
                        'image' => 'jalan_berlubang.jpg',
                        'tags' => ['Baru', 'Infrastruktur'],
                        'comments' => 3,
                        'votes' => 10
                    ],
                ];
            @endphp

            @foreach($posts as $post)
                <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800">{{ $post['author'] }}</span>
                                <span class="text-xs text-gray-500">{{ $post['time'] }} • {{ $post['location'] }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 text-sm mb-3">{{ $post['text'] }}</p>
                    
                    <img src="{{ asset('images/' . $post['image']) }}" class="rounded-lg mb-3 object-cover max-h-[400px] w-full">
                    
                    <div class="flex gap-2 mb-3">
                        @foreach($post['tags'] as $tag)
                            @if($tag == 'Baru')
                                <span class="px-3 py-1 text-xs rounded-full bg-pink-100 text-pink-700 font-medium">{{ $tag }}</span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700 font-medium border border-gray-200">{{ $tag }}</span>
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-3">
                        <div class="flex gap-4">
                            <button class="hover:text-blue-600 transition flex items-center gap-1.5">
                                <i class="fa-regular fa-comment"></i> {{ $post['comments'] }}
                            </button>
                            <button class="hover:text-red-500 transition flex items-center gap-1.5">
                                <i class="fa-solid fa-heart"></i> {{ $post['votes'] }}
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </main>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<script>
// Handle community selection
document.querySelectorAll('.community-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.community-card').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        // Load community feed based on selected community
    });
});
</script>
@endsection