<x-sidebar-layout>
    <x-slot name="header">
        <span>{{ __('Ajukan Surat Baru') }}
        </span>
    </x-slot>

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ajukan Surat Baru
                    </h1>
                    <p class="text-gray-600 mt-1">Lengkapi form untuk mengajukan surat keterangan</p>
                </div>
                <a href="{{ route('letter-requests.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Container with Better Layout -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                <!-- Header Section -->
                <div class="bg-blue-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Form Pengajuan Surat</h3>
                            <p class="text-blue-100 text-sm mt-1">
                                Lengkapi informasi berikut untuk mengajukan surat keterangan
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div class="bg-white border-b border-gray-200 px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center" data-step="1">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold" data-step-number="1">1</div>
                                <span class="ml-2 text-sm font-medium text-blue-600" data-step-text="1">Pilih Subjek</span>
                            </div>
                            <div class="w-8 h-0.5 bg-gray-300"></div>
                            <div class="flex items-center" data-step="2">
                                <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold" data-step-number="2">2</div>
                                <span class="ml-2 text-sm font-medium text-gray-500" data-step-text="2">Jenis Surat</span>
                            </div>
                            <div class="w-8 h-0.5 bg-gray-300"></div>
                            <div class="flex items-center" data-step="3">
                                <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold" data-step-number="3">3</div>
                                <span class="ml-2 text-sm font-medium text-gray-500" data-step-text="3">Lengkapi Data</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500" data-step-counter>
                            <span class="font-medium">Langkah 1</span> dari 3
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('letter-requests.store') }}" id="letterForm" class="space-y-8">
                        @csrf

                        <!-- Step 1: Subject Selection -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 form-step">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                                <h4 class="text-lg font-semibold text-gray-900">Pilih Subjek Surat</h4>
                            </div>

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Self Option -->
                                    <div class="relative">
                                        <input id="subject_self" name="subject_type" type="radio" value="self"
                                               class="sr-only peer"
                                               {{ old('subject_type', 'self') == 'self' ? 'checked' : '' }}
                                               onchange="toggleSubjectSelection()">
                                        <label for="subject_self" class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all radio-card">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Diri Sendiri</div>
                                                    <div class="text-sm text-gray-500">{{ auth()->user()->name }}</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Family Member Option -->
                                    @if($familyMembers->count() > 0)
                                        <div class="relative">
                                            <input id="subject_family" name="subject_type" type="radio" value="family_member"
                                                   class="sr-only peer"
                                                   {{ old('subject_type') == 'family_member' ? 'checked' : '' }}
                                                   onchange="toggleSubjectSelection()">
                                            <label for="subject_family" class="flex items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all radio-card">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">Anggota Keluarga</div>
                                                        <div class="text-sm text-gray-500">{{ $familyMembers->count() }} orang tersedia</div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                                <x-input-error :messages="$errors->get('subject_type')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Family Member Selection -->
                        @if($familyMembers->count() > 0)
                            <div id="family_member_selection" class="bg-gray-50 rounded-xl p-6 border border-gray-200 form-step" style="display: none;">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-900">Pilih Anggota Keluarga</h4>
                                </div>

                                <div class="space-y-3">
                                    <select id="subject_id" name="subject_id"
                                            class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                        <option value="">-- Pilih Anggota Keluarga --</option>
                                        @foreach($familyMembers as $member)
                                            <option value="{{ $member->id }}" {{ old('subject_id') == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }} - {{ $member->relationship_label }} (NIK: {{ $member->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                                    <div class="flex items-center text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
                                        <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Hanya anggota keluarga yang sudah disetujui yang dapat dipilih.
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                                <div class="flex items-start">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-yellow-800 mb-1">Belum ada anggota keluarga</h3>
                                        <p class="text-sm text-yellow-700 mb-3">
                                            Anda belum menambahkan anggota keluarga yang disetujui. Tambah anggota keluarga terlebih dahulu jika ingin mengajukan surat untuk anggota keluarga.
                                        </p>
                                        <a href="{{ route('family-members.create') }}" class="inline-flex items-center px-3 py-2 border border-yellow-300 shadow-sm text-sm leading-4 font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Tambah Anggota Keluarga
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Step 2: Letter Type Selection -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 form-step">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                                <h4 class="text-lg font-semibold text-gray-900">Pilih Jenis Surat</h4>
                            </div>

                            <div class="space-y-3">
                                <select id="letter_type_id" name="letter_type_id"
                                        class="block w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-lg shadow-sm text-sm"
                                        required onchange="loadLetterTypeFields()">
                                    <option value="">-- Pilih Jenis Surat --</option>
                                    @foreach($letterTypes as $type)
                                        <option value="{{ $type->id }}"
                                                data-fields="{{ json_encode($type->required_fields) }}"
                                                {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('letter_type_id')" class="mt-2" />

                                <div class="flex items-center text-sm text-gray-600 bg-purple-50 p-3 rounded-lg">
                                    <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pilih jenis surat yang ingin Anda ajukan. Form akan muncul setelah memilih jenis surat.
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Dynamic Fields Container -->
                        <div id="dynamicFieldsContainer" class="bg-gray-50 rounded-xl p-6 border border-gray-200 form-step" style="display: none;">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</div>
                                <h4 class="text-lg font-semibold text-gray-900">Lengkapi Data Surat</h4>
                            </div>

                            <div id="dynamicFields" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Fields will be loaded here based on letter type -->
                            </div>
                        </div>

                        <!-- Field Options for Select Fields -->
                        <div id="field-options" style="display: none;">
                            <div data-field="jeniskelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </div>
                            <div data-field="status_usaha">
                                <option value="">Pilih Status Usaha</option>
                                <option value="Pemilik">Pemilik</option>
                                <option value="Karyawan">Karyawan</option>
                                <option value="Mitra">Mitra</option>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="bg-white border-t border-gray-200 px-8 py-6 flex items-center justify-between">
                            <a href="{{ route('letter-requests.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali
                            </a>

                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Ajukan Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Simple transitions without animations */
        .form-step {
            transition: box-shadow 0.2s ease;
        }

        .form-step:hover {
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1);
        }

        /* Radio button styling */
        .radio-card {
            transition: all 0.2s ease;
        }

        .radio-card:hover {
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.1);
        }

        /* Form field focus effects */
        .form-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }
    </style>

    <script>
        function updateProgressIndicator(step) {
            // Reset all steps
            for (let i = 1; i <= 3; i++) {
                const stepElement = document.querySelector(`[data-step="${i}"]`);
                const stepNumber = document.querySelector(`[data-step-number="${i}"]`);
                const stepText = document.querySelector(`[data-step-text="${i}"]`);

                if (stepElement && stepNumber && stepText) {
                    if (i <= step) {
                        stepNumber.className = 'w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold';
                        stepText.className = 'ml-2 text-sm font-medium text-blue-600';
                    } else {
                        stepNumber.className = 'w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold';
                        stepText.className = 'ml-2 text-sm font-medium text-gray-500';
                    }
                }
            }

            // Update step counter
            const stepCounter = document.querySelector('[data-step-counter]');
            if (stepCounter) {
                stepCounter.innerHTML = `<span class="font-medium">Langkah ${step}</span> dari 3`;
            }
        }

        function toggleSubjectSelection() {
            const familyRadio = document.getElementById('subject_family');
            const familySelection = document.getElementById('family_member_selection');
            const subjectIdSelect = document.getElementById('subject_id');

            if (familyRadio && familyRadio.checked) {
                familySelection.style.display = 'block';
                familySelection.classList.add('step-enter');
                subjectIdSelect.required = true;
            } else {
                familySelection.style.display = 'none';
                familySelection.classList.remove('step-enter');
                subjectIdSelect.required = false;
                subjectIdSelect.value = '';
            }

            // Update progress to step 2 when subject is selected
            updateProgressIndicator(2);
        }

        function loadLetterTypeFields() {
            const select = document.getElementById('letter_type_id');
            const container = document.getElementById('dynamicFields');
            const containerWrapper = document.getElementById('dynamicFieldsContainer');
            const selectedOption = select.options[select.selectedIndex];

            // Clear existing fields
            container.innerHTML = '';

            if (selectedOption.value) {
                // Show the container with animation
                containerWrapper.style.display = 'block';
                containerWrapper.classList.add('step-enter');

                // Update progress to step 3
                updateProgressIndicator(3);

                const fields = JSON.parse(selectedOption.dataset.fields || '{}');

                Object.entries(fields).forEach(([fieldName, fieldType]) => {
                    const fieldDiv = document.createElement('div');
                    fieldDiv.className = 'space-y-2';

                    const label = document.createElement('label');
                    label.className = 'block text-sm font-semibold text-gray-700';
                    label.textContent = formatFieldName(fieldName);
                    label.setAttribute('for', `form_data_${fieldName}`);

                    let input;

                    switch(fieldType) {
                        case 'textarea':
                            input = document.createElement('textarea');
                            input.rows = 4;
                            input.className = 'block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-sm resize-none';
                            break;
                        case 'number':
                            input = document.createElement('input');
                            input.type = 'number';
                            input.className = 'block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-sm';
                            break;
                        case 'date':
                            input = document.createElement('input');
                            input.type = 'date';
                            input.className = 'block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-sm';
                            break;
                        case 'time':
                            input = document.createElement('input');
                            input.type = 'time';
                            input.className = 'block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-sm';
                            break;
                        case 'select':
                            input = document.createElement('select');
                            input.className = 'block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-sm';
                            // Add options based on field name
                            if (fieldName === 'jeniskelamin') {
                                input.innerHTML = '<option value="">-- Pilih Jenis Kelamin --</option><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option>';
                            } else if (fieldName === 'status_usaha') {
                                input.innerHTML = '<option value="">-- Pilih Status Usaha --</option><option value="Pemilik">Pemilik</option><option value="Karyawan">Karyawan</option><option value="Mitra">Mitra</option>';
                            } else {
                                input.innerHTML = '<option value="">-- Pilih --</option>';
                            }
                            break;
                        default:
                            input = document.createElement('input');
                            input.type = 'text';
                            input.className = 'block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-sm';
                    }

                    input.name = `form_data[${fieldName}]`;
                    input.id = `form_data_${fieldName}`;
                    input.required = true;
                    input.placeholder = `Masukkan ${formatFieldName(fieldName).toLowerCase()}`;

                    // Set old values if available
                    const oldValue = getOldValue(fieldName);
                    if (oldValue) {
                        input.value = oldValue;
                    }

                    fieldDiv.appendChild(label);
                    fieldDiv.appendChild(input);
                    container.appendChild(fieldDiv);
                });
            } else {
                // Hide the container if no letter type selected
                containerWrapper.style.display = 'none';
            }
        }
        
        function formatFieldName(fieldName) {
            return fieldName.replace(/_/g, ' ')
                           .replace(/\b\w/g, l => l.toUpperCase());
        }
        
        function getOldValue(fieldName) {
            // This would need to be populated from Laravel's old() helper
            // For now, return null
            return null;
        }
        
        // Load fields on page load if letter type is already selected
        document.addEventListener('DOMContentLoaded', function() {
            const letterTypeSelect = document.getElementById('letter_type_id');
            if (letterTypeSelect.value) {
                loadLetterTypeFields();
            }

            // Initialize subject selection display
            toggleSubjectSelection();
        });
    </script>
</x-sidebar-layout>
