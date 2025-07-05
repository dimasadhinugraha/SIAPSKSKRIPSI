<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Surat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Form Pengajuan Surat</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Pilih jenis surat dan lengkapi form yang diperlukan.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('letter-requests.store') }}" id="letterForm">
                        @csrf

                        <!-- Letter Type Selection -->
                        <div class="mb-6">
                            <x-input-label for="letter_type_id" value="Jenis Surat" />
                            <select id="letter_type_id" name="letter_type_id" 
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                    required onchange="loadLetterTypeFields()">
                                <option value="">Pilih Jenis Surat</option>
                                @foreach($letterTypes as $type)
                                    <option value="{{ $type->id }}" 
                                            data-fields="{{ json_encode($type->required_fields) }}"
                                            {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('letter_type_id')" class="mt-2" />
                        </div>

                        <!-- Dynamic Fields Container -->
                        <div id="dynamicFields" class="space-y-4">
                            <!-- Fields will be loaded here based on letter type -->
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

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('letter-requests.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Kembali
                            </a>

                            <x-primary-button>
                                Ajukan Surat
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadLetterTypeFields() {
            const select = document.getElementById('letter_type_id');
            const container = document.getElementById('dynamicFields');
            const selectedOption = select.options[select.selectedIndex];
            
            // Clear existing fields
            container.innerHTML = '';
            
            if (selectedOption.value) {
                const fields = JSON.parse(selectedOption.dataset.fields || '{}');
                
                Object.entries(fields).forEach(([fieldName, fieldType]) => {
                    const fieldDiv = document.createElement('div');
                    fieldDiv.className = 'mb-4';
                    
                    const label = document.createElement('label');
                    label.className = 'block text-sm font-medium text-gray-700 mb-2';
                    label.textContent = formatFieldName(fieldName);
                    
                    let input;
                    
                    switch(fieldType) {
                        case 'textarea':
                            input = document.createElement('textarea');
                            input.rows = 3;
                            break;
                        case 'number':
                            input = document.createElement('input');
                            input.type = 'number';
                            break;
                        case 'date':
                            input = document.createElement('input');
                            input.type = 'date';
                            break;
                        case 'time':
                            input = document.createElement('input');
                            input.type = 'time';
                            break;
                        case 'select':
                            input = document.createElement('select');
                            // Add options based on field name
                            if (fieldName === 'jeniskelamin') {
                                input.innerHTML = '<option value="">Pilih Jenis Kelamin</option><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option>';
                            } else if (fieldName === 'status_usaha') {
                                input.innerHTML = '<option value="">Pilih Status Usaha</option><option value="Pemilik">Pemilik</option><option value="Karyawan">Karyawan</option><option value="Mitra">Mitra</option>';
                            } else {
                                input.innerHTML = '<option value="">Pilih...</option>';
                            }
                            break;
                        default:
                            input = document.createElement('input');
                            input.type = 'text';
                    }
                    
                    input.name = `form_data[${fieldName}]`;
                    input.id = `form_data_${fieldName}`;
                    input.className = 'block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm';
                    input.required = true;
                    
                    // Set old values if available
                    const oldValue = getOldValue(fieldName);
                    if (oldValue) {
                        input.value = oldValue;
                    }
                    
                    fieldDiv.appendChild(label);
                    fieldDiv.appendChild(input);
                    container.appendChild(fieldDiv);
                });
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
        });
    </script>
</x-app-layout>
