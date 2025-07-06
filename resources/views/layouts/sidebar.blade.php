<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Sidebar Styles -->
        <style>
            /* Custom scrollbar for sidebar */
            .sidebar-scroll::-webkit-scrollbar {
                width: 4px;
            }

            .sidebar-scroll::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.1);
            }

            .sidebar-scroll::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
            }

            .sidebar-scroll::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
                <!-- Top Header -->
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex items-center lg:ml-0 ml-16">
                                <!-- Page Title -->
                                @if (isset($header))
                                    <div class="font-semibold text-xl text-gray-800 leading-tight">
                                        {{ $header }}
                                    </div>
                                @endif
                            </div>

                            <!-- Right side header items -->
                            <div class="flex items-center space-x-4">
                                <!-- Notifications -->
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        @php
                                            $pendingUsers = \App\Models\User::where('is_verified', false)->count();
                                            $pendingFamilyMembers = \App\Models\FamilyMember::where('approval_status', 'pending')->count();
                                        @endphp
                                        @if($pendingUsers > 0 || $pendingFamilyMembers > 0)
                                            <div class="relative">
                                                <button class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 17H6l5 5v-5zM7 7h10l-5-5L7 7z" />
                                                    </svg>
                                                </button>
                                                <span class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                                    {{ $pendingUsers + $pendingFamilyMembers }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif

                                    @if(auth()->user()->canApproveLetters())
                                        @php
                                            $pendingLetters = \App\Models\LetterRequest::where('status', 'pending')
                                                ->whereHas('user', function($query) {
                                                    $query->where('rt_rw', auth()->user()->rt_rw);
                                                })->count();
                                        @endphp
                                        @if($pendingLetters > 0)
                                            <div class="relative">
                                                <a href="{{ route('approvals.index') }}" class="p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                                <span class="absolute -top-1 -right-1 h-5 w-5 bg-green-500 text-white text-xs rounded-full flex items-center justify-center">
                                                    {{ $pendingLetters }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                @endauth

                                <!-- User Menu -->
                                @auth
                                    <div class="relative">
                                        <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" id="user-menu-button">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                                                <span class="text-white text-sm font-medium">
                                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden" id="user-menu">
                                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                Profile
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                    </svg>
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content Area -->
                <main class="flex-1 overflow-y-auto">
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <!-- Flash Messages -->
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

                            @if(session('error'))
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(session('warning'))
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Page Content -->
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script>
            // User menu dropdown
            document.addEventListener('DOMContentLoaded', function() {
                const userMenuButton = document.getElementById('user-menu-button');
                const userMenu = document.getElementById('user-menu');

                if (userMenuButton && userMenu) {
                    userMenuButton.addEventListener('click', function() {
                        userMenu.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                            userMenu.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
