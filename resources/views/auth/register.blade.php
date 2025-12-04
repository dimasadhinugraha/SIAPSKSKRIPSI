<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIAP SK Desa Ciasmara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 76px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: rgba(255,255,255,0.95) !important;
        }
        .register-container {
            flex: 1;
            padding: 2rem 0;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.15);
        }
        .input-group-text {
            background: transparent;
            border-right: none;
            min-width: 45px;
            justify-content: center;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus + .input-group-text {
            border-color: #86b7fe;
        }
        .form-text {
            font-size: 0.875em;
            color: #6c757d;
        }
        @media (max-width: 991px) {
            .navbar-collapse {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                border-radius: 0 0 1rem 1rem;
                z-index: 1000;
            }
            .navbar-nav {
                padding: 0.5rem;
            }
            .navbar-nav .nav-item {
                margin: 0.5rem 0;
                text-align: center;
            }
            .navbar-nav .btn {
                margin-top: 0.5rem;
            }
            .register-card {
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    @include('layouts.partials.navbar')

    <!-- Register Form -->
    <div class="register-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="register-card p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Daftar Akun</h2>
                            <p class="text-muted">Silakan lengkapi data diri Anda</p>
                        </div>

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Gagal mendaftar!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Pilihan Jenis Pendaftaran -->
                            <div class="card mb-4 border-0 bg-light">
                                <div class="card-header bg-transparent border-0 pt-3">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-users me-2"></i>
                                        Jenis Pendaftaran
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="registration_type" id="new_family" value="new_family" checked>
                                                <label class="form-check-label fw-bold" for="new_family">
                                                    Kepala Keluarga Baru
                                                </label>
                                                <div class="form-text">Anda adalah kepala keluarga dan akan mendaftarkan keluarga baru</div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="registration_type" id="existing_family" value="existing_family">
                                                <label class="form-check-label fw-bold" for="existing_family">
                                                    Anggota Keluarga
                                                </label>
                                                <div class="form-text">Anda adalah anggota keluarga yang sudah terdaftar</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Identitas Diri -->
                            <div class="card mb-4 border-0 bg-light">
                                <div class="card-header bg-transparent border-0 pt-3">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-user-circle me-2"></i>
                                        Identitas Diri
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- NIK -->
                                        <div class="col-md-6 mb-3">
                                            <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" required pattern="[0-9]{16}" maxlength="16">
                                            <div class="invalid-feedback">NIK harus 16 digit angka.</div>
                                        </div>

                                        <!-- Nama Lengkap -->
                                        <div class="col-md-6 mb-3">
                                            <label for="fullName" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="fullName" name="name" value="{{ old('name') }}" placeholder="Sesuai KTP" required>
                                            <div class="invalid-feedback">Nama lengkap harus diisi.</div>
                                        </div>
                                        
                                        <!-- Tanggal Lahir -->
                                        <div class="col-md-6 mb-3">
                                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                            <div class="invalid-feedback">Tanggal lahir harus diisi.</div>
                                        </div>

                                        <!-- Jenis Kelamin -->
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih...</option>
                                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            <div class="invalid-feedback">Jenis kelamin harus dipilih.</div>
                                        </div>

                                        <!-- Alamat -->
                                        <div class="col-12 mb-3">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="address" name="address" placeholder="Alamat lengkap sesuai KTP" required rows="2">{{ old('address') }}</textarea>
                                            <div class="invalid-feedback">Alamat harus diisi.</div>
                                        </div>

                                        <!-- Nomor HP -->
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Nomor Handphone</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" required pattern="[0-9]{10,15}">
                                            <div class="invalid-feedback">Nomor HP harus valid (10-15 digit).</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <!-- Data Keluarga -->
                             <div class="card mb-4 border-0 bg-light">
                                <div class="card-header bg-transparent border-0 pt-3">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-users me-2"></i>
                                        Data Keluarga
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <!-- Pencarian Keluarga (hanya untuk anggota keluarga) -->
                                    <div id="family_search_section" class="row" style="display: none;">
                                        <div class="col-12 mb-3">
                                            <label for="family_search" class="form-label">Cari Keluarga Anda <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" id="family_search" placeholder="Ketik nama kepala keluarga atau nama keluarga..." autocomplete="off">
                                                <input type="hidden" name="family_id" id="family_id">
                                                <div id="family_search_results" class="list-group position-absolute w-100 shadow-lg" style="display: none; z-index: 1050; max-height: 350px; overflow-y: auto; top: 100%; margin-top: 2px;"></div>
                                            </div>
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Ketik nama kepala keluarga (minimal 3 karakter) untuk mencari keluarga Anda
                                            </div>
                                        </div>
                                        <div id="selected_family_info" class="col-12 mb-3" style="display: none;">
                                            <div class="alert alert-success alert-dismissible fade show">
                                                <button type="button" class="btn-close" id="clear_family_selection"></button>
                                                <h6 class="alert-heading mb-2">
                                                    <i class="fas fa-check-circle me-2"></i>Keluarga Terpilih
                                                </h6>
                                                <div id="family_info_content"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form untuk Kepala Keluarga Baru -->
                                    <div id="new_family_section" class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="family_name" class="form-label">Nama Keluarga <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control new-family-required" id="family_name" name="family_name" value="{{ old('family_name') }}" placeholder="Contoh: Keluarga Wijaya">
                                            <div class="invalid-feedback">Nama keluarga harus diisi.</div>
                                        </div>

                                        <!-- Nomor KK -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kk_number" class="form-label">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control new-family-required" id="kk_number" name="kk_number" value="{{ old('kk_number') }}" placeholder="16 digit nomor KK" pattern="[0-9]{16}" maxlength="16">
                                            <div class="invalid-feedback">Nomor KK harus 16 digit angka.</div>
                                        </div>
                                        
                                        <!-- RT/RW -->
                                        <div class="col-md-6 mb-3">
                                            <label for="rt_rw" class="form-label">Pilih RT/RW Anda <span class="text-danger">*</span></label>
                                            <select class="form-select new-family-required" id="rt_rw" name="rt_rw">
                                                <option value="" disabled selected>Pilih dari daftar...</option>
                                                @if(isset($rws) && $rws->count() > 0 && isset($rts))
                                                    @foreach($rws as $rw)
                                                        <optgroup label="{{ optional($rw->biodata)->rt_rw }}">
                                                            @foreach($rts->where('biodata.rw_id', $rw->id) as $rt)
                                                                <option value="{{ optional($rt->biodata)->rt_rw }}" {{ old('rt_rw') == optional($rt->biodata)->rt_rw ? 'selected' : '' }}>
                                                                    {{ optional($rt->biodata)->rt_rw }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>Tidak ada data RT/RW tersedia.</option>
                                                @endif
                                            </select>
                                            <div class="invalid-feedback">Anda harus memilih RT/RW.</div>
                                        </div>
                                    </div>

                                    <!-- Info untuk anggota keluarga (data otomatis terisi) -->
                                    <div id="existing_family_data" class="row" style="display: none;">
                                        <div class="col-12">
                                            <div class="alert alert-success">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Data keluarga (Alamat, Nomor KK, RT/RW) akan otomatis terisi dari keluarga yang Anda pilih.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Informasi Akun -->
                            <div class="card mb-4 border-0 bg-light">
                                <div class="card-header bg-transparent border-0 pt-3">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-key me-2"></i>
                                        Informasi Akun
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Email -->
                                        <div class="col-md-12 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                                            <div class="invalid-feedback">Masukkan alamat email yang valid.</div>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required minlength="8">
                                            <div class="invalid-feedback">Password minimal 8 karakter.</div>
                                        </div>

                                        <!-- Konfirmasi Password -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                                            <div class="invalid-feedback">Password tidak cocok.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumen Pendukung -->
                            <div class="card mb-4 border-0 bg-light">
                                <div class="card-header bg-transparent border-0 pt-3">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-file-alt me-2"></i>
                                        Dokumen Pendukung
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- KTP -->
                                        <div class="col-md-6 mb-3">
                                            <label for="ktp_photo" class="form-label">Foto KTP</label>
                                            <input type="file" class="form-control" id="ktp_photo" name="ktp_photo" accept="image/*" required>
                                            <div class="invalid-feedback">Upload foto KTP.</div>
                                        </div>

                                        <!-- KK -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kk_photo" class="form-label">Foto Kartu Keluarga</label>
                                            <input type="file" class="form-control" id="kk_photo" name="kk_photo" accept="image/*" required>
                                            <div class="invalid-feedback">Upload foto Kartu Keluarga.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 mb-4 fw-semibold">
                                Daftar
                            </button>

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="text-decoration-none">Login disini</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.footer-dark')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Registration type toggle
        const newFamilyRadio = document.getElementById('new_family');
        const existingFamilyRadio = document.getElementById('existing_family');
        const newFamilySection = document.getElementById('new_family_section');
        const familySearchSection = document.getElementById('family_search_section');
        const existingFamilyData = document.getElementById('existing_family_data');
        const addressField = document.getElementById('address');

        function toggleRegistrationType() {
            if (newFamilyRadio.checked) {
                // Kepala Keluarga Baru
                newFamilySection.style.display = 'flex';
                familySearchSection.style.display = 'none';
                existingFamilyData.style.display = 'none';
                addressField.removeAttribute('readonly');
                
                // Set required for new family fields
                document.querySelectorAll('.new-family-required').forEach(field => {
                    field.setAttribute('required', 'required');
                });
            } else {
                // Anggota Keluarga
                newFamilySection.style.display = 'none';
                familySearchSection.style.display = 'flex';
                existingFamilyData.style.display = 'block';
                addressField.setAttribute('readonly', 'readonly');
                
                // Remove required from new family fields
                document.querySelectorAll('.new-family-required').forEach(field => {
                    field.removeAttribute('required');
                });
            }
        }

        newFamilyRadio.addEventListener('change', toggleRegistrationType);
        existingFamilyRadio.addEventListener('change', toggleRegistrationType);

        // Family search functionality
        const familySearchInput = document.getElementById('family_search');
        const familySearchResults = document.getElementById('family_search_results');
        const familyIdInput = document.getElementById('family_id');
        const selectedFamilyInfo = document.getElementById('selected_family_info');
        const familyInfoContent = document.getElementById('family_info_content');

        let searchTimeout;

        familySearchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 3) {
                familySearchResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/api/families/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            displaySearchResults(data.data);
                        } else {
                            familySearchResults.innerHTML = '<div class="p-3 text-muted">Keluarga tidak ditemukan</div>';
                            familySearchResults.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        familySearchResults.innerHTML = '<div class="p-3 text-danger">Terjadi kesalahan saat mencari</div>';
                        familySearchResults.style.display = 'block';
                    });
            }, 300);
        });

        function displaySearchResults(families) {
            if (families.length === 0) {
                familySearchResults.innerHTML = `
                    <div class="list-group-item text-center text-muted py-3">
                        <i class="fas fa-search me-2"></i>Keluarga tidak ditemukan
                    </div>
                `;
                familySearchResults.style.display = 'block';
                return;
            }

            let html = '';
            families.forEach((family, index) => {
                html += `
                    <button type="button" class="list-group-item list-group-item-action family-result-item border-0 ${index > 0 ? 'border-top' : ''}" data-family-id="${family.id}">
                        <div class="d-flex w-100 align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-bold">${family.family_name}</h6>
                                    <small class="badge bg-info text-dark">${family.rt_rw}</small>
                                </div>
                                <p class="mb-1 small text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    <strong>Kepala Keluarga:</strong> ${family.head_of_family_name}
                                </p>
                                <p class="mb-0 small text-muted">
                                    <i class="fas fa-id-card me-1"></i>
                                    <strong>No. KK:</strong> ${family.kk_number}
                                </p>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </button>
                `;
            });
            
            familySearchResults.innerHTML = html;
            familySearchResults.style.display = 'block';

            // Add click handlers
            document.querySelectorAll('.family-result-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const familyId = this.getAttribute('data-family-id');
                    selectFamily(familyId);
                });
            });
        }

        function selectFamily(familyId) {
            fetch(`/api/families/${familyId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const family = data.data;
                        
                        // Set family ID
                        familyIdInput.value = family.id;
                        
                        // Auto-fill address
                        addressField.value = family.address;
                        addressField.setAttribute('readonly', 'readonly');
                        
                        // Display selected family info with better styling
                        familyInfoContent.innerHTML = `
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Nama Keluarga</small>
                                    <strong>${family.family_name}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">RT/RW</small>
                                    <strong>${family.rt_rw}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Nomor KK</small>
                                    <strong>${family.kk_number}</strong>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Kepala Keluarga</small>
                                    <strong>${family.head_of_family_name}</strong>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Alamat</small>
                                    <strong>${family.address}</strong>
                                </div>
                            </div>
                        `;
                        
                        selectedFamilyInfo.style.display = 'block';
                        familySearchResults.style.display = 'none';
                        familySearchInput.value = family.head_of_family_name + ' - ' + family.family_name;
                        familySearchInput.setAttribute('readonly', 'readonly');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memilih keluarga');
                });
        }

        // Clear family selection
        document.addEventListener('DOMContentLoaded', function() {
            const clearFamilyBtn = document.getElementById('clear_family_selection');
            if (clearFamilyBtn) {
                clearFamilyBtn.addEventListener('click', function() {
                    familyIdInput.value = '';
                    familySearchInput.value = '';
                    familySearchInput.removeAttribute('readonly');
                    addressField.value = '';
                    addressField.removeAttribute('readonly');
                    selectedFamilyInfo.style.display = 'none';
                    familySearchInput.focus();
                });
            }
        });

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!familySearchInput.contains(e.target) && !familySearchResults.contains(e.target)) {
                familySearchResults.style.display = 'none';
            }
        });

        // Form validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    const password = form.querySelector('#password');
                    const confirmation = form.querySelector('#password_confirmation');
                    if (confirmation.value && password.value !== confirmation.value) {
                        confirmation.setCustomValidity('Passwords do not match');
                    } else {
                        confirmation.setCustomValidity('');
                    }

                    // Additional validation for existing family
                    if (existingFamilyRadio.checked && !familyIdInput.value) {
                        event.preventDefault();
                        event.stopPropagation();
                        alert('Silakan pilih keluarga Anda dari hasil pencarian');
                        return false;
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>