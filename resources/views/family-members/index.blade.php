<x-sidebar-layout>
    <x-slot name="title">Anggota Keluarga</x-slot>
    <x-slot name="header">
        Data Anggota Keluarga
    </x-slot>

    <!-- Compact Mobile Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg mb-4">
        <div class="w-full mx-auto px-2 sm:px-4 lg:px-6">
            <div class="py-4">
                <h1 class="text-lg sm:text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Data Anggota Keluarga
                </h1>
                <p class="text-blue-100 text-sm mt-1">Kelola data anggota keluarga Anda</p>
            </div>
        </div>
    </div>

    <div class="pb-4">
        <div class="w-full mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Compact Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-semibold text-blue-800 mb-1">Informasi Penting</h3>
                        <div class="text-xs text-blue-700 space-y-0.5">
                            <p>• Data yang sudah disubmit <strong>tidak dapat diedit</strong></p>
                            <p>• Pastikan informasi sudah benar sebelum menyimpan</p>
                            <p>• Data disetujui dapat digunakan untuk pengajuan surat</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($familyMembers->count() > 0)
                <!-- Compact Statistics Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                    <div class="bg-white rounded-lg shadow-sm p-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Total</p>
                                <p class="text-lg font-bold text-gray-900">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Disetujui</p>
                                <p class="text-lg font-bold text-gray-900">{{ $stats['approved'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Menunggu</p>
                                <p class="text-lg font-bold text-gray-900">{{ $stats['pending'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Ditolak</p>
                                <p class="text-lg font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($stats['pending'] > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 text-yellow-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-2">
                                <h3 class="text-xs font-medium text-yellow-800">Menunggu Persetujuan</h3>
                                <div class="mt-1 text-xs text-yellow-700">
                                    <p>{{ $stats['pending'] }} anggota menunggu persetujuan admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($stats['rejected'] > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-4 w-4 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-2">
                                <h3 class="text-xs font-medium text-red-800">Pengajuan Ditolak</h3>
                                <div class="mt-1 text-xs text-red-700">
                                    <p>{{ $stats['rejected'] }} anggota ditolak. Lihat alasan di tabel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Mobile-Friendly Family Members Cards -->
                <div class="space-y-3">
                    <div class="bg-white rounded-lg shadow-sm p-3 border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Daftar Anggota Keluarga</h3>
                    </div>
                    @foreach($familyMembers as $member)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-3">
                            <!-- Header with Avatar and Name -->
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center mr-3">
                                        <span class="text-white font-medium text-xs">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                        <div class="text-xs text-gray-500">NIK: {{ $member->nik }}</div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $member->status_badge_color }}">
                                    @if($member->approval_status === 'pending')
                                        ⏳ {{ $member->approval_status_label }}
                                    @elseif($member->approval_status === 'approved')
                                        ✅ {{ $member->approval_status_label }}
                                    @else
                                        ❌ {{ $member->approval_status_label }}
                                    @endif
                                </span>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Hubungan</div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($member->relationship === 'kepala_keluarga') bg-blue-100 text-blue-800
                                        @elseif(in_array($member->relationship, ['istri', 'suami'])) bg-green-100 text-green-800
                                        @elseif($member->relationship === 'anak') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $member->relationship_label }}
                                    </span>
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Jenis Kelamin</div>
                                    <span class="inline-flex items-center text-xs">
                                        @if($member->gender === 'L')
                                            <span class="text-blue-600 mr-1">👨</span>
                                        @else
                                            <span class="text-pink-600 mr-1">👩</span>
                                        @endif
                                        {{ $member->gender_label }}
                                    </span>
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Umur</div>
                                    <div class="text-xs text-gray-900">{{ $member->age }} tahun</div>
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500 mb-1">Tanggal Lahir</div>
                                    <div class="text-xs text-gray-900">{{ \Carbon\Carbon::parse($member->birth_date)->format('d/m/Y') }}</div>
                                </div>
                            </div>

                            <!-- Rejection Reason (if any) -->
                            @if($member->approval_status === 'rejected' && $member->rejection_reason)
                                <div class="mb-3">
                                    <button onclick="showRejectionReason('{{ $member->id }}')"
                                            class="text-xs text-red-600 hover:text-red-800 underline">
                                        Lihat Alasan Penolakan
                                    </button>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="{{ route('family-members.show', $member) }}"
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded-lg text-xs font-medium transition-colors">
                                    Detail
                                </a>
                                <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg text-xs font-medium transition-colors"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">👨‍👩‍👧‍👦</div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Anggota Keluarga</h3>
                    <p class="text-gray-600 mb-6">Mulai tambahkan data anggota keluarga Anda untuk melengkapi informasi keluarga.</p>
                    <a href="{{ route('family-members.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Anggota Keluarga Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal untuk Alasan Penolakan -->
    <div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        ❌ Alasan Penolakan
                    </h3>
                    <button onclick="closeRejectionModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-red-800">Pengajuan Ditolak</h4>
                            <div class="mt-2 text-sm text-red-700">
                                <p id="rejectionReasonText"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Langkah Selanjutnya</h4>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Anda dapat mengajukan ulang anggota keluarga ini dengan memperbaiki dokumen atau data sesuai alasan penolakan di atas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button onclick="closeRejectionModal()"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Tutup
                    </button>
                    <a href="{{ route('family-members.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Ajukan Ulang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data alasan penolakan
        const rejectionReasons = {
            @foreach($familyMembers as $member)
                @if($member->approval_status === 'rejected' && $member->rejection_reason)
                    '{{ $member->id }}': @json($member->rejection_reason),
                @endif
            @endforeach
        };

        function showRejectionReason(memberId) {
            const reason = rejectionReasons[memberId];
            if (reason) {
                document.getElementById('rejectionReasonText').textContent = reason;
                document.getElementById('rejectionModal').classList.remove('hidden');
            }
        }

        function closeRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('rejectionModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectionModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectionModal();
            }
        });
    </script>
</x-sidebar-layout>
