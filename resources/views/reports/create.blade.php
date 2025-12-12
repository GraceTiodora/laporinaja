@extends('layouts.app')

@section('title', 'Buat Laporan Baru')

@section('content')
<div class="container-fluid" style="max-width: 1200px; margin: 0 auto;">
    <div class="row mt-4">
        <!-- Back Button -->
        <div class="col-12 mb-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Form Card -->
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="d-flex align-items-center mb-5">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                            📝
                        </div>
                        <div class="ms-3">
                            <h2 class="mb-0" style="color: #2c3e50; font-weight: 700;">Buat Laporan Baru</h2>
                            <p class="text-muted mb-0">Laporkan masalah yang ada di lingkungan Anda</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px; border: none;">
                            <strong><i class="bi bi-exclamation-circle"></i> Terjadi Kesalahan!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul Laporan -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-600" style="color: #2c3e50; font-size: 16px;">
                                <i class="bi bi-chat-square-text" style="color: #667eea;"></i> Judul Laporan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Jalan Rusak di Jalan Sudirman" 
                                   required
                                   style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 15px; font-size: 15px;">
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-600" style="color: #2c3e50; font-size: 16px;">
                                <i class="bi bi-file-text" style="color: #667eea;"></i> Deskripsi Detail <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" 
                                      name="description" 
                                      rows="6"
                                      placeholder="Jelaskan masalah secara detail..."
                                      required
                                      style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 15px; font-size: 15px;">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi & Kategori -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="location" class="form-label fw-600" style="color: #2c3e50; font-size: 16px;">
                                    <i class="bi bi-geo-alt" style="color: #667eea;"></i> Lokasi <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}"
                                       placeholder="Contoh: Jalan Sudirman No.123"
                                       required
                                       style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 15px; font-size: 15px;">
                                @error('location')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="category_id" class="form-label fw-600" style="color: #2c3e50; font-size: 16px;">
                                    <i class="bi bi-tag" style="color: #667eea;"></i> Kategori <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" 
                                        name="category_id" 
                                        required
                                        style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 12px 15px; font-size: 15px;">
                                    <option value="">-- Pilih Kategori --</option>
                                    @forelse($categories as $category)
                                        <option value="{{ $category['id'] ?? $category->id }}" 
                                                {{ old('category_id') == ($category['id'] ?? $category->id) ? 'selected' : '' }}>
                                            {{ $category['name'] ?? $category->name }}
                                        </option>
                                    @empty
                                        <option disabled>Tidak ada kategori</option>
                                    @endforelse
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-600" style="color: #2c3e50; font-size: 16px;">
                                <i class="bi bi-image" style="color: #667eea;"></i> Foto (Opsional)
                            </label>
                            <div class="input-group">
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image" 
                                       name="image" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       style="border-radius: 10px 0 0 10px; border: 2px solid #e0e0e0;">
                                <span class="input-group-text" style="border-radius: 0 10px 10px 0; border: 2px solid #e0e0e0; background: #f8f9fa; border-left: none;">
                                    <i class="bi bi-cloud-upload"></i>
                                </span>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Maksimal 2MB, format: JPEG, PNG, JPG, GIF
                            </small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5 pt-3 border-top">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg" style="border-radius: 10px; padding: 12px 30px;">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; font-weight: 600;">
                                <i class="bi bi-check-circle"></i> Buat Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        margin-bottom: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection
