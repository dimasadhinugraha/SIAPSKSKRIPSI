<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
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
                        <p>
                            Terima kasih telah mendaftar di Portal Desa Ciasmara. Akun Anda saat ini sedang menunggu verifikasi dari admin desa.
                        </p>
                        <p class="mt-2">
                            Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Anda akan menerima notifikasi melalui email setelah akun diverifikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-lg font-semibold mb-4">Informasi Selanjutnya</h2>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100">
                            <span class="text-sm font-medium text-blue-600">1</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Verifikasi Data</h3>
                        <p class="text-sm text-gray-500">Admin akan memverifikasi data dan dokumen yang Anda upload.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100">
                            <span class="text-sm font-medium text-blue-600">2</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Aktivasi Akun</h3>
                        <p class="text-sm text-gray-500">Setelah diverifikasi, akun Anda akan diaktivasi dan dapat digunakan.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100">
                            <span class="text-sm font-medium text-blue-600">3</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Mulai Menggunakan</h3>
                        <p class="text-sm text-gray-500">Anda dapat login dan mulai mengajukan surat administrasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-center">
        <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
            Kembali ke halaman login
        </a>
    </div>
</x-guest-layout>
