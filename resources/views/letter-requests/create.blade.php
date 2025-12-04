@extends('layouts.app-bootstrap')

@section('title', 'Ajukan Surat Baru')

@push('styles')
<style>
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        text-align: center;
    }
    .stepper-item::before {
        content: "";
        position: absolute;
        top: 18px;
        left: -50%;
        right: 50%;
        height: 2px;
        background-color: #e0e0e0;
        z-index: 1;
    }
    .stepper-item:first-child::before {
        content: none;
    }
    .step-counter {
        height: 40px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: #fff;
        font-weight: bold;
        z-index: 2;
        transition: all 0.3s ease;
        transform: scale(0.9);
    }
    .step-name {
        margin-top: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        transition: all 0.3s ease;
    }
    .stepper-item.active .step-counter {
        background-color: var(--bs-primary);
        transform: scale(1.1);
    }
    .stepper-item.active .step-name {
        color: var(--bs-primary);
        font-weight: 600;
    }
    .stepper-item.completed .step-counter {
        background-color: var(--bs-success);
        transform: scale(1);
    }
    .stepper-item.completed .step-name {
        color: #495057;
    }
    .stepper-item.completed + .stepper-item::before {
        background-color: var(--bs-success);
    }

    /* Custom styles for radio button cards */
    .radio-card-input {
        display: none;
    }
    .radio-card {
        border: 2px solid var(--bs-border-color);
        transition: all 0.2s ease-in-out;
    }
    .radio-card-input:checked + .radio-card {
        border-color: var(--bs-primary);
        background-color: var(--bs-primary-bg-subtle);
    }
    .radio-card:hover {
        border-color: var(--bs-primary-border-subtle);
    }
    .fade-in {
        animation: fadeIn 0.5s;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    .compact-form .form-label {
        margin-bottom: 0.25rem;
    }
    .compact-form .form-select, .compact-form .form-control {
        margin-bottom: 0.5rem;
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
                    <h1 class="h4 mb-0 text-white"><i class="fas fa-file-alt me-2"></i>Ajukan Surat Baru</h1>
                    <p class="mb-0 small">Lengkapi formulir pengajuan dalam 3 langkah mudah.</p>
                </div>
                <a href="{{ route('letter-requests.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <!-- Stepper -->
            <div class="stepper-wrapper">
                <div class="stepper-item active" data-step="1">
                    <div class="step-counter">1</div>
                    <div class="step-name">Pilih Subjek</div>
                </div>
                <div class="stepper-item" data-step="2">
                    <div class="step-counter">2</div>
                    <div class="step-name">Jenis Surat</div>
                </div>
                <div class="stepper-item" data-step="3">
                    <div class="step-counter">3</div>
                    <div class="step-name">Lengkapi Data</div>
                </div>
            </div>

            <form method="POST" action="{{ route('letter-requests.store') }}" id="letterForm" class="compact-form">
                @csrf
        
                <!-- Step 1: Subject Selection -->
                <div class="form-step fade-in" data-step="1">
                    <h5 class="mb-3">Langkah 1: Pilih Subjek Surat</h5>
                    <div class="row g-3">
                        <!-- Self Option -->
                        <div class="col-md-6">
                            <input id="subject_self" name="subject_type" type="radio" value="self" class="radio-card-input" {{ old('subject_type', 'self') == 'self' ? 'checked' : '' }}>
                            <label for="subject_self" class="card radio-card p-3 h-100">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Diri Sendiri</div>
                                        <div class="small text-muted">{{ auth()->user()->name }}</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!-- Family Member Option -->
                        @if($familyMembers->count() > 0)
                        <div class="col-md-6">
                            <input id="subject_family" name="subject_type" type="radio" value="family_member" class="radio-card-input" {{ old('subject_type') == 'family_member' ? 'checked' : '' }}>
                             <label for="subject_family" class="card radio-card p-3 h-100">
                                <div class="d-flex align-items-center">
                                     <div class="flex-shrink-0 me-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                            <i class="fas fa-users text-success"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Anggota Keluarga</div>
                                        <div class="small text-muted">{{ $familyMembers->count() }} orang tersedia</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endif
                    </div>
                     @error('subject_type') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
    
                    <!-- Family Member Selection -->
                    @if($familyMembers->count() > 0)
                        <div id="family_member_selection" class="mt-3" style="display: {{ old('subject_type') == 'family_member' ? 'block' : 'none' }};">
                            <label for="subject_id" class="form-label">Pilih Anggota Keluarga</label>
                            <select id="subject_id" name="subject_id" class="form-select">
                                <option value="">-- Pilih Anggota Keluarga --</option>
                                @foreach($familyMembers as $member)
                                    <option value="{{ $member->id }}" {{ old('subject_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} - {{ $member->relationship_label }} (NIK: {{ $member->nik }})
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>
                    @else
                        <div class="alert alert-secondary mt-3">
                            <i class="fas fa-info-circle me-2"></i>Anda belum menambahkan anggota keluarga. Anda dapat menambahkannya di menu 'Data Keluarga'.
                        </div>
                    @endif
                </div>
                
                <!-- Step 2: Letter Type Selection -->
                <div class="form-step fade-in" data-step="2" style="display: none;">
                    <h5 class="mb-3">Langkah 2: Pilih Jenis Surat</h5>
                    <select id="letter_type_id" name="letter_type_id" class="form-select" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach($letterTypes as $type)
                            <option value="{{ $type->id }}" data-fields="{{ json_encode($type->required_fields) }}" {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('letter_type_id') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                </div>
    
                <!-- Step 3: Dynamic Fields Container -->
                <div class="form-step fade-in" data-step="3" style="display: none;">
                    <h5 class="mb-3">Langkah 3: Lengkapi Data Pendukung</h5>
                    <div id="dynamicFields" class="row g-3">
                        <!-- Fields will be loaded here -->
                    </div>
                </div>
    
                 <!-- Hidden select options -->
                <div id="field-options" class="d-none">
                    <div data-field="jeniskelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </div>
                    <div data-field="status_usaha">
                        <option value="">Pilih Status Usaha</option>
                        <option value="Pemilik">Pemilik</option>
                        <option value="Karyawan">Karyawan</option>
                        <option value="Mitra">Mitra</option>
                    </div>
                </div>
    
                <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="backBtn" style="display: none;">
                        Kembali
                    </button>
                    <button type="button" class="btn btn-primary" id="nextBtn">
                        Selanjutnya
                    </button>
                    <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                        <i class="fas fa-paper-plane me-2"></i>Ajukan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/letter-request-form.js') }}"></script>
@endpush
