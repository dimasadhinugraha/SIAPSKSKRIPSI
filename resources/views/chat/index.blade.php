<x-sidebar-layout>
    <x-slot name="header">
        💬 Chat & Komunikasi
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Actions -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">💬 Chat dengan Warga</h2>
                <p class="text-gray-600 mt-1">Pilih warga yang ingin Anda ajak chat</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($users as $user)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors cursor-pointer"
                                     onclick="startChat({{ $user->id }})">
                                    <div class="flex items-center space-x-4">
                                        <!-- User Avatar -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-lg font-semibold text-green-600">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- User Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-lg font-medium text-gray-900 truncate">{{ $user->name }}</h3>
                                                @if($user->unread_count > 0)
                                                    <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                                                        {{ $user->unread_count > 99 ? '99+' : $user->unread_count }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $user->role_label }}
                                                </span>
                                                <span class="text-xs text-gray-500">{{ $user->rt_rw }}</span>
                                            </div>

                                            @if($user->last_message)
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-600 truncate">
                                                        @if($user->last_message->type === 'file' || $user->last_message->type === 'image')
                                                            📎 {{ $user->last_message->file_name }}
                                                        @else
                                                            {{ $user->last_message->message }}
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        {{ $user->last_message->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-500 mt-2">Belum ada percakapan</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada warga lain</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada warga lain yang terdaftar di sistem.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function startChat(userId) {
            // Redirect to start private chat route
            window.location.href = `/chat/start-private/${userId}`;
        }
    </script>
</x-sidebar-layout>
