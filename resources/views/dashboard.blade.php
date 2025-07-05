<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard - Portal Desa Ciasmara
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-700 overflow-hidden shadow-xl sm:rounded-xl mb-8 relative">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold mb-2 flex items-center">
                                👋 Selamat Datang, {{ auth()->user()->name }}!
                            </h3>
                            <p class="text-blue-100 text-lg">
                                @if(auth()->user()->isAdmin())
                                    🛡️ Administrator Desa Ciasmara
                                @elseif(auth()->user()->isRT())
                                    👨‍💼 Ketua {{ auth()->user()->rt_rw }}
                                @elseif(auth()->user()->isRW())
                                    👨‍💼 Ketua {{ auth()->user()->rt_rw }}
                                @else
                                    🏠 Warga Desa Ciasmara - {{ auth()->user()->rt_rw }}
                                @endif
                            </p>
                            <p class="text-blue-200 text-sm mt-2">
                                📅 {{ now()->translatedFormat('l, d F Y') }} • 🕐 {{ now()->format('H:i') }} WIB
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <span class="text-4xl">
                                    @if(auth()->user()->isAdmin())
                                        🛡️
                                    @elseif(auth()->user()->canApproveLetters())
                                        👨‍💼
                                    @else
                                        👤
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="absolute top-4 right-4 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
                <div class="absolute bottom-4 left-4 w-12 h-12 bg-yellow-300 bg-opacity-20 rounded-full animate-bounce"></div>
            </div>

            @if(!auth()->user()->is_verified)
                <!-- Verification Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Akun Menunggu Verifikasi
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Akun Anda sedang menunggu verifikasi dari admin. Silakan hubungi admin desa untuk mempercepat proses verifikasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @if(auth()->user()->isUser())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-900">Ajukan Surat</h4>
                                        <p class="text-sm text-gray-500">Buat pengajuan surat administrasi baru</p>
                                        <a href="{{ route('letter-requests.create') }}" class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-500">
                                            Mulai Pengajuan →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-900">Riwayat Surat</h4>
                                        <p class="text-sm text-gray-500">Lihat status pengajuan surat Anda</p>
                                        <a href="{{ route('letter-requests.index') }}" class="mt-2 inline-flex items-center text-sm text-green-600 hover:text-green-500">
                                            Lihat Riwayat →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->canApproveLetters())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-900">Persetujuan</h4>
                                        <p class="text-sm text-gray-500">Review pengajuan surat warga</p>
                                        <a href="{{ route('approvals.index') }}" class="mt-2 inline-flex items-center text-sm text-orange-600 hover:text-orange-500">
                                            Lihat Pengajuan →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-900">Verifikasi User</h4>
                                        <p class="text-sm text-gray-500">Kelola verifikasi akun warga</p>
                                        <a href="{{ route('admin.user-verification.index') }}" class="mt-2 inline-flex items-center text-sm text-purple-600 hover:text-purple-500">
                                            Kelola User →
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
                            <p class="mb-2">🏛️ <strong>Portal Desa Ciasmara</strong> - Layanan Administrasi Online</p>
                            <p class="mb-2">📍 Alamat: Desa Ciasmara, Kecamatan [Nama Kecamatan], Kabupaten [Nama Kabupaten]</p>
                            <p class="mb-2">📞 Kontak: [Nomor Telepon Desa]</p>
                            <p>⏰ Jam Pelayanan: Senin - Jumat, 08:00 - 16:00 WIB</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
