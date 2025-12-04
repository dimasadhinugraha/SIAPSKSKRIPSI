@extends('layouts.app-bootstrap')

@section('title', 'Riwayat Pengajuan Surat')

@push('styles')
<style>
    /* Flat request tiles: no outer border, subtle hover lift */
    .request-card {
        border: 0 !important;
        transition: transform .18s ease, box-shadow .18s ease;
        border-radius: .75rem;
    }
    .request-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(16,24,40,0.08);
    }
    .request-card .card-header {
        border: 0;
        background: transparent;
    }
    .requests-empty {
        background-color: rgba(248,249,250,0.6); /* subtle light bg */
        border: 0;
        border-radius: .75rem;
    }
    /* Request number font styling */
    .request-number {
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        font-size: .98rem;
        color: var(--bs-body-color, #0d1b2a);
        letter-spacing: 0.01em;
    }
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="card bg-primary bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 mb-0"><i class="fas fa-history me-2"></i>Riwayat Pengajuan Surat</h1>
                        <p class="mb-0 small opacity-75">Total: <span class="fw-bold">{{ $requests->total() }}</span> pengajuan</p>
                    </div>
                    <a href="{{ route('letter-requests.create') }}" class="btn btn-light text-primary">
                        <i class="fas fa-plus me-2"></i>Ajukan Surat Baru
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($requests->count() > 0)
            <!-- Card Layout -->
            <div class="row g-4">
                @foreach($requests as $request)
                    @php
                        $statusConfig = [
                            'pending_rt' => ['border' => 'border-warning', 'badge' => 'bg-warning text-dark'],
                            'pending_rw' => ['border' => 'border-info', 'badge' => 'bg-info text-dark'],
                            'approved_final' => ['border' => 'border-success', 'badge' => 'bg-success text-white'],
                            'rejected_rt' => ['border' => 'border-danger', 'badge' => 'bg-danger text-white'],
                            'rejected_rw' => ['border' => 'border-danger', 'badge' => 'bg-danger text-white'],
                            'default' => ['border' => 'border-secondary', 'badge' => 'bg-secondary text-white'],
                        ];
                        $config = $statusConfig[$request->status] ?? $statusConfig['default'];
                    @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 request-card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="request-number fw-bold">{{ $request->request_number }}</span>
                                <span class="badge rounded-pill {{ $config['badge'] }}">{{ $request->status_label }}</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $request->letterType->name }}</h5>
                                <p class="card-text text-muted">
                                    <i class="fas fa-user fa-fw me-2"></i>{{ $request->subject_name }}
                                    <small>({{ $request->subject_type === 'self' ? 'Diri sendiri' : 'Anggota keluarga' }})</small>
                                </p>
                                <p class="card-text text-muted small">
                                    <i class="fas fa-clock fa-fw me-2"></i>{{ $request->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <div class="d-grid gap-2">
                                     <a href="{{ route('letter-requests.show', $request) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-search me-2"></i>Detail
                                    </a>
                                    @if($request->isApproved())
                                        <a href="{{ route('letter-requests.download', $request) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-download me-2"></i>Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($requests->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $requests->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="requests-empty text-center py-5 px-4">
                <div class="display-4 text-primary mb-3">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3 class="text-muted">Belum Ada Pengajuan Surat</h3>
                <p class="text-muted mb-4">Mulai dengan mengajukan surat administrasi pertama Anda. Prosesnya mudah dan cepat!</p>
                <a href="{{ route('letter-requests.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Ajukan Surat Baru
                </a>
            </div>
        @endif
    </div>
@endsection