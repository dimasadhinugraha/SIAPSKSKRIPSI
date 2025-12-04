<x-sidebar-layout>
    <x-slot name="header">
        💬 {{ $chat->getTitleForUser(auth()->id()) }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Chat Header -->
                <div class="bg-green-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('chat.index') }}" class="text-white hover:text-green-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $chat->getTitleForUser(auth()->id()) }}</h3>
                            <p class="text-green-100 text-sm">
                                @if($chat->type === 'private')
                                    Chat Private
                                @elseif($chat->type === 'group')
                                    {{ $participants->count() }} peserta
                                @else
                                    Pengumuman
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if($chat->type === 'group' && ($chat->created_by === auth()->id() || auth()->user()->role === 'admin'))
                            <button onclick="openParticipantsModal()" class="text-white hover:text-green-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </button>
                        @endif
                        
                        <button onclick="openInfoModal()" class="text-white hover:text-green-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="h-96 overflow-y-auto p-6" id="messagesContainer">
                    @forelse($messages as $message)
                        @php
                            $currentUserId = auth()->user()->getKey(); // Get primary key
                            $messageUserId = $message->user_id;
                            $isMyMessage = ($messageUserId == $currentUserId);
                        @endphp
                        
                        {{-- Debug: User {{ $currentUserId }} vs Message {{ $messageUserId }} = {{ $isMyMessage ? 'MINE' : 'OTHER' }} --}}

                        @if($isMyMessage)
                            <!-- My Messages (Right Side) -->
                            <div class="w-full mb-4" style="display: flex; justify-content: flex-end;">
                                <div class="max-w-xs lg:max-w-md" style="margin-left: auto;">
                                    <div class="px-4 py-2 rounded-lg bg-green-600 text-white rounded-br-none">
                                        @if($message->type === 'image')
                                            <img src="{{ $message->getFileUrl() }}" alt="{{ $message->file_name }}" class="max-w-full h-auto rounded mb-2">
                                        @elseif($message->type === 'file')
                                            <div class="flex items-center space-x-2 mb-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <a href="{{ route('chat.download-file', $message) }}" class="underline text-white">{{ $message->file_name }}</a>
                                            </div>
                                        @endif

                                        @if($message->message)
                                            <p class="text-sm">{{ $message->message }}</p>
                                        @endif
                                    </div>

                                    <div class="text-xs text-gray-400 mt-1 text-right">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Other Messages (Left Side) -->
                            <div class="w-full mb-4" style="display: flex; justify-content: flex-start;">
                                <div class="max-w-xs lg:max-w-md" style="margin-right: auto;">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-gray-600">
                                                {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $message->user->name }}</span>
                                    </div>

                                    <div class="px-4 py-2 rounded-lg bg-gray-200 text-gray-900 rounded-bl-none">
                                        @if($message->type === 'image')
                                            <img src="{{ $message->getFileUrl() }}" alt="{{ $message->file_name }}" class="max-w-full h-auto rounded mb-2">
                                        @elseif($message->type === 'file')
                                            <div class="flex items-center space-x-2 mb-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <a href="{{ route('chat.download-file', $message) }}" class="underline text-gray-700">{{ $message->file_name }}</a>
                                            </div>
                                        @endif

                                        @if($message->message)
                                            <p class="text-sm">{{ $message->message }}</p>
                                        @endif
                                    </div>

                                    <div class="text-xs text-gray-400 mt-1 text-left">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p>Belum ada pesan. Mulai percakapan!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="border-t border-gray-200 p-4">
                    <form id="messageForm" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-end space-x-3">
                            <div class="flex-1">
                                <textarea name="message" 
                                         id="messageInput"
                                         rows="1" 
                                         class="w-full border-gray-300 rounded-lg resize-none focus:ring-green-500 focus:border-green-500"
                                         placeholder="Ketik pesan..."
                                         onkeydown="handleKeyDown(event)"></textarea>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <label for="fileInput" class="cursor-pointer text-gray-500 hover:text-green-600 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </label>
                                <input type="file" id="fileInput" name="file" class="hidden" onchange="handleFileSelect(event)">
                                
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div id="filePreview" class="mt-2 hidden">
                            <div class="flex items-center space-x-2 p-2 bg-gray-100 rounded">
                                <span id="fileName" class="text-sm text-gray-700"></span>
                                <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Modal -->
    <div id="infoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Info Chat</h3>
                    <button onclick="closeInfoModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <p class="text-sm text-gray-900">{{ $chat->title }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis</label>
                        <p class="text-sm text-gray-900">
                            @if($chat->type === 'private')
                                Chat Private
                            @elseif($chat->type === 'group')
                                Group Chat
                            @else
                                Pengumuman
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dibuat oleh</label>
                        <p class="text-sm text-gray-900">{{ $chat->creator->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peserta ({{ $participants->count() }})</label>
                        <div class="mt-2 space-y-2">
                            @foreach($participants as $participant)
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-600">
                                            {{ strtoupper(substr($participant->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ $participant->name }}</span>
                                    @if($participant->id === $chat->created_by)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Creator</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    @if($chat->created_by !== auth()->id() && $chat->type !== 'announcement')
                        <form method="POST" action="{{ route('chat.leave', $chat) }}">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                                Keluar dari Chat
                            </button>
                        </form>
                    @endif
                    <button onclick="closeInfoModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let messagesContainer = document.getElementById('messagesContainer');
        
        // Scroll to bottom on load
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Handle form submission
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });

        function handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function sendMessage() {
            const form = document.getElementById('messageForm');
            const formData = new FormData(form);
            const messageInput = document.getElementById('messageInput');
            
            if (!formData.get('message').trim() && !formData.get('file')) {
                return;
            }

            fetch('{{ route("chat.send-message", $chat) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageInput.value = '';
                        messageInput.focus();
                        removeFile();
                        // Append the new message to container without full reload
                        const msg = data.message;
                        const container = document.getElementById('messagesContainer');
                        const wrapper = document.createElement('div');
                        wrapper.className = 'w-full mb-4';
                        wrapper.style.display = 'flex';
                        wrapper.style.justifyContent = 'flex-end';

                        const inner = document.createElement('div');
                        inner.className = 'max-w-xs lg:max-w-md';
                        inner.style.marginLeft = 'auto';

                        const bubble = document.createElement('div');
                        bubble.className = 'px-4 py-2 rounded-lg bg-green-600 text-white rounded-br-none';
                        bubble.innerHTML = msg.message ? '<p class="text-sm">'+msg.message+'</p>' : '';

                        inner.appendChild(bubble);
                        const time = document.createElement('div');
                        time.className = 'text-xs text-gray-400 mt-1 text-right';
                        time.textContent = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        inner.appendChild(time);

                        wrapper.appendChild(inner);
                        container.appendChild(wrapper);
                        container.scrollTop = container.scrollHeight;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageInput.value = '';
                });
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function loadMessages() {
            // Only reload after sending a message, not for auto-refresh
            // We'll implement proper message loading later if needed
        }

        function updateMessagesDisplay(messages) {
            // Disabled auto-update to prevent constant reloading
            // Messages will update when page is refreshed manually
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('filePreview').classList.remove('hidden');
            }
        }

        function removeFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('filePreview').classList.add('hidden');
        }

        function openInfoModal() {
            document.getElementById('infoModal').classList.remove('hidden');
        }

        function closeInfoModal() {
            document.getElementById('infoModal').classList.add('hidden');
        }

        // Start polling for new messages (every 3s)
        let showPoll = setInterval(() => {
            fetch('{{ route('chat.get-messages', $chat) }}')
                .then(r => r.json())
                .then(messages => {
                    const container = document.getElementById('messagesContainer');
                    // simple approach: re-render if new messages found
                    const existingIds = Array.from(container.querySelectorAll('[data-message-id]')).map(el => parseInt(el.getAttribute('data-message-id')));
                    const maxExisting = existingIds.length ? Math.max(...existingIds) : 0;
                    const newMessages = messages.filter(m => m.id > maxExisting);
                    if (newMessages.length) {
                        newMessages.forEach(message => {
                            const isMyMessage = message.user.id === {{ auth()->user()->getKey() }};
                            const wrapper = document.createElement('div');
                            wrapper.className = 'w-full mb-4';
                            wrapper.setAttribute('data-message-id', message.id);
                            wrapper.style.display = 'flex';
                            wrapper.style.justifyContent = isMyMessage ? 'flex-end' : 'flex-start';

                            const inner = document.createElement('div');
                            inner.className = 'max-w-xs lg:max-w-md';
                            if (isMyMessage) inner.style.marginLeft = 'auto'; else inner.style.marginRight = 'auto';

                            const bubble = document.createElement('div');
                            bubble.className = isMyMessage ? 'px-4 py-2 rounded-lg bg-green-600 text-white rounded-br-none' : 'px-4 py-2 rounded-lg bg-gray-200 text-gray-900 rounded-bl-none';
                            if (message.type === 'image') {
                                const img = document.createElement('img');
                                img.src = message.file_url || message.file_path || '';
                                img.alt = message.file_name || '';
                                img.className = 'max-w-full h-auto rounded mb-2';
                                bubble.appendChild(img);
                            } else if (message.type === 'file') {
                                const fileDiv = document.createElement('div');
                                fileDiv.className = 'flex items-center space-x-2 mb-2';
                                fileDiv.innerHTML = `<a href="/chat/download/${message.id}" class="underline ${isMyMessage ? 'text-white' : 'text-gray-700'}">${message.file_name}</a>`;
                                bubble.appendChild(fileDiv);
                            }

                            if (message.message) {
                                const p = document.createElement('p');
                                p.className = 'text-sm';
                                p.textContent = message.message;
                                bubble.appendChild(p);
                            }

                            inner.appendChild(bubble);
                            const time = document.createElement('div');
                            time.className = 'text-xs text-gray-400 mt-1 ' + (isMyMessage ? 'text-right' : 'text-left');
                            time.textContent = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                            inner.appendChild(time);

                            wrapper.appendChild(inner);
                            container.appendChild(wrapper);
                        });
                        container.scrollTop = container.scrollHeight;
                    }
                })
                .catch(err => console.error('Polling error', err));
        }, 500);
    </script>
</x-sidebar-layout>
