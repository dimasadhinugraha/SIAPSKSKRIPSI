@extends('layouts.app-bootstrap')

@section('title', 'Detail Anggota Keluarga ' . $familyMember->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0"><i class="fas fa-users me-2"></i>Detail Anggota Keluarga</h1>
                    <p class="mb-0 small">{{ $familyMember->name }} (NIK: {{ $familyMember->nik }})</p>
                </div>
                <a href="{{ route('family-members.index') }}" class="btn btn-light text-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Notice -->
    <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <div>
            <strong>Informasi:</strong> Data anggota keluarga tidak dapat diedit setelah disubmit untuk menjaga integritas data.
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <!-- Data Pribadi -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama Lengkap</dt>
                        <dd class="col-sm-8">{{ $familyMember->name }}</dd>

                        <dt class="col-sm-4">NIK</dt>
                        <dd class="col-sm-8">{{ $familyMember->nik }}</dd>

                        <dt class="col-sm-4">Jenis Kelamin</dt>
                        <dd class="col-sm-8">
                            @if($familyMember->gender === 'L')
                                <i class="fas fa-male me-1"></i>
                            @else
                                <i class="fas fa-female me-1"></i>
                            @endif
                            {{ $familyMember->gender_label }}
                        </dd>

                        <dt class="col-sm-4">Tempat, Tanggal Lahir</dt>
                        <dd class="col-sm-8">{{ $familyMember->place_of_birth }}, {{ $familyMember->formatted_date_of_birth }} ({{ $familyMember->age }} tahun)</dd>
                        
                        <dt class="col-sm-4">Hubungan Keluarga</dt>
                        <dd class="col-sm-8">
                            <span class="badge 
                                @if($familyMember->relationship === 'kepala_keluarga') bg-primary
                                @elseif(in_array($familyMember->relationship, ['istri', 'suami'])) bg-success
                                @elseif($familyMember->relationship === 'anak') bg-info
                                @else bg-secondary @endif">
                                {{ $familyMember->relationship_label }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Data Tambahan -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Data Tambahan</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Agama</dt>
                        <dd class="col-sm-8">{{ $familyMember->religion_label }}</dd>

                        <dt class="col-sm-4">Status Perkawinan</dt>
                        <dd class="col-sm-8">{{ $familyMember->marital_status_label }}</dd>

                        @if($familyMember->education)
                            <dt class="col-sm-4">Pendidikan</dt>
                            <dd class="col-sm-8">{{ $familyMember->education_label }}</dd>
                        @endif

                        @if($familyMember->occupation)
                            <dt class="col-sm-4">Pekerjaan</dt>
                            <dd class="col-sm-8">{{ $familyMember->occupation }}</dd>
                        @endif

                        <dt class="col-sm-4">Kewarganegaraan</dt>
                        <dd class="col-sm-8">{{ $familyMember->nationality }}</dd>

                        @if($familyMember->father_name)
                            <dt class="col-sm-4">Nama Ayah</dt>
                            <dd class="col-sm-8">{{ $familyMember->father_name }}</dd>
                        @endif

                        @if($familyMember->mother_name)
                            <dt class="col-sm-4">Nama Ibu</dt>
                            <dd class="col-sm-8">{{ $familyMember->mother_name }}</dd>
                        @endif

                        @if($familyMember->notes)
                            <dt class="col-sm-12">Catatan</dt>
                            <dd class="col-sm-12">{{ $familyMember->notes }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <!-- Status Persetujuan -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-check-double me-2"></i>Status & Dokumen</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Status Persetujuan:</span>
                        <span class="badge 
                            @if($familyMember->approval_status === 'pending') bg-warning text-dark
                            @elseif($familyMember->approval_status === 'approved') bg-success
                            @else bg-danger @endif">
                            {{ $familyMember->approval_status_label }}
                        </span>
                    </div>

                    @if($familyMember->approval_status === 'rejected' && $familyMember->rejection_reason)
                        <div class="alert alert-danger mt-3" role="alert">
                            <h6 class="alert-heading"><i class="fas fa-times-circle me-2"></i>Alasan Ditolak:</h6>
                            <p class="mb-0">{{ $familyMember->rejection_reason }}</p>
                        </div>
                    @endif

                    @if($familyMember->supporting_document)
                        <hr>
                        <h6 class="mt-3"><i class="fas fa-file-alt me-2"></i>Dokumen Pendukung:</h6>
                        <a href="{{ Storage::url($familyMember->supporting_document) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Dokumen
                        </a>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($familyMember->approval_status == 'rejected')
                            <a href="{{ route('family-members.create') }}" class="btn btn-warning">
                                <i class="fas fa-redo me-2"></i>Ajukan Ulang
                            </a>
                        @endif
                        <a href="{{ route('transfer-requests.create', $familyMember) }}" class="btn btn-primary">
                            <i class="fas fa-exchange-alt me-2"></i>Ajukan Permohonan Pindah
                        </a>
                        <form action="{{ route('family-members.destroy', $familyMember) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota keluarga ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash-alt me-2"></i>Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection