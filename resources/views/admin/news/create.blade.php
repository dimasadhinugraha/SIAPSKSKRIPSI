@extends('layouts.app-bootstrap')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">📝 Tambah Berita Baru</h1>
            <p class="text-muted mb-0">Lengkapi form untuk menambahkan berita baru.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-12">
                        <label for="title" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category" class="form-label">Kategori</label>
                        <select id="category" name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>Berita</option>
                            <option value="announcement" {{ old('category') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Kegiatan</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                     <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publikasikan</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="col-12">
                        <label for="excerpt" class="form-label">Ringkasan (Opsional)</label>
                        <textarea id="excerpt" name="excerpt" rows="3" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Ringkasan singkat berita...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="col-12">
                        <label for="content" class="form-label">Konten Berita</label>
                        <textarea id="content" name="content" rows="10" class="form-control @error('content') is-invalid @enderror" required placeholder="Tulis konten berita di sini...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Featured Image -->
                    <div class="col-md-6">
                        <label for="featured_image" class="form-label">Gambar Utama (Opsional)</label>
                        <input id="featured_image" type="file" name="featured_image" accept="image/*" class="form-control @error('featured_image') is-invalid @enderror">
                        <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Published Date -->
                    <div class="col-md-6">
                        <label for="published_at" class="form-label">Tanggal Publikasi (Opsional)</label>
                        <input id="published_at" type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" name="published_at" value="{{ old('published_at') }}">
                        <div class="form-text">Kosongkan untuk menggunakan waktu sekarang jika status "Publikasikan".</div>
                         @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection