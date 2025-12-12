@extends('layouts.app')

@section('title', 'Simple Login - Test')

@section('content')
<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Quick Login (Test)</h1>
    
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('simple-login-submit') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Email</label>
            <select name="email" class="w-full px-4 py-2 border rounded">
                <option value="">Pilih User</option>
                <option value="seprian@test.com">Seprian Siagian (seprian@test.com)</option>
                <option value="budi@test.com">Budi Santoso (budi@test.com)</option>
                <option value="ani@test.com">Ani Wijaya (ani@test.com)</option>
                <option value="rini@test.com">Rini Kusuma / Admin (rini@test.com)</option>
                <option value="admin@test.com">Admin (admin@test.com)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="text" value="password" disabled class="w-full px-4 py-2 border rounded bg-gray-100">
            <small class="text-gray-500">Default: "password" untuk user biasa, "admin123" untuk admin</small>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>

    <hr class="my-6">
    
    <div class="bg-blue-50 p-4 rounded text-sm">
        <h3 class="font-bold mb-2">📝 Test Credentials:</h3>
        <ul class="space-y-1">
            <li><strong>User:</strong> seprian@test.com / password</li>
            <li><strong>User:</strong> budi@test.com / password</li>
            <li><strong>Admin:</strong> admin@test.com / admin123</li>
        </ul>
    </div>
</div>
@endsection
