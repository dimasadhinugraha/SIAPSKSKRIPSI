<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <span>Detail Pengajuan Perpindahan</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-4">{{ $transferRequest->familyMember->name }} ({{ $transferRequest->familyMember->nik }})</h2>
                <p><strong>Requester:</strong> {{ $transferRequest->requester->name }}</p>
                <p><strong>Alamat Tujuan:</strong> {{ $transferRequest->to_address }}</p>
                <p><strong>No. KK Tujuan:</strong> {{ $transferRequest->to_kk_number }}</p>
                <p class="mt-4"><strong>Alasan:</strong><br>{{ $transferRequest->reason }}</p>

                <div class="mt-6 flex space-x-3">
                    @if($transferRequest->status === 'pending')
                        <form action="{{ route('admin.transfer-requests.approve', $transferRequest) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-600 text-white px-4 py-2 rounded">Setujui</button>
                        </form>
                        <form action="{{ route('admin.transfer-requests.reject', $transferRequest) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-red-600 text-white px-4 py-2 rounded">Tolak</button>
                        </form>
                    @else
                        <span class="px-3 py-1 bg-gray-100 rounded">Status: {{ $transferRequest->status }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
