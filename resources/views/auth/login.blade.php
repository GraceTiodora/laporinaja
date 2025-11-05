@extends('layouts.app')

@section('title', 'Login - Laporin Aja')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="bg-white max-w-md w-full rounded-xl shadow-lg p-8 relative">
        <!-- Cancel Link -->
        <a href="{{ url('/') }}" class="absolute top-5 left-6 text-gray-600 hover:underline text-sm font-medium">Cancel</a>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-blue-600">LaporinAja</h1>
            <p class="mt-1 text-blue-400">Sekali Klik, Masalah Tersampaikan</p>
            <p class="mt-4 text-gray-500">Masuk untuk Melaporkan Masalah Anda</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="username" class="block text-gray-700 font-semibold mb-1">Username</label>
                <input id="username" name="username" type="text" required placeholder="Masukkan Nama Lengkap Anda"
                    class="w-full rounded-full bg-gray-200 placeholder-gray-400 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition" value="{{ old('username') }}">
                @error('username')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Kata sandi</label>
                <input id="password" name="password" type="password" required placeholder="Masukkan Nomor HP atau Email Anda"
                    class="w-full rounded-full bg-gray-200 placeholder-gray-400 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full py-3 transition">
                Masuk dan Laporkan
            </button>
        </form>

        <div class="flex items-center justify-center mt-6 mb-4">
            <span class="text-gray-400 font-semibold">ATAU</span>
        </div>

        <!-- Google Login Button -->
        <a href="{{ route('login.google') }}" 
           class="w-full flex items-center justify-center border border-black rounded-full py-3 gap-2 hover:bg-gray-100 transition">
            <img src="{{ asset('images/google-icon.svg') }}" alt="Google Icon" class="w-5 h-5" />
            <span class="font-semibold text-black">Masuk dengan Google</span>
        </a>

        <p class="mt-6 text-center text-blue-500 hover:underline cursor-pointer">
            <a href="{{ route('register') }}">
                Belum punya akun? Daftar disini
            </a>
        </p>
    </div>
</div>
@endsection