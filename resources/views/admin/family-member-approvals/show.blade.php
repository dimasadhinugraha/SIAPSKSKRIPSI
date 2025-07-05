<x-sidebar-layout>
    <x-slot name="header">
        🔍 Review Anggota Keluarga
    </x-slot>

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">🔍 Review Anggota Keluarga</h1>
                    <p class="text-gray-600 mt-1">{{ $familyMember->name }} - {{ $familyMember->relationship_label }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    @if($familyMember->approval_status === 'pending')
                        <form action="{{ route('admin.family-member-approvals.approve', $familyMember) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Setujui anggota keluarga ini?')"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Setujui
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.family-member-approvals.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Status Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg mb-6 overflow-hidden">
                <div class="px-6 py-8 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <span class="text-white text-2xl font-bold">
                                        {{ strtoupper(substr($familyMember->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h1 class="text-3xl font-bold">{{ $familyMember->name }}</h1>
                                <p class="text-blue-100 text-lg">{{ $familyMember->relationship_label }}</p>
                                <p class="text-blue-200 text-sm">NIK: {{ $familyMember->nik }}</p>
                                <p class="text-blue-200 text-sm">Pengaju: {{ $familyMember->user->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="mb-4">
                                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $familyMember->status_badge_color }}">
                                    @if($familyMember->approval_status === 'pending')
                                        ⏳ {{ $familyMember->approval_status_label }}
                                    @elseif($familyMember->approval_status === 'approved')
                                        ✅ {{ $familyMember->approval_status_label }}
                                    @else
                                        ❌ {{ $familyMember->approval_status_label }}
                                    @endif
                                </span>
                            </div>
                            <p class="text-blue-100 text-sm">Diajukan: {{ $familyMember->created_at->format('d F Y, H:i') }}</p>
                            @if($familyMember->approved_at)
                                <p class="text-blue-100 text-sm">
                                    @if($familyMember->approval_status === 'approved')
                                        Disetujui: {{ $familyMember->approved_at->format('d F Y, H:i') }}
                                    @else
                                        Ditolak: {{ $familyMember->approved_at->format('d F Y, H:i') }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Data Pribadi -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                👤 Data Pribadi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->nik }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                                    <p class="text-lg font-semibold text-gray-900">
                                        @if($familyMember->gender === 'L')
                                            👨 {{ $familyMember->gender_label }}
                                        @else
                                            👩 {{ $familyMember->gender_label }}
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Hubungan Keluarga</label>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                        @if($familyMember->relationship === 'kepala_keluarga') bg-blue-100 text-blue-800
                                        @elseif(in_array($familyMember->relationship, ['istri', 'suami'])) bg-green-100 text-green-800
                                        @elseif($familyMember->relationship === 'anak') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $familyMember->relationship_label }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Lahir</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->place_of_birth }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->formatted_date_of_birth }} ({{ $familyMember->age }} tahun)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Tambahan -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                📋 Data Tambahan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Agama</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->religion_label }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Status Perkawinan</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->marital_status_label }}</p>
                                </div>
                                @if($familyMember->education)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Pendidikan</label>
                                        <p class="text-lg font-semibold text-gray-900">{{ $familyMember->education_label }}</p>
                                    </div>
                                @endif
                                @if($familyMember->occupation)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                                        <p class="text-lg font-semibold text-gray-900">{{ $familyMember->occupation }}</p>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Kewarganegaraan</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->nationality }}</p>
                                </div>
                                @if($familyMember->father_name)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ayah</label>
                                        <p class="text-lg font-semibold text-gray-900">{{ $familyMember->father_name }}</p>
                                    </div>
                                @endif
                                @if($familyMember->mother_name)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ibu</label>
                                        <p class="text-lg font-semibold text-gray-900">{{ $familyMember->mother_name }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            @if($familyMember->notes)
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Catatan</label>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-900">{{ $familyMember->notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Data Pengaju -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                👨‍💼 Data Pengaju
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pengaju</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">RT/RW</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $familyMember->user->rt_rw }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Status Verifikasi</label>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $familyMember->user->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $familyMember->user->is_verified ? '✅ Terverifikasi' : '⏳ Belum Terverifikasi' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Dokumen Pendukung -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                📄 Dokumen Pendukung
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($familyMember->supporting_document)
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-4">Dokumen telah diupload</p>
                                    <a href="{{ route('admin.family-member-approvals.download-document', $familyMember) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Dokumen
                                    </a>
                                </div>
                            @else
                                <div class="text-center text-gray-500">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm">Tidak ada dokumen</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($familyMember->approval_status === 'pending')
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    ⚡ Aksi Review
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Approve Form -->
                                <form action="{{ route('admin.family-member-approvals.approve', $familyMember) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            onclick="return confirm('Setujui anggota keluarga ini?')"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-colors inline-flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setujui Pengajuan
                                    </button>
                                </form>

                                <!-- Reject Form -->
                                <form action="{{ route('admin.family-member-approvals.reject', $familyMember) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                            Alasan Penolakan <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="rejection_reason" 
                                                  id="rejection_reason" 
                                                  rows="3" 
                                                  required
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                                  placeholder="Jelaskan alasan penolakan..."></textarea>
                                    </div>
                                    <button type="submit" 
                                            onclick="return confirm('Tolak anggota keluarga ini?')"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors inline-flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tolak Pengajuan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Status History -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                📊 Riwayat Status
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 text-sm">📝</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Pengajuan Dibuat</p>
                                        <p class="text-xs text-gray-500">{{ $familyMember->created_at->format('d F Y, H:i') }}</p>
                                    </div>
                                </div>

                                @if($familyMember->approved_at)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 {{ $familyMember->approval_status === 'approved' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                            <span class="{{ $familyMember->approval_status === 'approved' ? 'text-green-600' : 'text-red-600' }} text-sm">
                                                {{ $familyMember->approval_status === 'approved' ? '✅' : '❌' }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $familyMember->approval_status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                                @if($familyMember->approver)
                                                    oleh {{ $familyMember->approver->name }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $familyMember->approved_at->format('d F Y, H:i') }}</p>
                                            @if($familyMember->rejection_reason)
                                                <p class="text-xs text-red-600 mt-1">{{ $familyMember->rejection_reason }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
