@extends('layouts.app-bootstrap')

@section('title', 'Chat & Komunikasi')

@push('styles')
<style>
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    .list-group-item.active {
        background-color: var(--bs-primary-bg-subtle);
        border-color: var(--bs-primary-border-subtle);
    }
    #messages-container .card {
        border-radius: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row" style="height: calc(100vh - 88px);">
        <!-- User List -->
        <div class="col-md-4 border-end">
            <div class="p-3 border-bottom">
                <h4 class="mb-0">Percakapan</h4>
            </div>
            <div class="list-group list-group-flush overflow-auto" style="height: calc(100% - 60px);">
                @forelse($users as $user)
                    <a href="#" class="list-group-item list-group-item-action" onclick="openChat({{ $user->id }})">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <span class="avatar-title rounded-circle bg-success-subtle text-success-emphasis">
                                        {{ $user->initials }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    @if($user->unread_count > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $user->unread_count }}</span>
                                    @endif
                                </div>
                                @if($user->last_message)
                                    <small class="text-muted text-truncate">{{ $user->last_message->message }}</small>
                                @else
                                    <small class="text-muted">Belum ada percakapan</small>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted">
                        Belum ada pengguna lain.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Window -->
        <div class="col-md-8 d-flex flex-column">
            <div id="chat-window" class="card flex-grow-1" style="display: none;">
                <!-- Chat Header -->
                <div class="card-header d-flex align-items-center p-3">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <span id="chat-user-initial" class="avatar-title rounded-circle bg-primary-subtle text-primary-emphasis"></span>
                        </div>
                    </div>
                    <div>
                        <h5 id="chat-user-name" class="mb-0"></h5>
                        <small class="text-muted">Online</small>
                    </div>
                </div>

                <!-- Messages -->
                <div id="messages-container" class="card-body overflow-auto p-4" style="background-color: #f5f5f5;">
                    <!-- Messages will be loaded here -->
                </div>

                <!-- Message Input -->
                <div class="card-footer p-3">
                    <form id="message-form" class="d-flex align-items-center">
                        <input type="hidden" id="chat-id" name="chat_id">
                        <input type="text" id="message-input" name="message" placeholder="Ketik pesan..." class="form-control form-control-lg rounded-pill">
                        <button type="submit" class="btn btn-primary btn-lg rounded-circle ms-3">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div id="select-chat-placeholder" class="d-flex flex-grow-1 align-items-center justify-content-center">
                <div class="text-center text-muted">
                    <i class="fas fa-comments fa-4x mb-4"></i>
                    <h4>Pilih percakapan untuk memulai</h4>
                    <p>Pilih pengguna dari daftar di sebelah kiri untuk melihat pesan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentUserId = null;
    let pollInterval = null;
    let lastMessageId = 0;

    function openChat(userId) {
        if (currentUserId) {
            document.querySelector(`[onclick="openChat(${currentUserId})"]`).classList.remove('active');
        }
        currentUserId = userId;
        document.querySelector(`[onclick="openChat(${userId})"]`).classList.add('active');

        document.getElementById('select-chat-placeholder').style.display = 'none';
        document.getElementById('chat-window').style.display = 'flex';

        fetch(`/chat/with/${userId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('chat-user-name').textContent = data.user.name;
                document.getElementById('chat-user-initial').textContent = data.user.initials;
                document.getElementById('chat-id').value = data.chat_id;

                const messagesContainer = document.getElementById('messages-container');
                messagesContainer.innerHTML = ''; // Clear previous messages

                data.messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('d-flex', 'mb-4', message.user.id === {{ auth()->id() }} ? 'justify-content-end' : 'justify-content-start');
                    
                    let content = `
                        <div class="card w-75 ${ message.user.id === {{ auth()->id() }} ? 'bg-primary text-white' : '' }">
                            <div class="card-body p-3">
                                <p class="mb-0">${message.message}</p>
                                <small class="text-muted d-block text-end">${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>
                            </div>
                        </div>
                    `;

                    if(message.user.id !== {{ auth()->id() }}) {
                         content = `
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <span class="avatar-title rounded-circle bg-secondary-subtle text-secondary-emphasis">
                                        ${message.user.name.substring(0, 2).toUpperCase()}
                                    </span>
                                </div>
                            </div>
                        ` + content;
                    }

                    messageElement.innerHTML = content;
                    messagesContainer.appendChild(messageElement);
                });

                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                // set lastMessageId to the max id we received
                if (data.messages.length) {
                    lastMessageId = Math.max(...data.messages.map(m => m.id));
                } else {
                    lastMessageId = 0;
                }

                // start polling for new messages
                startPolling(data.chat_id);
            });
    }

    function startPolling(chatId) {
        stopPolling();
        pollInterval = setInterval(() => {
            fetch(`/chat/${chatId}/messages`)
                .then(r => r.json())
                .then(messages => {
                    const container = document.getElementById('messages-container');
                    const newMessages = messages.filter(m => m.id > lastMessageId);
                    if (newMessages.length) {
                        newMessages.forEach(message => {
                            const messageElement = document.createElement('div');
                            messageElement.classList.add('d-flex', 'mb-4', message.user.id === {{ auth()->user()->getKey() }} ? 'justify-content-end' : 'justify-content-start');
                            let content = `
                                <div class="card w-75 ${ message.user.id === {{ auth()->user()->getKey() }} ? 'bg-primary text-white' : '' }">
                                    <div class="card-body p-3">
                                        <p class="mb-0">${message.message}</p>
                                        <small class="text-muted d-block text-end">${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>
                                    </div>
                                </div>
                            `;

                            if(message.user.id !== {{ auth()->user()->getKey() }}) {
                                content = `
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <span class="avatar-title rounded-circle bg-secondary-subtle text-secondary-emphasis">
                                                ${message.user.name.substring(0, 2).toUpperCase()}
                                            </span>
                                        </div>
                                    </div>
                                ` + content;
                            }

                            messageElement.innerHTML = content;
                            container.appendChild(messageElement);
                        });

                        // update lastMessageId and scroll
                        lastMessageId = Math.max(...messages.map(m => m.id));
                        container.scrollTop = container.scrollHeight;
                    }
                })
                .catch(err => console.error('Polling error', err));
        }, 500);
    }

    function stopPolling() {
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
    }

    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const chatId = document.getElementById('chat-id').value;
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value;

        if (!message.trim()) return;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                chat_id: chatId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            const messagesContainer = document.getElementById('messages-container');
            const messageElement = document.createElement('div');
            messageElement.classList.add('d-flex', 'justify-content-end', 'mb-4');
            messageElement.innerHTML = `
                <div class="card w-75 bg-primary text-white">
                    <div class="card-body p-3">
                        <p class="mb-0">${data.message.message}</p>
                        <small class="text-white d-block text-end">${new Date(data.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>
                    </div>
                </div>
            `;
            messagesContainer.appendChild(messageElement);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            messageInput.value = '';
            messageInput.focus();
        })
        .catch(error => {
            console.error('Error:', error);
            messageInput.value = '';
        });
    });
</script>
@endpush
