@extends('layouts.app')

@section('title', 'New Report - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/create_report.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">
    <!-- 🧭 Left Sidebar -->
    <aside class="w-[270px] bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-r border-gray-200 p-6 flex flex-col justify-between sidebar-scroll shadow-lg">
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

<<<<<<< Updated upstream
        <!-- Profile Section -->
        <div>
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 user-info mb-3">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-medium text-gray-800">{{ session('user.name', 'Guest') }}</span>
                    <span class="text-xs text-gray-500">@{{ session('user.username', 'guest') }}</span>
=======
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            @php
                $menuItems = [
                    ['Beranda', 'home', 'fa-solid fa-house'],
                    ['Pencarian', 'explore', 'fa-solid fa-magnifying-glass'],
                    ['Notifikasi', 'notifications', 'fa-solid fa-bell'],
                    // ['Pesan', 'messages', 'fa-solid fa-envelope'], // Dihapus karena route tidak ada
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
>>>>>>> Stashed changes
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-600 font-semibold bg-white/50 hover:bg-red-50 hover:text-red-700 transition-all group border border-red-200 hover:border-red-300">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 📰 Main Content with Modal -->
    <main class="flex-1 relative bg-gradient-to-br from-white to-blue-50/20 border-r border-gray-200">
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
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-700 font-semibold mb-2">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    @endif

<<<<<<< Updated upstream
                    <form id="reportForm" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
=======
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
                        <label for="dusun" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-location-dot text-blue-600 mr-2"></i>
                            Dusun
                        </label>
                        <select id="dusun" name="dusun" required onchange="showAlamatLengkap()"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium">
                            <option value="">-- Pilih Dusun --</option>
                            <option value="Lumban Hariara">Lumban Hariara</option>
                            <option value="Panasala">Panasala</option>
                            <option value="Patujulu">Patujulu</option>
                            <option value="Puba Lubis">Puba Lubis</option>
                            <option value="Puntu Manda">Puntu Manda</option>
                            <option value="Silalahi">Silalahi</option>
                            <option value="Simuring">Simuring</option>
                        </select>
                        @error('dusun')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="alamatLengkapContainer" class="hidden mt-4">
                        <label for="alamat_lengkap" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-map-location-dot text-blue-600 mr-2"></i>
                            Alamat Lengkap
                        </label>
                        <input type="text" id="alamat_lengkap" name="alamat_lengkap"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                            placeholder="Alamat lengkap, RT/RW, patokan, dll">
                        @error('alamat_lengkap')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        function showAlamatLengkap() {
                            const dusun = document.getElementById('dusun').value;
                            const alamatContainer = document.getElementById('alamatLengkapContainer');
                            if (dusun) {
                                alamatContainer.classList.remove('hidden');
                            } else {
                                alamatContainer.classList.add('hidden');
                            }
                        }
                    </script>

                    @include('components.google-maps-picker')

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
>>>>>>> Stashed changes
                        
                        <!-- User Info -->
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ session('user.name') }}" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="font-bold text-base text-gray-900">{{ session('user.name', 'Guest') }}</p>
                            </div>
                        </div>

                        <!-- Title Input -->
                        <div>
                            <label for="title" class="block text-base font-bold text-gray-900 mb-3">Judul Laporan :</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base text-gray-700 placeholder-gray-400"
                                placeholder="Ringkasan singkat masalah Anda"
                                value="{{ old('title') }}"
                            >
                            @error('title')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Textarea -->
                        <div>
                            <label for="description" class="block text-base font-bold text-gray-900 mb-3">Deskripsi :</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="6" 
                                required
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base text-gray-700 placeholder-gray-400 resize-none"
                                placeholder="Apa yang terjadi?"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Input -->
                        <div>
                            <label for="location" class="block text-base font-bold text-gray-900 mb-3">Lokasi :</label>
                            <input 
                                type="text" 
                                id="location" 
                                name="location" 
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base text-gray-700 placeholder-gray-400"
                                placeholder="Alamat / Nama jalan"
                                value="{{ old('location') }}"
                            >
                            @error('location')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Select -->
                        <div>
                            <label for="category_id" class="block text-base font-bold text-gray-900 mb-3">Kategori :</label>
                            <select 
                                id="category_id" 
                                name="category_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base text-gray-700"
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
                            onclick="document.getElementById('location').focus()" 
                            class="p-3 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Tambah Lokasi"
                        >
                            <i class="fa-solid fa-location-dot text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 📊 Right Sidebar -->
    <aside class="w-[340px] bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 p-6 overflow-y-auto sidebar-scroll border-l border-gray-200 shadow-lg">
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
            // Add animation
            const preview = document.getElementById('imagePreview');
            preview.style.animation = 'fadeIn 0.3s ease-in';
        }
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('imageInput').value = '';
    const preview = document.getElementById('imagePreview');
    preview.style.animation = 'fadeOut 0.3s ease-out';
    setTimeout(() => {
        preview.classList.add('hidden');
        document.getElementById('previewImg').src = '';
    }, 300);
}

// Add interactivity to form inputs
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reportForm');
    const inputs = document.querySelectorAll('input[type="text"], textarea, select');
    
    // Form validation before submit
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        
        if (!title) {
            e.preventDefault();
            alert('Judul Laporan wajib diisi!');
            document.getElementById('title').focus();
            return false;
        }
        
        if (!description) {
            e.preventDefault();
            alert('Deskripsi wajib diisi!');
            document.getElementById('description').focus();
            return false;
        }
        
        // If all validation passes, submit form
        console.log('Form berhasil divalidasi, submit sekarang...');
    });
    
    inputs.forEach(input => {
        // Focus animation
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('opacity-100');
            this.parentElement.style.transform = 'scale(1.01)';
        });
        
        // Blur animation
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
        
        // Input validation with visual feedback
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-gray-200');
                this.classList.add('border-blue-400');
            } else {
                this.classList.remove('border-blue-400');
                this.classList.add('border-gray-200');
            }
        });
    });
    
    // Submit button animation
    const submitBtn = document.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 16px rgba(37, 99, 235, 0.3)';
        });
        
        submitBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    }
});

// CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
    
    input:focus, textarea:focus, select:focus {
        transition: all 0.3s ease;
    }
    
    button[type="submit"] {
        transition: all 0.2s ease;
    }
`;
document.head.appendChild(style);
</script>
@endsection