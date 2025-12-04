@extends('layouts.app-bootstrap')

@section('title', 'Persetujuan Surat')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="card bg-primary bg-gradient text-white mb-4">
            <div class="card-body">
                <h1 class="h4 mb-0"><i class="fas fa-check-double me-2"></i>Daftar Surat Menunggu {{ auth()->user()->isRT() ? 'Persetujuan RT' : 'Persetujuan RW' }}</h1>
                <p class="mb-0 small">Total: {{ $requests->total() }} surat menunggu persetujuan</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                @if($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nomor Pengajuan</th>
                                    <th scope="col">Pemohon</th>
                                    <th scope="col">Jenis Surat</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td class="font-monospace">{{ $request->request_number }}</td>
                                        <td>
                                            @if($request->subject_type === 'family_member' && $request->subject)
                                                <div>{{ $request->subject->name }}</div>
                                                <div class="small text-muted">{{ $request->subject->relationship_label }} - Diajukan oleh {{ $request->user->name }}</div>
                                            @else
                                                <div>{{ $request->user->name }}</div>
                                                <div class="small text-muted">NIK: {{ $request->user->nik }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $request->letterType->name }}</td>
                                        <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('approvals.show', $request) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-search me-1"></i> Review
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
                        <div class="display-4 text-success mb-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="mb-2">Tidak ada surat menunggu persetujuan</h3>
                        <p class="text-muted">Semua surat telah diproses.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection