@extends('layouts.app-bootstrap')

@section('title', 'Verifikasi User')

@push('styles')
<style>
    @media (max-width: 768px) {
        .stats-card .card-body {
            padding: 0.75rem;
        }
        .stats-card .icon-box {
            padding: 0.5rem !important;
        }
        .stats-card .icon-box i {
            font-size: 1.25rem !important;
        }
        .stats-card h3 {
            font-size: 1.25rem;
        }
        .stats-card p {
            font-size: 0.7rem;
        }
        .card-body {
            padding: 1rem;
        }
        .table {
            font-size: 0.85rem;
        }
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-user-check me-2"></i>Verifikasi User</h1>
                    <p class="mb-0 small">Kelola dan verifikasi pendaftaran user baru</p>
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
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded p-2 p-md-3 icon-box">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="text-muted mb-0 small">Total Pengajuan</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded p-2 p-md-3 icon-box">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="text-muted mb-0 small">Menunggu Review</p>
                            <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded p-2 p-md-3 icon-box">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="text-muted mb-0 small">Disetujui</p>
                            <h3 class="mb-0">{{ $stats['verified'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 rounded p-2 p-md-3 icon-box">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="text-muted mb-0 small">Ditolak</p>
                            <h3 class="mb-0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($pendingUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>RT/RW</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $user)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->biodata ? ($user->biodata->gender == 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $user->email ?? '-' }}</div>
                                        <div class="small text-muted">{{ $user->biodata->phone ?? '-' }}</div>
                                    </td>
                                    <td class="text-muted">{{ $user->nik }}</td>
                                    <td class="text-muted">{{ $user->biodata->rt_rw ?? '-' }}</td>
                                    <td class="text-muted small">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.user-verification.show', $user) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($pendingUsers->hasPages())
                    <div class="mt-3">
                        {{ $pendingUsers->links() }}
                    </div>
                @endif
            @else
                <div class="text-center p-5">
                    <i class="fas fa-user-check display-4 text-muted mb-3"></i>
                    <h4 class="mb-2">Tidak ada user menunggu verifikasi</h4>
                    <p class="text-muted mb-3">Semua user telah diverifikasi.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
