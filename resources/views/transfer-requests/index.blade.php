<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <span>Pengajuan Perpindahan Saya</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Alamat Tujuan</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $r)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $r->id }}</td>
                                <td class="px-4 py-2">{{ $r->familyMember->name }}</td>
                                <td class="px-4 py-2">{{ $r->to_address }}</td>
                                <td class="px-4 py-2">{{ $r->status }}</td>
                                <td class="px-4 py-2"><a href="{{ route('transfer-requests.show', $r) }}" class="text-blue-600">Lihat</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sidebar-layout>
