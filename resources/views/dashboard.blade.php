@extends('layouts.app-bootstrap')

@section('title', 'Home Dashboard')

@push('styles')
<style>
    .news-carousel {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 400px;
    }
    .ratio-16x9 {
        aspect-ratio: 16 / 9;
        overflow: hidden;
    }
    .carousel-caption {
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    }
    .news-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush


@section('content')
    <!-- Welcome Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ Auth::user()->biodata && Auth::user()->biodata->profile_photo ? Storage::url(Auth::user()->biodata->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}"
                alt="Profile" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #dee2e6;">
            <div>
                <h1 class="h3 mb-0">Selamat Datang,
                    <span class="text-primary">{{ Auth::user()->name }}</span>
                </h1>
                <p class="text-muted mb-0">Berikut adalah informasi terbaru dari Desa Ciasmara</p>
            </div>
        </div>
    </div>

    <!-- News Carousel -->
    <div class="news-carousel mb-5">
        <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @if(isset($recentNews) && $recentNews->count() > 0)
                    @foreach($recentNews as $index => $item)
                        <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                @endif
            </div>
            <div class="carousel-inner">
                @forelse($recentNews as $index => $item)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="ratio ratio-16x9">
                            <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : asset('images/desaciasmara.jpg') }}" class="d-block w-100" alt="{{ $item->title }}">
                        </div>
                        <div class="carousel-caption d-none d-md-block text-center">
                            <span class="badge bg-primary mb-2">{{ ucfirst($item->category) }}</span>
                            <h5 class="text-white">{{ $item->title }}</h5>
                            <a href="{{ route('news.show', $item) }}" class="btn btn-light btn-sm btn-read-more">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('images/desaciasmara.jpg') }}" class="d-block w-100" alt="Tidak ada berita">
                        </div>
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-white">Tidak ada berita</h5>
                            <p class="text-white">Belum ada berita yang dipublikasikan</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Berikutnya</span>
            </button>
        </div>
    </div>

    <!-- Berita Terbaru Grid -->
    <div class="mb-4">
        <h2 class="section-title">Semua Berita</h2>
        <div class="row g-4">
            @forelse($recentNews as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="news-card card h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : asset('images/desaciasmara.jpg') }}" class="card-img-top" alt="{{ $item->title }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="news-meta mb-2">
                                <span class="badge bg-primary">{{ ucfirst($item->category) }}</span>
                                <span class="ms-2">
                                    <i class="fas fa-calendar me-1"></i> {{ $item->published_at->format('d F Y') }}
                                </span>
                            </div>
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($item->content, 100) }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('news.show', $item) }}" class="btn btn-primary btn-read-more">
                                    Baca Selengkapnya
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada berita yang dipublikasikan</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modals have been removed as they are no longer needed --}}
@endsection