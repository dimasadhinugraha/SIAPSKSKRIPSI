@extends('layouts.app-bootstrap')

@section('title', 'Detail Berita')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">👁️ Detail Berita</h1>
        </div>
        <div>
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <!-- Article Header -->
            <div class="mb-4">
                @php
                    $categoryColors = [
                        'news' => 'bg-primary',
                        'announcement' => 'bg-info text-dark',
                        'event' => 'bg-success',
                    ];
                    $categoryLabels = [
                        'news' => 'Berita',
                        'announcement' => 'Pengumuman',
                        'event' => 'Kegiatan',
                    ];
                @endphp
                <span class="badge rounded-pill {{ $categoryColors[$news->category] ?? 'bg-secondary' }}">
                    {{ $categoryLabels[$news->category] ?? ucfirst($news->category) }}
                </span>
                
                <h1 class="h2 fw-bold text-dark my-3">{{ $news->title }}</h1>
                
                <div class="d-flex flex-wrap align-items-center small text-muted">
                    <span class="me-3"><i class="fas fa-user me-2"></i>Oleh: {{ $news->author->name }}</span>
                    <span class="me-3"><i class="fas fa-calendar-alt me-2"></i>{{ ($news->published_at ?? $news->created_at)->format('d F Y, H:i') }} WIB</span>
                    <span class="badge rounded-pill {{ $news->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $news->status === 'published' ? 'Dipublikasi' : 'Draft' }}
                    </span>
                </div>
                
                @if($news->excerpt)
                    <blockquote class="blockquote bg-light p-3 rounded mt-3 fst-italic">
                        <p class="mb-0">{{ $news->excerpt }}</p>
                    </blockquote>
                @endif
            </div>

            <!-- Featured Image -->
            @if($news->featured_image)
                <div class="mb-4">
                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="img-fluid rounded shadow-sm">
                </div>
            @endif

            <!-- Article Content -->
            <div class="article-content">
                {!! nl2br(e($news->content)) !!}
            </div>

        </div>

        <!-- Article Footer -->
        <div class="card-footer bg-light">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Informasi Artikel</h6>
                    <ul class="list-unstyled small text-muted">
                        <li><strong>Dibuat:</strong> {{ $news->created_at->format('d F Y, H:i') }} WIB</li>
                        @if($news->updated_at != $news->created_at)
                            <li><strong>Diperbarui:</strong> {{ $news->updated_at->format('d F Y, H:i') }} WIB</li>
                        @endif
                        @if($news->published_at)
                             <li><strong>Dipublikasi:</strong> {{ $news->published_at->format('d F Y, H:i') }} WIB</li>
                        @endif
                        <li><strong>Slug:</strong> {{ $news->slug }}</li>
                    </ul>
                </div>
                 <div class="col-md-6">
                    <h6 class="fw-bold">Aksi</h6>
                     <div class="d-flex flex-column flex-sm-row gap-2">
                        @if($news->status === 'published')
                            <a href="{{ route('news.show', $news) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-globe me-2"></i>Lihat di Website
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.news.destroy', $news) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash me-2"></i>Hapus Berita
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection