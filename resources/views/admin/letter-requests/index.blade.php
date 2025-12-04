@extends('layouts.app-bootstrap')

@section('title', 'Manajemen Pengajuan Surat')

@push('styles')
<style>
    .stat-card {
        border-left: 4px solid;
    }
    .stat-card.border-primary { border-color: #0d6efd; }
    .stat-card.border-warning { border-color: #ffc107; }
    .stat-card.border-info { border-color: #0dcaf0; }
    .stat-card.border-success { border-color: #198754; }
    .stat-card.border-danger { border-color: #dc3545; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-file-alt me-2"></i>Manajemen Pengajuan Surat</h1>
                    <p class="mb-0 small">Kelola dan pantau semua pengajuan surat dari warga.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg col-md-6">
            <div class="card shadow-sm stat-card border-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-file-alt fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6">
            <div class="card shadow-sm stat-card border-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-clock fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted small">Pending RT</div>
                        <div class="fs-4 fw-bold">{{ $stats['pending_rt'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6">
            <div class="card shadow-sm stat-card border-info h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-hourglass-half fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted small">Pending RW</div>
                        <div class="fs-4 fw-bold">{{ $stats['pending_rw'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6">
            <div class="card shadow-sm stat-card border-success h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-check-circle fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted small">Disetujui</div>
                        <div class="fs-4 fw-bold">{{ $stats['approved'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6">
            <div class="card shadow-sm stat-card border-danger h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-times-circle fs-5"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-muted small">Ditolak</div>
                        <div class="fs-4 fw-bold">{{ $stats['rejected'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.letter-requests.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Cari</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nomor surat, nama, NIK" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending_rt" {{ request('status') === 'pending_rt' ? 'selected' : '' }}>Pending RT</option>
                            <option value="pending_rw" {{ request('status') === 'pending_rw' ? 'selected' : '' }}>Pending RW</option>
                            <option value="approved_final" {{ request('status') === 'approved_final' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected_rt" {{ request('status') === 'rejected_rt' ? 'selected' : '' }}>Ditolak RT</option>
                            <option value="rejected_rw" {{ request('status') === 'rejected_rw' ? 'selected' : '' }}>Ditolak RW</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.letter-requests.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt me-1"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Letter Requests Table -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Pengajuan Surat</h5>
        </div>
        <div class="card-body">
            @if($requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nomor Surat</th>
                                <th>Pemohon</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td class="fw-medium">{{ $request->request_number }}</td>
                                    <td>
                                        <div>{{ $request->user->name }}</div>
                                        <small class="text-muted">{{ $request->user->nik }}</small>
                                    </td>
                                    <td>{{ $request->letterType->name }}</td>
                                    <td>
                                        @php
                                            $statusBadges = [
                                                'pending_rt' => 'bg-warning text-dark',
                                                'pending_rw' => 'bg-info text-dark',
                                                'approved_final' => 'bg-success',
                                                'rejected_rt' => 'bg-danger',
                                                'rejected_rw' => 'bg-danger',
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusBadges[$request->status] ?? 'bg-secondary' }}">
                                            {{ $request->status_label }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.letter-requests.show', $request) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $requests->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada pengajuan surat</h5>
                    <p class="text-muted">Belum ada pengajuan surat yang sesuai dengan filter.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
