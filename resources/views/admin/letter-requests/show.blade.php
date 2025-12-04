@extends('layouts.app-bootstrap')

@section('title', 'Detail Pengajuan Surat')

@section('content')
<div class="container-fluid">
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-file-signature me-2"></i>Detail Pengajuan Surat</h1>
                    <p class="mb-0 small">Nomor: {{ $letterRequest->request_number }}</p>
                </div>
                <a href="{{ route('admin.letter-requests.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{ $letterRequest->letterType->name }}</h5>
            @php
                $statusBadges = [
                    'pending_rt' => 'bg-warning text-dark',
                    'pending_rw' => 'bg-info text-dark',
                    'approved_final' => 'bg-success',
                    'rejected_rt' => 'bg-danger',
                    'rejected_rw' => 'bg-danger',
                ];
            @endphp
            <span class="badge fs-6 {{ $statusBadges[$letterRequest->status] ?? 'bg-secondary' }}">
                {{ $letterRequest->status_label }}
            </span>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <!-- Requester Information -->
                <div class="col-md-6">
                    <h6 class="mb-3">Data Pemohon</h6>
                    <dl class="row">
                        <dt class="col-sm-4 text-muted">Nama</dt>
                        <dd class="col-sm-8">{{ $letterRequest->user->name }}</dd>
                        <dt class="col-sm-4 text-muted">NIK</dt>
                        <dd class="col-sm-8">{{ $letterRequest->user->nik }}</dd>
                        <dt class="col-sm-4 text-muted">Alamat</dt>
                        <dd class="col-sm-8">{{ $letterRequest->user->address }}</dd>
                        <dt class="col-sm-4 text-muted">RT/RW</dt>
                        <dd class="col-sm-8">{{ $letterRequest->user->rt_rw }}</dd>
                        <dt class="col-sm-4 text-muted">No. HP</dt>
                        <dd class="col-sm-8">{{ $letterRequest->user->phone }}</dd>
                    </dl>
                </div>

                <!-- Subject Information -->
                <div class="col-md-6">
                    <h6 class="mb-3">Data Subjek Surat</h6>
                    @if($letterRequest->subject && $letterRequest->subject->id !== $letterRequest->user->id)
                        <dl class="row">
                            <dt class="col-sm-4 text-muted">Nama</dt>
                            <dd class="col-sm-8">{{ $letterRequest->subject->name }}</dd>
                            <dt class="col-sm-4 text-muted">NIK</dt>
                            <dd class="col-sm-8">{{ $letterRequest->subject->nik }}</dd>
                            <dt class="col-sm-4 text-muted">Hubungan</dt>
                            <dd class="col-sm-8">{{ $letterRequest->subject->relationship_label }}</dd>
                            <dt class="col-sm-4 text-muted">Jenis Kelamin</dt>
                            <dd class="col-sm-8">{{ $letterRequest->subject->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                            <dt class="col-sm-4 text-muted">Tgl. Lahir</dt>
                            <dd class="col-sm-8">{{ $letterRequest->subject->birth_date ? $letterRequest->subject->birth_date->format('d/m/Y') : '-' }}</dd>
                        </dl>
                    @else
                        <dl class="row">
                            <dt class="col-sm-4 text-muted">Subjek</dt>
                            <dd class="col-sm-8">Diri Sendiri</dd>
                            <dt class="col-sm-4 text-muted">Jenis Kelamin</dt>
                            <dd class="col-sm-8">{{ $letterRequest->user->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                            <dt class="col-sm-4 text-muted">Tgl. Lahir</dt>
                            <dd class="col-sm-8">{{ $letterRequest->user->birth_date ? $letterRequest->user->birth_date->format('d/m/Y') : '-' }}</dd>
                        </dl>
                    @endif
                </div>
            </div>

            <!-- Approval History -->
            @if($letterRequest->approvals->count() > 0)
                <div class="mt-4">
                    <h6 class="mb-3">Riwayat Persetujuan</h6>
                    <div class="list-group">
                        @foreach($letterRequest->approvals as $approval)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $approval->approver->name }} ({{ $approval->approver->role_name }})</h6>
                                    <small class="text-muted">{{ $approval->processed_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ $approval->notes ?? 'Tidak ada catatan.' }}</p>
                                <span class="badge {{ $approval->status === 'approved' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $approval->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Download Letter -->
            @if($letterRequest->status === 'approved_final')
                <div class="alert alert-success mt-4 d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Surat Telah Disetujui.</strong> File surat sudah tersedia untuk diunduh.
                    </div>
                    <a href="{{ route('letter-requests.download', $letterRequest) }}" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Unduh Surat
                    </a>
                </div>
            @endif
        </div>
        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
            <small>Tanggal Pengajuan: {{ $letterRequest->created_at->format('d F Y, H:i') }}</small>
            <small class="fw-bold"><i class="fas fa-desktop me-2"></i>Mode Monitoring Admin</small>
        </div>
    </div>
</div>
@endsection
