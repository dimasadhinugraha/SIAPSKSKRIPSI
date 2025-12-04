<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <span>Buat Pengajuan Perpindahan</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Pengajuan perpindahan untuk: {{ $familyMember->name }} (NIK: {{ $familyMember->nik }})</h2>

                <form action="{{ route('transfer-requests.store', $familyMember) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alamat Tujuan</label>
                        <input type="text" name="to_address" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('to_address') }}">
                        @error('to_address') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">No. KK Tujuan (opsional)</label>
                        <input type="text" name="to_kk_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('to_kk_number') }}">
                        @error('to_kk_number') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Alasan</label>
                        <textarea name="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('reason') }}</textarea>
                        @error('reason') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Dokumen Pendukung (jpg,png,pdf)</label>
                        <input type="file" name="supporting_document" class="mt-1 block w-full">
                        @error('supporting_document') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Kirim Pengajuan</button>
                        <a href="{{ route('family-members.show', $familyMember) }}" class="text-gray-600">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
