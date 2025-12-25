@extends('layouts.app-bootstrap')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>Edit Pengguna: {{ $user->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Account Information -->
                        <h6 class="border-bottom pb-2 mb-3">Informasi Akun</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="rt" {{ old('role', $user->role) == 'rt' ? 'selected' : '' }}>RT</option>
                                    <option value="rw" {{ old('role', $user->role) == 'rw' ? 'selected' : '' }}>RW</option>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

        <!-- Personal Information -->
        <h6 class="border-bottom pb-2 mb-3 mt-4">Data Pribadi</h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                       id="nik" name="nik" value="{{ old('nik', $user->nik) }}" 
                       maxlength="16" pattern="[0-9]{16}" required>
                <small class="text-muted">16 digit</small>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                @php
                    $gender = old('jenis_kelamin', $user->biodata?->gender ?? $user->gender);
                @endphp
                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                        id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ $gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                       id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $user->birth_place) }}">
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                @php
                    $birthDate = $user->biodata?->birth_date ?? $user->birth_date;
                    $birthDateFormatted = $birthDate ? \Carbon\Carbon::parse($birthDate)->format('Y-m-d') : '';
                @endphp
                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                       id="tanggal_lahir" name="tanggal_lahir" 
                       value="{{ old('tanggal_lahir', $birthDateFormatted) }}" required>
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
            @php
                $address = old('alamat', $user->biodata?->address ?? $user->address);
            @endphp
            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                      id="alamat" name="alamat" rows="3" required>{{ $address }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>        <div class="row mb-3">
            <div class="col-md-4">
                <label for="rt_rw" class="form-label">RT/RW <span class="text-danger">*</span></label>
                @php
                    $rtRw = '';
                    if ($user->biodata && $user->biodata->rt_rw) {
                        $rtRw = $user->biodata->rt_rw;
                    } elseif ($user->rt && $user->rw) {
                        $rtRw = sprintf('%03d/%03d', $user->rt, $user->rw);
                    }
                @endphp
                <input type="text" class="form-control @error('rt_rw') is-invalid @enderror" 
                       id="rt_rw" name="rt_rw" 
                       value="{{ old('rt_rw', $rtRw) }}" 
                       placeholder="001/002" required>
                <small class="text-muted">Format: RT/RW (contoh: 001/002)</small>
                @error('rt_rw')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                @php
                    $phone = old('no_telepon', $user->biodata?->phone ?? $user->phone);
                @endphp
                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                       id="no_telepon" name="no_telepon" value="{{ $phone }}" required>
                @error('no_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="no_kk" class="form-label">No. KK <span class="text-danger">*</span></label>
                @php
                    $kkNumber = old('no_kk', $user->biodata?->kk_number ?? $user->kk_number);
                @endphp
                <input type="text" class="form-control @error('no_kk') is-invalid @enderror" 
                       id="no_kk" name="no_kk" value="{{ $kkNumber }}" 
                       maxlength="16" pattern="[0-9]{16}" required>
                <small class="text-muted">16 digit</small>
                @error('no_kk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>        <!-- Document Upload -->
        <h6 class="border-bottom pb-2 mb-3 mt-4">Dokumen</h6>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="foto_ktp" class="form-label">Foto KTP</label>
                @php
                    $ktpPhoto = $user->biodata?->ktp_photo ?? $user->ktp_photo;
                @endphp
                @if($ktpPhoto)
                    <div class="mb-2">
                        <img src="{{ Storage::url($ktpPhoto) }}" 
                             alt="KTP" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif
                <input type="file" class="form-control @error('foto_ktp') is-invalid @enderror" 
                       id="foto_ktp" name="foto_ktp" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah. Format: JPG, PNG. Max 2MB</small>
                @error('foto_ktp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="foto_kk" class="form-label">Foto KK</label>
                @php
                    $kkPhoto = $user->biodata?->kk_photo ?? $user->kk_photo;
                @endphp
                @if($kkPhoto)
                    <div class="mb-2">
                        <img src="{{ Storage::url($kkPhoto) }}" 
                             alt="KK" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                @endif
                <input type="file" class="form-control @error('foto_kk') is-invalid @enderror" 
                       id="foto_kk" name="foto_kk" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah. Format: JPG, PNG. Max 2MB</small>
                @error('foto_kk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>                        <!-- Status -->
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Status Akun</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_verified" 
                                           name="is_verified" value="1" {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_verified">
                                        Akun Terverifikasi
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_approved" 
                                           name="is_approved" value="1" {{ old('is_approved', $user->is_approved) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_approved">
                                        Akun Disetujui
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Update Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
