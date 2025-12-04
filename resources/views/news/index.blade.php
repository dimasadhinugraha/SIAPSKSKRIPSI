@extends('layouts.public-bootstrap')

@section('title', 'Berita & Informasi - SIAP SK Desa Ciasmara')

@section('content')
<main class="container py-5">
    <!-- Page Header -->
    <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-light">
        <div class="col-lg-8 px-0">
            <h1 class="display-4 fst-italic">Arsip Berita & Informasi Desa</h1>
            <p class="lead my-3">Ikuti perkembangan dan pengumuman terbaru dari Desa Ciasmara melalui arsip berita kami.</p>
        </div>
    </div>

    @if($news->count() > 0)
        <div class="row g-4">
            @foreach($news as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm news-card">
                        @if($item->featured_image)
                            <img src="{{ Storage::url($item->featured_image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary card-img-top d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-2x text-white"></i>
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                @php
                                    $categoryColors = ['news' => 'bg-primary', 'announcement' => 'bg-info text-dark', 'event' => 'bg-success'];
                                    $categoryLabels = ['news' => 'Berita', 'announcement' => 'Pengumuman', 'event' => 'Kegiatan'];
                                @endphp
                                <span class="badge rounded-pill {{ $categoryColors[$item->category] ?? 'bg-secondary' }}">
                                    {{ $categoryLabels[$item->category] ?? ucfirst($item->category) }}
                                </span>
                                <small class="text-muted">{{ $item->published_at->format('d M Y') }}</small>
                            </div>
                            
                            <h5 class="card-title fw-bold">{{ $item->title }}</h5>
                            
                            @if($item->excerpt)
                                <p class="card-text small text-muted">{{ Str::limit($item->excerpt, 100) }}</p>
                            @endif
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted">Oleh: {{ $item->author->name }}</small>
                                <a href="{{ route('news.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                    Baca &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $news->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-newspaper display-4 text-muted mb-3"></i>
            <h4 class="mb-2">Belum ada berita</h4>
            <p class="text-muted">Berita dan informasi akan ditampilkan di sini setelah dipublikasikan.</p>
        </div>
    @endif
</main>
@endsection
