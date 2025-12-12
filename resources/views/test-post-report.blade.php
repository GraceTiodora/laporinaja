@extends('layouts.app')

@section('title', 'Test Post Report')

@section('content')
<div class="container mx-auto p-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">🧪 Test Posting Laporan</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <h3 class="font-bold">Errors:</h3>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold mb-2">Title (Judul Laporan)</label>
                <input 
                    type="text" 
                    name="title" 
                    required
                    placeholder="Contoh: Jalan berlubang di Jl. Merdeka"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('title') }}"
                >
            </div>

            <div>
                <label class="block font-bold mb-2">Description (Deskripsi)</label>
                <textarea 
                    name="description" 
                    required
                    rows="5"
                    placeholder="Jelaskan masalah secara detail..."
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-bold mb-2">Location (Lokasi)</label>
                <input 
                    type="text" 
                    name="location" 
                    required
                    placeholder="Contoh: Jl. Merdeka No. 45"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('location') }}"
                >
            </div>

            <div>
                <label class="block font-bold mb-2">Category (Kategori)</label>
                <select 
                    name="category_id" 
                    required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">-- Pilih Kategori --</option>
                    @forelse($categories as $cat)
                        <option value="{{ $cat['id'] ?? $cat->id }}" {{ old('category_id') == ($cat['id'] ?? $cat->id) ? 'selected' : '' }}>
                            {{ $cat['name'] ?? $cat->name }}
                        </option>
                    @empty
                        <option disabled>❌ Tidak ada kategori</option>
                    @endforelse
                </select>
            </div>

            <div>
                <label class="block font-bold mb-2">Image (Foto - Optional)</label>
                <input 
                    type="file" 
                    name="image" 
                    accept="image/*"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-blue-500 text-white font-bold py-3 rounded hover:bg-blue-600 transition"
            >
                ✅ POST LAPORAN
            </button>
        </form>
    </div>

    <div class="mt-8 bg-blue-50 p-6 rounded border border-blue-200">
        <h3 class="font-bold mb-3">📋 Debug Info:</h3>
        <ul class="list-disc list-inside space-y-2 text-sm">
            <li><strong>User:</strong> {{ session('user.name') ?? 'Not logged in' }}</li>
            <li><strong>User ID:</strong> {{ session('user.id') ?? 'N/A' }}</li>
            <li><strong>Authenticated:</strong> {{ session('authenticated') ? '✅ Yes' : '❌ No' }}</li>
            <li><strong>Categories Count:</strong> {{ count($categories ?? []) }}</li>
        </ul>
    </div>
</div>
@endsection
