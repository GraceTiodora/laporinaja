@extends('layouts.app')

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
                    ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                    ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                    ['Pesan', 'messages', 'fa-regular fa-envelope'],
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
            <button class="w-full mt-3 px-4 py-3 bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 text-red-600 rounded-xl font-bold border-2 border-red-200 hover:border-red-400 hover:shadow-lg transition-all flex items-center justify-center gap-2 group hover:translate-x-2">
                <i class="fa-solid fa-right-from-bracket group-hover:scale-110 transition-transform"></i>
                <span>Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('profile') }}" 
                       class="w-12 h-12 rounded-full bg-white border-2 border-gray-200 hover:border-blue-400 flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all hover:scale-110 shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-arrow-left text-lg"></i>
                    </a>
                    <div>
                        <h2 class="text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-3">
                            <i class="fa-solid fa-user-pen"></i>
                            Edit Profil
                        </h2>
                        <p class="text-gray-600 mt-1">Perbarui informasi profil Anda</p>
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

            <!-- Form -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Profile Photo -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-camera text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Foto Profil</h3>
                            <p class="text-gray-600">Upload foto profil Anda (max 2MB)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-8">
                        <div class="relative group">
                            <img id="preview-avatar" 
                                 src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') . '&size=200' }}" 
                                 alt="Profile Preview" 
                                 class="w-32 h-32 rounded-full ring-4 ring-blue-400 group-hover:ring-6 transition-all object-cover shadow-xl">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-full transition-all flex items-center justify-center">
                                <i class="fa-solid fa-camera text-white text-2xl opacity-0 group-hover:opacity-100 transition-all"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block cursor-pointer">
                                <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden">
                                <div class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-2 transform hover:scale-105">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                    Upload Foto Baru
                                </div>
                            </label>
                            <p class="text-sm text-gray-500 mt-2">JPG, PNG, atau GIF. Max 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-address-card text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Informasi Pribadi</h3>
                            <p class="text-gray-600">Update data pribadi Anda</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-signature text-blue-600 mr-2"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', session('user')['name'] ?? '') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   placeholder="Masukkan nama lengkap Anda"
                                   required>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-at text-blue-600 mr-2"></i>
                                Username
                            </label>
                            <input type="text" 
                                   name="username" 
                                   value="{{ old('username', session('user')['username'] ?? '') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   placeholder="username_anda"
                                   required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-envelope text-blue-600 mr-2"></i>
                                Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', session('user')['email'] ?? '') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   placeholder="email@example.com"
                                   required>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-phone text-blue-600 mr-2"></i>
                                Nomor Telepon
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone', session('user')['phone'] ?? '') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   placeholder="081234567890">
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-align-left text-blue-600 mr-2"></i>
                                Bio
                            </label>
                            <textarea name="bio" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium resize-none"
                                      placeholder="Ceritakan tentang diri Anda...">{{ old('bio', session('user')['bio'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            id="saveBtn"
                            class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-black text-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <i class="fa-solid fa-floppy-disk text-2xl" id="saveIcon"></i>
                        <span id="saveText">Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('profile') }}" 
                       class="px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-black text-lg border-2 border-gray-300 hover:border-gray-400 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-xmark text-2xl"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // Preview avatar sebelum upload
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                showToast('Ukuran file terlalu besar! Maksimal 2MB.', 'error');
                e.target.value = '';
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                showToast('Format file tidak valid! Gunakan JPG, PNG, atau GIF.', 'error');
                e.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-avatar').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action*=\"profile.update\"]');
        const saveBtn = document.getElementById('saveBtn');
        const saveIcon = document.getElementById('saveIcon');
        const saveText = document.getElementById('saveText');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const username = document.getElementById('username').value.trim();
                const email = document.getElementById('email').value.trim();
                const bio = document.getElementById('bio').value;
                
                // Validation
                if (!name) {
                    e.preventDefault();
                    showToast('Nama tidak boleh kosong!', 'error');
                    document.getElementById('name').focus();
                    return false;
                }
                
                if (name.length < 3) {
                    e.preventDefault();
                    showToast('Nama minimal 3 karakter!', 'error');
                    document.getElementById('name').focus();
                    return false;
                }
                
                if (!username) {
                    e.preventDefault();
                    showToast('Username tidak boleh kosong!', 'error');
                    document.getElementById('username').focus();
                    return false;
                }
                
                if (username.length < 3) {
                    e.preventDefault();
                    showToast('Username minimal 3 karakter!', 'error');
                    document.getElementById('username').focus();
                    return false;
                }
                
                if (!/^[a-zA-Z0-9_-]+$/.test(username)) {
                    e.preventDefault();
                    showToast('Username hanya boleh huruf, angka, dash dan underscore!', 'error');
                    document.getElementById('username').focus();
                    return false;
                }
                
                if (!email) {
                    e.preventDefault();
                    showToast('Email tidak boleh kosong!', 'error');
                    document.getElementById('email').focus();
                    return false;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    showToast('Format email tidak valid!', 'error');
                    document.getElementById('email').focus();
                    return false;
                }
                
                if (bio && bio.length > 500) {
                    e.preventDefault();
                    showToast('Bio maksimal 500 karakter!', 'error');
                    document.getElementById('bio').focus();
                    return false;
                }
                
                // Show loading state
                if (saveBtn) {
                    saveBtn.disabled = true;
                    if (saveIcon) saveIcon.className = 'fa-solid fa-spinner fa-spin text-2xl';
                    if (saveText) saveText.textContent = 'Menyimpan...';
                }
            });
        }
    });
</script>
@endsection
