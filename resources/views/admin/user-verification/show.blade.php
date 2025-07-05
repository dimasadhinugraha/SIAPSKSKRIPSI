<x-sidebar-layout>
    <x-slot name="header">
        <span>{{ __('Detail Verifikasi User') }}
        </span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informasi User</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Periksa data dan dokumen user sebelum melakukan verifikasi.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data Personal -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Data Personal</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->nik }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->birth_date->format('d/m/Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Handphone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->phone }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->address }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">RT/RW</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->rt_rw }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor KK</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->kk_number }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pendaftaran</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Dokumen -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Dokumen</h4>
                            
                            @if($user->ktp_photo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP</label>
                                    <div class="border rounded-lg p-2">
                                        <img src="{{ Storage::url($user->ktp_photo) }}" 
                                             alt="KTP {{ $user->name }}" 
                                             class="w-full h-auto rounded cursor-pointer"
                                             onclick="openImageModal('{{ Storage::url($user->ktp_photo) }}', 'KTP {{ $user->name }}')">
                                    </div>
                                </div>
                            @endif

                            @if($user->kk_photo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kartu Keluarga</label>
                                    <div class="border rounded-lg p-2">
                                        <img src="{{ Storage::url($user->kk_photo) }}" 
                                             alt="KK {{ $user->name }}" 
                                             class="w-full h-auto rounded cursor-pointer"
                                             onclick="openImageModal('{{ Storage::url($user->kk_photo) }}', 'KK {{ $user->name }}')">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('admin.user-verification.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali
                        </a>

                        <div class="flex space-x-3">
                            <!-- Reject Button -->
                            <button type="button" 
                                    onclick="openRejectModal()"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Tolak
                            </button>

                            <!-- Approve Button -->
                            <form method="POST" action="{{ route('admin.user-verification.verify', $user) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="return confirm('Apakah Anda yakin ingin memverifikasi user ini?')">
                                    Verifikasi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle"></h3>
                    <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <img id="modalImage" src="" alt="" class="w-full h-auto">
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Verifikasi</h3>
                <form method="POST" action="{{ route('admin.user-verification.reject', $user) }}">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <textarea id="reason" name="reason" rows="3" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(src, title) {
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const imageModal = document.getElementById('imageModal');
            const rejectModal = document.getElementById('rejectModal');
            
            if (event.target === imageModal) {
                closeImageModal();
            }
            if (event.target === rejectModal) {
                closeRejectModal();
            }
        }
    </script>
</x-sidebar-layout>
