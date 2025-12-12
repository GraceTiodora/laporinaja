@extends('layouts.app')

@section('title', 'Test Register')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6">Test Registrasi Langsung</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow max-w-md">
        <form action="{{ route('test.register.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-2">Nama</label>
                <input type="text" name="name" required placeholder="Nama lengkap" 
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block font-semibold mb-2">Email</label>
                <input type="email" name="email" required placeholder="Email unik" 
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block font-semibold mb-2">Password</label>
                <input type="password" name="password" required placeholder="Min 6 karakter" 
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password" 
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password_confirmation')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">
                Registrasi Sekarang
            </button>
        </form>

        <hr class="my-6">

        <p class="text-sm text-gray-600 mb-4">Atau coba normal register:</p>
        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register Form Normal</a>
    </div>

    <!-- List users yang sudah terdaftar -->
    <div class="mt-8 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Users yang Sudah Terdaftar:</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">Role</th>
                    <th class="border px-4 py-2 text-left">Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $user->id }}</td>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">
                        <span class="px-2 py-1 rounded text-sm {{ $user->role === 'admin' ? 'bg-red-200' : 'bg-blue-200' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">{{ $user->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Belum ada user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
