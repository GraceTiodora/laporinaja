@extends('layouts.app')

@section('title', 'New Report - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/create_report.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between sidebar-scroll">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">Laporin<span class="text-gray-900">Aja</span></h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'reports', 'fa-solid fa-clipboard-list'],
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ $route == '#' ? '#' : route($route) }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl text-gray-600 font-medium transition-all hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs($route) ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="nav-text">{{ $name }}</span>
                        
                        @if($name === 'Notification')
                            @php
                                $unreadCount = 0;
                                if (session()->has('notifications')) {
                                    $unreadCount = count(array_filter(session('notifications', []), function($n) {
                                        return !$n['read'];
                                    }));
                                }
                            @endphp
                            
                            @if($unreadCount > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        @endif
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition-all font-semibold btn-new-report">
                <i class="fa-solid fa-plus-circle"></i> <span class="btn-text">New Report</span>
            </button>
        </div>

        <!-- Profile Section -->
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4 user-info">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div class="flex flex-col leading-tight">
                <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                <span class="text-xs text-gray-500">@{{ session('user.username', 'guest') }}</span>
            </div>
        </div>
    </aside>

    <!-- 📰 Main Content with Modal -->
    <main class="flex-1 relative bg-white border-r border-gray-200">
        <!-- Semi-transparent overlay -->
        <div class="absolute inset-0 bg-black/30 z-10"></div>
        
        <!-- Centered Modal Card -->
        <div class="absolute inset-0 flex items-center justify-center z-20 p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 font-medium text-base transition">
                        Cancel
                    </a>
                    <button type="submit" form="reportForm" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-2.5 rounded-full text-base transition shadow-sm">
                        Post
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="flex-1 overflow-y-auto px-6 py-6">
                    <form id="reportForm" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <!-- User Info -->
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="font-bold text-base text-gray-900">{{ session('user.name', 'Guest') }}</p>
                            </div>
                        </div>

                        <!-- Description Textarea -->
                        <div>
                            <label for="description" class="block text-base font-bold text-gray-900 mb-3">Deskripsi :</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="10" 
                                required
                                class="w-full px-0 py-2 border-0 focus:ring-0 text-base text-gray-700 placeholder-gray-400 resize-none bg-transparent"
                                placeholder="Apa yang terjadi?"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hidden Title (auto-generated) -->
                        <input type="hidden" name="title" id="title" value="Laporan Baru">

                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden">
                            <div class="relative rounded-xl overflow-hidden border border-gray-200">
                                <img id="previewImg" src="" alt="Preview" class="w-full max-h-96 object-cover">
                                <button 
                                    type="button" 
                                    onclick="removeImage()" 
                                    class="absolute top-3 right-3 bg-gray-900/70 hover:bg-gray-900 text-white rounded-full p-2 transition"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hidden File Input -->
                        <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </form>
                </div>

                <!-- Modal Footer with Action Icons -->
                <div class="border-t border-gray-200 px-6 py-4 flex-shrink-0">
                    <div class="flex items-center gap-1">
                        <!-- Camera Icon -->
                        <button 
                            type="button" 
                            onclick="document.getElementById('imageInput').click()" 
                            class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Upload Foto"
                        >
                            <i class="fa-solid fa-camera text-xl"></i>
                        </button>

                        <!-- Image Icon -->
                        <button 
                            type="button" 
                            onclick="document.getElementById('imageInput').click()" 
                            class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Upload Gambar"
                        >
                            <i class="fa-regular fa-image text-xl"></i>
                        </button>

                        <!-- Location Icon -->
                        <button 
                            type="button" 
                            class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Tambah Lokasi"
                        >
                            <i class="fa-solid fa-location-dot text-xl"></i>
                        </button>

                        <!-- Tag Icon -->
                        <button 
                            type="button" 
                            class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Tambah Tag"
                        >
                            <i class="fa-solid fa-tag text-xl"></i>
                        </button>

                        <!-- Edit Icon -->
                        <button 
                            type="button" 
                            class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Edit"
                        >
                            <i class="fa-solid fa-pen text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-white p-6 overflow-y-auto sidebar-scroll">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-fire text-red-500"></i> Masalah Penting
            </h2>
            <ul class="space-y-4">
                <li class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">Jalan Rusak</p>
                        <p class="text-xs text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">96 Votes</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-blue-500"></i> Masalah Trending
            </h2>
            <ul class="space-y-4">
                <li class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-pink-100 text-pink-700">Pentinng</span>
                </li>
                <li class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl text-xs font-medium bg-yellow-100 text-yellow-700">Sedang</span>
                </li>
            </ul>
        </section>
    </aside>
</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
}

// Auto-generate title from description
document.getElementById('description').addEventListener('input', function() {
    const desc = this.value.trim();
    const title = desc ? desc.substring(0, 50) : 'Laporan Baru';
    document.getElementById('title').value = title;
});
</script>
@endsection