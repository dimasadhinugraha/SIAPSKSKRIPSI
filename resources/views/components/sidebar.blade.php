<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" id="sidebar">
    <div class="flex items-center justify-center h-20 shadow-md bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="flex items-center">
            <img src="{{ asset('images/ciasmara.png') }}" alt="Logo Desa Ciasmara" class="w-10 h-10 mr-3">
            <div class="text-white">
                <h1 class="text-lg font-bold">Desa Ciasmara</h1>
                <p class="text-xs text-blue-100">Portal Digital</p>
            </div>
        </div>
    </div>

    <nav class="mt-5 px-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
            <svg class="mr-4 h-6 w-6 {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
            </svg>
            Dashboard
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-3"></div>

        <!-- User Menu -->
        @auth
            @if(auth()->user()->isUser())
                <!-- Family Members -->
                <a href="{{ route('family-members.index') }}" 
                   class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('family-members.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('family-members.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Anggota Keluarga
                </a>

                <!-- Letter Requests -->
                <a href="{{ route('letter-requests.index') }}" 
                   class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('letter-requests.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('letter-requests.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Pengajuan Surat
                </a>
            @endif

            <!-- RT/RW Menu -->
            @if(auth()->user()->canApproveLetters())
                <!-- Divider -->
                <div class="border-t border-gray-200 my-3"></div>
                <div class="px-2 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">RT/RW</h3>
                </div>

                <!-- Letter Approvals -->
                <a href="{{ route('approvals.index') }}" 
                   class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('approvals.*') ? 'bg-green-100 text-green-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('approvals.*') ? 'text-green-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Persetujuan Surat
                </a>
            @endif

            <!-- Admin Menu -->
            @if(auth()->user()->isAdmin())
                <!-- Divider -->
                <div class="border-t border-gray-200 my-3"></div>
                <div class="px-2 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</h3>
                </div>

                <!-- User Verification -->
                <a href="{{ route('admin.user-verification.index') }}" 
                   class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.user-verification.*') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.user-verification.*') ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Verifikasi User
                </a>

                <!-- Family Member Approvals -->
                <a href="{{ route('admin.family-member-approvals.index') }}" 
                   class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.family-member-approvals.*') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.family-member-approvals.*') ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Persetujuan Keluarga
                </a>

                <!-- News Management -->
                <a href="{{ route('admin.news.index') }}" 
                   class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.news.*') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                    <svg class="mr-4 h-6 w-6 {{ request()->routeIs('admin.news.*') ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Kelola Berita
                </a>
            @endif

            <!-- Divider -->
            <div class="border-t border-gray-200 my-3"></div>

            <!-- Public Pages -->
            <div class="px-2 py-2">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Publik</h3>
            </div>

            <!-- News -->
            <a href="{{ route('news.index') }}" 
               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('news.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-4 h-6 w-6 {{ request()->routeIs('news.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Berita Desa
            </a>

            <!-- QR Verification -->
            <a href="{{ route('qr-verification.scan') }}" 
               class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('qr-verification.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors">
                <svg class="mr-4 h-6 w-6 {{ request()->routeIs('qr-verification.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Verifikasi QR
            </a>
        @endauth
    </nav>

    <!-- User Info at Bottom -->
    @auth
        <div class="absolute bottom-0 w-full p-4 bg-gray-50 border-t">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        @if(auth()->user()->isAdmin())
                            🛡️ Administrator
                        @elseif(auth()->user()->canApproveLetters())
                            👨‍💼 {{ auth()->user()->rt_rw }}
                        @else
                            👤 Warga
                        @endif
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-2">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-gray-600 transition-colors" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endauth
</div>

<!-- Mobile sidebar overlay -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden" id="sidebar-overlay"></div>

<!-- Mobile menu button -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button type="button" 
            class="bg-white p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
            id="mobile-menu-button">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>

<script>
    // Mobile sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuButton = document.getElementById('mobile-menu-button');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        menuButton.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
    });
</script>
