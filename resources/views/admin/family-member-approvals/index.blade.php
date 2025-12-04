@extends('layouts.app-bootstrap')

@section('title', 'Persetujuan Anggota Keluarga')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-users-cog me-2"></i>Persetujuan Anggota Keluarga</h1>
                    <p class="mb-0 small">Review dan setujui pengajuan anggota keluarga</p>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total Pengajuan</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Menunggu Review</p>
                            <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Disetujui</p>
                            <h3 class="mb-0">{{ $stats['approved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 rounded p-3">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Ditolak</p>
                            <h3 class="mb-0">{{ $stats['rejected'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.family-member-approvals.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari nama atau NIK..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($familyMembers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Anggota Keluarga</th>
                                <th>Kepala Keluarga</th>
                                <th>Hubungan</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($familyMembers as $member)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary-emphasis">
                                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $member->name }}</div>
                                                <div class="small text-muted">NIK: {{ $member->nik }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($member->user)
                                            <div class="fw-bold">{{ $member->user->name }}</div>
                                            <div class="small text-muted">NIK: {{ $member->user->nik }}</div>
                                        @else
                                            <div class="text-muted fst-italic">Akun belum terhubung</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($member->relationship === 'kepala_keluarga') bg-primary
                                            @elseif($member->relationship === 'istri' || $member->relationship === 'suami') bg-info
                                            @elseif($member->relationship === 'anak') bg-success
                                            @else bg-secondary
                                            @endif">
                                            {{ ucwords(str_replace('_', ' ', $member->relationship)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($member->approval_status === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>Menunggu Review
                                            </span>
                                        @elseif($member->approval_status === 'approved')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Disetujui
                                            </span>
                                        @elseif($member->approval_status === 'rejected')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ $member->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.family-member-approvals.show', $member) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($familyMembers->hasPages())
                    <div class="mt-3">
                        {{ $familyMembers->links() }}
                    </div>
                @endif
            @else
                <div class="text-center p-5">
                    <i class="fas fa-users display-4 text-muted mb-3"></i>
                    <h4 class="mb-2">Tidak ada data</h4>
                    <p class="text-muted mb-3">
                        @if(request('search') || request('status'))
                            Tidak ada pengajuan yang sesuai dengan filter.
                        @else
                            Belum ada pengajuan anggota keluarga.
                        @endif
                    </p>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.family-member-approvals.index') }}" class="btn btn-primary">
                            <i class="fas fa-redo me-1"></i>Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
