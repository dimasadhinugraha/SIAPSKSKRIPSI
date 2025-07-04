<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $news->title }}
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
                            <a href="{{ route('news.index') }}" 
                               class="text-sm text-gray-600 hover:text-gray-800">
                                ← Kembali ke Berita
                            </a>
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
                            <span>{{ $news->published_at->format('d F Y, H:i') }} WIB</span>
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
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <p>Dipublikasikan: {{ $news->published_at->format('d F Y, H:i') }} WIB</p>
                                @if($news->updated_at != $news->created_at)
                                    <p>Diperbarui: {{ $news->updated_at->format('d F Y, H:i') }} WIB</p>
                                @endif
                            </div>
                            
                            <div class="flex space-x-2">
                                <!-- Share buttons could go here -->
                                <button onclick="window.print()" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related News or Navigation -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Berita Lainnya</h3>
                        @php
                            $relatedNews = App\Models\News::published()
                                ->where('id', '!=', $news->id)
                                ->where('category', $news->category)
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @if($relatedNews->count() > 0)
                            <div class="space-y-4">
                                @foreach($relatedNews as $related)
                                    <div class="flex items-center space-x-4 p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                        @if($related->featured_image)
                                            <img src="{{ Storage::url($related->featured_image) }}" 
                                                 alt="{{ $related->title }}" 
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 line-clamp-2">
                                                <a href="{{ route('news.show', $related) }}" class="hover:text-blue-600">
                                                    {{ $related->title }}
                                                </a>
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $related->published_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Tidak ada berita terkait lainnya.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
