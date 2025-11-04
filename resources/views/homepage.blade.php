{{-- resources/views/homepage.blade.php --}}
@extends('layouts.app')

@section('title', 'Home - Laporin Aja')

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
                    <!-- icon + label -->
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Beranda</span>
                </a>
                <!-- other nav items... -->
            </nav>
        </div>
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
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Beranda</h1>
            <button class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Posting</button>
        </header>

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
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="w-80 bg-white border-l border-gray-200 p-6 space-y-6">
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