<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Article Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            @php
                                $categoryColors = [
                                    'news' => 'bg-blue-100 text-blue-800',
                                    'announcement' => 'bg-yellow-100 text-yellow-800',
                                    'event' => 'bg-green-100 text-green-800',
                                ];
                                $categoryLabels = [
                                    'news' => 'Berita',
                                    'announcement' => 'Pengumuman',
                                    'event' => 'Kegiatan',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $categoryColors[$news->category] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $categoryLabels[$news->category] ?? ucfirst($news->category) }}
                            </span>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.news.edit', $news) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Edit
                                </a>
                                <a href="{{ route('admin.news.index') }}" 
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                                    Kembali
                                </a>
                            </div>
                        </div>
                        
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
                        
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="mr-4">Oleh: {{ $news->author->name }}</span>
                            
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="mr-4">
                                @if($news->published_at)
                                    {{ $news->published_at->format('d F Y, H:i') }} WIB
                                @else
                                    Belum dipublikasi
                                @endif
                            </span>
                            
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $news->status === 'published' ? 'Dipublikasi' : 'Draft' }}
                            </span>
                        </div>
                        
                        @if($news->excerpt)
                            <div class="bg-gray-50 border-l-4 border-blue-500 p-4 mb-6">
                                <p class="text-gray-700 font-medium italic">{{ $news->excerpt }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Featured Image -->
                    @if($news->featured_image)
                        <div class="mb-6">
                            <img src="{{ Storage::url($news->featured_image) }}" 
                                 alt="{{ $news->title }}" 
                                 class="w-full h-auto rounded-lg shadow-md">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    <!-- Article Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="text-sm text-gray-600">
                                <h4 class="font-medium text-gray-900 mb-2">Informasi Artikel</h4>
                                <p><strong>Dibuat:</strong> {{ $news->created_at->format('d F Y, H:i') }} WIB</p>
                                @if($news->updated_at != $news->created_at)
                                    <p><strong>Diperbarui:</strong> {{ $news->updated_at->format('d F Y, H:i') }} WIB</p>
                                @endif
                                @if($news->published_at)
                                    <p><strong>Dipublikasi:</strong> {{ $news->published_at->format('d F Y, H:i') }} WIB</p>
                                @endif
                                <p><strong>Slug:</strong> {{ $news->slug }}</p>
                            </div>
                            
                            <div class="text-sm text-gray-600">
                                <h4 class="font-medium text-gray-900 mb-2">Aksi</h4>
                                <div class="space-y-2">
                                    @if($news->status === 'published')
                                        <a href="{{ route('news.show', $news) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7l10 10M17 7l-10 10"></path>
                                            </svg>
                                            Lihat di Website
                                        </a>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('admin.news.destroy', $news) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus Berita
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
