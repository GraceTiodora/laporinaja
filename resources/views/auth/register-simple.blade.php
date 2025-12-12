@extends('layouts.app')

@section('title', 'Registrasi Cepat - Laporin Aja')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="bg-white max-w-md w-full rounded-xl shadow-lg p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-black">Daftar Sekarang</h1>
            <h2 class="text-blue-600 text-lg font-semibold mt-1">LaporinAja</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register.simple.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-gray-800 font-semibold mb-2 text-sm">Nama Lengkap</label>
                <input 
                    id="name" 
                    name="name" 
                    type="text" 
                    required 
                    placeholder="Contoh: Rian Pratama"
                    class="w-full rounded-lg bg-gray-100 placeholder-gray-400 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0"
                    value="{{ old('name') }}"
                >
            </div>

            <div>
                <label for="email" class="block text-gray-800 font-semibold mb-2 text-sm">Email</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    required 
                    placeholder="contoh@email.com"
                    class="w-full rounded-lg bg-gray-100 placeholder-gray-400 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0"
                    value="{{ old('email') }}"
                >
                <p class="text-xs text-gray-500 mt-1">💡 Gunakan email yang belum pernah digunakan sebelumnya</p>
            </div>

            <div>
                <label for="password" class="block text-gray-800 font-semibold mb-2 text-sm">Password</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    placeholder="Minimal 6 karakter"
                    class="w-full rounded-lg bg-gray-100 placeholder-gray-400 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-800 font-semibold mb-2 text-sm">Konfirmasi Password</label>
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    required 
                    placeholder="Ulangi password"
                    class="w-full rounded-lg bg-gray-100 placeholder-gray-400 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition border-0"
                >
            </div>

            <button 
                type="submit"
                class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg py-3 transition text-base">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <p class="text-gray-600">Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-medium hover:underline">
                    Login di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
