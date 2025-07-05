<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Portal Desa Ciasmara</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .register-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen register-bg flex items-center justify-center relative overflow-hidden py-8">
        <!-- Background Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full floating-animation"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-yellow-300 bg-opacity-20 rounded-full floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-blue-300 bg-opacity-20 rounded-full floating-animation" style="animation-delay: -4s;"></div>

        <div class="w-full max-w-4xl mx-4">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 bg-white rounded-full shadow-lg flex items-center justify-center">
                        <img src="{{ asset('images/ciasmara.png') }}" alt="Logo Desa Ciasmara" class="w-20 h-20 object-contain">
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Daftar Akun Baru</h1>
                <p class="text-blue-100">Bergabunglah dengan Portal Digital Desa Ciasmara</p>
            </div>

            <!-- Register Form -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Lengkapi Data Diri Anda</h2>
                    <p class="text-gray-600">Akun akan diverifikasi oleh admin sebelum dapat digunakan</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Data Pribadi -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            👤 Data Pribadi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input id="name"
                                       type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       autofocus
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap sesuai KTP">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    📧 Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input id="email"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                                       placeholder="contoh@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                    🆔 NIK (16 digit) <span class="text-red-500">*</span>
                                </label>
                                <input id="nik"
                                       type="text"
                                       name="nik"
                                       value="{{ old('nik') }}"
                                       required
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nik') border-red-500 @enderror"
                                       placeholder="Masukkan 16 digit NIK">
                                @error('nik')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                    ⚧ Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="gender"
                                        name="gender"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('gender') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    📅 Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input id="birth_date"
                                       type="date"
                                       name="birth_date"
                                       value="{{ old('birth_date') }}"
                                       required
                                       max="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('birth_date') border-red-500 @enderror">
                                @error('birth_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    📱 Nomor Handphone <span class="text-red-500">*</span>
                                </label>
                                <input id="phone"
                                       type="text"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-500 @enderror"
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mt-6">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                🏠 Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address"
                                      name="address"
                                      rows="3"
                                      required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-500 @enderror"
                                      placeholder="Masukkan alamat lengkap sesuai KTP">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- NIK -->
            <div>
                <x-input-label for="nik" value="NIK (16 digit)" />
                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required maxlength="16" />
                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            </div>

            <!-- Gender -->
            <div>
                <x-input-label for="gender" value="Jenis Kelamin" />
                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Birth Date -->
            <div>
                <x-input-label for="birth_date" value="Tanggal Lahir" />
                <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" value="Nomor Handphone" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" value="Alamat Lengkap" />
            <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

                    <!-- Data Keluarga -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            👨‍👩‍👧‍👦 Data Keluarga
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- KK Number -->
                            <div>
                                <label for="kk_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    📋 Nomor Kartu Keluarga (16 digit) <span class="text-red-500">*</span>
                                </label>
                                <input id="kk_number"
                                       type="text"
                                       name="kk_number"
                                       value="{{ old('kk_number') }}"
                                       required
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('kk_number') border-red-500 @enderror"
                                       placeholder="Masukkan 16 digit nomor KK">
                                @error('kk_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RT/RW -->
                            <div>
                                <label for="rt_rw" class="block text-sm font-medium text-gray-700 mb-2">
                                    🏘️ RT/RW <span class="text-red-500">*</span>
                                </label>
                                <input id="rt_rw"
                                       type="text"
                                       name="rt_rw"
                                       value="{{ old('rt_rw') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('rt_rw') border-red-500 @enderror"
                                       placeholder="Contoh: RT 01/RW 02">
                                @error('rt_rw')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            📄 Upload Dokumen
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- KTP Photo -->
                            <div>
                                <label for="ktp_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    🆔 Foto KTP <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="ktp_photo"
                                           type="file"
                                           name="ktp_photo"
                                           accept="image/*"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('ktp_photo') border-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                                @error('ktp_photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- KK Photo -->
                            <div>
                                <label for="kk_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    👨‍👩‍👧‍👦 Foto Kartu Keluarga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="kk_photo"
                                           type="file"
                                           name="kk_photo"
                                           accept="image/*"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('kk_photo') border-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                                @error('kk_photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            🔒 Keamanan Akun
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    🔑 Kata Sandi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="password"
                                           type="password"
                                           name="password"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror"
                                           placeholder="Minimal 8 karakter">
                                    <button type="button"
                                            onclick="togglePasswordVisibility('password', 'eye-icon-1')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg id="eye-icon-1" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    🔑 Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation"
                                           type="password"
                                           name="password_confirmation"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password_confirmation') border-red-500 @enderror"
                                           placeholder="Ulangi kata sandi">
                                    <button type="button"
                                            onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-2')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg id="eye-icon-2" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}"
                           class="text-blue-600 hover:text-blue-800 font-medium transition-colors inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Sudah punya akun? Masuk
                        </a>

                        <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-8 rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                            🚀 Daftar Sekarang
                        </button>
                    </div>
                </form>

                <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="{{ route('welcome') }}"
                       class="text-gray-500 hover:text-gray-700 text-sm transition-colors inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto format NIK and KK Number
        function formatNumber(inputId) {
            document.getElementById(inputId).addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 16) {
                    value = value.slice(0, 16);
                }
                e.target.value = value;
            });
        }

        formatNumber('nik');
        formatNumber('kk_number');

        // Toggle password visibility
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 15) {
                value = value.slice(0, 15);
            }
            e.target.value = value;
        });

        // File upload preview
        function setupFilePreview(inputId) {
            document.getElementById(inputId).addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // Convert to MB
                    if (fileSize > 2) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        e.target.value = '';
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPG atau PNG.');
                        e.target.value = '';
                        return;
                    }
                }
            });
        }

        setupFilePreview('ktp_photo');
        setupFilePreview('kk_photo');
    </script>
</body>
</html>
