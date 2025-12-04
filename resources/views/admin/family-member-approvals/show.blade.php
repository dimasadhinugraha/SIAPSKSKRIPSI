@extends('layouts.app-bootstrap')

@section('content')
<div class="container-fluid px-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Review Anggota Keluarga</h5>
                    <small>Detail dan verifikasi data anggota keluarga</small>
                </div>
                <div>
                    @if($familyMember->approval_status === 'pending')
                        <span class="badge bg-warning text-dark">Menunggu Review</span>
                    @elseif($familyMember->approval_status === 'approved')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h4 class="mb-1">{{ $familyMember->name }}</h4>
                    <p class="text-muted mb-2">{{ $familyMember->relationship_label }}</p>
                    <p class="mb-1"><strong>NIK:</strong> {{ $familyMember->nik }}</p>
                    <p class="mb-0"><strong>Pengaju:</strong> {{ $familyMember->user ? $familyMember->user->name : 'Tidak ada' }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1"><small class="text-muted">Diajukan:</small> {{ $familyMember->created_at->format('d M Y, H:i') }}</p>
                    @if($familyMember->approved_at)
                        <p class="mb-2">
                            <small class="text-muted">
                                @if($familyMember->approval_status === 'approved')
                                    Disetujui:
                                @else
                                    Ditolak:
                                @endif
                            </small>
                            {{ $familyMember->approved_at->format('d M Y, H:i') }}
                        </p>
                    @endif
                    <div class="mt-3">
                        @if($familyMember->approval_status === 'pending')
                            <form action="{{ route('admin.family-member-approvals.approve', $familyMember) }}" method="POST" class="d-inline me-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Setujui anggota keluarga ini?')" 
                                        class="btn btn-success">
                                    <i class="fas fa-check me-1"></i> Setujui
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.family-member-approvals.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Data Pribadi -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Nama Lengkap</label>
                            <strong>{{ $familyMember->name }}</strong>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">NIK</label>
                            <strong>{{ $familyMember->nik }}</strong>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Jenis Kelamin</label>
                            <strong>
                                @if($familyMember->gender === 'L')
                                    <i class="fas fa-mars text-primary"></i> Laki-laki
                                @else
                                    <i class="fas fa-venus text-danger"></i> Perempuan
                                @endif
                            </strong>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Hubungan Keluarga</label>
                            <span class="badge bg-primary">{{ $familyMember->relationship_label }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Tempat Lahir</label>
                            <strong>{{ $familyMember->place_of_birth }}</strong>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Tanggal Lahir</label>
                            <strong>{{ $familyMember->date_of_birth->format('d M Y') }} ({{ $familyMember->date_of_birth->age }} tahun)</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Tambahan -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Data Tambahan</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Agama</label>
                            <strong>{{ ucfirst($familyMember->religion) }}</strong>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Status Perkawinan</label>
                            <strong>{{ ucfirst($familyMember->marital_status) }}</strong>
                        </div>
                        @if($familyMember->education)
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Pendidikan</label>
                                <strong>{{ strtoupper($familyMember->education) }}</strong>
                            </div>
                        @endif
                        @if($familyMember->occupation)
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Pekerjaan</label>
                                <strong>{{ $familyMember->occupation }}</strong>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <label class="text-muted small d-block">Kewarganegaraan</label>
                            <strong>{{ $familyMember->nationality }}</strong>
                        </div>
                        @if($familyMember->father_name)
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Nama Ayah</label>
                                <strong>{{ $familyMember->father_name }}</strong>
                            </div>
                        @endif
                        @if($familyMember->mother_name)
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Nama Ibu</label>
                                <strong>{{ $familyMember->mother_name }}</strong>
                            </div>
                        @endif
                    </div>
                    
                    @if($familyMember->notes)
                        <div class="mt-3">
                            <label class="text-muted small d-block">Catatan</label>
                            <div class="alert alert-info mb-0">{{ $familyMember->notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Data Pengaju -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-user-tie me-2"></i>Data Pengaju</h6>
                </div>
                <div class="card-body">
                    @if($familyMember->user)
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Nama Pengaju</label>
                                <strong>{{ $familyMember->user->name }}</strong>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Email</label>
                                <strong>{{ $familyMember->user->email }}</strong>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small d-block">NIK Kepala Keluarga</label>
                                <strong>{{ $familyMember->user->nik }}</strong>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small d-block">Status Verifikasi</label>
                                @if($familyMember->user->is_verified)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Terverifikasi</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>Data pengaju tidak tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Dokumen Pendukung -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Dokumen Pendukung</h6>
                </div>
                <div class="card-body text-center">
                    @if($familyMember->supporting_document)
                        <a href="{{ Storage::url($familyMember->supporting_document) }}" 
                           target="_blank" 
                           class="btn btn-outline-primary w-100">
                            <i class="fas fa-download me-2"></i>Download Dokumen
                        </a>
                    @else
                        <p class="text-muted mb-0">Tidak ada dokumen</p>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($familyMember->approval_status === 'pending')
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Review</h6>
                    </div>
                    <div class="card-body">
                        <!-- Approve Form -->
                        <form action="{{ route('admin.family-member-approvals.approve', $familyMember) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    onclick="return confirm('Setujui anggota keluarga ini?')"
                                    class="btn btn-success w-100">
                                <i class="fas fa-check me-2"></i>Setujui Pengajuan
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="{{ route('admin.family-member-approvals.reject', $familyMember) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">
                                    Alasan Penolakan <span class="text-danger">*</span>
                                </label>
                                <textarea name="rejection_reason" 
                                          id="rejection_reason" 
                                          rows="3" 
                                          required
                                          class="form-control"
                                          placeholder="Jelaskan alasan penolakan..."></textarea>
                            </div>
                            <button type="submit" 
                                    onclick="return confirm('Tolak anggota keluarga ini?')"
                                    class="btn btn-danger w-100">
                                <i class="fas fa-times me-2"></i>Tolak Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Riwayat Status -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-plus text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <strong class="d-block">Pengajuan Dibuat</strong>
                                <small class="text-muted">{{ $familyMember->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>

                        @if($familyMember->approved_at)
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="bg-{{ $familyMember->approval_status === 'approved' ? 'success' : 'danger' }} bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-{{ $familyMember->approval_status === 'approved' ? 'check' : 'times' }} text-{{ $familyMember->approval_status === 'approved' ? 'success' : 'danger' }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <strong class="d-block">
                                        {{ $familyMember->approval_status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                        @if($familyMember->approver)
                                            oleh {{ $familyMember->approver->name }}
                                        @endif
                                    </strong>
                                    <small class="text-muted d-block">{{ $familyMember->approved_at->format('d M Y, H:i') }}</small>
                                    @if($familyMember->rejection_reason)
                                        <div class="alert alert-danger alert-sm mt-2 mb-0">
                                            <small>{{ $familyMember->rejection_reason }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
