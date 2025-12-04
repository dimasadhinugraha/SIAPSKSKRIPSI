@extends(Auth::check() ? 'layouts.app-bootstrap' : 'layouts.public-bootstrap')

@section('title', $news->title)

@section('content')
    {{-- This content will be placed in the appropriate layout based on auth status --}}
    <div class="container py-4">
        <div class="row">
            {{-- Main Article Column --}}
            <div class="col-lg-8">
                <article class="bg-white p-4 rounded-3 shadow-sm">
                    <!-- Article Header -->
                    <header class="mb-4">
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
                            <span><i class="fas fa-calendar-alt me-2"></i>{{ $news->published_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                        
                        @if($news->excerpt)
                            <blockquote class="blockquote bg-light p-3 rounded mt-3 fst-italic">
                                <p class="mb-0">{{ $news->excerpt }}</p>
                            </blockquote>
                        @endif
                    </header>

                    <!-- Featured Image -->
                    @if($news->featured_image)
                        <div class="mb-4">
                            <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="img-fluid rounded shadow-sm">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <section class="article-content" style="line-height: 1.8; font-size: 1.1rem;">
                        {!! nl2br(e($news->content)) !!}
                    </section>
                </article>
            </div>

            {{-- Sidebar for Related News --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 20px;">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Berita Lainnya</h5>
                        </div>
                        <div class="card-body">
                             @if($relatedNews->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($relatedNews as $related)
                                        <a href="{{ route('news.show', $related) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $related->title }}</h6>
                                            </div>
                                            <small class="text-muted">{{ $related->published_at->format('d M Y') }}</small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted small">Tidak ada berita terkait lainnya.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
