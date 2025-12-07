@extends('layouts.app')

@section('title', 'Register - Laporin Aja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
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

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif
 
            <div>
                <label for="name" class="block text-gray-800 font-semibold mb-2 text-sm">Nama</label>
                <input id="name" name="name" type="text" required placeholder="Nama"
                    class="w-full rounded-full bg-gray-100 placeholder-gray-400 px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0" value="{{ old('name') }}">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-800 font-semibold mb-2 text-sm">Email</label>
                <input id="email" name="email" type="email" required placeholder="Email"
                    class="w-full rounded-full bg-gray-100 placeholder-gray-400 px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0" value="{{ old('email') }}">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-800 font-semibold mb-2 text-sm">Tanggal Lahir</label>
                <div class="flex gap-3">
                    <select name="bulan" required class="flex-1 rounded-full bg-gray-100 px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0 text-gray-500">
                        <option value="" disabled selected>Bulan</option>
                        @php
                            $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        @endphp
                        @foreach ($bulan as $b)
                            <option value="{{ $b }}"{{ old('bulan') == $b ? ' selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    <select name="hari" required class="flex-1 rounded-full bg-gray-100 px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0 text-gray-500">
                        <option value="" disabled selected>Hari</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}"{{ old('hari') == $i ? ' selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="tahun" required class="flex-1 rounded-full bg-gray-100 px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0 text-gray-500">
                        <option value="" disabled selected>Tahun</option>
                        @php
                            $year = date('Y');
                        @endphp
                        @for ($y = $year; $y >= 1900; $y--)
                            <option value="{{ $y }}"{{ old('tahun') == $y ? ' selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                @error('bulan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                @error('hari') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                @error('tahun') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-full py-3.5 transition text-base">
                Daftar
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
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-medium hover:underline">
                Sudah punya akun? Login disini
            </a>
        </p>
    </div>
</div>
@endsection