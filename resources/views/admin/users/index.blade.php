@extends('layouts.app-bootstrap')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-users me-2"></i>Manajemen Pengguna</h1>
                    <p class="mb-0 small">Kelola data pengguna sistem</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-light">
                    <i class="fas fa-plus me-2"></i>Tambah Pengguna
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
                            <p class="text-muted mb-0 small">Total Pengguna</p>
                            <h3 class="mb-0">{{ $statistics['total'] }}</h3>
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
                                <i class="fas fa-user-shield fa-2x text-danger"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Admin</p>
                            <h3 class="mb-0">{{ $statistics['admin'] }}</h3>
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
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <i class="fas fa-user-tie fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">RT/RW</p>
                            <h3 class="mb-0">{{ $statistics['rt'] + $statistics['rw'] }}</h3>
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
                                <i class="fas fa-user-check fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Terverifikasi</p>
                            <h3 class="mb-0">{{ $statistics['verified'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Cari</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nama, NIK, Email...">
                    </div>
                    <div class="col-md-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="rt" {{ request('role') == 'rt' ? 'selected' : '' }}>RT</option>
                            <option value="rw" {{ request('role') == 'rw' ? 'selected' : '' }}>RW</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="not_verified" {{ request('status') == 'not_verified' ? 'selected' : '' }}>Belum Terverifikasi</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="not_approved" {{ request('status') == 'not_approved' ? 'selected' : '' }}>Belum Disetujui</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0">Daftar Pengguna</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4" style="min-width: 250px;">Nama</th>
                            <th class="py-3 px-4" style="min-width: 100px;">Role</th>
                            <th class="py-3 px-4" style="min-width: 180px;">Email & Alamat</th>
                            <th class="py-3 px-4" style="min-width: 150px;">Status</th>
                            <th class="py-3 px-4 text-center" style="min-width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="align-middle">
                                <td class="px-4 border-top">
                                    <div class="d-flex align-items-center">
                                        @if($user->biodata && $user->biodata->profile_photo)
                                            <img src="{{ Storage::url($user->biodata->profile_photo) }}" 
                                                 alt="Photo" class="rounded-circle me-3" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; font-size: 16px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold mb-0">{{ $user->name }}</div>
                                            <small class="text-muted">NIK: {{ $user->nik ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 border-top">
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger-soft text-danger">Admin</span>
                                    @elseif($user->role == 'rt')
                                        <span class="badge bg-info-soft text-info">RT</span>
                                    @elseif($user->role == 'rw')
                                        <span class="badge bg-primary-soft text-primary">RW</span>
                                    @else
                                        <span class="badge bg-secondary-soft text-secondary">User</span>
                                    @endif
                                </td>
                                <td class="px-4 border-top">
                                    <div>{{ $user->email }}</div>
                                    <small class="text-muted">
                                        @if($user->biodata && $user->biodata->rt_rw)
                                            {{ $user->biodata->rt_rw }}
                                        @elseif($user->biodata && $user->biodata->address)
                                            {{ Str::limit($user->biodata->address, 30) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </td>
                                <td class="px-4 border-top">
                                    <div>
                                        @if($user->hasVerifiedEmail())
                                            <span class="badge bg-success-soft text-success d-inline-flex align-items-center">
                                                <i class="fas fa-check-circle me-1"></i> Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge bg-warning-soft text-warning d-inline-flex align-items-center">
                                                <i class="fas fa-exclamation-circle me-1"></i> Belum Verifikasi
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        @if($user->is_approved)
                                            <span class="badge bg-success-soft text-success d-inline-flex align-items-center">
                                                <i class="fas fa-check-circle me-1"></i> Disetujui
                                            </span>
                                        @else
                                            <span class="badge bg-warning-soft text-warning d-inline-flex align-items-center">
                                                <i class="fas fa-exclamation-circle me-1"></i> Belum Disetujui
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center px-4 border-top">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" @if(auth()->id() == $user->id) disabled @endif>
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Tidak ada pengguna yang ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($users->hasPages())
            <div class="card-footer bg-white">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .text-danger { color: #dc3545 !important; }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .text-info { color: #0dcaf0 !important; }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .text-primary { color: #0d6efd !important; }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
    .text-secondary { color: #6c757d !important; }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .text-success { color: #198754 !important; }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .text-warning { color: #ffc107 !important; }
</style>
@endsection
