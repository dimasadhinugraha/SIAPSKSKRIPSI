@extends('layouts.app-bootstrap')

@section('title', 'Tambah Anggota Keluarga')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card bg-primary bg-gradient text-white mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Anggota Keluarga</h1>
                    <p class="mb-0 small">Lengkapi data anggota keluarga baru dengan benar</p>
                </div>
                <a href="{{ route('family-members.index') }}" class="btn btn-light text-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
             <h5 class="mb-0">Formulir Anggota Keluarga</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('family-members.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Data Pribadi -->
                <h6 class="mb-3 text-primary">👤 Data Pribadi</h6>
                <div class="row g-3 mb-4">
                    <!-- NIK -->
                    <div class="col-md-6">
                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nik" 
                               id="nik" 
                               value="{{ old('nik') }}"
                               maxlength="16"
                               pattern="[0-9]{16}"
                               class="form-control @error('nik') is-invalid @enderror"
                               placeholder="Masukkan 16 digit NIK"
                               required>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="gender" 
                                id="gender" 
                                class="form-select @error('gender') is-invalid @enderror"
                                required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hubungan Keluarga -->
                    <div class="col-md-6">
                        <label for="relationship" class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                        <select name="relationship" 
                                id="relationship" 
                                class="form-select @error('relationship') is-invalid @enderror"
                                required>
                            <option value="">Pilih Hubungan Keluarga</option>
                            @foreach(App\Models\FamilyMember::getRelationshipOptions() as $key => $label)
                                <option value="{{ $key }}" {{ old('relationship') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('relationship')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="col-md-6">
                        <label for="place_of_birth" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="place_of_birth" 
                               id="place_of_birth" 
                               value="{{ old('place_of_birth') }}"
                               class="form-control @error('place_of_birth') is-invalid @enderror"
                               placeholder="Masukkan tempat lahir"
                               required>
                        @error('place_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" 
                               name="date_of_birth" 
                               id="date_of_birth" 
                               value="{{ old('date_of_birth') }}"
                               max="{{ date('Y-m-d') }}"
                               class="form-control @error('date_of_birth') is-invalid @enderror"
                               required>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Tambahan -->
                <h6 class="mb-3 text-primary">📋 Data Tambahan</h6>
                <div class="row g-3 mb-4">
                     <!-- Agama -->
                    <div class="col-md-6">
                        <label for="religion" class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="religion" 
                                id="religion" 
                                class="form-select @error('religion') is-invalid @enderror"
                                required>
                            <option value="">Pilih Agama</option>
                            @foreach(App\Models\FamilyMember::getReligionOptions() as $key => $label)
                                <option value="{{ $key }}" {{ old('religion') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('religion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Perkawinan -->
                    <div class="col-md-6">
                        <label for="marital_status" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="marital_status" 
                                id="marital_status" 
                                class="form-select @error('marital_status') is-invalid @enderror"
                                required>
                            <option value="">Pilih Status Perkawinan</option>
                            @foreach(App\Models\FamilyMember::getMaritalStatusOptions() as $key => $label)
                                <option value="{{ $key }}" {{ old('marital_status') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('marital_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pendidikan -->
                    <div class="col-md-6">
                        <label for="education" class="form-label">Pendidikan Terakhir</label>
                        <select name="education" 
                                id="education" 
                                class="form-select @error('education') is-invalid @enderror">
                            <option value="">Pilih Pendidikan</option>
                            @foreach(App\Models\FamilyMember::getEducationOptions() as $key => $label)
                                <option value="{{ $key }}" {{ old('education') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('education')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pekerjaan -->
                    <div class="col-md-6">
                        <label for="occupation" class="form-label">Pekerjaan</label>
                        <input type="text" 
                               name="occupation" 
                               id="occupation" 
                               value="{{ old('occupation') }}"
                               class="form-control @error('occupation') is-invalid @enderror"
                               placeholder="Masukkan pekerjaan">
                        @error('occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     <!-- Kewarganegaraan -->
                    <div class="col-md-4">
                        <label for="nationality" class="form-label">Kewarganegaraan</label>
                        <input type="text" 
                               name="nationality" 
                               id="nationality" 
                               value="{{ old('nationality', 'WNI') }}"
                               class="form-control @error('nationality') is-invalid @enderror"
                               placeholder="WNI">
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Ayah -->
                    <div class="col-md-4">
                        <label for="father_name" class="form-label">Nama Ayah</label>
                        <input type="text" 
                               name="father_name" 
                               id="father_name" 
                               value="{{ old('father_name') }}"
                               class="form-control @error('father_name') is-invalid @enderror"
                               placeholder="Masukkan nama ayah">
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Ibu -->
                    <div class="col-md-4">
                        <label for="mother_name" class="form-label">Nama Ibu</label>
                        <input type="text" 
                               name="mother_name" 
                               id="mother_name" 
                               value="{{ old('mother_name') }}"
                               class="form-control @error('mother_name') is-invalid @enderror"
                               placeholder="Masukkan nama ibu">
                        @error('mother_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Dokumen Pendukung -->
                <h6 class="mb-3 text-primary">📄 Dokumen Pendukung</h6>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Perhatian!</h6>
                            <p class="mb-1">Upload dokumen pendukung yang valid untuk verifikasi admin. Dokumen yang dapat diterima:</p>
                            <ul class="mb-0 small">
                                <li>Foto KTP anggota keluarga yang bersangkutan</li>
                                <li>Foto Kartu Keluarga yang mencantumkan nama anggota keluarga</li>
                                <li>Akta kelahiran (untuk anak) atau Surat nikah (untuk pasangan)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="supporting_document" class="form-label">Upload Dokumen <span class="text-danger">*</span></label>
                        <input type="file"
                               name="supporting_document"
                               id="supporting_document"
                               accept="image/*,application/pdf"
                               required
                               class="form-control @error('supporting_document') is-invalid @enderror">
                        <div class="form-text">Format: JPG, PNG, PDF. Maksimal 2MB</div>
                        @error('supporting_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Catatan -->
                <h6 class="mb-3 text-primary">📝 Catatan Tambahan</h6>
                 <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  class="form-control @error('notes') is-invalid @enderror"
                                  placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="card-footer bg-transparent text-end border-0 px-0">
                    <a href="{{ route('family-members.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" name="add_another" value="1" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Simpan & Tambah Lagi
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto format NIK input to only allow numbers
    document.getElementById('nik').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>
@endpush