@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-auth.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
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
                        $isActive = request()->routeIs($route);
                        $showBadge = $route === 'notifications' && isset($unreadNotifications) && $unreadNotifications > 0;
                    @endphp
                    <a href="{{ $href }}"
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300 relative
                              {{ $isActive 
                                  ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' 
                                  : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                        @if($isActive)
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        @endif
                        <i class="{{ $icon }} text-lg group-hover:scale-125 transition-transform"></i>
                        <span class="font-semibold">{{ $name }}</span>
                        @if($showBadge)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full min-w-[20px] text-center">
                                {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all duration-300 font-bold transform hover:scale-105 group">
                <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <!-- Profile Bottom -->
        <div>
            <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 hover:border-blue-400 bg-white hover:bg-blue-50 transition-all cursor-pointer mb-3 group ring-2 ring-gray-200 hover:ring-blue-400">
                <div class="relative">
                    <img src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-white">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ session('user')['name'] ?? 'User' }}</p>
                    <p class="text-xs text-gray-500">@{{ session('user')['username'] ?? 'username' }}</p>
                </div>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 transition-all duration-300 group border-2 border-red-200 hover:border-red-400 hover:shadow-lg transform hover:scale-105">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-2 transition-transform text-lg"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 📝 Main Feed -->
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20">

        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-user-pen text-blue-600 text-xl"></i>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Edit Profil</h1>
                </div>
                <a href="{{ route('profile') }}" 
                   class="w-10 h-10 rounded-full bg-white border-2 border-gray-200 hover:border-blue-400 flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all hover:scale-110 shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
            </div>
        </header>

        <div class="overflow-y-auto p-6 space-y-5">
            <div class="max-w-3xl mx-auto w-full">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-2xl flex items-center gap-3 shadow-lg animate-pulse">
                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-white text-lg"></i>
                    </div>
                    <p class="text-green-800 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-300 rounded-2xl shadow-lg">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center flex-shrink-0">
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
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Profile Photo Section -->
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300 group">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                            
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Foto Profil</h3>
                            <p class="text-sm text-gray-600">Upload foto profil Anda (max 2MB)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-8">
                        <div class="relative group/avatar">
                            <img id="preview-avatar" 
                                 src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') . '&size=200' }}" 
                                 alt="Profile Preview" 
                                 class="w-32 h-32 rounded-full ring-4 ring-blue-400 group-hover/avatar:ring-6 transition-all object-cover shadow-xl">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover/avatar:bg-opacity-30 rounded-full transition-all flex items-center justify-center">
                                
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block cursor-pointer">
                                <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden">
                                <div class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-2 transform hover:scale-105">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                    Upload Foto Baru
                                </div>
                            </label>
                            <p class="text-sm text-gray-500 mt-2">JPG, PNG, atau GIF. Max 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Info Section -->
                <div class="bg-white border-2 border-gray-200 rounded-2xl shadow-sm p-6 hover:shadow-2xl transition-all duration-300 hover:border-blue-300 group">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-address-card text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                            <p class="text-sm text-gray-600">Update data pribadi Anda</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-signature text-blue-600 mr-2"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" 
                                   id="name"
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
                                   id="username"
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
                                   id="email"
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
                                <div>
                                    <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 hover:border-blue-400 bg-white hover:bg-blue-50 transition-all cursor-pointer mb-3 group ring-2 ring-gray-200 hover:ring-blue-400">
                                        <div class="relative">
                                            <img src="{{ session('user')['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user')['name'] ?? 'User') }}"
                                                 class="w-12 h-12 rounded-full object-cover ring-2 ring-white"
                                                 alt="Profile"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(session('user')['name'] ?? 'User') }}'">
                                            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-gray-900 truncate">{{ session('user')['name'] ?? 'User' }}</p>
                                            <p class="text-xs text-gray-500 truncate">@{{ session('user')['username'] ?? 'username' }}</p>
                                        </div>
                                    </a>
                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            id="saveBtn"
                            class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <i class="fa-solid fa-floppy-disk text-xl" id="saveIcon"></i>
                        <span id="saveText">Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('profile') }}" 
                       class="px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-bold text-lg border-2 border-gray-300 hover:border-gray-400 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-xmark text-xl"></i>
                        Batal
                    </a>
                </div>
            </form>
            </div>
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[360px] bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6 overflow-y-auto border-l border-gray-200 space-y-5 shadow-lg">
        
        <!-- Tips & Info -->
        <section class="bg-white rounded-2xl p-5 border-2 border-blue-200 shadow-lg">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-lightbulb text-white"></i>
                </div>
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Tips Profil</span>
            </h2>
            
            <div class="space-y-3">
                <div class="p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-blue-600 text-lg flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Foto Profil Jelas</p>
                            <p class="text-xs text-gray-600 mt-0.5">Gunakan foto yang jelas dan terlihat profesional</p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-green-600 text-lg flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Username Unik</p>
                            <p class="text-xs text-gray-600 mt-0.5">Pilih username yang mudah diingat</p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-purple-600 text-lg flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Bio Menarik</p>
                            <p class="text-xs text-gray-600 mt-0.5">Ceritakan tentang diri Anda secara singkat</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Security Info -->
        <section class="bg-white rounded-2xl p-5 border-2 border-orange-200 shadow-lg">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-shield text-white"></i>
                </div>
                <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">Keamanan</span>
            </h2>
            
            <div class="space-y-3">
                <div class="p-3 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-lock text-orange-600 text-lg flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Email Terverifikasi</p>
                            <p class="text-xs text-gray-600 mt-0.5">{{ session('user')['email'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <a href="#" class="block p-3 bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 hover:shadow-md transition-all">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-key text-red-600 text-lg flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Ubah Kata Sandi</p>
                            <p class="text-xs text-gray-600 mt-0.5">Update password untuk keamanan lebih baik</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Account Info -->
        <section class="bg-white rounded-2xl p-5 border-2 border-gray-200 shadow-lg">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-info text-white"></i>
                </div>
                <span class="bg-gradient-to-r from-gray-600 to-gray-700 bg-clip-text text-transparent">Informasi Akun</span>
            </h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <span class="text-gray-600 font-medium">Username</span>
                    <span class="text-gray-900 font-bold">{{ session('user')['username'] ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <span class="text-gray-600 font-medium">Bergabung</span>
                    <span class="text-gray-900 font-bold">{{ session('user')['created_at'] ?? '-' }}</span>
                </div>
            </div>
        </section>
    </aside>
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
