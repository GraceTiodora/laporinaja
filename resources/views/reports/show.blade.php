@extends('layouts.app')

@section('title', $report['title'] ?? 'Detail Laporan')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h1 class="card-title mb-3">{{ $report['judul'] ?? $report['title'] ?? 'N/A' }}</h1>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted">
                                <strong>Pelapor:</strong> {{ $report['user']['name'] ?? 'Anonymous' }}<br>
                                <strong>Tanggal:</strong> {{ $report['created_at'] ?? 'N/A' }}<br>
                                <strong>Lokasi:</strong> {{ $report['lokasi'] ?? $report['location'] ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p>
                                <span class="badge bg-secondary">{{ $report['category']['name'] ?? 'N/A' }}</span>
                                <span class="badge" 
                                      style="background-color: {{ $report['status'] === 'open' ? '#28a745' : ($report['status'] === 'investigating' || $report['status'] === 'diproses' ? '#ffc107' : ($report['status'] === 'resolved' ? '#17a2b8' : '#dc3545')) }}">
                                    {{ ucfirst($report['status'] ?? 'unknown') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    @if($report['foto'] ?? $report['image'] ?? null)
                        <div class="mb-4">
                            <img src="{{ asset($report['foto'] ?? $report['image']) }}" 
                                 alt="Foto Laporan" class="img-fluid rounded" style="max-height: 500px;">
                        </div>
                    @endif

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Deskripsi</h5>
                            <p class="card-text" style="white-space: pre-wrap;">{{ $report['deskripsi'] ?? $report['description'] ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mb-4">
                        @if(session('authenticated') && (session('user.id') === $report['user_id'] || session('user.role') === 'admin'))
                            <a href="{{ route('reports.edit', $report['id']) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Laporan
                            </a>
                            <form action="{{ route('reports.destroy', $report['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Yakin hapus laporan ini?')">
                                    <i class="bi bi-trash"></i> Hapus Laporan
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary float-end">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <hr>

                    <!-- Statistics -->
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h5><span class="badge bg-primary">{{ count($report['votes'] ?? []) }}</span></h5>
                            <p class="text-muted">Upvote</p>
                        </div>
                        <div class="col-md-4">
                            <h5><span class="badge bg-info">{{ count($report['comments'] ?? []) }}</span></h5>
                            <p class="text-muted">Komentar</p>
                        </div>
                        <div class="col-md-4">
                            <h5><span class="badge bg-secondary">0</span></h5>
                            <p class="text-muted">Views</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Vote Section -->
                    @if(session('authenticated'))
                        <div class="mb-4">
                            <h5>Apakah laporan ini bermanfaat?</h5>
                            <form action="{{ route('reports.vote', $report['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" name="vote" value="up">
                                    <i class="bi bi-hand-thumbs-up"></i> Upvote
                                </button>
                                <button type="submit" class="btn btn-danger" name="vote" value="down">
                                    <i class="bi bi-hand-thumbs-down"></i> Downvote
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <a href="{{ route('login') }}">Login</a> untuk upvote atau komentar
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="mt-5">
                        <h4>Komentar ({{ count($report['comments'] ?? []) }})</h4>

                        @forelse($report['comments'] ?? [] as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $comment['user']['name'] ?? 'Anonymous' }}</h6>
                                    <p class="card-text small text-muted">{{ $comment['created_at'] ?? 'N/A' }}</p>
                                    <p class="card-text">{{ $comment['content'] }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Tidak ada komentar.</p>
                        @endforelse

                        @if(session('authenticated'))
                            <form action="{{ route('reports.comment', $report['id']) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" name="content" rows="3" 
                                              placeholder="Tulis komentar Anda..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-chat"></i> Kirim Komentar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Informasi Laporan</h5>
                    <dl class="row">
                        <dt class="col-6">Status:</dt>
                        <dd class="col-6">
                            <span class="badge" 
                                  style="background-color: {{ $report['status'] === 'open' ? '#28a745' : ($report['status'] === 'investigating' ? '#ffc107' : ($report['status'] === 'resolved' ? '#17a2b8' : '#dc3545')) }}">
                                {{ ucfirst($report['status']) }}
                            </span>
                        </dd>

                        <dt class="col-6">Kategori:</dt>
                        <dd class="col-6">{{ $report['category']['name'] ?? 'N/A' }}</dd>

                        <dt class="col-6">Lokasi:</dt>
                        <dd class="col-6">{{ $report['location'] }}</dd>

                        <dt class="col-6">Dibuat:</dt>
                        <dd class="col-6">{{ $report['created_at'] ?? 'N/A' }}</dd>

                        <dt class="col-6">Diupdate:</dt>
                        <dd class="col-6">{{ $report['updated_at'] ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5 class="card-title">Tentang Pelapor</h5>
                    <p class="mb-2">
                        <strong>Nama:</strong><br>
                        {{ $report['user']['name'] ?? 'Anonymous' }}
                    </p>
                    <p class="mb-0">
                        <strong>Reputasi:</strong><br>
                        <span class="badge bg-warning">{{ $report['user']['reputation'] ?? 0 }} pts</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
