<!-- Sidebar -->
<div aria-hidden="true" aria-labelledby="sidebar-label" role="navigation" tabindex="-1" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-2xl transform -translate-x-full transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" id="sidebar">
    <!-- Header with solid color -->
    <div class="h-20 bg-green-600">
        <div class="flex items-center justify-center h-full px-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="text-white">
                    <h1 class="text-lg font-bold tracking-wide">Desa Ciasmara</h1>
                    <p class="text-xs text-green-100 font-medium">Portal Digital</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-3 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                </svg>
            </div>
            <span class="font-semibold">Dashboard</span>
            @if(request()->routeIs('dashboard'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
            @endif
        </a>

        <!-- Divider -->
        <div class="border-t border-slate-700 my-4"></div>

        <!-- User Menu -->
        @auth
            @if(auth()->user()->isUser())
                <!-- Section Header -->
                <div class="px-3 py-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Layanan Warga
                    </h3>
                </div>

                <!-- Family Members -->
                <a href="{{ route('family-members.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('family-members.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('family-members.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('family-members.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Anggota Keluarga</span>
                    @if(request()->routeIs('family-members.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Letter Requests -->
                <a href="{{ route('letter-requests.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('letter-requests.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('letter-requests.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('letter-requests.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Pengajuan Surat</span>
                    @if(request()->routeIs('letter-requests.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            @endif

            <!-- RT/RW Menu -->
            @if(auth()->user()->canApproveLetters())
                <!-- Divider -->
                <div class="border-t border-slate-700 my-4"></div>

                <!-- Section Header -->
                <div class="px-3 py-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        RT/RW Panel
                    </h3>
                </div>

                <!-- Letter Approvals -->
                <a href="{{ route('approvals.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('approvals.index') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('approvals.index') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('approvals.index') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Persetujuan Surat</span>
                    @if(request()->routeIs('approvals.index'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Approval History -->
                <a href="{{ route('approvals.history') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('approvals.history') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('approvals.history') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('approvals.history') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Riwayat Persetujuan</span>
                    @if(request()->routeIs('approvals.history'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            @endif

            <!-- Admin Menu -->
            @if(auth()->user()->isAdmin())
                <!-- Divider -->
                <div class="border-t border-slate-700 my-4"></div>

                <!-- Section Header -->
                <div class="px-3 py-2">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Admin Panel
                    </h3>
                </div>

                <!-- User Verification -->
                <a href="{{ route('admin.user-verification.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.user-verification.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.user-verification.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.user-verification.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Verifikasi User</span>
                    @if(request()->routeIs('admin.user-verification.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Letter Requests Management -->
                <a href="{{ route('admin.letter-requests.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.letter-requests.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.letter-requests.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.letter-requests.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="font-semibold">Pengajuan Surat</span>
                    @if(request()->routeIs('admin.letter-requests.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- Family Member Approvals -->
                <a href="{{ route('admin.family-member-approvals.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.family-member-approvals.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.family-member-approvals.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.family-member-approvals.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Persetujuan Keluarga</span>
                    @if(request()->routeIs('admin.family-member-approvals.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>

                <!-- News Management -->
                <a href="{{ route('admin.news.index') }}"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.news.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.news.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                        <svg class="h-5 w-5 {{ request()->routeIs('admin.news.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <span class="font-semibold">Kelola Berita</span>
                    @if(request()->routeIs('admin.news.*'))
                        <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    @endif
                </a>
            @endif

            <!-- Divider -->
            <div class="border-t border-slate-700 my-4"></div>

            <!-- Public Pages -->
            <div class="px-3 py-2">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center">
                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Layanan Publik
                </h3>
            </div>

            <!-- News -->
            <a href="{{ route('news.index') }}"
               class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('news.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('news.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                    <svg class="h-5 w-5 {{ request()->routeIs('news.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <span class="font-semibold">Berita Desa</span>
                @if(request()->routeIs('news.*'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                @endif
            </a>

            <!-- Chat -->
            <a href="{{ route('chat.index') }}"
               class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('chat.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('chat.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                    <svg class="h-5 w-5 {{ request()->routeIs('chat.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <span class="font-semibold">Chat</span>
                @if(request()->routeIs('chat.*'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                @endif
            </a>

            <!-- QR Verification -->
            <a href="{{ route('qr-verification.scan') }}"
               class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('qr-verification.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('qr-verification.*') ? 'bg-white bg-opacity-20' : 'bg-slate-700 group-hover:bg-slate-600' }} mr-3 transition-all duration-200">
                    <svg class="h-5 w-5 {{ request()->routeIs('qr-verification.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <span class="font-semibold">Verifikasi QR</span>
                @if(request()->routeIs('qr-verification.*'))
                    <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
                @endif
            </a>
        @endauth
    </nav>

    <!-- User Info at Bottom -->
    @auth
        <div class="absolute bottom-0 w-full p-4 bg-slate-800 border-t border-slate-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-slate-400 truncate flex items-center">
                        @if(auth()->user()->isAdmin())
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Administrator
                        @elseif(auth()->user()->canApproveLetters())
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ auth()->user()->rt_rw }}
                        @else
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Warga
                        @endif
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-2">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition-all duration-200" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endauth
</div>

<!-- Mobile sidebar overlay -->
<div aria-hidden="true" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden" id="sidebar-overlay"></div>

<!-- Mobile menu button -->
<div class="lg:hidden fixed top-4 z-50 transition-all duration-300 ease-in-out" id="mobile-menu-container">
        <button type="button"
                aria-expanded="false"
                aria-controls="sidebar"
                class="bg-white p-2 rounded-md text-gray-600 hover:text-green-600 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 shadow-lg transition-colors"
                id="mobile-menu-button">
            <span class="sr-only" id="menu-button-text">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="menu-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" id="hamburger-icon"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" id="close-icon" style="display: none;"/>
            </svg>
        </button>
</div>

<script>
    // Improved mobile sidebar toggle: dynamic width, ARIA updates, and resize handling
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuButton = document.getElementById('mobile-menu-button');
        const menuContainer = document.getElementById('mobile-menu-container');
        const menuButtonText = document.getElementById('menu-button-text');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        let isOpen = false;

        function sidebarWidth() {
            // Compute the computed width of the sidebar to position the button
            const style = window.getComputedStyle(sidebar);
            const width = parseFloat(style.width) || 256; // fallback
            return Math.round(width);
        }

        function showSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.setAttribute('aria-hidden', 'false');
            overlay.classList.remove('hidden');
            overlay.setAttribute('aria-hidden', 'false');
            menuButton.setAttribute('aria-expanded', 'true');
            menuButtonText.textContent = 'Close sidebar';
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'block';

            // Position the button to the right edge of opened sidebar with small padding
            const leftPos = sidebarWidth() + 16; // sidebar width + 16px
            menuContainer.style.left = leftPos + 'px';
            isOpen = true;

            // Move focus to first focusable element inside sidebar for accessibility
            const focusable = sidebar.querySelector('a, button, input, [tabindex]:not([tabindex="-1"])');
            if (focusable) focusable.focus();
        }

        function hideSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.setAttribute('aria-hidden', 'true');
            overlay.classList.add('hidden');
            overlay.setAttribute('aria-hidden', 'true');
            menuButton.setAttribute('aria-expanded', 'false');
            menuButtonText.textContent = 'Open sidebar';
            hamburgerIcon.style.display = 'block';
            closeIcon.style.display = 'none';

            // Reset button position to default
            menuContainer.style.left = '16px';
            isOpen = false;

            // Return focus to menu button
            menuButton.focus();
        }

        function toggleSidebar() {
            if (isOpen) hideSidebar(); else showSidebar();
        }

        // Initialize state according to current breakpoint
        function initialize() {
            // If we're on large screens, ensure sidebar is visible and mobile UI hidden/neutral
            if (window.innerWidth >= 1024) { // tailwind lg breakpoint
                sidebar.classList.remove('-translate-x-full');
                sidebar.setAttribute('aria-hidden', 'false');
                overlay.classList.add('hidden');
                overlay.setAttribute('aria-hidden', 'true');
                menuContainer.style.left = '16px';
                menuButton.setAttribute('aria-expanded', 'false');
                hamburgerIcon.style.display = 'block';
                closeIcon.style.display = 'none';
                isOpen = false;
            } else {
                // mobile: ensure closed by default
                sidebar.classList.add('-translate-x-full');
                sidebar.setAttribute('aria-hidden', 'true');
                overlay.classList.add('hidden');
                overlay.setAttribute('aria-hidden', 'true');
                menuContainer.style.left = '16px';
                menuButton.setAttribute('aria-expanded', 'false');
                hamburgerIcon.style.display = 'block';
                closeIcon.style.display = 'none';
                isOpen = false;
            }
        }

        // Event listeners
        menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });

        overlay.addEventListener('click', function() {
            if (isOpen) hideSidebar();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) hideSidebar();
        });

        // Handle resize: if moving to large screens, reset mobile state
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // If we resized to large, ensure sidebar present and mobile UI reset
                if (window.innerWidth >= 1024) {
                    initialize();
                } else {
                    // if sidebar is open, recompute button position
                    if (isOpen) {
                        menuContainer.style.left = (sidebarWidth() + 16) + 'px';
                    }
                }
            }, 120);
        });

        // init
        initialize();
    });
</script>
