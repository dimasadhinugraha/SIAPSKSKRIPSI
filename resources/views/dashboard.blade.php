<x-sidebar-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="header">
        🏠 Dashboard - Portal Desa Ciasmara
    </x-slot>

    <div class="py-4">
        <div class="w-full mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Compact Welcome Section -->
            <div class="bg-green-600 overflow-hidden shadow-lg rounded-lg mb-4 relative">
                <div class="relative p-4 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold mb-1 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3.5M3 16.5h18"/>
                                </svg>
                                Selamat Datang, {{ auth()->user()->name }}!
                            </h3>
                            <p class="text-blue-100 text-sm">
                                @if(auth()->user()->isAdmin())
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Administrator Desa Ciasmara
                                @elseif(auth()->user()->isRT())
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Ketua {{ auth()->user()->rt_rw }}
                                @elseif(auth()->user()->isRW())
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Ketua {{ auth()->user()->rt_rw }}
                                @else
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Warga Desa Ciasmara - {{ auth()->user()->rt_rw }}
                                @endif
                            </p>
                            <p class="text-blue-200 text-xs mt-1">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ now()->translatedFormat('d M Y') }} •
                                <svg class="w-3 h-3 inline mr-1 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ now()->format('H:i') }} WIB
                            </p>
                        </div>
                        <div class="hidden sm:block">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <span class="text-white">
                                    @if(auth()->user()->isAdmin())
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    @elseif(auth()->user()->canApproveLetters())
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compact Floating Elements -->
                <div class="absolute top-2 right-2 w-8 h-8 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
                <div class="absolute bottom-2 left-2 w-6 h-6 bg-yellow-300 bg-opacity-20 rounded-full animate-bounce"></div>
            </div>

            @if(!auth()->user()->is_verified)
                <!-- Compact Verification Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-yellow-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-2">
                            <h3 class="text-xs font-medium text-yellow-800">
                                Akun Menunggu Verifikasi
                            </h3>
                            <div class="mt-1 text-xs text-yellow-700">
                                <p>Akun sedang menunggu verifikasi admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Compact Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    @if(auth()->user()->isUser())
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Ajukan Surat</h4>
                                        <p class="text-xs text-gray-500">Buat pengajuan surat baru</p>
                                        <a href="{{ route('letter-requests.create') }}" class="mt-1 inline-flex items-center text-xs text-blue-600 hover:text-blue-500">
                                            Mulai Pengajuan →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Riwayat Surat</h4>
                                        <p class="text-xs text-gray-500">Lihat status pengajuan surat Anda</p>
                                        <a href="{{ route('letter-requests.index') }}" class="mt-1 inline-flex items-center text-xs text-green-600 hover:text-green-500">
                                            Lihat Riwayat →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Anggota Keluarga</h4>
                                        <p class="text-xs text-gray-500">Kelola data anggota keluarga</p>
                                        <a href="{{ route('family-members.index') }}" class="mt-1 inline-flex items-center text-xs text-purple-600 hover:text-purple-500">
                                            Kelola Data →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->canApproveLetters())
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Persetujuan</h4>
                                        <p class="text-xs text-gray-500">Review pengajuan surat warga</p>
                                        <a href="{{ route('approvals.index') }}" class="mt-1 inline-flex items-center text-xs text-orange-600 hover:text-orange-500">
                                            Lihat Pengajuan →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Verifikasi User</h4>
                                        <p class="text-xs text-gray-500">Kelola verifikasi akun warga</p>
                                        <a href="{{ route('admin.user-verification.index') }}" class="mt-1 inline-flex items-center text-xs text-purple-600 hover:text-purple-500">
                                            Kelola User →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">Persetujuan Keluarga</h4>
                                        <p class="text-xs text-gray-500">Review pengajuan anggota keluarga</p>
                                        <a href="{{ route('admin.family-member-approvals.index') }}" class="mt-1 inline-flex items-center text-xs text-orange-600 hover:text-orange-500">
                                            Review Pengajuan →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Statistics -->
                @if(isset($stats) && count($stats) > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @if(auth()->user()->isAdmin())
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $stats['pending_users'] }}</div>
                                        <div class="text-sm text-gray-600">User Menunggu Verifikasi</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $stats['total_users'] }}</div>
                                        <div class="text-sm text-gray-600">Total Warga</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_letters'] }}</div>
                                        <div class="text-sm text-gray-600">Surat Dalam Proses</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $stats['approved_letters'] }}</div>
                                        <div class="text-sm text-gray-600">Surat Selesai</div>
                                    </div>
                                @elseif(auth()->user()->canApproveLetters())
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_letters'] }}</div>
                                        <div class="text-sm text-gray-600">Menunggu Persetujuan</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $stats['approved_letters'] }}</div>
                                        <div class="text-sm text-gray-600">Telah Disetujui</div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_requests'] }}</div>
                                        <div class="text-sm text-gray-600">Total Pengajuan</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_requests'] }}</div>
                                        <div class="text-sm text-gray-600">Dalam Proses</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $stats['approved_requests'] }}</div>
                                        <div class="text-sm text-gray-600">Selesai</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-red-600">{{ $stats['rejected_requests'] }}</div>
                                        <div class="text-sm text-gray-600">Ditolak</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent News -->
                @if(isset($recentNews) && $recentNews->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Berita Terbaru</h3>
                                <a href="{{ route('news.index') }}" class="text-sm text-blue-600 hover:text-blue-500">
                                    Lihat Semua →
                                </a>
                            </div>
                            <div class="space-y-4">
                                @foreach($recentNews as $news)
                                    <div class="flex items-start space-x-4 p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                        @if($news->featured_image)
                                            <img src="{{ Storage::url($news->featured_image) }}"
                                                 alt="{{ $news->title }}"
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 line-clamp-2">
                                                <a href="{{ route('news.show', $news) }}" class="hover:text-blue-600">
                                                    {{ $news->title }}
                                                </a>
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $news->published_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Desa</h3>
                        <div class="text-sm text-gray-600">
                            <p class="mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <strong>Portal Desa Ciasmara</strong> - Layanan Administrasi Online
                            </p>
                            <p class="mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Alamat: Desa Ciasmara, Kecamatan [Nama Kecamatan], Kabupaten [Nama Kabupaten]
                            </p>
                            <p class="mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Kontak: [Nomor Telepon Desa]
                            </p>
                            <p class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Jam Pelayanan: Senin - Jumat, 08:00 - 16:00 WIB
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-sidebar-layout>
