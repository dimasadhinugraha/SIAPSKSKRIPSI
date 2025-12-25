@extends('layouts.public-bootstrap')

@section('title', 'SIAP SK - Sistem Informasi Desa Ciasmara')

@push('styles')
<style>
    body {
        padding-top: 0;
    }
    .carousel-item img {
      width: 100%;
      height: 100vh;
      object-fit: cover;
    }
    .navbar {
      background-color: rgba(255,255,255,0.95) !important;
      transition: background-color 0.3s ease-in-out;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .navbar.scrolled {
      background-color: rgba(255,255,255,0.95) !important;
    }
    .navbar .navbar-brand,
    .navbar .nav-link {
      color: #0d6efd !important; /* primary blue */
      text-shadow: none;
    }
</style>
@endpush

@section('content')
  <!-- Carousel Hero -->
  <section id="home">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{ asset('images/Gambar1Carousel.jpg') }}" class="d-block w-100" alt="Desa Ciasmara">
          <div class="carousel-caption d-none d-md-block text-center">
            <h1 class="display-3 fw-bold">SIAP SK Desa Ciasmara</h1>
            <p class="lead">Layanan administrasi digital untuk kemudahan warga.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Sekarang</a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('images/Gambar2Carousel.jpg') }}" class="d-block w-100" alt="Pelayanan Mudah">
           <div class="carousel-caption d-none d-md-block text-center">
            <h1 class="display-3 fw-bold">Pelayanan Cepat & Mudah</h1>
            <p class="lead">Ajukan surat keterangan dari mana saja, kapan saja.</p>
            <a href="#about" class="btn btn-light btn-lg">Pelajari Lebih Lanjut</a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('images/Gambar3Carousel.jpg') }}" class="d-block w-100" alt="Kegiatan Warga">
           <div class="carousel-caption d-none d-md-block text-center">
            <h1 class="display-3 fw-bold">Informasi Desa Terkini</h1>
            <p class="lead">Jangan lewatkan berita dan pengumuman penting dari desa.</p>
            <a href="#galeri-berita" class="btn btn-info btn-lg">Lihat Berita</a>
          </div>
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Berikutnya</span>
      </button>
    </div>
  </section>

  <!-- Tentang -->
  <section id="about" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="display-5 fw-bold">Tentang Desa Ciasmara</h2>
          <p class="text-muted">Desa Ciasmara adalah sebuah desa yang terletak di wilayah Kecamatan Pamijahan, Kabupaten Bogor, Jawa Barat. Penduduknya terdiri dari berbagai kelompok masyarakat, dengan sebagian besar bermata pencaharian sebagai petani, pedagang, dan pekerja sektor lainnya.</p>
        </div>
        <div class="col-lg-6">
          <img src="{{ asset('images/desaciasmara.jpg') }}" alt="Desa Ciasmara" class="img-fluid rounded shadow" />
        </div>
      </div>
    </div>
  </section>

<section id="galeri-berita" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5 display-5">Berita & Informasi Terbaru</h2>
    <div class="row g-4">
        @forelse($latestNews as $item)
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
                            <small class="text-muted">{{ ($item->published_at ?? $item->created_at)->format('d M Y') }}</small>
                        </div>
                        <h5 class="card-title fw-bold">{{ $item->title }}</h5>
                        <p class="card-text small text-muted">{{ Str::limit($item->excerpt ?? $item->content, 100) }}</p>
                        <div class="mt-auto text-end">
                            <a href="{{ route('news.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
                </div>
            </div>
        @endforelse
    </div>
    @if($latestNews->count() > 0)
    <div class="text-center mt-5">
        <a href="{{ route('news.index') }}" class="btn btn-primary btn-lg">Lihat Semua Berita</a>
    </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            // Function to handle scroll event
            const handleScroll = () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            };

            // Add scroll event listener
            window.addEventListener('scroll', handleScroll);

            // Also run on page load
            handleScroll();
        }
    });
</script>
@endpush