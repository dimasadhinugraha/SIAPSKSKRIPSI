@extends('layouts.app-bootstrap')

@section('title', 'Detail Surat ' . $letterRequest->request_number)

@push('styles')
<style>
    .progress-timeline {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    .timeline-step {
        text-align: center;
        flex: 1;
        position: relative;
    }
    .timeline-step .step-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin: 0 auto 0.5rem auto;
        border: 2px solid;
    }
    .timeline-step .step-text {
        font-size: 0.8rem;
    }
    .timeline-connector {
        flex-grow: 1;
        height: 2px;
        background-color: var(--bs-gray-300);
        position: relative;
        top: 1.25rem;
    }
    /* Status colors */
    .timeline-step.status-completed .step-icon { background-color: var(--bs-success); border-color: var(--bs-success); color: white; }
    .timeline-step.status-pending .step-icon { background-color: var(--bs-warning); border-color: var(--bs-warning); color: black; }
    .timeline-step.status-default .step-icon { background-color: var(--bs-gray-300); border-color: var(--bs-gray-300); color: var(--bs-gray-600); }
    .timeline-connector.status-completed { background-color: var(--bs-success); }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0"><i class="fas fa-file-alt me-2"></i>Detail Pengajuan Surat</h1>
                    <p class="mb-0 small">{{ $letterRequest->letterType->name }}</p>
                </div>
                <a href="{{ route('letter-requests.index') }}" class="btn btn-light text-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    
    <!-- Progress Timeline -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-shoe-prints me-2"></i>Progress Pengajuan</h5>
        </div>
        <div class="card-body p-4">
            <div class="progress-timeline">
                <!-- Step 1: Pengajuan -->
                <div class="timeline-step status-completed">
                    <div class="step-icon"><i class="fas fa-check"></i></div>
                    <div class="step-text fw-bold">Pengajuan</div>
                    <div class="step-text text-muted small">{{ $letterRequest->created_at->format('d/m H:i') }}</div>
                </div>

                <div class="timeline-connector {{ $letterRequest->rt_processed_at ? 'status-completed' : '' }}"></div>

                <!-- Step 2: RT -->
                @php
                    $rt_status = 'default';
                    if($letterRequest->rt_processed_at) $rt_status = 'completed';
                    elseif($letterRequest->status == 'pending_rt') $rt_status = 'pending';
                @endphp
                <div class="timeline-step status-{{ $rt_status }}">
                    <div class="step-icon">
                         @if($rt_status == 'completed') <i class="fas fa-check"></i> @elseif($rt_status == 'pending') <i class="fas fa-clock"></i> @else 2 @endif
                    </div>
                    <div class="step-text fw-bold">RT</div>
                    <div class="step-text text-muted small">{{ $letterRequest->rt_processed_at ? $letterRequest->rt_processed_at->format('d/m H:i') : 'Menunggu' }}</div>
                </div>

                <div class="timeline-connector {{ $letterRequest->rw_processed_at ? 'status-completed' : '' }}"></div>

                <!-- Step 3: RW -->
                 @php
                    $rw_status = 'default';
                    if($letterRequest->rw_processed_at) $rw_status = 'completed';
                    elseif($letterRequest->status == 'pending_rw') $rw_status = 'pending';
                @endphp
                <div class="timeline-step status-{{ $rw_status }}">
                    <div class="step-icon">
                        @if($rw_status == 'completed') <i class="fas fa-check"></i> @elseif($rw_status == 'pending') <i class="fas fa-clock"></i> @else 3 @endif
                    </div>
                    <div class="step-text fw-bold">RW</div>
                    <div class="step-text text-muted small">{{ $letterRequest->rw_processed_at ? $letterRequest->rw_processed_at->format('d/m H:i') : 'Menunggu' }}</div>
                </div>

                 <div class="timeline-connector {{ $letterRequest->final_processed_at ? 'status-completed' : '' }}"></div>

                <!-- Step 4: Selesai -->
                 @php
                    $final_status = 'default';
                    if($letterRequest->isApproved()) $final_status = 'completed';
                @endphp
                <div class="timeline-step status-{{ $final_status }}">
                    <div class="step-icon">
                       @if($final_status == 'completed') <i class="fas fa-award"></i> @else 4 @endif
                    </div>
                    <div class="step-text fw-bold">Selesai</div>
                     <div class="step-text text-muted small">{{ $letterRequest->final_processed_at ? $letterRequest->final_processed_at->format('d/m H:i') : 'Menunggu' }}</div>
                </div>
            </div>

            @if($letterRequest->rejection_reason)
                <div class="alert alert-danger mt-4">
                    <strong>Ditolak:</strong> {{ $letterRequest->rejection_reason }}
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-7">
            <!-- Data Pengajuan -->
            <div class="card shadow-sm mb-4">
                 <div class="card-header"><h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Data Pengajuan</h5></div>
                 <div class="card-body">
                     @if($letterRequest->form_data)
                        <dl class="dl-horizontal">
                             @foreach($letterRequest->form_data as $key => $value)
                                <dt>{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                <dd>{{ $value }}</dd>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-muted">Tidak ada data tambahan.</p>
                    @endif
                 </div>
            </div>

            <!-- Riwayat Persetujuan -->
             @if($letterRequest->approvals->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header"><h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Persetujuan</h5></div>
                    <ul class="list-group list-group-flush">
                        @foreach($letterRequest->approvals as $approval)
                            <li class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $approval->approver->name }} ({{ strtoupper($approval->approval_level) }})</h6>
                                    <small>{{ $approval->processed_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 fst-italic">"{{ $approval->notes ?? 'Tidak ada catatan.' }}"</p>
                                @if($approval->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                     <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-lg-5">
             <!-- Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Aksi</h5></div>
                <div class="card-body">
                    @if($letterRequest->isApproved())
                        <div class="d-grid gap-2">
                             <a href="{{ route('letter-requests.download', $letterRequest) }}" class="btn btn-success"><i class="fas fa-download me-2"></i>Download PDF</a>
                             <a href="{{ route('qr-verification.verify', ['requestNumber' => $letterRequest->request_number]) }}" target="_blank" class="btn btn-secondary"><i class="fas fa-qrcode me-2"></i>Verifikasi QR</a>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada aksi yang tersedia hingga surat disetujui.</p>
                    @endif
                </div>
            </div>

             <!-- QR Code -->
            @if($qrCodeBase64)
                 <div class="card shadow-sm mb-4">
                    <div class="card-header"><h5 class="mb-0"><i class="fas fa-qrcode me-2"></i>QR Code Verifikasi</h5></div>
                    <div class="card-body text-center">
                       <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="img-fluid rounded">
                       <p class="mt-2 small text-muted">Scan untuk verifikasi keaslian surat.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection