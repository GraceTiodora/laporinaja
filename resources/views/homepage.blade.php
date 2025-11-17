@extends('layouts.app')

@section('title', 'Home - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
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
        ['Notification', 'notifications', 'fa-regular fa-bell'],   // <-- FIX !!!
        ['Messages', 'messages', 'fa-regular fa-envelope'],
        ['My Reports', 'my.reports', 'fa-solid fa-clipboard-list'],
        ['Communities', '#', 'fa-solid fa-users'],
        ['Profile', '#', 'fa-regular fa-user'],
        ['More', '#', 'fa-solid fa-ellipsis-h'],
    ];
@endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600">
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
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Main Feed -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-white">
        <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10">
            <h1 class="text-xl font-bold text-gray-800">Beranda</h1>
            <button class="text-gray-400 hover:text-blue-600 transition">
                <i class="fa-solid fa-gear text-xl"></i>
            </button>
        </header>

        <div class="overflow-y-auto p-6 space-y-5">
            <!-- Post Input -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                    <input type="text" placeholder="Laporkan masalah di lingkunganmu..."
                           onclick="window.location.href='{{ route('reports.create') }}'"
                           class="flex-1 bg-gray-50 px-3 py-2 rounded-full border border-transparent focus:ring-2 focus:ring-blue-100 focus:border-blue-300 transition">
                </div>
                <div class="flex justify-between px-2">
                    <div class="flex gap-3 text-gray-400">
                        <i class="fa-solid fa-camera cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-image cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-location-dot cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-tag cursor-pointer hover:text-blue-600 transition"></i>
                        <i class="fa-solid fa-pen cursor-pointer hover:text-blue-600 transition"></i>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition font-semibold">Post</button>
                </div>
            </div>

            <!-- Feed Example -->
            @foreach ([[
                'name'=>'Audrey Stark', 'time'=>'2 jam', 'lokasi'=>'Jl. Melati',
                'text'=>'Jalan berlubang besar dekat sekolah sangat berbahaya untuk dilewati',
                'img'=>'images/jalan_berlubang.jpg', 'kategori'=>'Infrastruktur', 'votes'=>128, 'komen'=>3
            ],[
                'name'=>'David Blend', 'time'=>'12 menit', 'lokasi'=>'Jl. Ahmad Yani',
                'text'=>'Pohon besar tumbang menutupi jalan raya, menyebabkan kemacetan parah.',
                'img'=>'images/pohon-tumbang.jpg', 'kategori'=>'Bencana Alam', 'votes'=>54, 'komen'=>1
            ]] as $report)
                <article class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">
                        <div>
                            <div class="flex gap-2 items-center">
                                <span class="font-semibold text-gray-800">{{ $report['name'] }}</span>
                                <span class="text-xs text-gray-500">{{ $report['time'] }} • {{ $report['lokasi'] }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-3">{{ $report['text'] }}</p>
                    <img src="{{ asset($report['img']) }}" class="rounded-lg mb-3 object-cover max-h-[400px] w-full">
                    <div class="flex gap-2 mb-3">
                        <span class="px-3 py-1 text-xs rounded-full bg-pink-100 text-pink-700">Baru</span>
                        <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ $report['kategori'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-3">
                        <div class="flex gap-4">
                            <button class="hover:text-blue-600 transition"><i class="fa-regular fa-comment"></i> {{ $report['komen'] }}</button>
                            <button class="hover:text-red-500 transition"><i class="fa-solid fa-heart"></i> {{ $report['votes'] }}</button>
                        </div>
                        <button class="text-xs text-blue-600 hover:underline">Lihat detail</button>
                    </div>
                </article>
            @endforeach
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-white p-6 overflow-y-auto">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Urgent
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-xs text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">96 Votes</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-pink-100 text-pink-700 font-medium">Urgent</span>
                </li>
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs bg-yellow-100 text-yellow-700 font-medium">Medium</span>
                </li>
            </ul>
        </section>
    </aside>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
@endsection