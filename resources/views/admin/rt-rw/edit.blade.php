@extends('layouts.app-bootstrap')

@section('title', 'Edit RT/RW')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Akun {{ strtoupper($user->role) }} {{ str_pad($number, 3, '0', STR_PAD_LEFT) }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Gagal!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info Akun:</strong><br>
                        Email: <span class="fw-bold">{{ $user->email }}</span><br>
                        Role: <span class="fw-bold">{{ $user->role === 'rt' ? 'Ketua RT' : 'Ketua RW' }}</span><br>
                        Status: <span class="badge {{ $user->is_verified && $user->is_approved ? 'bg-success' : 'bg-warning' }}">
                            {{ $user->is_verified && $user->is_approved ? 'Aktif' : 'Pending' }}
                        </span>
                    </div>

                    <form action="{{ route('admin.rt-rw.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   required placeholder="Contoh: Budi Santoso">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Minimal 8 karakter. Kosongkan jika tidak ingin mengubah.
                            </small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.rt-rw.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
