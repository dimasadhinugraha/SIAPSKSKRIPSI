<x-sidebar-layout>
    <x-slot name="header">
        💬 Buat Chat Baru
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('chat.store') }}" id="chatForm">
                        @csrf

                        <!-- Chat Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Jenis Chat</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                                    <input type="radio" name="type" value="private" id="private" class="sr-only" checked>
                                    <label for="private" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-colors chat-type-option">
                                        <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Private Chat</span>
                                        <span class="text-xs text-gray-500 text-center">Chat dengan 1 orang</span>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="radio" name="type" value="group" id="group" class="sr-only">
                                    <label for="group" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-colors chat-type-option">
                                        <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Group Chat</span>
                                        <span class="text-xs text-gray-500 text-center">Chat dengan banyak orang</span>
                                    </label>
                                </div>

                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'rt' || auth()->user()->role === 'rw')
                                <div class="relative">
                                    <input type="radio" name="type" value="announcement" id="announcement" class="sr-only">
                                    <label for="announcement" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition-colors chat-type-option">
                                        <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Pengumuman</span>
                                        <span class="text-xs text-gray-500 text-center">Broadcast ke warga</span>
                                    </label>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Chat Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Chat</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                                   placeholder="Masukkan judul chat"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Participants Selection -->
                        <div class="mb-6" id="participantsSection">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Peserta</label>
                            <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-lg">
                                @foreach($users as $user)
                                    <div class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                        <input type="checkbox" 
                                               name="participants[]" 
                                               value="{{ $user->id }}" 
                                               id="user_{{ $user->id }}"
                                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded participant-checkbox">
                                        <label for="user_{{ $user->id }}" class="ml-3 flex-1 cursor-pointer">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <span class="text-xs font-medium text-gray-600">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $user->role_label }} - {{ $user->rt_rw }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('participants')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('chat.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Buat Chat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatTypeInputs = document.querySelectorAll('input[name="type"]');
            const participantsSection = document.getElementById('participantsSection');
            const participantCheckboxes = document.querySelectorAll('.participant-checkbox');
            const titleInput = document.getElementById('title');

            function updateFormBasedOnType() {
                const selectedType = document.querySelector('input[name="type"]:checked').value;
                
                // Update visual selection
                document.querySelectorAll('.chat-type-option').forEach(option => {
                    option.classList.remove('border-green-500', 'bg-green-50');
                    option.classList.add('border-gray-200');
                });
                
                const selectedOption = document.querySelector(`input[name="type"]:checked`).nextElementSibling;
                selectedOption.classList.remove('border-gray-200');
                selectedOption.classList.add('border-green-500', 'bg-green-50');

                // Update participants section visibility and validation
                if (selectedType === 'announcement') {
                    participantsSection.style.display = 'none';
                    participantCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.removeAttribute('required');
                    });
                } else {
                    participantsSection.style.display = 'block';
                    
                    if (selectedType === 'private') {
                        // For private chat, limit to 1 participant
                        participantCheckboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                if (this.checked) {
                                    participantCheckboxes.forEach(other => {
                                        if (other !== this) other.checked = false;
                                    });
                                }
                            });
                        });
                    } else {
                        // For group chat, allow multiple
                        participantCheckboxes.forEach(checkbox => {
                            checkbox.removeEventListener('change', function() {});
                        });
                    }
                }

                // Update title placeholder
                if (selectedType === 'private') {
                    titleInput.placeholder = 'Chat dengan...';
                } else if (selectedType === 'group') {
                    titleInput.placeholder = 'Nama grup chat';
                } else {
                    titleInput.placeholder = 'Judul pengumuman';
                }
            }

            // Initialize
            updateFormBasedOnType();

            // Listen for type changes
            chatTypeInputs.forEach(input => {
                input.addEventListener('change', updateFormBasedOnType);
            });

            // Form validation
            document.getElementById('chatForm').addEventListener('submit', function(e) {
                const selectedType = document.querySelector('input[name="type"]:checked').value;
                const checkedParticipants = document.querySelectorAll('.participant-checkbox:checked');

                if (selectedType !== 'announcement' && checkedParticipants.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal 1 peserta untuk chat.');
                    return false;
                }

                if (selectedType === 'private' && checkedParticipants.length > 1) {
                    e.preventDefault();
                    alert('Chat private hanya bisa dengan 1 orang.');
                    return false;
                }
            });
        });
    </script>
</x-sidebar-layout>
