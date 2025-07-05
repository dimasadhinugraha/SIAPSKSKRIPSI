<x-sidebar-layout>
    <x-slot name="header">
        📰 Manajemen Berita
    </x-slot>

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">📰 Manajemen Berita</h1>
                    <p class="text-gray-600 mt-1">Kelola berita dan informasi desa</p>
                </div>
                <a href="{{ route('admin.news.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Berita
                </a>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Berita</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Total: {{ $news->total() }} berita
                        </p>
                    </div>

                    @if($news->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Judul
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Penulis
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($news as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if($item->featured_image)
                                                        <img src="{{ Storage::url($item->featured_image) }}" 
                                                             alt="{{ $item->title }}" 
                                                             class="w-10 h-10 object-cover rounded mr-3">
                                                    @else
                                                        <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item->title }}</div>
                                                        @if($item->excerpt)
                                                            <div class="text-sm text-gray-500 line-clamp-1">{{ $item->excerpt }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
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
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $categoryColors[$item->category] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $categoryLabels[$item->category] ?? ucfirst($item->category) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $item->status === 'published' ? 'Dipublikasi' : 'Draft' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->author->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($item->published_at)
                                                    {{ $item->published_at->format('d/m/Y') }}
                                                @else
                                                    {{ $item->created_at->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    @if($item->status === 'published')
                                                        <a href="{{ route('news.show', $item) }}" 
                                                           class="text-blue-600 hover:text-blue-900" target="_blank">
                                                            Lihat
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('admin.news.edit', $item) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.news.destroy', $item) }}" 
                                                          class="inline" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $news->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada berita</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat berita pertama.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.news.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Tambah Berita
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-sidebar-layout>
