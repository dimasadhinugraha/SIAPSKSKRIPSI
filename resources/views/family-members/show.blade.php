<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <span>👤 Detail Anggota Keluarga
            </span>
            <div class="flex items-center space-x-3">
                <a href="{{ route('family-members.edit', $familyMember) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('family-members.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg mb-6 overflow-hidden">
                <div class="px-6 py-8 text-white">
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
                        </div>
                        <div class="ml-auto text-right">
                            <div class="text-4xl mb-2">
                                @if($familyMember->gender === 'L')
                                    👨
                                @else
                                    👩
                                @endif
                            </div>
                            <p class="text-blue-100 text-sm">{{ $familyMember->age }} tahun</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Data Pribadi -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            👤 Data Pribadi
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Nama Lengkap</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">NIK</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->nik }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Jenis Kelamin</span>
                            <span class="text-sm font-medium text-gray-900">
                                @if($familyMember->gender === 'L')
                                    👨 {{ $familyMember->gender_label }}
                                @else
                                    👩 {{ $familyMember->gender_label }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Tempat Lahir</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->place_of_birth }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Tanggal Lahir</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->formatted_date_of_birth }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Umur</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->age }} tahun</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Hubungan Keluarga</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($familyMember->relationship === 'kepala_keluarga') bg-blue-100 text-blue-800
                                @elseif(in_array($familyMember->relationship, ['istri', 'suami'])) bg-green-100 text-green-800
                                @elseif($familyMember->relationship === 'anak') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $familyMember->relationship_label }}
                            </span>
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
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Agama</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->religion_label }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Status Perkawinan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->marital_status_label }}</span>
                        </div>
                        @if($familyMember->education)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Pendidikan</span>
                                <span class="text-sm font-medium text-gray-900">{{ $familyMember->education_label }}</span>
                            </div>
                        @endif
                        @if($familyMember->occupation)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Pekerjaan</span>
                                <span class="text-sm font-medium text-gray-900">{{ $familyMember->occupation }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Kewarganegaraan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $familyMember->nationality }}</span>
                        </div>
                        @if($familyMember->father_name)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Nama Ayah</span>
                                <span class="text-sm font-medium text-gray-900">{{ $familyMember->father_name }}</span>
                            </div>
                        @endif
                        @if($familyMember->mother_name)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Nama Ibu</span>
                                <span class="text-sm font-medium text-gray-900">{{ $familyMember->mother_name }}</span>
                            </div>
                        @endif
                        @if($familyMember->notes)
                            <div class="py-2">
                                <span class="text-sm text-gray-600 block mb-2">Catatan</span>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="text-sm text-gray-900">{{ $familyMember->notes }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    ⚡ Aksi
                </h3>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('family-members.edit', $familyMember) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Data
                    </a>
                    
                    <form action="{{ route('family-members.destroy', $familyMember) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-flex items-center"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data anggota keluarga ini?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Data
                        </button>
                    </form>
                    
                    <a href="{{ route('family-members.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            <!-- Metadata -->
            <div class="mt-6 bg-gray-50 rounded-xl p-4">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Data ditambahkan: {{ $familyMember->created_at->format('d F Y, H:i') }} WIB</span>
                    @if($familyMember->updated_at != $familyMember->created_at)
                        <span>Terakhir diupdate: {{ $familyMember->updated_at->format('d F Y, H:i') }} WIB</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
