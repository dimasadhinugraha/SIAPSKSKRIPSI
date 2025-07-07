<x-sidebar-layout>
    <x-slot name="title">Verifikasi Surat</x-slot>
    <x-slot name="header">
        <span>{{ __('Verifikasi Surat') }}
        </span>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto px-2 sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Verification Status -->
                    <div class="mb-6">
                        @if($valid)
                            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">
                                            ✅ Surat Valid
                                        </h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>{{ $message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            ❌ Surat Tidak Valid
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>{{ $message }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($letterRequest)
                        <!-- Letter Information -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Letter Details -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Informasi Surat</h4>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor Surat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->request_number }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Surat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->letterType->name }}</p>
                                </div>

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
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->created_at->format('d F Y, H:i') }} WIB</p>
                                </div>

                                @if($letterRequest->final_processed_at)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->final_processed_at->format('d F Y, H:i') }} WIB</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Subject Details -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Data Subjek Surat</h4>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject_name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject_details['nik'] }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject_details['relationship'] }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject_details['address'] }}</p>
                                </div>
                            </div>

                            <!-- Applicant Details -->
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Data Pengaju</h4>
                                
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

                                @if($letterRequest->form_data)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Data Tambahan</label>
                                        <div class="mt-1 text-sm text-gray-900">
                                            @foreach($letterRequest->form_data as $key => $value)
                                                <p><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
                                            @endforeach
                                        </div>
                                    </div>
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
                                            <div class="flex items-center justify-between w-full">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $approval->approver->name }} ({{ strtoupper($approval->approval_level) }})
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $approval->processed_at->format('d F Y, H:i') }} WIB
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
                    @endif

                    <!-- Actions -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('qr-verification.scan') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Scan QR Code Lain
                        </a>
                        
                        <a href="{{ route('dashboard') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
