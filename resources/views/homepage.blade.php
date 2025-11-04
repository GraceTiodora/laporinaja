{{-- resources/views/homepage.blade.php --}}
@extends('layouts.app')

@section('title', 'Home - Laporkan Masalah')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Left Sidebar Navigation -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
        <div class="p-4">
            <div class="flex items-center space-x-3 mb-6">
                <img src="https://via.placeholder.com/40x40" alt="Profile" class="w-10 h-10 rounded-full">
                <span class="text-sm font-medium text-gray-700">Laporkan masalah di lingkunganmu</span>
            </div>
            <nav class="space-y-2">
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Telusuri</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span>Notifikasi</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>Pesan</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Laporan Saya</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Komunitas</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Profil</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                    <span>Lebih</span>
                </a>
            </nav>
        </div>
        <!-- New Report Button at bottom -->
        <div class="mt-auto p-4">
            <button class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Laporan Baru</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Beranda</h1>
            <button class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                Posting
            </button>
        </header>

        <!-- Feed Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            <!-- Recent Report 1 -->
            <article class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 flex items-start space-x-3">
                    <img src="https://via.placeholder.com/40x40" alt="User" class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="font-medium text-gray-900">Audrey Stark</span>
                            <span class="text-sm text-gray-500">2 jam lalu • Jl. Melati</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">Jalan berlubang berbahaya dekat sekolah. Tolong segera diperbaiki agar anak-anak aman.</p>
                        <img src="https://via.placeholder.com/400x200?text=Jalan+Berlubang" alt="Report Image" class="w-full rounded-md mb-3">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span>🗨️ 3</span>
                                <span>❤️ 10</span>
                            </div>
                            <span class="text-xs bg-pink-100 text-pink-800 px-2 py-1 rounded-full">Baru • Infrastruktur</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Recent Report 2 -->
            <article class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 flex items-start space-x-3">
                    <img src="https://via.placeholder.com/40x40" alt="User" class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="font-medium text-gray-900">David Blanc</span>
                            <span class="text-sm text-gray-500">12 menit lalu • Jl. Ahmad Yani</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">Sebuah pohon besar tumbang menghalangi jalan raya, menyebabkan kemacetan parah. Mohon segera ditangani agar jalan bisa dilewati kembali.</p>
                        <img src="https://via.placeholder.com/400x200?text=Pohon+Tumbang" alt="Report Image" class="w-full rounded-md mb-3">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center space-x-4">
                                <span>🗨️ 1</span>
                                <span>❤️ 5</span>
                            </div>
                            <span class="text-xs bg-pink-100 text-pink-800 px-2 py-1 rounded-full">Baru • Bencana Alam</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Add more reports as needed -->
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="w-80 bg-white border-l border-gray-200 p-6 space-y-6">
        <!-- Urgent Issues Section -->
        <section>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Masalah Urgent</h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">Jalan Rusak • Jl. Melati</span>
                    <span class="text-sm font-semibold text-red-600">128 suara</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">Sampah Menumpuk • Pasar Baru</span>
                    <span class="text-sm font-semibold text-red-600">99 suara</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">Lampu Jalan Mati • RT 05 Jl. Mati</span>
                    <span class="text-sm font-semibold text-red-600">54 suara</span>
                </li>
            </ul>
        </section>

        <!-- Trending Issues Section -->
        <section>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Masalah Trending</h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">Infrastruktur Jalan</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">Urgent</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">Sampah Menumpuk • Pasar Baru</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Medium</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">Lampu Jalan Mati • RT 05 Jl. Mati</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Low</span>
                </li>
            </ul>
            <p class="text-xs text-gray-500 mt-2">5 laporan hari ini</p>
        </section>
    </aside>
</div>
@endsection