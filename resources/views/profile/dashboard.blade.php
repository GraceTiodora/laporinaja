@extends('layouts.app')

@section('title', 'My Profile - Laporin Aja')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center gap-6 mb-8">
            <img src="{{ asset('images/profile-user.jpg') }}" alt="{{ $user['name'] }}" class="w-24 h-24 rounded-full object-cover ring-4 ring-blue-500">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">{{ $user['name'] }}</h1>
                <p class="text-gray-600">{{ $user['email'] }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $user['role'] ?? 'user' }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="flex border-b border-gray-200">
                <a href="{{ route('profile') }}" class="flex-1 py-4 px-6 text-center font-semibold text-blue-600 border-b-2 border-blue-600 transition">
                    Profil
                </a>
                <a href="{{ route('my-reports') }}" class="flex-1 py-4 px-6 text-center font-semibold text-gray-600 hover:text-gray-900 transition">
                    Laporan Saya
                </a>
            </div>

            <!-- Profile Content -->
            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ $user['name'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ $user['email'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
