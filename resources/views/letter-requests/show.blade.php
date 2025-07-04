<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Surat') }}
        </h2>
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
                        <!-- Request Information -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Informasi Pengajuan</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                @php
                                    $statusColors = [
                                        'pending_rt' => 'bg-yellow-100 text-yellow-800',
                                        'pending_rw' => 'bg-blue-100 text-blue-800',
                                        'approved_final' => 'bg-green-100 text-green-800',
                                        'rejected_rt' => 'bg-red-100 text-red-800',
                                        'rejected_rw' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$letterRequest->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $letterRequest->status_label }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            @if($letterRequest->rt_processed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Diproses RT</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->rt_processed_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif

                            @if($letterRequest->rw_processed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Diproses RW</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->rw_processed_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif

                            @if($letterRequest->final_processed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Selesai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->final_processed_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif

                            @if($letterRequest->rejection_reason)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                    <p class="mt-1 text-sm text-red-600">{{ $letterRequest->rejection_reason }}</p>
                                </div>
                            @endif
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

                    <!-- Approval History -->
                    @if($letterRequest->approvals->count() > 0)
                        <div class="mt-8">
                            <h4 class="font-medium text-gray-900 mb-4">Riwayat Persetujuan</h4>
                            <div class="space-y-4">
                                @foreach($letterRequest->approvals as $approval)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between">
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
                        <a href="{{ route('letter-requests.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali
                        </a>

                        @if($letterRequest->isApproved() && $letterRequest->letter_file)
                            <a href="{{ route('letter-requests.download', $letterRequest) }}" 
                               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Download Surat
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
