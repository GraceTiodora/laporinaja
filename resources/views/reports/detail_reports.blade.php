@extends('layouts.app')

@section('title', 'Detail Laporan - LaporinAja')

@section('content')
<div class="container mt-5 mb-5">
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Header Info -->
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="rounded-circle" width="50" height="50" alt="Profile">
                        <div class="ms-3">
                            <h6 class="mb-0">{{ $report['user']['name'] ?? 'Anonymous' }}</h6>
                            <small class="text-muted">{{ $report['created_at'] ?? 'N/A' }} • {{ $report['location'] }}</small>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="card-title mb-3">{{ $report['title'] }}</h2>

                    <!-- Image (if exists) -->
                    @if($report['image'] ?? null)
                        <img src="{{ asset($report['image']) }}" alt="Report Image" class="img-fluid rounded mb-4" style="max-height: 500px; object-fit: cover;">
                    @endif

                    <!-- Description -->
                    <p class="card-text">{{ $report['description'] }}</p>

                    <!-- Status & Category Badges -->
                    <div class="mb-4">
                        <span class="badge bg-secondary me-2">{{ $report['category']['name'] ?? 'N/A' }}</span>
                        <span class="badge bg-info">{{ $report['location'] }}</span>
                        <span class="badge" 
                              style="background-color: {{ $report['status'] === 'open' ? '#28a745' : ($report['status'] === 'investigating' ? '#ffc107' : ($report['status'] === 'resolved' ? '#17a2b8' : '#dc3545')) }}">
                            {{ ucfirst($report['status'] ?? 'unknown') }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    @if(session('authenticated') && (session('user.id') === $report['user_id'] || session('user.role') === 'admin'))
                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ route('reports.edit', $report['id']) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('reports.destroy', $report['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Voting Section -->
                    <div class="card mt-4 mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Apakah laporan ini penting?</h6>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success flex-grow-1">
                                    <i class="bi bi-hand-thumbs-up"></i> Penting
                                </button>
                                <button class="btn btn-danger flex-grow-1">
                                    <i class="bi bi-hand-thumbs-down"></i> Tidak Penting
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="bi bi-chat-dots"></i> Komentar
                            </h6>

                            <!-- Comment Input -->
                            @if(session('authenticated'))
                                <form class="mb-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tambahkan komentar..." />
                                        <button class="btn btn-primary" type="button">Kirim</button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-info mb-4">
                                    <small><a href="{{ route('login') }}">Login</a> untuk menambahkan komentar</small>
                                </div>
                            @endif

                            <!-- Comments List -->
                            <div class="comments-list">
                                <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                    <img src="{{ asset('images/profile-user.jpg') }}" class="rounded-circle" width="40" height="40" alt="Profile">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            Jennie Kim 
                                            <small class="text-muted">• 2 jam lalu</small>
                                        </h6>
                                        <p class="mb-0 text-muted">
                                            Saya juga sering lewat sini setiap pagi. Lubangnya makin dalam apalagi setelah hujan kemarin.
                                        </p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                    <img src="{{ asset('images/profile-user.jpg') }}" class="rounded-circle" width="40" height="40" alt="Profile">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            Budi Santoso 
                                            <small class="text-muted">• 1 jam lalu</small>
                                        </h6>
                                        <p class="mb-0 text-muted">
                                            Sudah dilaporkan ke dinas beberapa kali tetap tidak ada tindakan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Popular Reports -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-fire text-danger"></i> Laporan Populer
                    </h6>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <h6 class="mb-1">Jalan Rusak</h6>
                            <small class="text-muted">Jl. Melati • 128 Votes</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2">
                            <h6 class="mb-1">Sampah Menumpuk</h6>
                            <small class="text-muted">Pasar Baru • 96 Votes</small>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trending -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-graph-up text-primary"></i> Trending
                    </h6>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Infrastruktur Jalan</h6>
                                <small class="text-muted">5 laporan hari ini</small>
                            </div>
                            <span class="badge bg-danger">Penting</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Sampah Menumpuk</h6>
                                <small class="text-muted">Pasar Baru</small>
                            </div>
                            <span class="badge bg-warning">Sedang</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
