<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $villageProfile['name'] }} - Portal Desa Digital</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">🏛️</span>
                        </div>
                        <h1 class="text-xl font-bold gradient-text">{{ $villageProfile['name'] }}</h1>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        📰 Berita
                    </a>
                    <a href="{{ route('qr-verification.scan') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        📱 Verifikasi QR
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Selamat Datang di<br>
                    <span class="text-yellow-300">{{ $villageProfile['name'] }}</span>
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    {{ $villageProfile['visi'] }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('letter-requests.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors inline-flex items-center justify-center">
                            📄 Ajukan Surat Online
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors inline-flex items-center justify-center">
                            📝 Daftar Sekarang
                        </a>
                    @endauth
                    <a href="#profil-desa" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors inline-flex items-center justify-center">
                        🏛️ Profil Desa
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-yellow-300 bg-opacity-20 rounded-full animate-bounce"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-blue-300 bg-opacity-20 rounded-full animate-ping"></div>
    </section>

    <!-- Quick Stats -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">{{ $villageProfile['jumlah_penduduk'] }}</div>
                    <div class="text-gray-600 font-medium">Penduduk</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $villageProfile['jumlah_kk'] }}</div>
                    <div class="text-gray-600 font-medium">Kepala Keluarga</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ $villageProfile['luas_wilayah'] }}</div>
                    <div class="text-gray-600 font-medium">Luas Wilayah</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{{ count($letterTypes) }}</div>
                    <div class="text-gray-600 font-medium">Layanan Surat</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    🚀 Layanan Digital Desa
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Nikmati kemudahan layanan administrasi desa secara online dengan sistem yang modern dan terpercaya
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($letterTypes->take(6) as $letterType)
                    <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                            <span class="text-white text-xl">📄</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $letterType->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $letterType->description }}</p>
                        @auth
                            <a href="{{ route('letter-requests.create') }}?type={{ $letterType->id }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Ajukan Sekarang →
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Daftar untuk Mengajukan →
                            </a>
                        @endauth
                    </div>
                @endforeach
            </div>
            
            @if($letterTypes->count() > 6)
                <div class="text-center mt-8">
                    @auth
                        <a href="{{ route('letter-requests.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Lihat Semua Layanan ({{ $letterTypes->count() }})
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Daftar untuk Akses Semua Layanan
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>

    <!-- Village Profile Section -->
    <section id="profil-desa" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    🏛️ Profil {{ $villageProfile['name'] }}
                </h2>
                <p class="text-xl text-gray-600">
                    Mengenal lebih dekat desa kami yang penuh potensi dan keindahan
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
                <!-- Village Info -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            📍 Informasi Umum
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Desa:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['name'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kecamatan:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['kecamatan'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kabupaten:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['kabupaten'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Provinsi:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['provinsi'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kode Pos:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['kode_pos'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kepala Desa:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['kepala_desa'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            📞 Kontak & Pelayanan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span class="text-gray-600 w-20">Alamat:</span>
                                <span class="font-medium text-gray-900 flex-1">{{ $villageProfile['alamat_kantor'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Telepon:</span>
                                <span class="font-medium text-gray-900">{{ $villageProfile['telepon'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium text-blue-600">{{ $villageProfile['email'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Website:</span>
                                <span class="font-medium text-blue-600">{{ $villageProfile['website'] }}</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-gray-600 w-20">Jam:</span>
                                <span class="font-medium text-gray-900 flex-1">{{ $villageProfile['jam_pelayanan'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vision & Mission -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            🎯 Visi Desa
                        </h3>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            {{ $villageProfile['visi'] }}
                        </p>
                    </div>

                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            🚀 Misi Desa
                        </h3>
                        <ul class="space-y-2">
                            @foreach($villageProfile['misi'] as $index => $misi)
                                <li class="flex items-start">
                                    <span class="bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="text-gray-700">{{ $misi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            🏢 Fasilitas Desa
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($villageProfile['fasilitas'] as $fasilitas)
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-700 text-sm">{{ $fasilitas }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    📰 Berita & Informasi Terkini
                </h2>
                <p class="text-xl text-gray-600">
                    Tetap update dengan berita dan pengumuman terbaru dari desa
                </p>
            </div>

            @if($latestNews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                    @foreach($latestNews as $news)
                        <article class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                            @if($news->featured_image)
                                <div class="h-48 bg-gray-200 overflow-hidden">
                                    <img src="{{ Storage::url($news->featured_image) }}"
                                         alt="{{ $news->title }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white text-4xl">📰</span>
                                </div>
                            @endif

                            <div class="p-6">
                                @php
                                    $categoryColors = [
                                        'news' => 'bg-blue-100 text-blue-800',
                                        'announcement' => 'bg-yellow-100 text-yellow-800',
                                        'event' => 'bg-green-100 text-green-800',
                                    ];
                                    $categoryLabels = [
                                        'news' => 'Berita',
                                        'announcement' => 'Pengumuman',
                                        'event' => 'Kegiatan',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $categoryColors[$news->category] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $categoryLabels[$news->category] ?? ucfirst($news->category) }}
                                </span>

                                <h3 class="text-xl font-bold text-gray-900 mt-3 mb-2 line-clamp-2">
                                    {{ $news->title }}
                                </h3>

                                @if($news->excerpt)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ $news->excerpt }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">
                                        {{ $news->published_at->format('d F Y') }}
                                    </span>
                                    <a href="{{ route('news.show', $news) }}"
                                       class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('news.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        Lihat Semua Berita
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">📰</div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Berita</h3>
                    <p class="text-gray-600">Berita dan pengumuman akan ditampilkan di sini</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Siap Menggunakan Layanan Digital Desa?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Daftar sekarang dan nikmati kemudahan mengurus administrasi desa secara online
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('letter-requests.create') }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors">
                        📄 Ajukan Surat Sekarang
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors">
                        🏠 Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors">
                        📝 Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}"
                       class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 font-bold py-4 px-8 rounded-lg text-lg transition-colors">
                        🔑 Masuk
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">🏛️</span>
                        </div>
                        <h3 class="text-xl font-bold">{{ $villageProfile['name'] }}</h3>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Portal digital resmi {{ $villageProfile['name'] }} untuk pelayanan administrasi yang modern dan terpercaya.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">📘</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">📷</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">🐦</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">📺</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        @foreach($letterTypes->take(5) as $letterType)
                            <li>
                                <a href="{{ auth()->check() ? route('letter-requests.create') : route('register') }}"
                                   class="text-gray-400 hover:text-white transition-colors">
                                    {{ $letterType->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <div class="space-y-2 text-gray-400">
                        <p>📍 {{ $villageProfile['alamat_kantor'] }}</p>
                        <p>📞 {{ $villageProfile['telepon'] }}</p>
                        <p>✉️ {{ $villageProfile['email'] }}</p>
                        <p>🌐 {{ $villageProfile['website'] }}</p>
                        <p>🕒 {{ $villageProfile['jam_pelayanan'] }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    © {{ date('Y') }} {{ $villageProfile['name'] }}. Semua hak dilindungi.
                    <span class="text-blue-400">Dibuat dengan ❤️ untuk kemajuan desa</span>
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
