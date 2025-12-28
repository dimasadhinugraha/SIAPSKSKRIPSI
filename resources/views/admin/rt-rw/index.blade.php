@extends('layouts.app-bootstrap')

@section('title', 'Manajemen RT/RW')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-map-marked-alt me-2"></i>Manajemen RT/RW</h1>
                    <p class="mb-0 small">Daftar ketua RT dan RW di desa</p>
                </div>
                <a href="{{ route('admin.rt-rw.create') }}" class="btn btn-light">
                    <i class="fas fa-plus me-2"></i>Tambah RT/RW
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="fas fa-map-marked-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total RT & RW</p>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <i class="fas fa-house-user fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total RT</p>
                            <h3 class="mb-0">{{ $stats['total_rt'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <i class="fas fa-building fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total RW</p>
                            <h3 class="mb-0">{{ $stats['total_rw'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RW Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0"><i class="fas fa-building me-2 text-success"></i>Daftar Ketua RW</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">RW</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Telepon</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rwUsers as $index => $user)
                            @php
                                // Extract RW number from email (rw001@...)
                                preg_match('/rw(\d+)@/', $user->email, $matches);
                                $rwNumber = isset($matches[1]) ? ltrim($matches[1], '0') : '-';
                            @endphp
                            <tr class="align-middle">
                                <td class="px-4 border-top">{{ $index + 1 }}</td>
                                <td class="px-4 border-top">
                                    <span class="badge bg-success">RW {{ str_pad($rwNumber, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-4 border-top">
                                    <div class="fw-bold">{{ $user->name }}</div>
                                </td>
                                <td class="px-4 border-top">{{ $user->email }}</td>
                                <td class="px-4 border-top">{{ $user->biodata->phone ?? '-' }}</td>
                                <td class="px-4 border-top">
                                    @if($user->hasVerifiedEmail() && $user->is_approved)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 border-top text-center">
                                    <a href="{{ route('admin.rt-rw.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada data RW
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- RT Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0"><i class="fas fa-house-user me-2 text-info"></i>Daftar Ketua RT</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">RT</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Telepon</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rtUsers as $index => $user)
                            @php
                                // Extract RT number from email (rt001@...)
                                preg_match('/rt(\d+)@/', $user->email, $matches);
                                $rtNumber = isset($matches[1]) ? ltrim($matches[1], '0') : '-';
                            @endphp
                            <tr class="align-middle">
                                <td class="px-4 border-top">{{ $index + 1 }}</td>
                                <td class="px-4 border-top">
                                    <span class="badge bg-info">RT {{ str_pad($rtNumber, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-4 border-top">
                                    <div class="fw-bold">{{ $user->name }}</div>
                                </td>
                                <td class="px-4 border-top">{{ $user->email }}</td>
                                <td class="px-4 border-top">{{ $user->biodata->phone ?? '-' }}</td>
                                <td class="px-4 border-top">
                                    @if($user->hasVerifiedEmail() && $user->is_approved)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 border-top text-center">
                                    <a href="{{ route('admin.rt-rw.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada data RT
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
