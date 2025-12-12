@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/homepage.auth.css') }}">
@endpush

@section('title', 'Pengaturan Akun')

@section('content')
@php
    $user = $user ?? auth()->user();
@endphp

<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    {{-- SIDEBAR --}}
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Dashboard', 'admin.dashboard', 'fa-solid fa-house'],
                        ['Verifikasi & Penanganan', 'admin.verifikasi', 'fa-solid fa-check-circle'],
                        ['Monitoring & Statistik', 'admin.monitoring', 'fa-solid fa-chart-line'],
                        ['Voting Publik', 'admin.voting', 'fa-solid fa-vote-yea'],
                        ['Pengaturan Akun', 'admin.pengaturan', 'fa-solid fa-gear'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ route($route) }}"
                       class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                              {{ request()->routeIs($route) ? 'active bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}
                              hover:bg-blue-50 hover:text-blue-600 transition-all duration-300">
                        <i class="{{ $icon }} text-lg group-hover:scale-110 transition-transform"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Profile --}}
        <div>
            <a href="{{ route('admin.pengaturan') }}" class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 hover:border-blue-400 bg-white hover:bg-blue-50 transition-all cursor-pointer mb-3 group ring-2 ring-gray-200 hover:ring-blue-400">
                <div class="relative">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/profile-user.jpg') }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-white group-hover:ring-blue-300 transition-all">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">Admin</p>
                </div>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 transition-all duration-300 group border-2 border-red-200 hover:border-red-400 hover:shadow-lg transform hover:scale-105">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 flex flex-col border-r border-gray-200 bg-gradient-to-br from-white to-blue-50/20 overflow-y-auto">
        <header class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-gear text-blue-600 text-xl"></i>
                    <h1 class="text-xl font-bold text-gray-800">Pengaturan Akun</h1>
                </div>
                <button class="text-gray-400 hover:text-blue-600 transition-all p-2 hover:bg-blue-50 rounded-lg group hover:rotate-90 duration-300">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </div>
        </header>

        <div class="p-6 space-y-6">
            <div>
                <p class="text-sm text-gray-500">Kelola informasi profil dan keamanan akun administrator</p>
            </div>

            {{-- Profile Section --}}
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-6 shadow-sm hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-user-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Profil Admin</h2>
                        <p class="text-sm text-gray-600">Update informasi profil Anda</p>
                    </div>
                </div>

                <form action="{{ route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    {{-- Avatar Upload --}}
                    <div class="flex items-center gap-6 mb-6 pb-6 border-b border-gray-200">
                        <div class="relative group/avatar flex-shrink-0">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/profile-user.jpg') }}" 
                                 class="w-24 h-24 rounded-full object-cover ring-4 ring-blue-400 group-hover/avatar:ring-6 transition-all shadow-lg"
                                 alt="Profile Avatar"
                                 id="avatarPreview">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover/avatar:bg-opacity-30 rounded-full transition-all flex items-center justify-center">
                                <i class="fa-solid fa-camera text-white text-2xl opacity-0 group-hover/avatar:opacity-100 transition-all"></i>
                            </div>
                        </div>
                        <div>
                            <label for="avatarInput" class="block">
                                <div class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-2 transform hover:scale-105 cursor-pointer">
                                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                                    Ubah Foto
                                </div>
                            </label>
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
                            <p class="text-sm text-gray-500 mt-2">JPG, PNG atau GIF. Max 2MB.</p>
                        </div>
                    </div>

                    {{-- Profile Input Fields --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-signature text-blue-600 mr-2"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" id="name" name="name" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   value="{{ $user->name }}"
                                   placeholder="Masukkan nama lengkap">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-envelope text-blue-600 mr-2"></i>
                                Email
                            </label>
                            <input type="email" id="email" name="email" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   value="{{ $user->email }}"
                                   placeholder="Masukkan email">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-phone text-blue-600 mr-2"></i>
                                Nomor Telepon
                            </label>
                            <input type="text" id="phone" name="phone" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all font-medium"
                                   value="{{ $user->phone }}"
                                   placeholder="Masukkan nomor telepon">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-shield text-blue-600 mr-2"></i>
                                Role
                            </label>
                            <input type="text" id="role" name="role" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl bg-gray-100 text-gray-600 cursor-not-allowed font-medium"
                                   value="{{ ucfirst($user->role) }}"
                                   readonly>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end gap-4">
                        <button type="button" class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-bold border-2 border-gray-300 hover:border-gray-400 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2 btn-cancel">
                            <i class="fa-solid fa-xmark text-lg"></i>
                            Batal
                        </button>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk text-lg"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Security Section --}}
            <div class="bg-white rounded-2xl border-2 border-gray-200 p-6 shadow-sm hover:shadow-xl transition-all">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-lock text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Keamanan</h2>
                        <p class="text-sm text-gray-600">Kelola password dan keamanan akun</p>
                    </div>
                </div>

                <form action="{{ route('admin.updatePassword') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')

                    {{-- Password Saat Ini --}}
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-lock text-orange-600 mr-2"></i>
                            Password Saat Ini
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="current_password" name="current_password" 
                                   class="w-full pl-12 pr-12 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-200 transition-all font-medium"
                                   placeholder="Masukkan password saat ini">
                            <i class="fa-solid fa-eye-slash absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer toggle-password transition-colors hover:text-orange-600" data-target="current_password"></i>
                        </div>
                    </div>

                    {{-- Password Baru & Konfirmasi --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="new_password" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-key text-orange-600 mr-2"></i>
                                Password Baru
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" id="new_password" name="new_password" 
                                       class="w-full pl-12 pr-12 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-200 transition-all font-medium"
                                       placeholder="Masukkan password baru">
                                <i class="fa-solid fa-eye-slash absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer toggle-password transition-colors hover:text-orange-600" data-target="new_password"></i>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fa-solid fa-check-circle text-orange-600 mr-2"></i>
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" id="password_confirmation" name="new_password_confirmation" 
                                       class="w-full pl-12 pr-12 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-200 transition-all font-medium"
                                       placeholder="Konfirmasi password baru">
                                <i class="fa-solid fa-eye-slash absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer toggle-password transition-colors hover:text-orange-600" data-target="password_confirmation"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end gap-4">
                        <button type="button" class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-bold border-2 border-gray-300 hover:border-gray-400 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2 btn-cancel">
                            <i class="fa-solid fa-xmark text-lg"></i>
                            Batal
                        </button>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk text-lg"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
  // Avatar preview
  document.getElementById('avatarInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      // Validate file size (max 2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB!');
        this.value = '';
        return;
      }
      
      // Validate file type
      const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
      if (!validTypes.includes(file.type)) {
        alert('Format file harus JPG, PNG, atau GIF!');
        this.value = '';
        return;
      }
      
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function() {
      const targetId = this.dataset.target;
      const input = document.getElementById(targetId);
      
      if (input.type === 'password') {
        input.type = 'text';
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
      } else {
        input.type = 'password';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
      }
    });
  });

  // Cancel buttons
  document.querySelectorAll('.btn-cancel').forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      form.reset();
      
      // Reset avatar preview if in profile form
      if (form.id === 'profileForm') {
        document.getElementById('avatarPreview').src = '{{ asset("images/" . $user->avatar) }}';
      }
      
      // Reset all password toggles to hide
      document.querySelectorAll('.toggle-password').forEach(icon => {
        const targetId = icon.dataset.target;
        const input = document.getElementById(targetId);
        if (input.type === 'text') {
          input.type = 'password';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        }
      });
    });
  });

  // Form submissions
  document.getElementById('profileForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate form
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    
    if (!name || !email) {
      alert('Nama dan Email wajib diisi!');
      return;
    }
    
    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert('Format email tidak valid!');
      return;
    }
    
    // Submit form via AJAX
    const formData = new FormData(this);
    fetch('{{ route("admin.updateProfile") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.message) {
        alert(data.message);
        if (data.user) {
          // Reload page to show updated data
          location.reload();
        }
      }
    })
    .catch(error => {
      alert('Gagal menyimpan profil');
      console.error('Error:', error);
    });
  });

  document.getElementById('passwordForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const currentPass = document.getElementById('current_password').value;
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('password_confirmation').value;
    
    // Validate all fields filled
    if (!currentPass || !newPass || !confirmPass) {
      alert('Semua field password harus diisi!');
      return;
    }
    
    // Validate new password length
    if (newPass.length < 8) {
      alert('Password baru minimal 8 karakter!');
      return;
    }
    
    // Validate password match
    if (newPass !== confirmPass) {
      alert('Password baru dan konfirmasi password tidak cocok!');
      return;
    }
    
    // Submit form via AJAX
    const formData = new FormData(this);
    fetch('{{ route("admin.updatePassword") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.message) {
        alert(data.message);
        if (data.success) {
          this.reset();
          
          // Reset all password toggles
          document.querySelectorAll('.toggle-password').forEach(icon => {
            const targetId = icon.dataset.target;
            const input = document.getElementById(targetId);
            if (input.type === 'text') {
              input.type = 'password';
              icon.classList.remove('fa-eye');
              icon.classList.add('fa-eye-slash');
            }
          });
        }
      }
    })
    .catch(error => {
      alert('Gagal mengubah password');
      console.error('Error:', error);
    });
  });
</script>
@endpush
@endsection
