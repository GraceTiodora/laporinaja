@extends('layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Daftar Laporan</h2>
        </div>
        <div class="col-md-4 text-md-end">
            @if(session('authenticated'))
                <a href="{{ route('reports.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Laporan
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Login untuk Membuat Laporan
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('error') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari laporan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Buka</option>
                        <option value="investigating" {{ request('status') === 'investigating' ? 'selected' : '' }}>Proses</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports List -->
    @forelse($reports['data'] ?? [] as $report)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="card-title">
                            <a href="{{ route('reports.show', $report['id']) }}" class="text-decoration-none">
                                {{ $report['title'] }}
                            </a>
                        </h5>
                        <p class="card-text text-muted small mb-2">
                            <i class="bi bi-person"></i> {{ $report['user']['name'] ?? 'Anonymous' }} 
                            | <i class="bi bi-calendar"></i> {{ $report['created_at'] ?? 'N/A' }}
                        </p>
                        <p class="card-text">{{ Str::limit($report['description'], 150) }}</p>
                        <p class="card-text">
                            <span class="badge bg-secondary">{{ $report['category']['name'] ?? 'N/A' }}</span>
                            <span class="badge bg-info">{{ $report['location'] }}</span>
                            <span class="badge" 
                                  style="background-color: {{ $report['status'] === 'open' ? '#28a745' : ($report['status'] === 'investigating' ? '#ffc107' : ($report['status'] === 'resolved' ? '#17a2b8' : '#dc3545')) }}">
                                {{ ucfirst($report['status'] ?? 'unknown') }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('reports.show', $report['id']) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                            @if(session('authenticated') && (session('user.id') === $report['user_id'] || session('user.role') === 'admin'))
                                <a href="{{ route('reports.edit', $report['id']) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('reports.destroy', $report['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Yakin hapus laporan ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Tidak ada laporan yang ditemukan.
        </div>
    @endforelse

    <!-- Pagination -->
    @if(isset($reports['links']))
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                @foreach($reports['links'] as $link)
                    <li class="page-item {{ $link['active'] ? 'active' : ($link['url'] ? '' : 'disabled') }}">
                        @if($link['url'])
                            <a class="page-link" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                        @else
                            <span class="page-link">{{ $link['label'] }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    @endif
</div>
@endsection
