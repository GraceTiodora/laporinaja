@extends('layouts.app')

@section('title', 'New Report - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/create_report.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">
    <!-- Left Sidebar -->
    <aside class="w-[280px] bg-white border-r border-gray-200 p-5 flex flex-col overflow-y-auto sidebar-scroll">
        <div class="mb-7">
            <h2 class="text-2xl font-bold text-blue-500">LaporinAja</h2>
        </div>
        
        <nav class="flex flex-col gap-2">
            <a href="{{ route('home') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">🏠</span>
                <span class="nav-text leading-none">Home</span>
            </a>
            <a href="{{ route('explore') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">#</span>
                <span class="nav-text leading-none">Explore</span>
            </a>
            <a href="{{ route('notifications') }}" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800 relative">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">🔔</span>
                <span class="nav-text leading-none">Notification</span>
                
                @php
                    $unreadCount = 0;
                    if (session()->has('notifications')) {
                        $unreadCount = count(array_filter(session('notifications', []), function($n) {
                            return !$n['read'];
                        }));
                    }
                @endphp
                
                @if($unreadCount > 0)
                    <span class="absolute top-2 left-8 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">💬</span>
                <span class="nav-text leading-none">Messages</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">📋</span>
                <span class="nav-text leading-none">My Reports</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">👥</span>
                <span class="nav-text leading-none">Communities</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">👤</span>
                <span class="nav-text leading-none">Profile</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-4 px-4 py-3 rounded-lg text-base font-medium text-gray-600 transition-all duration-200 hover:bg-gray-100 hover:text-gray-800">
                <span class="w-6 h-6 flex items-center justify-center flex-shrink-0 text-xl leading-none">⚙️</span>
                <span class="nav-text leading-none">More</span>
            </a>
        </nav>
        
        <button onclick="window.location.href='{{ route('reports.create') }}'" class="mt-5 bg-blue-500 text-white border-none px-6 py-3.5 rounded-3xl text-base font-semibold cursor-pointer transition-colors duration-200 hover:bg-blue-600 btn-new-report">
            <span class="btn-text">+ New Report</span>
        </button>
        
        <!-- User Profile -->
        <div class="mt-auto pt-5 border-t border-gray-200">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-12 h-12 rounded-full object-cover">
                <div class="flex-1">
                    <p class="font-semibold text-sm text-gray-800">{{ session('user.name') }}</p>
                    <p class="text-xs text-gray-500">@{{ session('user.username') }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content with Modal -->
    <main class="flex-1 relative">
        <!-- Semi-transparent overlay -->
        <div class="absolute inset-0 bg-black/30 z-10"></div>
        
        <!-- Centered Modal Card -->
        <div class="absolute inset-0 flex items-center justify-center z-20 p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 font-medium text-base transition">
                        Cancel
                    </a>
                    <button type="submit" form="reportForm" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-8 py-2.5 rounded-full text-base transition shadow-sm">
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
                                <p class="font-bold text-base text-gray-900">{{ session('user.name') }} :</p>
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
                            class="p-3 text-blue-500 hover:bg-blue-50 rounded-lg transition"
                            title="Upload Foto"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 15.2c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                                <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm11 14H4V6h4.05l1.83-2h4.24l1.83 2H20v10z"/>
                            </svg>
                        </button>

                        <!-- Image Icon -->
                        <button 
                            type="button" 
                            onclick="document.getElementById('imageInput').click()" 
                            class="p-3 text-blue-500 hover:bg-blue-50 rounded-lg transition"
                            title="Upload Gambar"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                            </svg>
                        </button>

                        <!-- Location Icon -->
                        <button 
                            type="button" 
                            class="p-3 text-blue-500 hover:bg-blue-50 rounded-lg transition"
                            title="Tambah Lokasi"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </button>

                        <!-- Tag Icon -->
                        <button 
                            type="button" 
                            class="p-3 text-blue-500 hover:bg-blue-50 rounded-lg transition"
                            title="Tambah Tag"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
                            </svg>
                        </button>

                        <!-- Edit Icon -->
                        <button 
                            type="button" 
                            class="p-3 text-blue-500 hover:bg-blue-50 rounded-lg transition"
                            title="Edit"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="w-80 bg-white p-6 overflow-y-auto border-l border-gray-200">
        <section class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Urgent</h2>
            <ul class="space-y-0">
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Jalan Rusak</p>
                        <p class="text-xs text-gray-500">Jl. Melati</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">128 Votes</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">96 Votes</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">54 Votes</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Masalah Trending</h2>
            <ul class="space-y-0">
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Infrastruktur Jalan</p>
                        <p class="text-xs text-gray-500">5 laporan hari ini</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-700">Urgent</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Sampah Menumpuk</p>
                        <p class="text-xs text-gray-500">Pasar Baru</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Medium</span>
                </li>
                <li class="flex justify-between items-center py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">Lampu Jalan Mati</p>
                        <p class="text-xs text-gray-500">RT 05</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Low</span>
                </li>
            </ul>
        </section>
    </aside>
</div>

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