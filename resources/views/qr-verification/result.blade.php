@extends('layouts.public-bootstrap')

@section('title', 'Hasil Verifikasi Surat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                @if($valid)
                    <div class="card-header bg-success bg-gradient text-white text-center py-3">
                        <h1 class="h3 mb-0"><i class="fas fa-check-circle me-2"></i>Surat Terverifikasi (VALID)</h1>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-center text-muted">{{ $message }}</p>
                        <hr>
                        <h5 class="card-title mb-3">Detail Surat</h5>
                        <dl class="row">
                            <dt class="col-sm-4">Nomor Surat</dt>
                            <dd class="col-sm-8 font-monospace">{{ $letterRequest->request_number }}</dd>

                            <dt class="col-sm-4">Jenis Surat</dt>
                            <dd class="col-sm-8">{{ $letterRequest->letterType->name }}</dd>

                            <dt class="col-sm-4">Tanggal Pengajuan</dt>
                            <dd class="col-sm-8">{{ $letterRequest->created_at->format('d F Y, H:i') }}</dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8"><span class="badge bg-success">{{ $letterRequest->status_label }}</span></dd>
                        </dl>
                        
                        <hr>
                        <h5 class="card-title mb-3">Data Subjek</h5>
                        <dl class="row">
                             <dt class="col-sm-4">Nama</dt>
                            <dd class="col-sm-8">{{ $letterRequest->subject_name }}</dd>

                            <dt class="col-sm-4">NIK</dt>
                            <dd class="col-sm-8 font-monospace">{{ $letterRequest->subject_nik }}</dd>
                        </dl>
                        
                        @if($letterRequest->form_data)
                        <hr>
                        <h5 class="card-title mb-3">Informasi Tambahan</h5>
                        <dl class="row">
                            @foreach($letterRequest->form_data as $key => $value)
                                <dt class="col-sm-4">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                <dd class="col-sm-8">{{ $value }}</dd>
                            @endforeach
                        </dl>
                        @endif

                    </div>
                @else
                    <div class="card-header bg-danger bg-gradient text-white text-center py-3">
                        <h1 class="h3 mb-0"><i class="fas fa-times-circle me-2"></i>Surat Tidak Valid</h1>
                    </div>
                    <div class="card-body p-4 text-center">
                        <p class="h5">{{ $message }}</p>

                        @if($letterRequest)
                        <hr>
                        <p class="text-muted">Informasi surat yang coba diakses:</p>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Nomor Surat
                                <span class="badge bg-secondary rounded-pill">{{ $letterRequest->request_number }}</span>
                            </li>
                             <li class="list-group-item d-flex justify-content-between align-items-center">
                                Status
                                <span class="badge bg-warning text-dark rounded-pill">{{ $letterRequest->status_label }}</span>
                            </li>
                        </ul>
                        @endif
                    </div>
                @endif
                <div class="card-footer text-center">
                     <a href="{{ route('welcome') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection