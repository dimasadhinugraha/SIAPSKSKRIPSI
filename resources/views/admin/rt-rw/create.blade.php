@extends('layouts.app-bootstrap')

@section('title', 'Tambah RT/RW')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Akun RT/RW Baru
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

                    <form action="{{ route('admin.rt-rw.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label">Tipe Akun <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_rt" value="rt" {{ old('role', 'rt') == 'rt' ? 'checked' : '' }} onchange="updatePreview()">
                                <label class="form-check-label" for="role_rt">
                                    <i class="fas fa-house-user text-info me-1"></i> Ketua RT
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_rw" value="rw" {{ old('role') == 'rw' ? 'checked' : '' }} onchange="updatePreview()">
                                <label class="form-check-label" for="role_rw">
                                    <i class="fas fa-building text-success me-1"></i> Ketua RW
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="number" class="form-label">Nomor <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('number') is-invalid @enderror" 
                                   id="number" name="number" value="{{ old('number') }}" 
                                   min="1" max="999" required placeholder="Contoh: 35" oninput="updatePreview()">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                RT yang sudah ada: <span id="existing-rt">{{ $existingRtNumbers->implode(', ') ?: 'Belum ada' }}</span><br>
                                RW yang sudah ada: <span id="existing-rw">{{ $existingRwNumbers->implode(', ') ?: 'Belum ada' }}</span>
                            </small>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   required placeholder="Contoh: Budi Santoso">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required 
                                   placeholder="Minimal 8 karakter">
                            <small class="form-text text-muted">Password minimal 8 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Preview:</strong><br>
                            Email: <span id="preview-email" class="fw-bold">rt001@siappsk.local</span><br>
                            Role: <span id="preview-role" class="fw-bold">Ketua RT</span>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.rt-rw.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updatePreview() {
        const role = document.querySelector('input[name="role"]:checked').value;
        const number = document.getElementById('number').value || '1';
        const paddedNumber = number.padStart(3, '0');
        
        document.getElementById('preview-email').textContent = `${role}${paddedNumber}@siappsk.local`;
        document.getElementById('preview-role').textContent = role === 'rt' ? 'Ketua RT' : 'Ketua RW';
    }

    // Initialize on page load
    updatePreview();
</script>
@endsection
