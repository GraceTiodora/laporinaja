@extends('layouts.app')

@section('title', 'Login - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="bg-white max-w-md w-full rounded-xl shadow-lg p-8 relative">
        <!-- Cancel Link -->
        <a href="{{ route('home') }}" class="absolute top-5 left-6 text-gray-600 hover:underline text-sm font-medium">Cancel</a>

        <div class="text-center mb-8 mt-8">
            <h1 class="text-4xl font-extrabold text-blue-600">LaporinAja</h1>
            <p class="mt-1 text-sm text-blue-400">Sekali Klik, Masalah Tersampaikan</p>
        </div>

        <div class="text-center mb-6">
            <p class="text-gray-500 text-base">Masuk untuk Melaporkan Masalah Anda</p>
        </div>
 
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label for="email" class="block text-gray-800 font-semibold mb-2 text-sm">Email</label>
                <input id="email" name="email" type="email" required placeholder="Masukkan Email Anda"
                    class="w-full rounded-full bg-gray-100 placeholder-gray-400 px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0" value="{{ old('email') }}">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-800 font-semibold mb-2 text-sm">Kata Sandi</label>
                <input id="password" name="password" type="password" required placeholder="Masukkan Password Anda"
                    class="w-full rounded-full bg-gray-100 placeholder-gray-400 px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0">
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full py-3.5 transition text-base">
                Masuk dan Laporkan
            </button>
        </form>

        <div class="flex items-center justify-center my-6">
            <span class="text-gray-400 font-semibold text-sm">ATAU</span>
        </div>

        <!-- Google Login Button -->
        <a href="{{ route('login.google') }}" 
           class="w-full flex items-center justify-center border-2 border-black rounded-full py-3.5 gap-3 hover:bg-gray-50 transition">
            <img src="images/logo-google.png" alt="Google Icon" class="w-10 h-10" />
            <span class="font-bold text-black text-sm">Masuk dengan Google</span>
        </a>

        <p class="mt-6 text-center text-sm">
            <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600 font-medium hover:underline">
                Belum punya akun? Daftar disini
            </a>
        </p>
    </div>
</div>
@endsection