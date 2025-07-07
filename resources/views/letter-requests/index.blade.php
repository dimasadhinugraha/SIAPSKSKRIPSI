<x-sidebar-layout>
    <x-slot name="title">Pengajuan Surat</x-slot>
    <x-slot name="header">
        📄 Pengajuan Surat
    </x-slot>

    <!-- Compact Mobile Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg mb-4">
        <div class="w-full mx-auto px-2 sm:px-4 lg:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 space-y-2 sm:space-y-0">
                <div class="text-white">
                    <h1 class="text-lg font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Pengajuan Surat
                    </h1>
                    <p class="text-blue-100 text-sm">Kelola pengajuan surat keterangan</p>
                    <div class="mt-1 flex items-center text-blue-100 text-xs">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Total: {{ $requests->total() }} pengajuan
                    </div>
                </div>
                <a href="{{ route('letter-requests.create') }}"
                   class="bg-white text-blue-600 hover:bg-blue-50 font-medium py-2 px-3 rounded-lg shadow-sm transition-colors inline-flex items-center text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Ajukan Surat Baru</span>
                    <span class="sm:hidden">Baru</span>
                </a>
            </div>
        </div>
    </div>

    <div class="pb-8">
        <div class="w-full mx-auto px-2 sm:px-4 lg:px-6">
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 rounded-lg p-4 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" viewBox="0 0 20 20" fill="currentColor">
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

                    @if($requests->count() > 0)
                        <!-- Modern Card Layout -->
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($requests as $request)
                                @php
                                    $statusConfig = [
                                        'pending_rt' => [
                                            'bg' => 'bg-yellow-50',
                                            'border' => 'border-yellow-200',
                                            'badge' => 'bg-yellow-100 text-yellow-800',
                                            'icon' => 'text-yellow-500'
                                        ],
                                        'pending_rw' => [
                                            'bg' => 'bg-blue-50',
                                            'border' => 'border-blue-200',
                                            'badge' => 'bg-blue-100 text-blue-800',
                                            'icon' => 'text-blue-500'
                                        ],
                                        'approved_final' => [
                                            'bg' => 'bg-green-50',
                                            'border' => 'border-green-200',
                                            'badge' => 'bg-green-100 text-green-800',
                                            'icon' => 'text-green-500'
                                        ],
                                        'rejected_rt' => [
                                            'bg' => 'bg-red-50',
                                            'border' => 'border-red-200',
                                            'badge' => 'bg-red-100 text-red-800',
                                            'icon' => 'text-red-500'
                                        ],
                                        'rejected_rw' => [
                                            'bg' => 'bg-red-50',
                                            'border' => 'border-red-200',
                                            'badge' => 'bg-red-100 text-red-800',
                                            'icon' => 'text-red-500'
                                        ],
                                    ];
                                    $config = $statusConfig[$request->status] ?? [
                                        'bg' => 'bg-gray-50',
                                        'border' => 'border-gray-200',
                                        'badge' => 'bg-gray-100 text-gray-800',
                                        'icon' => 'text-gray-500'
                                    ];
                                @endphp

                                <div class="bg-white rounded-xl shadow-sm border {{ $config['border'] }} hover:shadow-md transition-all duration-200 overflow-hidden">
                                    <!-- Card Header -->
                                    <div class="{{ $config['bg'] }} px-6 py-4 border-b {{ $config['border'] }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 {{ $config['icon'] }} mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span class="text-sm font-medium text-gray-900">{{ $request->request_number }}</span>
                                            </div>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $config['badge'] }}">
                                                {{ $request->status_label }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $request->letterType->name }}</h3>

                                        <div class="space-y-3 mb-4">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <span class="font-medium">{{ $request->subject_name }}</span>
                                                <span class="ml-2 text-xs text-gray-500">
                                                    ({{ $request->subject_type === 'self' ? 'Diri sendiri' : 'Anggota keluarga' }})
                                                </span>
                                            </div>

                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"/>
                                                </svg>
                                                {{ $request->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('letter-requests.show', $request) }}"
                                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                                Detail
                                            </a>
                                            @if($request->isApproved() && $request->letter_file)
                                                <a href="{{ route('letter-requests.download', $request) }}"
                                                   class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                                    Download
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($requests->hasPages())
                            <div class="mt-8 flex justify-center">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                                    {{ $requests->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Enhanced Empty State -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="text-center py-16 px-6">
                                <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pengajuan Surat</h3>
                                <p class="text-gray-600 mb-8 w-full mx-auto">
                                    Mulai dengan mengajukan surat administrasi pertama Anda. Proses pengajuan mudah dan cepat!
                                </p>

                                <!-- Quick Actions -->
                                <div class="space-y-4">
                                    <a href="{{ route('letter-requests.create') }}"
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Ajukan Surat Baru
                                    </a>

                                    <div class="text-sm text-gray-500">
                                        <p>💡 <strong>Tips:</strong> Pastikan data keluarga sudah lengkap sebelum mengajukan surat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
        </div>
    </div>
</x-sidebar-layout>
