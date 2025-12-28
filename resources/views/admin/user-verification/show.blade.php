@extends('layouts.app-bootstrap')

@section('title', 'Detail Verifikasi User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">👤 Detail Verifikasi User</h1>
        </div>
        <div>
            <a href="{{ route('admin.user-verification.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Section -->
    @if(!$user->hasVerifiedEmail())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Email Belum Terverifikasi!</strong> User ini belum melakukan verifikasi email. Pastikan user telah mengklik link aktivasi di email mereka sebelum Anda melakukan verifikasi akun.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($user->hasVerifiedEmail() && $user->is_approved)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Akun Telah Diverifikasi!</strong> User ini sudah terverifikasi dan dapat menggunakan semua fitur sistem.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <!-- User Header -->
            <div class="mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <h2 class="h4 mb-1">{{ $user->name }}</h2>
                        <p class="text-muted mb-0">
                            <i class="fas fa-id-card me-1"></i>{{ $user->nik }}
                        </p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2">
                    @if($user->hasVerifiedEmail())
                        <span class="badge bg-success">
                            <i class="fas fa-envelope-circle-check me-1"></i>Email Terverifikasi
                        </span>
                    @else
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-envelope me-1"></i>Belum Verifikasi Email
                        </span>
                    @endif
                    
                    @if($user->hasVerifiedEmail() && $user->is_approved)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Akun Disetujui
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            <i class="fas fa-clock me-1"></i>Menunggu Persetujuan
                        </span>
                    @endif
                </div>
            </div>

            <hr>

            <!-- Data Personal -->
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <h5 class="fw-bold mb-3"><i class="fas fa-user me-2 text-primary"></i>Data Personal</h5>
                    
                    <dl class="row">
                        <dt class="col-sm-4 text-muted">NIK</dt>
                        <dd class="col-sm-8">{{ $user->nik }}</dd>

                        <dt class="col-sm-4 text-muted">Nama Lengkap</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>

                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ $user->email ?? '-' }}</dd>

                        <dt class="col-sm-4 text-muted">Jenis Kelamin</dt>
                        <dd class="col-sm-8">{{ $user->biodata ? ($user->biodata->gender == 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}</dd>

                        <dt class="col-sm-4 text-muted">Tanggal Lahir</dt>
                        <dd class="col-sm-8">{{ $user->biodata && $user->biodata->birth_date ? \Carbon\Carbon::parse($user->biodata->birth_date)->format('d F Y') : '-' }}</dd>

                        <dt class="col-sm-4 text-muted">No. Telepon</dt>
                        <dd class="col-sm-8">{{ $user->biodata->phone ?? '-' }}</dd>

                        <dt class="col-sm-4 text-muted">Tanggal Pendaftaran</dt>
                        <dd class="col-sm-8">{{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }} WIB</dd>
                    </dl>
                </div>

                <div class="col-lg-6">
                    <h5 class="fw-bold mb-3"><i class="fas fa-map-marker-alt me-2 text-success"></i>Data Lokasi</h5>
                    
                    <dl class="row">
                        <dt class="col-sm-4 text-muted">Alamat</dt>
                        <dd class="col-sm-8">{{ $user->biodata->address ?? '-' }}</dd>

                        <dt class="col-sm-4 text-muted">RT/RW</dt>
                        <dd class="col-sm-8">{{ $user->biodata->rt_rw ?? '-' }}</dd>

                        <dt class="col-sm-4 text-muted">No. Kartu Keluarga</dt>
                        <dd class="col-sm-8">{{ $user->biodata->kk_number ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <hr>

            <!-- Dokumen -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-file-image me-2 text-info"></i>Dokumen Pendukung</h5>

                <div class="row g-4">
                    @if($user->biodata && $user->biodata->ktp_photo)
                    <div class="col-md-6">
                        <div class="text-center">
                            <p class="text-muted small mb-2"><strong>Foto KTP</strong></p>
                            <img src="{{ Storage::url($user->biodata->ktp_photo) }}" 
                                 alt="KTP {{ $user->name }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="cursor:pointer; max-height:300px; object-fit:contain;" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageModal" 
                                 data-bs-img-src="{{ Storage::url($user->biodata->ktp_photo) }}" 
                                 data-bs-img-title="KTP {{ $user->name }}">
                        </div>
                    </div>
                    @endif

                    @if($user->biodata && $user->biodata->kk_photo)
                    <div class="col-md-6">
                        <div class="text-center">
                            <p class="text-muted small mb-2"><strong>Foto Kartu Keluarga</strong></p>
                            <img src="{{ Storage::url($user->biodata->kk_photo) }}" 
                                 alt="KK {{ $user->name }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="cursor:pointer; max-height:300px; object-fit:contain;" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#imageModal" 
                                 data-bs-img-src="{{ Storage::url($user->biodata->kk_photo) }}" 
                                 data-bs-img-title="KK {{ $user->name }}">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Footer with Actions -->
        @if(!($user->hasVerifiedEmail() && $user->is_approved))
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1">Verifikasi Akun User</h6>
                    <p class="text-muted mb-0 small">Pastikan semua data dan dokumen sudah sesuai sebelum melakukan verifikasi</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times-circle me-2"></i>Tolak
                    </button>
                    <form action="{{ route('admin.user-verification.verify', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi user ini? User akan mendapatkan notifikasi email.');" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success" @if(!$user->hasVerifiedEmail()) disabled @endif>
                            <i class="fas fa-check-circle me-2"></i>Verifikasi Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid" alt="Document Preview">
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.user-verification.reject', $user) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Penolakan</label>
                        <textarea id="reason" name="reason" rows="3" required class="form-control" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal image preview
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const imgSrc = button.getAttribute('data-bs-img-src');
            const imgTitle = button.getAttribute('data-bs-img-title');
            
            const modalImage = imageModal.querySelector('#modalImage');
            const modalTitle = imageModal.querySelector('.modal-title');
            
            modalImage.src = imgSrc;
            modalTitle.textContent = imgTitle;
        });
    }
</script>
@endpush

