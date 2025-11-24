@extends('layouts.app')

@section('title', 'Buat Kata Sandi - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/password.css') }}">
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="bg-white max-w-md w-full rounded-xl shadow-lg p-8 relative">
        <!-- Cancel Link -->
        <a href="{{ route('home') }}" class="absolute top-5 left-6 text-gray-600 hover:underline text-sm font-medium">Cancel</a>

        <div class="text-left mb-8 mt-8">
            <h1 class="text-3xl font-extrabold text-black">Buat Akun Anda</h1>
            <h2 class="text-blue-600 text-xl font-semibold mt-1">LaporinAja</h2>
        </div>

        <form action="{{ route('register.password') }}" method="POST" class="space-y-5">
            @csrf
            
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label for="password" class="block text-gray-800 font-semibold mb-2 text-sm">Kata Sandi</label>
                <input id="password" name="password" type="password" required placeholder="Minimal 6 karakter"
                    class="w-full rounded-full bg-gray-100 placeholder-gray-400 px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0">
                @error('password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-800 font-semibold mb-2 text-sm">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ulangi kata sandi"
                    class="w-full rounded-full bg-gray-100 placeholder-gray-400 px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0">
                @error('password_confirmation')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full py-3.5 transition text-base">
                Daftar
            </button>
        </form>
    </div>
</div>
@endsection