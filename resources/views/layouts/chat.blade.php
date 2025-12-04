<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SIAP Desa Ciasmara'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @stack('styles')

</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white">
                <a class="text-white text-decoration-none" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/ciasmara.png') }}" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                    {{ config('app.name', 'SIAP Desa Ciasmara') }}
                </a>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                
                @auth
                    @if(auth()->user()->isUser())
                        <div class="list-group-item bg-dark text-white-50">Layanan Warga</div>
                        <a href="{{ route('family-members.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('family-members.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i>Anggota Keluarga
                        </a>
                        <a href="{{ route('letter-requests.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('letter-requests.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt me-2"></i>Pengajuan Surat
                        </a>
                    @endif

                    @if(auth()->user()->canApproveLetters())
                        <div class="list-group-item bg-dark text-white-50">RT/RW Panel</div>
                        <a href="{{ route('approvals.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('approvals.index') ? 'active' : '' }}">
                            <i class="fas fa-check-circle me-2"></i>Persetujuan Surat
                        </a>
                        <a href="{{ route('approvals.history') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('approvals.history') ? 'active' : '' }}">
                            <i class="fas fa-history me-2"></i>Riwayat Persetujuan
                        </a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <div class="list-group-item bg-dark text-white-50">Admin Panel</div>
                        <a href="{{ route('admin.user-verification.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.user-verification.*') ? 'active' : '' }}">
                            <i class="fas fa-user-check me-2"></i>Verifikasi User
                        </a>
                        <a href="{{ route('admin.letter-requests.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.letter-requests.*') ? 'active' : '' }}">
                            <i class="fas fa-file-signature me-2"></i>Pengajuan Surat
                        </a>
                        <a href="{{ route('admin.family-member-approvals.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.family-member-approvals.*') ? 'active' : '' }}">
                            <i class="fas fa-user-friends me-2"></i>Persetujuan Keluarga
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper me-2"></i>Kelola Berita
                        </a>
                    @endif

                    <div class="list-group-item bg-dark text-white-50">Layanan Publik</div>
                    <a href="{{ route('news.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('news.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper me-2"></i>Berita Desa
                    </a>
                    <a href="{{ route('chat.index') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                        <i class="fas fa-comments me-2"></i>Chat
                    </a>
                    <a href="{{ route('qr-verification.scan') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('qr-verification.*') ? 'active' : '' }}">
                        <i class="fas fa-qrcode me-2"></i>Verifikasi QR
                    </a>
                @endauth
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-online d-inline-block">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary-emphasis">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                </div>
            </nav>

            <main class="container-fluid py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("menu-toggle").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("wrapper").classList.toggle("toggled");
        });
    </script>
    @stack('scripts')
</body>
</html>
