<x-sidebar-layout>
    <x-slot name="header">
        <span>{{ __('Review Pengajuan Surat') }}
        </span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $letterRequest->letterType->name }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Nomor Pengajuan: {{ $letterRequest->request_number }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pemohon Information -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Data Pemohon</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->nik }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->address }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">RT/RW</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->rt_rw }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->phone }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Form Data -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Data Pengajuan</h4>
                            
                            @if($letterRequest->form_data)
                                @foreach($letterRequest->form_data as $key => $value)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $value }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Previous Approvals -->
                    @if($letterRequest->approvals->count() > 0)
                        <div class="mt-8">
                            <h4 class="font-medium text-gray-900 mb-4">Riwayat Persetujuan</h4>
                            <div class="space-y-4">
                                @foreach($letterRequest->approvals as $approval)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between w-full">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $approval->approver->name }} ({{ strtoupper($approval->approval_level) }})
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $approval->processed_at->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $approval->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $approval->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                            </span>
                                        </div>
                                        @if($approval->notes)
                                            <p class="mt-2 text-sm text-gray-600">{{ $approval->notes }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('approvals.index') }}" 
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
                            <button type="button" 
                                    onclick="openApproveModal()"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Setujui
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Pengajuan</h3>
                <form method="POST" action="{{ route('approvals.approve', $letterRequest) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="approve_notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea id="approve_notes" name="notes" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeApproveModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pengajuan</h3>
                <form method="POST" action="{{ route('approvals.reject', $letterRequest) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="reject_notes" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <textarea id="reject_notes" name="notes" rows="3" required
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
        function openApproveModal() {
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const approveModal = document.getElementById('approveModal');
            const rejectModal = document.getElementById('rejectModal');
            
            if (event.target === approveModal) {
                closeApproveModal();
            }
            if (event.target === rejectModal) {
                closeRejectModal();
            }
        }
    </script>
</x-sidebar-layout>
