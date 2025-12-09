@extends('layouts.app')

@section('title', 'New Report - Laporin Aja')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex">
    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-lg flex flex-col h-screen sticky top-0">
        <div class="p-6 border-b-2 border-blue-100">
            <h1 class="text-3xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">LaporinAja</h1>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            @php
                $menuItems = [
                    ['Beranda', 'home', 'fa-solid fa-house'],
                    ['Pencarian', 'explore', 'fa-solid fa-magnifying-glass'],
                    ['Notifikasi', 'notifications', 'fa-solid fa-bell'],
                    ['Pesan', 'messages', 'fa-solid fa-envelope'],
                    ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                    ['Profil', 'profile', 'fa-solid fa-user'],
                ];
            @endphp

            @foreach($menuItems as $item)
                <a href="{{ route($item[1]) }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold transition-all duration-300 relative
                          {{ request()->routeIs($item[1]) 
                             ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' 
                             : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                    <i class="{{ $item[2] }} text-xl w-6"></i>
                    <span>{{ $item[0] }}</span>
                    @if(request()->routeIs($item[1]))
                        <span class="absolute right-3 w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t-2 border-blue-100">
            <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-blue-200 bg-white hover:border-blue-400 hover:ring-2 hover:ring-blue-400 transition-all cursor-pointer group">
                <div class="relative">
                    <img src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') }}" 
                         alt="Profile" 
                         class="w-12 h-12 rounded-full ring-2 ring-blue-400 group-hover:ring-4 transition-all object-cover">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 truncate">{{ session('user')['name'] ?? 'User' }}</p>
                    <p class="text-sm text-gray-500 truncate">@{{ session('user')['username'] ?? 'username' }}</p>
                </div>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 text-red-600 rounded-xl font-bold border-2 border-red-200 hover:border-red-400 hover:shadow-lg transition-all flex items-center justify-center gap-2 group hover:translate-x-2">
                    <i class="fa-solid fa-right-from-bracket group-hover:scale-110 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" 
                       class="w-12 h-12 rounded-full bg-white border-2 border-gray-200 hover:border-blue-400 flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all hover:scale-110 shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-arrow-left text-lg"></i>
                    </a>
                    <div>
                        <h2 class="text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-3">
                            <i class="fa-solid fa-file-circle-plus"></i>
                            Buat Laporan Baru
                        </h2>
                        <p class="text-gray-600 mt-1">Laporkan masalah yang ada di lingkungan Anda</p>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl flex items-center gap-3 shadow-lg animate-pulse">
                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center">
                        <i class="fa-solid fa-check text-white text-lg"></i>
                    </div>
                    <p class="text-green-800 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-300 rounded-xl shadow-lg">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center">
                            <i class="fa-solid fa-exclamation text-white text-lg"></i>
                        </div>
                        <p class="text-red-800 font-bold">Terjadi kesalahan:</p>
                    </div>
                    <ul class="ml-14 space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-red-700">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-300 rounded-xl flex items-center gap-3 shadow-lg">
                    <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center">
                        <i class="fa-solid fa-exclamation text-white text-lg"></i>
                    </div>
                    <p class="text-red-800 font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-8">
                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- User Info -->
                    <div class="flex items-center gap-3 pb-6 border-b-2 border-blue-100">
                        <img src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') }}" 
                             alt="{{ session('user')['name'] ?? 'User' }}" 
                             class="w-14 h-14 rounded-full object-cover ring-2 ring-blue-400">
                        <div>
                            <p class="font-bold text-lg text-gray-900">{{ session('user')['name'] ?? 'User' }}</p>
                            <p class="text-sm text-gray-500">@{{ session('user')['username'] ?? 'username' }}</p>
                        </div>
                    </div>

                    <!-- Title Input -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-heading text-blue-600 mr-2"></i>
                            Judul Laporan
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                            placeholder="Ringkasan singkat masalah Anda"
                            value="{{ old('title') }}"
                        >
                        @error('title')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Textarea -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-align-left text-blue-600 mr-2"></i>
                            Deskripsi
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="6" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium resize-none"
                            placeholder="Jelaskan detail masalah yang Anda laporkan..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location Input -->
                    <div>
                        <label for="location" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-location-dot text-blue-600 mr-2"></i>
                            Lokasi
                        </label>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                            placeholder="Alamat / Nama jalan"
                            value="{{ old('location') }}"
                        >
                        @error('location')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Select -->
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-layer-group text-blue-600 mr-2"></i>
                            Kategori
                        </label>
                        <select 
                            id="category_id" 
                            name="category_id"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                        >
                            <option value="">-- Pilih Kategori --</option>
                            <option value="1">Infrastruktur</option>
                            <option value="2">Keamanan</option>
                            <option value="3">Sanitasi</option>
                            <option value="4">Taman</option>
                            <option value="5">Aksesibilitas</option>
                        </select>
                        @error('category_id')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-image text-blue-600 mr-2"></i>
                            Foto Laporan
                        </label>
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden mb-4">
                            <div class="relative rounded-xl overflow-hidden border-2 border-gray-300">
                                <img id="previewImg" src="" alt="Preview" class="w-full max-h-96 object-cover">
                                <button 
                                    type="button" 
                                    onclick="removeImage()" 
                                    class="absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white rounded-full w-10 h-10 flex items-center justify-center transition-all shadow-lg hover:scale-110"
                                >
                                    <i class="fa-solid fa-xmark text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <label class="cursor-pointer">
                            <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <div class="flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border-2 border-dashed border-blue-300 hover:border-blue-500 rounded-xl transition-all group">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-blue-600 group-hover:scale-110 transition-transform"></i>
                                <div class="text-left">
                                    <p class="font-bold text-gray-900">Klik untuk upload foto</p>
                                    <p class="text-sm text-gray-500">JPG, PNG, atau GIF. Max 2MB.</p>
                                </div>
                            </div>
                        </label>
                        @error('image')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6 border-t-2 border-blue-100">
                        <button type="submit" 
                                id="submitBtn"
                                class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-black text-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <i class="fa-solid fa-paper-plane text-2xl" id="submitIcon"></i>
                            <span id="submitText">Kirim Laporan</span>
                        </button>
                        <a href="{{ route('home') }}" 
                           class="px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-black text-lg border-2 border-gray-300 hover:border-gray-400 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-xmark text-2xl"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran file terlalu besar! Maksimal 2MB.', 'error');
            event.target.value = '';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            showToast('Format file tidak valid! Gunakan JPG, PNG, atau GIF.', 'error');
            event.target.value = '';
            return;
        }
        
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

// Form validation and submit handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="reports.store"]');
    const submitBtn = document.getElementById('submitBtn');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            
            // Client-side validation
            if (!title) {
                e.preventDefault();
                showToast('Judul laporan tidak boleh kosong!', 'error');
                document.getElementById('title').focus();
                return false;
            }
            
            if (title.length < 5) {
                e.preventDefault();
                showToast('Judul laporan minimal 5 karakter!', 'error');
                document.getElementById('title').focus();
                return false;
            }
            
            if (!description) {
                e.preventDefault();
                showToast('Deskripsi laporan tidak boleh kosong!', 'error');
                document.getElementById('description').focus();
                return false;
            }
            
            if (description.length < 10) {
                e.preventDefault();
                showToast('Deskripsi minimal 10 karakter!', 'error');
                document.getElementById('description').focus();
                return false;
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitIcon.className = 'fa-solid fa-spinner fa-spin text-2xl';
            submitText.textContent = 'Mengirim...';
        });
    }
});
</script>
@endsection