<x-sidebar-layout>
    <x-slot name="header">
        🔍 Persetujuan Anggota Keluarga
    </x-slot>

    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">🔍 Persetujuan Anggota Keluarga</h1>
                    <p class="text-gray-600 mt-1">Review dan setujui pengajuan anggota keluarga</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $familyMembers->total() }} total pengajuan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-600 text-2xl">📊</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Pengajuan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <span class="text-yellow-600 text-2xl">⏳</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Menunggu Review</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-600 text-2xl">✅</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <span class="text-red-600 text-2xl">❌</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ditolak</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <form method="GET" action="{{ route('admin.family-member-approvals.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari nama, NIK, atau nama pengaju..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full md:w-48">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" 
                                id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            🔍 Filter
                        </button>
                    </div>
                </form>
            </div>

            @if($familyMembers->count() > 0)
                <!-- Family Members Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Pengajuan Anggota Keluarga</h3>
                        
                        @if($familyMembers->where('approval_status', 'pending')->count() > 0)
                            <form action="{{ route('admin.family-member-approvals.bulk-approve') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Setujui semua pengajuan yang dipilih?')"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                                    ✅ Setujui Terpilih
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Anggota Keluarga
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengaju
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hubungan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($familyMembers as $member)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($member->approval_status === 'pending')
                                                <input type="checkbox" name="family_member_ids[]" value="{{ $member->id }}" class="rounded border-gray-300 member-checkbox">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                                        <span class="text-white font-medium text-sm">
                                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                                    <div class="text-sm text-gray-500">NIK: {{ $member->nik }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $member->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $member->user->rt_rw }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($member->relationship === 'kepala_keluarga') bg-blue-100 text-blue-800
                                                @elseif(in_array($member->relationship, ['istri', 'suami'])) bg-green-100 text-green-800
                                                @elseif($member->relationship === 'anak') bg-purple-100 text-purple-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $member->relationship_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->status_badge_color }}">
                                                @if($member->approval_status === 'pending')
                                                    ⏳ {{ $member->approval_status_label }}
                                                @elseif($member->approval_status === 'approved')
                                                    ✅ {{ $member->approval_status_label }}
                                                @else
                                                    ❌ {{ $member->approval_status_label }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.family-member-approvals.show', $member) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                
                                                @if($member->approval_status === 'pending')
                                                    <form action="{{ route('admin.family-member-approvals.approve', $member) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                onclick="return confirm('Setujui anggota keluarga ini?')"
                                                                class="text-green-600 hover:text-green-900 transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $familyMembers->links() }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">👨‍👩‍👧‍👦</div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak Ada Pengajuan</h3>
                    <p class="text-gray-600">Belum ada pengajuan anggota keluarga yang perlu direview.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.member-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Update bulk approve form
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('member-checkbox')) {
                const form = document.querySelector('form[action*="bulk-approve"]');
                const checkedBoxes = document.querySelectorAll('.member-checkbox:checked');
                
                // Update form with selected IDs
                const existingInputs = form.querySelectorAll('input[name="family_member_ids[]"]');
                existingInputs.forEach(input => input.remove());
                
                checkedBoxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'family_member_ids[]';
                    input.value = checkbox.value;
                    form.appendChild(input);
                });
            }
        });
    </script>
</x-sidebar-layout>
