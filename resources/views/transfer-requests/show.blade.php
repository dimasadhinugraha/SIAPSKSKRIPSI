<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <span>Detail Pengajuan Perpindahan</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-4">{{ $transferRequest->familyMember->name }} ({{ $transferRequest->familyMember->nik }})</h2>
                <p><strong>Alamat Tujuan:</strong> {{ $transferRequest->to_address }}</p>
                <p><strong>No. KK Tujuan:</strong> {{ $transferRequest->to_kk_number }}</p>
                <p class="mt-4"><strong>Alasan:</strong><br>{{ $transferRequest->reason }}</p>
                <p class="mt-4"><strong>Status:</strong> {{ $transferRequest->status }}</p>
            </div>
        </div>
    </div>
</x-sidebar-layout>
