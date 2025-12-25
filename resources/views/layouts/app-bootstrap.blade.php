<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIAP SK Desa Ciasmara</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}" />
    
    <style>
        /* Sidebar dropdown submenu styles */
        .sidebar-dropdown {
            padding-left: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out;
            background-color: rgba(0, 123, 255, 0.1);
        }
        
        .sidebar-dropdown:not(.show) {
            max-height: 0;
        }
        
        .sidebar-dropdown.show {
            max-height: 500px;
        }
        
        .sidebar-dropdown .sidebar-item {
            padding-left: 20px;
        }
        
        .sidebar-dropdown .sidebar-link {
            padding-left: 40px;
            font-size: 0.9rem;
            color: #333 !important;
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            transition: padding-left 0.2s ease, background-color 0.2s ease;
        }
        
        .sidebar-dropdown .sidebar-link:hover {
            padding-left: 45px;
            background-color: rgba(0, 123, 255, 0.2) !important;
            color: #0056b3 !important;
        }
        
        .sidebar-dropdown .sidebar-link.active {
            background-color: rgba(0, 123, 255, 0.3) !important;
            color: #0056b3 !important;
            font-weight: 600;
        }
        
        .sidebar-link .fa-chevron-down {
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar-link[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }
        
        .sidebar-link.collapsed .fa-chevron-down {
            transform: rotate(0deg);
        }
        
        /* Smooth transition for parent link */
        .sidebar-item > a[data-bs-toggle="collapse"] {
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        
        .sidebar-item > a[data-bs-toggle="collapse"]:not(.collapsed) {
            background-color: var(--primary-color, #007bff) !important;
            color: white !important;
        }
        
        .sidebar-item > a[data-bs-toggle="collapse"]:not(.collapsed) i {
            color: white !important;
        }
        
        /* Notification styles */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            font-weight: bold;
            min-width: 18px;
            text-align: center;
        }
        
        .notification-item {
            transition: background-color 0.2s;
        }
        
        .notification-item:hover {
            background-color: #f8f9fa;
        }
        
        .notification-item.unread {
            background-color: #e7f3ff;
        }
        
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .avatar {
            width: 38px;
            height: 38px;
            display: inline-flex;
        }
        
        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 600;
        }
        
        /* Navbar styles */
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        
        .navbar .nav-link {
            color: #6c757d;
            transition: color 0.2s;
        }
        
        .navbar .nav-link:hover {
            color: #495057;
        }
        
        .user-info-text {
            line-height: 1.2;
        }
        
        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #212529;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        <div class="sidebar-overlay"></div>
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn d-none d-lg-block" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home fa-fw"></i>
                        <span>Home</span>
                    </a>
                </li>

                {{-- Admin Menu --}}
                @if(Auth::user()->isAdmin())
                    <li class="sidebar-item">
                        <a href="#verificationSubmenu" data-bs-toggle="collapse" class="sidebar-link {{ request()->routeIs('admin.user-verification.*', 'admin.family-member-approvals.*') ? '' : 'collapsed' }}" aria-expanded="{{ request()->routeIs('admin.user-verification.*', 'admin.family-member-approvals.*') ? 'true' : 'false' }}">
                            <i class="fas fa-user-check fa-fw"></i>
                            <span>Verifikasi & Persetujuan</span>
                            <i class="fas fa-chevron-down ms-auto"></i>
                        </a>
                        <ul id="verificationSubmenu" class="sidebar-dropdown list-unstyled collapse {{ request()->routeIs('admin.user-verification.*', 'admin.family-member-approvals.*') ? 'show' : '' }}">
                            <li class="sidebar-item">
                                <a href="{{ route('admin.user-verification.index') }}" class="sidebar-link {{ request()->routeIs('admin.user-verification.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-check fa-fw"></i>
                                    <span>Verifikasi Warga</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('admin.family-member-approvals.index') }}" class="sidebar-link {{ request()->routeIs('admin.family-member-approvals.*') ? 'active' : '' }}">
                                    <i class="fas fa-users-cog fa-fw"></i>
                                    <span>Persetujuan Keluarga</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                     <li class="sidebar-item">
                        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users fa-fw"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                    </li>
                     <li class="sidebar-item">
                        <a href="{{ route('admin.news.index') }}" class="sidebar-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper fa-fw"></i>
                            <span>Manajemen Berita</span>
                        </a>
                    </li>
                     <li class="sidebar-item">
                        <a href="{{ route('admin.rt-rw.index') }}" class="sidebar-link {{ request()->routeIs('admin.rt-rw.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marked-alt fa-fw"></i>
                            <span>Manajemen RT/RW</span>
                        </a>
                    </li>
                     <li class="sidebar-item">
                        <a href="{{ route('admin.letter-requests.index') }}" class="sidebar-link {{ request()->routeIs('admin.letter-requests.*') ? 'active' : '' }}">
                            <i class="fas fa-file-signature fa-fw"></i>
                            <span>Manajemen Surat</span>
                        </a>
                    </li>
                @endif

                {{-- RT/RW Menu --}}
                @if(Auth::user()->isRT() || Auth::user()->isRW())
                    <li class="sidebar-item">
                        <a href="{{ route('approvals.index') }}" class="sidebar-link {{ request()->routeIs('approvals.index', 'approvals.show') ? 'active' : '' }}">
                            <i class="fas fa-check-double fa-fw"></i>
                            <span>Persetujuan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('approvals.history') }}" class="sidebar-link {{ request()->routeIs('approvals.history') ? 'active' : '' }}">
                            <i class="fas fa-history fa-fw"></i>
                            <span>Riwayat Persetujuan</span>
                        </a>
                    </li>
                @endif

                {{-- User Menu --}}
                @if(Auth::user()->isUser())
                    <li class="sidebar-item">
                        <a href="{{ route('family-members.index') }}" class="sidebar-link {{ request()->routeIs('family-members.*') ? 'active' : '' }}">
                            <i class="fas fa-users fa-fw"></i>
                            <span>Anggota Keluarga</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('letter-requests.create') }}" class="sidebar-link {{ request()->routeIs('letter-requests.create') ? 'active' : '' }}">
                            <i class="fas fa-file-alt fa-fw"></i>
                            <span>Pengajuan Surat</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('letter-requests.index') }}" class="sidebar-link {{ request()->routeIs('letter-requests.index') ? 'active' : '' }}">
                            <i class="fas fa-history fa-fw"></i>
                            <span>Riwayat Pengajuan</span>
                        </a>
                    </li>
                @endif

                {{-- Common Menu For All Authenticated Users --}}
                <li class="sidebar-item">
                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-user-cog fa-fw"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('chat.index') }}" class="sidebar-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                        <i class="fas fa-comments fa-fw"></i>
                        <span>Chat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fas fa-question-circle fa-fw"></i>
                        <span>FAQ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="sidebar-link text-danger">
                        <i class="fas fa-sign-out-alt fa-fw"></i>
                        <span>Logout</span>
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3 border-bottom">
                <button class="toggle-btn d-lg-none me-3" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-none d-lg-flex align-items-center">
                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                    <span class="text-muted">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                
                <div class="ms-auto d-flex align-items-center gap-3">
                    <!-- Notification Dropdown -->
                    <div class="dropdown">
                        <a class="nav-link position-relative p-2" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell fa-lg"></i>
                            @php
                                $unreadCount = 0;
                                $notifications = [];
                                
                                if(Auth::user()->isAdmin()) {
                                    $unreadCount += \App\Models\User::where('is_verified', false)->where('role', 'user')->count();
                                    $unreadCount += \App\Models\FamilyMember::where('approval_status', 'pending')->count();
                                } elseif(Auth::user()->isRT() || Auth::user()->isRW()) {
                                    $unreadCount = Auth::user()->unreadNotifications->count();
                                    $notifications = Auth::user()->unreadNotifications->take(5);
                                }
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown" style="min-width: 320px;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Notifikasi</span>
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger">{{ $unreadCount }}</span>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            
                            @if(Auth::user()->isAdmin())
                                @php
                                    $pendingUsers = \App\Models\User::where('is_verified', false)->where('role', 'user')->take(3)->get();
                                    $pendingMembers = \App\Models\FamilyMember::where('approval_status', 'pending')->take(3)->get();
                                @endphp
                                
                                @if($pendingUsers->count() > 0)
                                    @foreach($pendingUsers as $user)
                                        <li>
                                            <a class="dropdown-item notification-item unread py-3" href="{{ route('admin.user-verification.show', $user) }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-user-check text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-bold small">Verifikasi User Baru</div>
                                                        <div class="text-muted small">{{ $user->name }} menunggu verifikasi</div>
                                                        <div class="text-muted small">{{ $user->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                
                                @if($pendingMembers->count() > 0)
                                    @foreach($pendingMembers as $member)
                                        <li>
                                            <a class="dropdown-item notification-item unread py-3" href="{{ route('admin.family-member-approvals.show', $member) }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-users-cog text-warning"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-bold small">Persetujuan Anggota Keluarga</div>
                                                        <div class="text-muted small">{{ $member->name }} menunggu persetujuan</div>
                                                        <div class="text-muted small">{{ $member->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                
                                @if($pendingUsers->count() == 0 && $pendingMembers->count() == 0)
                                    <li>
                                        <div class="dropdown-item text-center py-4">
                                            <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                            <div class="text-muted small">Tidak ada notifikasi baru</div>
                                        </div>
                                    </li>
                                @endif
                                
                            @elseif(Auth::user()->isRT() || Auth::user()->isRW())
                                @if($notifications->count() > 0)
                                    @foreach($notifications as $notification)
                                        @php
                                            $data = $notification->data;
                                        @endphp
                                        <li>
                                            <a class="dropdown-item notification-item unread py-3" href="{{ $data['url'] ?? '#' }}" onclick="markAsRead('{{ $notification->id }}')">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-file-signature text-info"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <div class="fw-bold small">Pengajuan Surat Baru</div>
                                                        <div class="text-muted small">{{ $data['message'] ?? 'Pengajuan surat baru' }}</div>
                                                        <div class="text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <div class="dropdown-item text-center py-4">
                                            <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                            <div class="text-muted small">Tidak ada notifikasi baru</div>
                                        </div>
                                    </li>
                                @endif
                                
                                @if($notifications->count() > 0)
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-center text-primary small py-2" href="{{ route('approvals.index') }}">
                                            Lihat Semua Notifikasi
                                        </a>
                                    </li>
                                @endif
                                
                            @else
                                <li>
                                    <div class="dropdown-item text-center py-4">
                                        <i class="fas fa-bell-slash text-muted fa-2x mb-2"></i>
                                        <div class="text-muted small">Tidak ada notifikasi</div>
                                    </div>
                                </li>
                            @endif
                            
                            @if(Auth::user()->isAdmin() && ($pendingUsers->count() > 0 || $pendingMembers->count() > 0))
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-center text-primary small py-2" href="{{ route('admin.user-verification.index') }}">
                                        Lihat Semua Notifikasi
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                            <div class="d-none d-md-flex flex-column align-items-end me-3 user-info-text">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>
                            @if(Auth::user()->biodata && Auth::user()->biodata->profile_photo)
                                <img src="{{ Storage::url(Auth::user()->biodata->profile_photo) }}" 
                                     alt="Profile" 
                                     class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #dee2e6;">
                            @else
                                <div class="avatar bg-primary bg-gradient">
                                    <span class="avatar-title rounded-circle text-white">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userDropdown" style="min-width: 200px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="small text-muted">Signed in as</div>
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-cog me-2 text-muted"></i>Profile Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item text-danger py-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
            <div class="p-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/dashboard-script.js') }}"></script>
    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).catch(err => console.error('Failed to mark notification as read:', err));
        }
    </script>
    @stack('scripts')
</body>
</html>
