<x-sidebar-layout>
    <x-slot name="header">
        <span>{{ __('Tambah Berita Baru') }}
        </span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Form Tambah Berita</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Lengkapi form di bawah untuk menambahkan berita baru.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Judul Berita" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category" value="Kategori" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>Berita</option>
                                <option value="announcement" {{ old('category') == 'announcement' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Kegiatan</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <x-input-label for="excerpt" value="Ringkasan (Opsional)" />
                            <textarea id="excerpt" name="excerpt" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ringkasan singkat berita...">{{ old('excerpt') }}</textarea>
                            <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div>
                            <x-input-label for="content" value="Konten Berita" />
                            <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Tulis konten berita di sini...">{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <x-input-label for="featured_image" value="Gambar Utama (Opsional)" />
                            <input id="featured_image" type="file" name="featured_image" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                            <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                        </div>

                        <!-- Status and Published Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="status" value="Status" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publikasikan</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="published_at" value="Tanggal Publikasi (Opsional)" />
                                <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local" name="published_at" :value="old('published_at')" />
                                <p class="mt-1 text-sm text-gray-500">Kosongkan untuk menggunakan waktu sekarang</p>
                                <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between w-full">
                            <a href="{{ route('admin.news.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Kembali
                            </a>

                            <x-primary-button>
                                Simpan Berita
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
