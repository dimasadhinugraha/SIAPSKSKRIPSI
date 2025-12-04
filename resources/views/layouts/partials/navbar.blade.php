<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
            <img src="{{ asset('images/ciasmara.png') }}" alt="Logo" height="40" class="me-2">
            <span class="fw-bold text-primary">SIAP SK Desa Ciasmara</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">
                        <i class="fas fa-home me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news.index') }}">
                        <i class="fas fa-newspaper me-1"></i> Berita
                    </a>
                </li>
                
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-2" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Daftar
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-2" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
