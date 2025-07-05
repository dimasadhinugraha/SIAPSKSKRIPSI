<x-sidebar-layout>
    <x-slot name="header">
        👨‍👩‍👧‍👦 Data Anggota Keluarga
    </x-slot>

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">👨‍👩‍👧‍👦 Data Anggota Keluarga</h1>
                    <p class="text-gray-600 mt-1">Kelola data anggota keluarga Anda</p>
                </div>
                <a href="{{ route('family-members.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Anggota Keluarga
                </a>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 text-2xl">👥</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Anggota</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="text-green-600 text-2xl">✅</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Disetujui</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <span class="text-yellow-600 text-2xl">⏳</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Menunggu</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <span class="text-red-600 text-2xl">❌</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Ditolak</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($stats['pending'] > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Menunggu Persetujuan Admin</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Anda memiliki {{ $stats['pending'] }} anggota keluarga yang menunggu persetujuan admin. Anggota keluarga yang belum disetujui tidak dapat digunakan untuk pengajuan surat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($stats['rejected'] > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Pengajuan Ditolak</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>Anda memiliki {{ $stats['rejected'] }} anggota keluarga yang ditolak admin. Klik "Lihat Alasan" pada tabel untuk mengetahui alasan penolakan dan dapat mengajukan ulang dengan perbaikan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Family Members Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Anggota Keluarga</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama & NIK
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hubungan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Kelamin
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Umur
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($familyMembers as $member)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                                        <span class="text-white font-medium text-sm">
                                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                                    <div class="text-sm text-gray-500">NIK: {{ $member->nik }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($member->relationship === 'kepala_keluarga') bg-blue-100 text-blue-800
                                                @elseif(in_array($member->relationship, ['istri', 'suami'])) bg-green-100 text-green-800
                                                @elseif($member->relationship === 'anak') bg-purple-100 text-purple-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $member->relationship_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex items-center">
                                                @if($member->gender === 'L')
                                                    <span class="text-blue-600 mr-1">👨</span>
                                                @else
                                                    <span class="text-pink-600 mr-1">👩</span>
                                                @endif
                                                {{ $member->gender_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $member->age }} tahun
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->status_badge_color }}">
                                                    @if($member->approval_status === 'pending')
                                                        ⏳ {{ $member->approval_status_label }}
                                                    @elseif($member->approval_status === 'approved')
                                                        ✅ {{ $member->approval_status_label }}
                                                    @else
                                                        ❌ {{ $member->approval_status_label }}
                                                    @endif
                                                </span>
                                                @if($member->approval_status === 'rejected' && $member->rejection_reason)
                                                    <div class="mt-2">
                                                        <button onclick="showRejectionReason('{{ $member->id }}')"
                                                                class="text-xs text-red-600 hover:text-red-800 underline">
                                                            Lihat Alasan
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('family-members.show', $member) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('family-members.edit', $member) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 transition-colors"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
