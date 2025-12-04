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
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2 text-sm">
                @php
                    $menu = [
                        ['Beranda', 'admin.dashboard', 'fa-solid fa-house'],
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
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-800 mb-1">Pengaturan Akun</h1>
            <p class="text-sm text-gray-500">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Profile Section --}}
        <div class="settings-card bg-white rounded-3xl border-2 border-gray-200 p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Profil Admin</h2>
            <p class="text-base text-gray-500 mb-8">Selamat datang di sistem  manajemen  laporan masyarakat</p>

            <form action="#" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                {{-- Avatar Upload --}}
                <div class="flex items-center gap-6 mb-10">
                    <div class="avatar-wrapper">
                        <img src="{{ asset('images/' . $user->avatar) }}" 
                             class="w-32 h-32 rounded-full object-cover border-2 border-gray-200"
                             alt="Profile Avatar"
                             id="avatarPreview">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="avatarInput" class="upload-btn-text">
                            Ubah Foto
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
                        <p class="text-sm text-gray-500">JPG, PNG atau GIF, Maks 2MB.</p>
                    </div>
                </div>

                {{-- Profile Info Display --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-6 mb-10">
                    <div class="profile-info-item">
                        <b><label class="profile-label">Nama Lengkap</label></b>
                        <div class="profile-value">{{ $user->name }}</div>
                    </div>

                    <div class="profile-info-item">
                        <b><label class="profile-label">Email</label></b>
                        <div class="profile-value">{{ $user->email }}</div>
                    </div>

                    <div class="profile-info-item">
                        <b><label class="profile-label">Nomor Telepon</label></b>
                        <div class="profile-value">{{ $user->phone }}</div>
                    </div>

                    <div class="profile-info-item">
                        <b><label class="profile-label">Role</label></b>
                        <div class="profile-value">{{ $user->role }}</div>
                    </div>
                </div>

                {{-- Hidden inputs untuk actual form data --}}
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="hidden" name="phone" value="{{ $user->phone }}">

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-4">
                    <button type="button" class="btn-cancel">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- Security Section --}}
        <div class="settings-card bg-white rounded-3xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Keamanan</h2>
            <p class="text-base text-gray-500 mb-8">Kelola password dan keamanan akun</p>

            <form action="#" method="POST" id="passwordForm">
                @csrf
                @method('PUT')

                {{-- Password Saat Ini (Full Width) --}}
                <div class="form-group mb-6">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <div class="password-input-wrapper">
                        <i class="fa-solid fa-lock password-icon"></i>
                        <input type="password" id="current_password" name="current_password" 
                               class="form-input-full with-icon" placeholder="Masukkan password saat ini">
                    </div>
                </div>

                {{-- Password Baru & Konfirmasi (Grid 2 Kolom) --}}
                <div class="grid grid-cols-2 gap-x-8 gap-y-6 mb-10">
                    <div class="form-group">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="password-input-wrapper">
                            <i class="fa-solid fa-lock password-icon"></i>
                            <input type="password" id="new_password" name="new_password" 
                                   class="form-input with-icon" placeholder="Masukkan password baru">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-input-wrapper">
                            <i class="fa-solid fa-lock password-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-input with-icon" placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-4">
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
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
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
    });
  });

  // Form submissions
  document.getElementById('profileForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    // Add your AJAX submission here
    alert('Profil berhasil diperbarui!');
  });

  document.getElementById('passwordForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPass = document.getElementById('new_password').value;
    const confirmPass = document.getElementById('password_confirmation').value;
    
    if (newPass !== confirmPass) {
      alert('Password baru dan konfirmasi password tidak cocok!');
      return;
    }
    
    // Add your AJAX submission here
    alert('Password berhasil diubah!');
    this.reset();
  });
</script>
@endpush
@endsection
