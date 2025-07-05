<x-sidebar-layout>
    <x-slot name="header">
        ✏️ Edit Anggota Keluarga
    </x-slot>

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">✏️ Edit Anggota Keluarga</h1>
                    <p class="text-gray-600 mt-1">{{ $familyMember->name }} - {{ $familyMember->relationship_label }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('family-members.show', $familyMember) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
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
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600">
                    <h3 class="text-lg font-semibold text-white">Edit Data: {{ $familyMember->name }}</h3>
                    <p class="text-blue-100 text-sm mt-1">Perbarui data anggota keluarga dengan benar</p>
                </div>

                <form action="{{ route('family-members.update', $familyMember) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Data Pribadi -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            👤 Data Pribadi
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                    NIK <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nik" 
                                       id="nik" 
                                       value="{{ old('nik', $familyMember->nik) }}"
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror"
                                       placeholder="Masukkan 16 digit NIK">
                                @error('nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $familyMember->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="gender" 
                                        id="gender" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-500 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender', $familyMember->gender) === 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                                    <option value="P" {{ old('gender', $familyMember->gender) === 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hubungan Keluarga -->
                            <div>
                                <label for="relationship" class="block text-sm font-medium text-gray-700 mb-2">
                                    Hubungan Keluarga <span class="text-red-500">*</span>
                                </label>
                                <select name="relationship" 
                                        id="relationship" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('relationship') border-red-500 @enderror">
                                    <option value="">Pilih Hubungan Keluarga</option>
                                    @foreach(App\Models\FamilyMember::getRelationshipOptions() as $key => $label)
                                        <option value="{{ $key }}" {{ old('relationship', $familyMember->relationship) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('relationship')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label for="place_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="place_of_birth" 
                                       id="place_of_birth" 
                                       value="{{ old('place_of_birth', $familyMember->place_of_birth) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('place_of_birth') border-red-500 @enderror"
                                       placeholder="Masukkan tempat lahir">
                                @error('place_of_birth')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="date_of_birth" 
                                       id="date_of_birth" 
                                       value="{{ old('date_of_birth', $familyMember->date_of_birth->format('Y-m-d')) }}"
                                       max="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-500 @enderror">
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Tambahan -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            📋 Data Tambahan
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Agama -->
                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select name="religion" 
                                        id="religion" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('religion') border-red-500 @enderror">
                                    <option value="">Pilih Agama</option>
                                    @foreach(App\Models\FamilyMember::getReligionOptions() as $key => $label)
                                        <option value="{{ $key }}" {{ old('religion', $familyMember->religion) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('religion')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Perkawinan -->
                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Perkawinan <span class="text-red-500">*</span>
                                </label>
                                <select name="marital_status" 
                                        id="marital_status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('marital_status') border-red-500 @enderror">
                                    <option value="">Pilih Status Perkawinan</option>
                                    @foreach(App\Models\FamilyMember::getMaritalStatusOptions() as $key => $label)
                                        <option value="{{ $key }}" {{ old('marital_status', $familyMember->marital_status) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('marital_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pendidikan -->
                            <div>
                                <label for="education" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pendidikan Terakhir
                                </label>
                                <select name="education" 
                                        id="education" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('education') border-red-500 @enderror">
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach(App\Models\FamilyMember::getEducationOptions() as $key => $label)
                                        <option value="{{ $key }}" {{ old('education', $familyMember->education) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('education')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pekerjaan -->
                            <div>
                                <label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pekerjaan
                                </label>
                                <input type="text" 
                                       name="occupation" 
                                       id="occupation" 
                                       value="{{ old('occupation', $familyMember->occupation) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('occupation') border-red-500 @enderror"
                                       placeholder="Masukkan pekerjaan">
                                @error('occupation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kewarganegaraan -->
                            <div>
                                <label for="nationality" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kewarganegaraan
                                </label>
                                <input type="text" 
                                       name="nationality" 
                                       id="nationality" 
                                       value="{{ old('nationality', $familyMember->nationality) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nationality') border-red-500 @enderror"
                                       placeholder="WNI">
                                @error('nationality')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Ayah -->
                            <div>
                                <label for="father_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Ayah
                                </label>
                                <input type="text" 
                                       name="father_name" 
                                       id="father_name" 
                                       value="{{ old('father_name', $familyMember->father_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('father_name') border-red-500 @enderror"
                                       placeholder="Masukkan nama ayah">
                                @error('father_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Ibu -->
                            <div>
                                <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Ibu
                                </label>
                                <input type="text" 
                                       name="mother_name" 
                                       id="mother_name" 
                                       value="{{ old('mother_name', $familyMember->mother_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mother_name') border-red-500 @enderror"
                                       placeholder="Masukkan nama ibu">
                                @error('mother_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                                  placeholder="Catatan tambahan (opsional)">{{ old('notes', $familyMember->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('family-members.show', $familyMember) }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto format NIK input
        document.getElementById('nik').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            e.target.value = value;
        });
    </script>
</x-sidebar-layout>
