@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
@endpush

@section('title', 'Pengaturan Akun')

@section('content')
@php
    $user = $user ?? (object)[
        'name' => 'Justin Hubner',
        'email' => 'justin.hubner@example.com',
        'phone' => '081234567890',
        'role' => 'Admin',
        'avatar' => 'profile-user.jpg'
    ]; 
@endphp

<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR (sama seperti monitoring) --}}
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2 text-sm">
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
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl 
                              {{ request()->routeIs($route) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}
                              hover:bg-blue-50 hover:text-blue-600 transition-all">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Profile --}}
        <div class="mt-6 border-t border-gray-200 pt-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">

                <div>
                    <p class="text-sm font-semibold">Justin Hubner</p>
                    <p class="text-xs text-gray-500">@adminhubner</p>
                </div>
            </div>

            <form action="#" method="POST" class="mt-4">
                @csrf
                <button class="text-red-500 text-sm font-semibold hover:underline flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto bg-gray-50">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800 mb-1">Pengaturan Akun</h1>
            <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Profile Section --}}
        <div class="settings-card bg-white rounded-2xl border border-gray-200 p-6 mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-1">Profil Admin</h2>
            <p class="text-sm text-gray-500 mb-5">Selamat datang di sistem manajemen laporan masyarakat</p>

            <form action="#" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                {{-- Avatar Upload --}}
                <div class="flex items-center gap-3 mb-5">
                    <div class="avatar-wrapper">
                        <img src="{{ asset('images/' . $user->avatar) }}" 
                             class="w-16 h-16 rounded-full object-cover border-2 border-gray-200"
                             alt="Profile Avatar"
                             id="avatarPreview">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="avatarInput" class="upload-btn-text">
                            Ubah Foto
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
                        <p class="text-xs text-gray-500">JPG, PNG atau GIF, Maks 2MB.</p>
                    </div>
                </div>

                {{-- Profile Input Fields --}}
                <div class="grid grid-cols-2 gap-x-5 gap-y-4 mb-5">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" 
                               class="form-input" 
                               value="{{ $user->name }}"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" 
                               class="form-input" 
                               value="{{ $user->email }}"
                               placeholder="Masukkan email">
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" 
                               class="form-input" 
                               value="{{ $user->phone }}"
                               placeholder="Masukkan nomor telepon">
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" id="role" name="role" 
                               class="form-input" 
                               value="{{ $user->role }}"
                               readonly
                               style="background: #f9fafb; cursor: not-allowed;">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3">
                    <button type="button" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- Security Section --}}
        <div class="settings-card bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-gray-900 mb-1">Keamanan</h2>
            <p class="text-sm text-gray-500 mb-5">Kelola password dan keamanan akun</p>

            <form action="#" method="POST" id="passwordForm">
                @csrf
                @method('PUT')

                {{-- Password Saat Ini (Full Width) --}}
                <div class="form-group mb-4">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <div class="password-input-wrapper">
                        <i class="fa-solid fa-lock password-icon-left"></i>
                        <input type="password" id="current_password" name="current_password" 
                               class="form-input-full with-icons" placeholder="Masukkan password saat ini">
                        <i class="fa-solid fa-eye-slash password-icon-right toggle-password" data-target="current_password"></i>
                    </div>
                </div>

                {{-- Password Baru & Konfirmasi (Grid 2 Kolom) --}}
                <div class="grid grid-cols-2 gap-x-5 gap-y-4 mb-5">
                    <div class="form-group">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="password-input-wrapper">
                            <i class="fa-solid fa-lock password-icon-left"></i>
                            <input type="password" id="new_password" name="new_password" 
                                   class="form-input with-icons" placeholder="Masukkan password baru">
                            <i class="fa-solid fa-eye-slash password-icon-right toggle-password" data-target="new_password"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-input-wrapper">
                            <i class="fa-solid fa-lock password-icon-left"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-input with-icons" placeholder="Konfirmasi password baru">
                            <i class="fa-solid fa-eye-slash password-icon-right toggle-password" data-target="password_confirmation"></i>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3">
                    <button type="button" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
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
    
    if (!name || !email || !phone) {
      alert('Semua field harus diisi!');
      return;
    }
    
    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert('Format email tidak valid!');
      return;
    }
    
    // Validate phone format (basic)
    const phoneRegex = /^[0-9]{10,13}$/;
    if (!phoneRegex.test(phone)) {
      alert('Nomor telepon harus 10-13 digit angka!');
      return;
    }
    
    // Add your AJAX submission here
    alert('Profil berhasil diperbarui!');
    console.log('Profile data:', { name, email, phone });
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
    
    // Add your AJAX submission here
    alert('Password berhasil diubah!');
    console.log('Password change requested');
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
  });
</script>
@endpush
@endsection
