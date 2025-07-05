<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengajuan Surat') }}
            </h2>
            <div class="flex items-center space-x-2">
                @php
                    $statusConfig = [
                        'pending_rt' => ['color' => 'yellow', 'icon' => '⏳', 'text' => 'Menunggu RT'],
                        'pending_rw' => ['color' => 'blue', 'icon' => '⏳', 'text' => 'Menunggu RW'],
                        'approved_final' => ['color' => 'green', 'icon' => '✅', 'text' => 'Selesai'],
                        'rejected_rt' => ['color' => 'red', 'icon' => '❌', 'text' => 'Ditolak RT'],
                        'rejected_rw' => ['color' => 'red', 'icon' => '❌', 'text' => 'Ditolak RW'],
                    ];
                    $status = $statusConfig[$letterRequest->status] ?? ['color' => 'gray', 'icon' => '❓', 'text' => 'Unknown'];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                    {{ $status['icon'] }} {{ $status['text'] }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg mb-6">
                <div class="px-6 py-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $letterRequest->letterType->name }}</h1>
                            <p class="text-blue-100 mt-2">
                                <span class="inline-flex items-center">
                                    📄 {{ $letterRequest->request_number }}
                                </span>
                            </p>
                            <p class="text-blue-100 text-sm mt-1">
                                Diajukan pada {{ $letterRequest->created_at->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                                <div class="text-3xl mb-2">{{ $status['icon'] }}</div>
                                <div class="text-sm font-medium">{{ $status['text'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Timeline -->
            <div class="bg-white rounded-lg shadow-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        🔄 Progress Pengajuan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <!-- Step 1: Pengajuan -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold mb-2">
                                ✓
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-gray-900">Pengajuan</p>
                                <p class="text-xs text-gray-500">{{ $letterRequest->created_at->format('d/m H:i') }}</p>
                            </div>
                        </div>

                        <!-- Connector -->
                        <div class="flex-1 h-1 {{ $letterRequest->rt_processed_at ? 'bg-green-500' : 'bg-gray-300' }} mx-2"></div>

                        <!-- Step 2: RT -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 {{ $letterRequest->rt_processed_at ? 'bg-green-500' : ($letterRequest->status == 'pending_rt' ? 'bg-yellow-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center text-white font-bold mb-2">
                                @if($letterRequest->rt_processed_at)
                                    ✓
                                @elseif($letterRequest->status == 'pending_rt')
                                    ⏳
                                @else
                                    2
                                @endif
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-gray-900">Persetujuan RT</p>
                                <p class="text-xs text-gray-500">
                                    {{ $letterRequest->rt_processed_at ? $letterRequest->rt_processed_at->format('d/m H:i') : 'Menunggu' }}
                                </p>
                            </div>
                        </div>

                        <!-- Connector -->
                        <div class="flex-1 h-1 {{ $letterRequest->rw_processed_at ? 'bg-green-500' : 'bg-gray-300' }} mx-2"></div>

                        <!-- Step 3: RW -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 {{ $letterRequest->rw_processed_at ? 'bg-green-500' : ($letterRequest->status == 'pending_rw' ? 'bg-yellow-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center text-white font-bold mb-2">
                                @if($letterRequest->rw_processed_at)
                                    ✓
                                @elseif($letterRequest->status == 'pending_rw')
                                    ⏳
                                @else
                                    3
                                @endif
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-gray-900">Persetujuan RW</p>
                                <p class="text-xs text-gray-500">
                                    {{ $letterRequest->rw_processed_at ? $letterRequest->rw_processed_at->format('d/m H:i') : 'Menunggu' }}
                                </p>
                            </div>
                        </div>

                        <!-- Connector -->
                        <div class="flex-1 h-1 {{ $letterRequest->final_processed_at ? 'bg-green-500' : 'bg-gray-300' }} mx-2"></div>

                        <!-- Step 4: Selesai -->
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 {{ $letterRequest->final_processed_at ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-bold mb-2">
                                @if($letterRequest->final_processed_at)
                                    🎉
                                @else
                                    4
                                @endif
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-gray-900">Selesai</p>
                                <p class="text-xs text-gray-500">
                                    {{ $letterRequest->final_processed_at ? $letterRequest->final_processed_at->format('d/m H:i') : 'Menunggu' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($letterRequest->rejection_reason)
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Pengajuan Ditolak</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ $letterRequest->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Data Pengajuan -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Data Pengajuan Card -->
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                📝 Data Pengajuan
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($letterRequest->form_data)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($letterRequest->form_data as $key => $value)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </label>
                                            <p class="text-sm text-gray-900 font-medium">
                                                @if(is_numeric($value) && strlen($value) > 10)
                                                    {{ number_format($value, 0, ',', '.') }}
                                                @elseif(strtotime($value))
                                                    {{ \Carbon\Carbon::parse($value)->format('d F Y') }}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="text-gray-400 text-4xl mb-4">📄</div>
                                    <p class="text-gray-500">Tidak ada data tambahan</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Approval History -->
                    @if($letterRequest->approvals->count() > 0)
                        <div class="bg-white rounded-lg shadow-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    📋 Riwayat Persetujuan
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach($letterRequest->approvals as $approval)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0">
                                                        @if($approval->status === 'approved')
                                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            </div>
                                                        @else
                                                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $approval->approver->name }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ strtoupper($approval->approval_level) }} • {{ $approval->processed_at->format('d F Y, H:i') }} WIB
                                                        </p>
                                                        @if($approval->notes)
                                                            <p class="mt-2 text-sm text-gray-600 bg-gray-50 rounded p-2">
                                                                "{{ $approval->notes }}"
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $approval->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $approval->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Info & Actions -->
                <div class="space-y-6">
                    <!-- Quick Info Card -->
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                ℹ️ Informasi Pengajuan
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Nomor Pengajuan</span>
                                <span class="text-sm font-medium text-gray-900">{{ $letterRequest->request_number }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Jenis Surat</span>
                                <span class="text-sm font-medium text-gray-900">{{ $letterRequest->letterType->name }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Tanggal Pengajuan</span>
                                <span class="text-sm font-medium text-gray-900">{{ $letterRequest->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Waktu Pengajuan</span>
                                <span class="text-sm font-medium text-gray-900">{{ $letterRequest->created_at->format('H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">Status Saat Ini</span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                    {{ $status['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Card -->
                    <div class="bg-white rounded-lg shadow-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                ⚡ Aksi
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            @if($letterRequest->isApproved() && $letterRequest->letter_file)
                                <a href="{{ route('letter-requests.download', $letterRequest) }}"
                                   class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>Download Surat PDF</span>
                                </a>

                                <a href="{{ route('qr-verification.verify', $letterRequest->request_number) }}"
                                   target="_blank"
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    <span>Verifikasi QR Code</span>
                                </a>
                            @endif

                            <a href="{{ route('letter-requests.index') }}"
                               class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span>Kembali ke Daftar</span>
                            </a>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg shadow-lg">
                        <div class="p-6">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Bantuan</h4>
                            </div>
                            <div class="space-y-2 text-sm text-gray-700">
                                <p>• Pengajuan akan diproses secara berurutan oleh RT kemudian RW</p>
                                <p>• Anda akan mendapat notifikasi setiap ada update status</p>
                                <p>• Surat dapat didownload setelah disetujui RW</p>
                                <p>• QR Code pada surat dapat digunakan untuk verifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
