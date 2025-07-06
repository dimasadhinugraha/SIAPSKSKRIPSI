<x-sidebar-layout>
    <x-slot name="header">
        📋 Detail Pengajuan Surat - {{ $letterRequest->request_number }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $letterRequest->letterType->name }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Nomor Pengajuan: {{ $letterRequest->request_number }} | 
                                    Tanggal: {{ $letterRequest->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusColors = [
                                        'pending_rt' => 'bg-yellow-100 text-yellow-800',
                                        'pending_rw' => 'bg-blue-100 text-blue-800',
                                        'approved_final' => 'bg-green-100 text-green-800',
                                        'rejected_rt' => 'bg-red-100 text-red-800',
                                        'rejected_rw' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$letterRequest->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $letterRequest->status_label }}
                                </span>
                            </div>
                        </div>
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
                        </div>

                        <!-- Subject Information (if different from user) -->
                        @if($letterRequest->subject && $letterRequest->subject->id !== $letterRequest->user->id)
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Data Subjek Surat</h4>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject->nik }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hubungan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject->relationship_label }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->subject->birth_date ? $letterRequest->subject->birth_date->format('d/m/Y') : '-' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="space-y-4">
                                <h4 class="font-medium text-gray-900">Informasi Tambahan</h4>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $letterRequest->user->birth_date ? $letterRequest->user->birth_date->format('d/m/Y') : '-' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Subjek Surat</label>
                                    <p class="mt-1 text-sm text-gray-900">Diri Sendiri</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Approval History -->
                    @if($letterRequest->approvals->count() > 0)
                        <div class="mt-8">
                            <h4 class="font-medium text-gray-900 mb-4">Riwayat Persetujuan</h4>
                            <div class="space-y-4">
                                @foreach($letterRequest->approvals as $approval)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                        <span class="text-xs font-medium text-gray-600">
                                                            {{ strtoupper(substr($approval->approver->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $approval->approver->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $approval->processed_at->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
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

                    <!-- Download Letter -->
                    @if($letterRequest->status === 'approved_final' && $letterRequest->letter_file)
                        <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-medium text-green-900">Surat Telah Disetujui</h5>
                                        <p class="text-sm text-green-700">File surat sudah tersedia untuk diunduh</p>
                                    </div>
                                </div>
                                <a href="{{ route('letter-requests.download', $letterRequest) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    📄 Unduh Surat
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex items-center justify-between">
                        <a href="{{ route('admin.letter-requests.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Kembali ke Daftar</span>
                        </a>

                        <div class="flex items-center space-x-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Mode Monitoring Admin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
