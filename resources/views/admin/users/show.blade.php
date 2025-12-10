@extends('layouts.app-bootstrap')

@section('title', 'Detail Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-light rounded-circle p-2 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-eye fa-lg"></i>
            </div>
            <h1 class="h3 mb-0">Detail Pengguna</h1>
        </div>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-pencil-alt me-2"></i>Edit
            </a>
            @if(auth()->id() != $user->id)
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Hapus
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- User Profile Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($user->biodata && $user->biodata->profile_photo)
                                <img src="{{ Storage::url($user->biodata->profile_photo) }}" 
                                     alt="Photo" class="img-fluid rounded-circle mb-3" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 150px; height: 150px; font-size: 3rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <!-- Status Badges -->
                            <div class="d-flex flex-column gap-2">
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role == 'rt')
                                    <span class="badge bg-info">RT</span>
                                @elseif($user->role == 'rw')
                                    <span class="badge bg-primary">RW</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                                
                                @if($user->is_verified)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning">Belum Verifikasi</span>
                                @endif
                                
                                @if($user->is_approved)
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-warning">Belum Disetujui</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h4 class="mb-3">{{ $user->name }}</h4>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Email:</strong></div>
                                <div class="col-md-8">{{ $user->email }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>NIK:</strong></div>
                                <div class="col-md-8">{{ $user->nik ?? '-' }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Jenis Kelamin:</strong></div>
                                <div class="col-md-8">{{ $user->gender == 'L' ? 'Laki-laki' : ($user->gender == 'P' ? 'Perempuan' : '-') }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Tanggal Lahir:</strong></div>
                                <div class="col-md-8">
                                    {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F Y') : '-' }}
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Alamat:</strong></div>
                                <div class="col-md-8">{{ $user->address ?? '-' }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>RT/RW:</strong></div>
                                <div class="col-md-8">RT {{ $user->rt ?? '-' }} / RW {{ $user->rw ?? '-' }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>No. Telepon:</strong></div>
                                <div class="col-md-8">{{ $user->phone ?? '-' }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>No. KK:</strong></div>
                                <div class="col-md-8">{{ $user->kk_number ?? '-' }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Terdaftar:</strong></div>
                                <div class="col-md-8">{{ $user->created_at->format('d F Y H:i') }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-4"><strong>Terakhir Update:</strong></div>
                                <div class="col-md-8">{{ $user->updated_at->format('d F Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            @if($user->ktp_photo || $user->kk_photo)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-file-image me-2"></i>Dokumen</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            @if($user->ktp_photo)
                                <div class="col-md-6 mb-3">
                                    <h6>Foto KTP</h6>
                                    <a href="{{ Storage::url($user->ktp_photo) }}" target="_blank">
                                        <img src="{{ Storage::url($user->ktp_photo) }}" 
                                             alt="KTP" class="img-fluid img-thumbnail">
                                    </a>
                                </div>
                            @endif
                            
                            @if($user->kk_photo)
                                <div class="col-md-6 mb-3">
                                    <h6>Foto KK</h6>
                                    <a href="{{ Storage::url($user->kk_photo) }}" target="_blank">
                                        <img src="{{ Storage::url($user->kk_photo) }}" 
                                             alt="KK" class="img-fluid img-thumbnail">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Family Information -->
            @if($user->family)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-home me-2"></i>Informasi Keluarga</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-2">
                            <div class="col-md-3"><strong>No. KK:</strong></div>
                            <div class="col-md-9">{{ $user->family->kk_number }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"><strong>Kepala Keluarga:</strong></div>
                            <div class="col-md-9">{{ $user->family->kepala_keluarga }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"><strong>Alamat:</strong></div>
                            <div class="col-md-9">{{ $user->family->address }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"><strong>RT/RW:</strong></div>
                            <div class="col-md-9">RT {{ $user->family->rt }} / RW {{ $user->family->rw }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Letter Requests History -->
            @if($user->letterRequests && $user->letterRequests->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Riwayat Pengajuan Surat ({{ $user->letterRequests->count() }})</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No. Surat</th>
                                        <th>Jenis Surat</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->letterRequests->take(10) as $letter)
                                        <tr>
                                            <td>{{ $letter->request_number }}</td>
                                            <td>{{ $letter->letterType->name }}</td>
                                            <td>{{ $letter->created_at->format('d F Y') }}</td>
                                            <td>
                                                @if($letter->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($letter->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($letter->status == 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($user->letterRequests->count() > 10)
                            <p class="text-muted mb-0 mt-2">
                                <small>Menampilkan 10 dari {{ $user->letterRequests->count() }} pengajuan surat</small>
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('admin.users.toggle-verification', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-{{ $user->is_verified ? 'secondary' : 'success' }} w-100">
                                    <i class="fas fa-{{ $user->is_verified ? 'times' : 'check' }}-circle me-2"></i>
                                    {{ $user->is_verified ? 'Batalkan Verifikasi' : 'Verifikasi Akun' }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 mb-2">
                            <form action="{{ route('admin.users.toggle-approval', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-{{ $user->is_approved ? 'secondary' : 'primary' }} w-100">
                                    <i class="fas fa-{{ $user->is_approved ? 'ban' : 'thumbs-up' }} me-2"></i>
                                    {{ $user->is_approved ? 'Batalkan Persetujuan' : 'Setujui Akun' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection
