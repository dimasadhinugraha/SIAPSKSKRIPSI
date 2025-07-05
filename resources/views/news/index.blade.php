<x-sidebar-layout>
    <x-slot name="header">
        <span>{{ __('Berita & Informasi Desa') }}
        </span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Terkini Desa Ciasmara</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Dapatkan informasi terbaru tentang kegiatan, pengumuman, dan berita dari Desa Ciasmara
                        </p>
                    </div>

                    @if($news->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($news as $item)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    @if($item->featured_image)
                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                             alt="{{ $item->title }}" 
                                             class="w-full h-48 object-cover rounded-t-lg">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
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
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $categoryColors[$item->category] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $categoryLabels[$item->category] ?? ucfirst($item->category) }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $item->published_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                            {{ $item->title }}
                                        </h4>
                                        
                                        @if($item->excerpt)
                                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                                {{ $item->excerpt }}
                                            </p>
                                        @endif
                                        
                                        <div class="flex items-center justify-between w-full">
                                            <span class="text-xs text-gray-500">
                                                Oleh: {{ $item->author->name }}
                                            </span>
                                            <a href="{{ route('news.show', $item) }}" 
                                               class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Baca Selengkapnya →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $news->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada berita</h3>
                            <p class="mt-1 text-sm text-gray-500">Berita dan informasi akan ditampilkan di sini.</p>
                        </div>
                    @endif
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
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-sidebar-layout>
