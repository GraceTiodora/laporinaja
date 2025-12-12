@extends('layouts.app')

@section('title', 'My Reports - Laporin Aja')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Laporan Saya</h1>
            <p class="text-gray-600 mt-2">Kelola semua laporan yang Anda buat</p>
        </div>

        <!-- Reports List -->
        <div class="grid gap-6">
            @forelse($reports as $report)
                <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $report['title'] }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $report['location'] }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($report['status'] == 'open') bg-blue-100 text-blue-700
                            @elseif($report['status'] == 'investigating') bg-yellow-100 text-yellow-700
                            @elseif($report['status'] == 'resolved') bg-green-100 text-green-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($report['status']) }}
                        </span>
                    </div>

                    <p class="text-gray-700 mb-4 line-clamp-2">{{ $report['description'] }}</p>

                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-folder"></i> {{ $report['category']['name'] ?? 'Umum' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-heart"></i> {{ $report['vote_count'] ?? 0 }} Votes
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-comment"></i> {{ $report['comments_count'] ?? 0 }} Komentar
                        </span>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('reports.show', $report['id']) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold transition">
                            Lihat Detail
                        </a>
                        <a href="{{ route('reports.edit', $report['id']) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm font-semibold transition">
                            Edit
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <i class="fa-solid fa-inbox text-6xl text-gray-300 mb-4 block"></i>
                    <p class="text-gray-600 text-lg font-semibold">Anda belum membuat laporan</p>
                    <p class="text-gray-500 mt-2">Mulai buat laporan untuk membantu komunitas</p>
                    <a href="{{ route('reports.create') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                        Buat Laporan Baru
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
