@extends('layouts.app-bootstrap')

@section('title', 'Data Anggota Keluarga')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0"><i class="fas fa-users me-2"></i>Data Anggota Keluarga</h1>
                    <p class="mb-0 small">Kelola data anggota keluarga Anda</p>
                </div>
                <a href="{{ route('family-members.create') }}" class="btn btn-light text-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Anggota
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    
    @if($familyMembers->count() > 0)
        <!-- Stats Cards: two per row on small screens, four per row on md+ -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                           <i class="fas fa-users fa-fw"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total</div>
                            <div class="fw-bold h5 mb-0">{{ $stats['total'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3">
                           <i class="fas fa-check-circle fa-fw"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Disetujui</div>
                            <div class="fw-bold h5 mb-0">{{ $stats['approved'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                 <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-3">
                           <i class="fas fa-clock fa-fw"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Menunggu</div>
                            <div class="fw-bold h5 mb-0">{{ $stats['pending'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 text-danger p-2 rounded-circle me-3">
                           <i class="fas fa-times-circle fa-fw"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Ditolak</div>
                            <div class="fw-bold h5 mb-0">{{ $stats['rejected'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Family Member Cards -->
        <div class="row g-4">
            @foreach($familyMembers as $member)
                 @php
                    $statusConfig = [
                        'pending' => ['border' => 'border-warning', 'badge' => 'bg-warning text-dark'],
                        'approved' => ['border' => 'border-success', 'badge' => 'bg-success'],
                        'rejected' => ['border' => 'border-danger', 'badge' => 'bg-danger'],
                        'default' => ['border' => 'border-secondary', 'badge' => 'bg-secondary'],
                    ];
                    $config = $statusConfig[$member->approval_status] ?? $statusConfig['default'];
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm {{ $config['border'] }} border-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold">{{ $member->name }}</span>
                             <span class="badge rounded-pill {{ $config['badge'] }}">
                                <i class="fas {{ $member->approval_status === 'approved' ? 'fa-check' : ($member->approval_status === 'pending' ? 'fa-clock' : 'fa-times') }} me-1"></i>
                                {{ $member->approval_status_label }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-id-card fa-fw me-2"></i>NIK: {{ $member->nik }}
                            </p>
                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-birthday-cake fa-fw me-2"></i>{{ $member->age }} tahun ({{ \Carbon\Carbon::parse($member->date_of_birth)->format('d/m/Y') }})
                            </p>
                            <p class="card-text text-muted">
                                <i class="fas fa-user-friends fa-fw me-2"></i>{{ $member->relationship_label }}
                            </p>

                             @if($member->approval_status === 'rejected' && $member->rejection_reason)
                                <button type="button" class="btn btn-sm btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#rejectionModal" data-bs-reason="{{ $member->rejection_reason }}">
                                    <i class="fas fa-info-circle me-1"></i>Lihat Alasan Ditolak
                                </button>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('family-members.show', $member) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-search me-2"></i>Detail
                                </a>
                                <form action="{{ route('family-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota keluarga ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-trash-alt me-2"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="card text-center shadow-sm">
            <div class="card-body p-5">
                <div class="display-4 text-primary mb-3">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="card-title">Belum Ada Anggota Keluarga</h3>
                <p class="card-text text-muted mb-4">Mulai tambahkan data anggota keluarga Anda untuk melengkapi informasi keluarga.</p>
                <a href="{{ route('family-members.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Anggota Keluarga
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Rejection Reason Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectionModalLabel"><i class="fas fa-times-circle me-2"></i>Alasan Penolakan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="rejectionReasonText" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                 <a href="{{ route('family-members.create') }}" class="btn btn-primary">
                    Ajukan Ulang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const rejectionModal = document.getElementById('rejectionModal');
    if (rejectionModal) {
        rejectionModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const reason = button.getAttribute('data-bs-reason');
            const modalBody = rejectionModal.querySelector('#rejectionReasonText');
            modalBody.textContent = reason;
        });
    }
</script>
@endpush