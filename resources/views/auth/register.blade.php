@extends('layouts.app')

@section('title', 'Register - Laporin Aja')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="bg-white max-w-md w-full rounded-xl shadow-lg p-8 relative">
        <!-- Cancel Link -->
        <a href="{{ url('/') }}" class="absolute top-5 left-6 text-gray-600 hover:underline text-sm font-medium">Cancel</a>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-black">Buat Akun Anda</h1>
            <h2 class="text-blue-600 text-xl font-semibold">LaporinAja</h2>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-1">Nama</label>
                <input id="name" name="name" type="text" required placeholder="Nama"
                    class="w-full rounded-full bg-gray-200 placeholder-gray-400 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition" value="{{ old('name') }}">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input id="email" name="email" type="email" required placeholder="Email"
                    class="w-full rounded-full bg-gray-200 placeholder-gray-400 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition" value="{{ old('email') }}">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tanggal Lahir</label>
                <div class="flex gap-3">
                    <select name="bulan" required class="flex-1 rounded-full bg-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        <option value="" disabled selected>Bulan</option>
                        @php
                            $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        @endphp
                        @foreach ($bulan as $b)
                            <option value="{{ $b }}"{{ old('bulan') == $b ? ' selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    <select name="hari" required class="flex-1 rounded-full bg-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        <option value="" disabled selected>Hari</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}"{{ old('hari') == $i ? ' selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="tahun" required class="flex-1 rounded-full bg-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                        <option value="" disabled selected>Tahun</option>
                        @php
                            $year = date('Y');
                        @endphp
                        @for ($y = $year; $y >= 1900; $y--)
                            <option value="{{ $y }}"{{ old('tahun') == $y ? ' selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                @error('bulan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                @error('hari') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                @error('tahun') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full py-3 transition">
                Daftar
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
            <a href="{{ route('login') }}">
                Sudah punya akun ? Login disini
            </a>
        </p>
    </div>
</div>
@endsection