@extends('layouts.app-bootstrap')

@section('title', 'Review Pengajuan Surat')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0"><i class="fas fa-search me-2"></i>Review Pengajuan Surat</h1>
                    <p class="mb-0 small">Nomor: {{ $letterRequest->request_number }}</p>
                </div>
                <a href="{{ route('approvals.index') }}" class="btn btn-light text-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $letterRequest->letterType->name }}</h5>
            @php
                $statusColors = [
                    'pending_rt' => 'bg-warning text-dark',
                    'pending_rw' => 'bg-info text-dark',
                    'approved_final' => 'bg-success',
                    'rejected_rt' => 'bg-danger',
                    'rejected_rw' => 'bg-danger',
                    'default' => 'bg-secondary',
                ];
                $statusClass = $statusColors[$letterRequest->status] ?? $statusColors['default'];
            @endphp
            <span class="badge rounded-pill {{ $statusClass }}">{{ $letterRequest->status_label }}</span>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Applicant Data -->
                <div class="col-md-6">
                    <h6 class="text-muted">Data Pemohon</h6>
                    <dl class="dl-horizontal">
                        @if($letterRequest->subject_type === 'family_member' && $letterRequest->subject)
                            <dt>Nama Lengkap</dt><dd>{{ $letterRequest->subject->name }}</dd>
                            <dt>NIK</dt><dd class="font-monospace">{{ $letterRequest->subject->nik }}</dd>
                            <dt>Hubungan</dt><dd>{{ $letterRequest->subject->relationship_label }}</dd>
                            <dt>Tempat/Tgl Lahir</dt><dd>{{ $letterRequest->subject->place_of_birth }}, {{ $letterRequest->subject->date_of_birth->format('d M Y') }}</dd>
                            <dt>Jenis Kelamin</dt><dd>{{ $letterRequest->subject->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                            <dt>Diajukan oleh</dt><dd>{{ $letterRequest->user->name }} ({{ $letterRequest->user->nik }})</dd>
                        @else
                            <dt>Nama Lengkap</dt><dd>{{ $letterRequest->user->name }}</dd>
                            <dt>NIK</dt><dd class="font-monospace">{{ $letterRequest->user->nik }}</dd>
                            <dt>Alamat</dt><dd>{{ $letterRequest->user->biodata->address ?? '-' }}</dd>
                            <dt>RT/RW</dt><dd>{{ $letterRequest->user->biodata->rt_rw ?? '-' }}</dd>
                            <dt>Nomor HP</dt><dd>{{ $letterRequest->user->biodata->phone ?? '-' }}</dd>
                        @endif
                        <dt>Tgl Pengajuan</dt><dd>{{ $letterRequest->created_at->format('d F Y, H:i') }}</dd>
                    </dl>
                </div>

                <!-- Request Data -->
                <div class="col-md-6">
                    <h6 class="text-muted">Data Pengajuan</h6>
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

            <!-- Approval History -->
            @if($letterRequest->approvals->count() > 0)
                <div class="mt-4">
                    <h6 class="text-muted">Riwayat Persetujuan</h6>
                    <ul class="list-group">
                        @foreach($letterRequest->approvals as $approval)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $approval->approver->name }} ({{ strtoupper($approval->approval_level) }})</div>
                                    <small class="text-muted">{{ $approval->processed_at->format('d/m/Y H:i') }}</small>
                                    @if($approval->notes)
                                        <p class="mb-0 mt-1 fst-italic">"{{ $approval->notes }}"</p>
                                    @endif
                                </div>
                                @if($approval->status === 'approved')
                                    <span class="badge bg-success rounded-pill">Disetujui</span>
                                @else
                                     <span class="badge bg-danger rounded-pill">Ditolak</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="card-footer bg-transparent">
             @php
                $canApprove = (auth()->user()->isRT() && $letterRequest->status === 'pending_rt') || 
                              (auth()->user()->isRW() && $letterRequest->status === 'pending_rw');
            @endphp

            @if($canApprove)
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-danger" onclick="openRejectModal()">
                        <i class="fas fa-times me-2"></i>Tolak
                    </button>
                    <button type="button" class="btn btn-success" onclick="openApproveModal()">
                        <i class="fas fa-check me-2"></i>Setujui
                    </button>
                </div>
            @else
                <p class="text-muted text-center small fst-italic">Surat telah diproses atau menunggu persetujuan dari level lain.</p>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveModalLabel">Setujui Pengajuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('approvals.approve', $letterRequest) }}">
          @csrf
          @method('PATCH')
          <div class="modal-body">
              <div class="mb-3">
                  <label for="approve_notes" class="form-label">Catatan (Opsional)</label>
                  <textarea id="approve_notes" name="notes" rows="3" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Setujui</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Tolak Pengajuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('approvals.reject', $letterRequest) }}">
          @csrf
          @method('PATCH')
          <div class="modal-body">
              <div class="mb-3">
                  <label for="reject_notes" class="form-label">Alasan Penolakan</label>
                  <textarea id="reject_notes" name="notes" rows="3" class="form-control" placeholder="Masukkan alasan penolakan..." required></textarea>
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
<script src="{{ asset('js/approval-modal.js') }}"></script>
@endpush