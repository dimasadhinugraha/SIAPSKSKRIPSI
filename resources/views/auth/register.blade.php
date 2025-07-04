<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Silakan lengkapi data diri Anda untuk mendaftar sebagai warga Desa Ciasmara. Akun akan diverifikasi oleh admin sebelum dapat digunakan.
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- KK Number -->
            <div>
                <x-input-label for="kk_number" value="Nomor Kartu Keluarga (16 digit)" />
                <x-text-input id="kk_number" class="block mt-1 w-full" type="text" name="kk_number" :value="old('kk_number')" required maxlength="16" />
                <x-input-error :messages="$errors->get('kk_number')" class="mt-2" />
            </div>

            <!-- RT/RW -->
            <div>
                <x-input-label for="rt_rw" value="RT/RW" />
                <x-text-input id="rt_rw" class="block mt-1 w-full" type="text" name="rt_rw" :value="old('rt_rw')" placeholder="Contoh: RT 01/RW 02" required />
                <x-input-error :messages="$errors->get('rt_rw')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- KTP Photo -->
            <div>
                <x-input-label for="ktp_photo" value="Foto KTP" />
                <input id="ktp_photo" type="file" name="ktp_photo" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required />
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                <x-input-error :messages="$errors->get('ktp_photo')" class="mt-2" />
            </div>

            <!-- KK Photo -->
            <div>
                <x-input-label for="kk_photo" value="Foto Kartu Keluarga" />
                <input id="kk_photo" type="file" name="kk_photo" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required />
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                <x-input-error :messages="$errors->get('kk_photo')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Password -->
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button>
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
