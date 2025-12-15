@extends('layouts.app')

@section('title', 'Detail Laporan User')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-4">Detail Laporan</h2>
        <div class="mb-4">
            <strong>Judul:</strong> {{ $report->title }}
        </div>
        <div class="mb-4">
            <strong>Kategori:</strong> {{ $report->category->name ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Status:</strong> {{ $report->status }}
        </div>
        <div class="mb-4">
            <strong>Pelapor:</strong> {{ $report->user->name ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Lokasi:</strong> {{ $report->location }}
        </div>

        @if($report->location)
        <div class="mb-4">
            <strong>Peta Lokasi:</strong>
            <div id="detailMapDiv" style="width: 100%; height: 350px; border: 2px solid #ddd; border-radius: 8px; margin-top: 10px;"></div>
        </div>
        @endif
        <div class="mb-4">
            <strong>Deskripsi:</strong>
            <div class="bg-gray-50 rounded p-3 mt-1">{{ $report->description }}</div>
        </div>
        @if($report->image)
        <div class="mb-4">
            <strong>Gambar:</strong><br>
            <img src="{{ $report->image }}" alt="Gambar laporan" class="rounded-lg max-w-full h-auto mt-2">
        </div>
        @endif
        <div class="mb-4">
            <strong>Tanggal Dibuat:</strong> {{ $report->created_at ? $report->created_at->format('d/m/Y H:i') : '-' }}
        </div>
        <div class="mb-4">
            <strong>Jumlah Vote:</strong> {{ $report->upvotes ?? 0 }}
        </div>
        <div class="mb-4">
            <strong>Komentar:</strong>
            <ul class="list-disc ml-6">
                @foreach($report->comments as $comment)
                <li>
                    <strong>{{ $comment->user->name ?? 'Anonim' }}:</strong> {{ $comment->content }}
                </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('admin.monitoring') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">Kembali ke Monitoring</a>
    </div>
</div>

@if($report->location)
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const locationStr = '{{ $report->location }}';
        const coords = locationStr.split(',');
        
        if (coords.length === 2) {
            const lat = parseFloat(coords[0]);
            const lng = parseFloat(coords[1]);
            
            const mapOptions = {
                zoom: 17,
                center: { lat: lat, lng: lng },
                mapTypeControl: true,
                fullscreenControl: true,
                streetViewControl: true,
            };
            
            const detailMap = new google.maps.Map(document.getElementById('detailMapDiv'), mapOptions);
            
            // Add marker
            new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: detailMap,
                title: 'Lokasi Laporan'
            });
        }
    });
</script>
@endif

@endsection
