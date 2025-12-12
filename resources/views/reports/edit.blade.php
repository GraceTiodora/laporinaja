@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">Edit Laporan</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Error!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reports.update', $report['id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Laporan *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $report['title'] ?? '') }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Detail *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5" required>{{ old('description', $report['description'] ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Lokasi *</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                       id="location" name="location" value="{{ old('location', $report['location'] ?? '') }}"
                                       required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Kategori *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @forelse($categories as $category)
                                        <option value="{{ $category['id'] ?? $category->id }}" 
                                                {{ old('category_id', $report['category_id'] ?? '') == ($category['id'] ?? $category->id) ? 'selected' : '' }}>
                                            {{ $category['name'] ?? $category->name }}
                                        </option>
                                    @empty
                                        <option disabled>Tidak ada kategori</option>
                                    @endforelse
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status">
                                    <option value="">-- Tidak Ada Perubahan --</option>
                                    <option value="open" {{ old('status', $report['status'] ?? '') === 'open' ? 'selected' : '' }}>Buka</option>
                                    <option value="investigating" {{ old('status', $report['status'] ?? '') === 'investigating' ? 'selected' : '' }}>Proses</option>
                                    <option value="resolved" {{ old('status', $report['status'] ?? '') === 'resolved' ? 'selected' : '' }}>Selesai</option>
                                    <option value="rejected" {{ old('status', $report['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Foto (Opsional)</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif">
                                <small class="text-muted">Maksimal 2MB</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @if($report['image'] ?? null)
                            <div class="mb-3">
                                <label class="form-label">Foto Saat Ini</label><br>
                                <img src="{{ asset('storage/' . $report['image']) }}" 
                                     alt="Foto Laporan" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reports.show', $report['id']) }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
