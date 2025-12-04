@extends('layouts.app-bootstrap')

@section('title', 'Riwayat Persetujuan')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="card bg-primary bg-gradient text-white mb-4">
            <div class="card-body">
                <h1 class="h4 mb-0"><i class="fas fa-history me-2"></i>Riwayat Persetujuan Surat</h1>
                <p class="mb-0 small">Melihat kembali semua surat yang telah Anda proses.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        @php
            $approved = $requests->whereIn('status', ['approved_final', 'pending_rw'])->count();
            $rejected = $requests->whereIn('status', ['rejected_rt', 'rejected_rw'])->count();
            $total = $requests->count();
        @endphp
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small">Disetujui</div>
                            <div class="h5 mb-0 fw-bold">{{ $approved }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small">Ditolak</div>
                            <div class="h5 mb-0 fw-bold">{{ $rejected }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-muted small">Total Diproses</div>
                            <div class="h5 mb-0 fw-bold">{{ $total }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Riwayat Surat yang Telah Diproses</h5>
            </div>
            <div class="card-body">
                @if($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor Surat</th>
                                    <th>Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                    <th>Tgl. Proses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td class="font-monospace">{{ $request->request_number }}</td>
                                        <td>
                                            <div>{{ $request->user->name }}</div>
                                            <div class="small text-muted">{{ $request->user->rt_rw }}</div>
                                        </td>
                                        <td>{{ $request->letterType->name }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending_rw' => 'bg-warning text-dark',
                                                    'approved_final' => 'bg-success',
                                                    'rejected_rt' => 'bg-danger',
                                                    'rejected_rw' => 'bg-danger',
                                                ];
                                                $statusClass = $statusColors[$request->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge rounded-pill {{ $statusClass }}">{{ $request->status_label }}</span>
                                        </td>
                                        <td class="small text-muted">
                                             @if(auth()->user()->isRT() && $request->rt_processed_at)
                                                {{ $request->rt_processed_at->format('d/m/Y H:i') }}
                                            @elseif(auth()->user()->isRW() && $request->rw_processed_at)
                                                {{ $request->rw_processed_at->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('approvals.show', $request) }}" class="btn btn-sm btn-outline-primary">
                                               <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($requests->hasPages())
                        <div class="mt-3">
                            {{ $requests->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <div class="display-4 text-muted mb-3"><i class="fas fa-folder-open"></i></div>
                        <h4 class="mb-2">Belum ada riwayat</h4>
                        <p class="text-muted">Anda belum memproses surat apapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection