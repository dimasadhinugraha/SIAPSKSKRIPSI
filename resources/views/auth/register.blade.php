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
                                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                                            <div class="invalid-feedback">Tanggal lahir harus diisi dan minimal berumur 18 tahun.</div>
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

                                        <!-- Agama -->
                                        <div class="col-md-6 mb-3">
                                            <label for="agama" class="form-label">Agama</label>
                                            <select class="form-select" id="agama" name="agama" required>
                                                <option value="" disabled {{ old('agama') ? '' : 'selected' }}>Pilih Agama...</option>
                                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            </select>
                                            <div class="invalid-feedback">Agama harus dipilih.</div>
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
                                    <div class="row">
                                        <!-- Nomor KK -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kk_number" class="form-label">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="kk_number" name="kk_number" value="{{ old('kk_number') }}" placeholder="16 digit nomor KK" required pattern="[0-9]{16}" maxlength="16">
                                            <div class="invalid-feedback">Nomor KK harus 16 digit angka.</div>
                                        </div>
                                        
                                        <!-- RT dan RW terpisah -->
                                        <div class="col-md-3 mb-3">
                                            <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                            <select class="form-select" id="rt" name="rt" required>
                                                <option value="" disabled {{ old('rt') ? '' : 'selected' }}>Pilih RT...</option>
                                                @if(isset($rtUsers) && $rtUsers->count() > 0)
                                                    @foreach($rtUsers as $rt)
                                                        <option value="{{ $rt['number'] }}" {{ old('rt') == $rt['number'] ? 'selected' : '' }}>
                                                            RT {{ str_pad($rt['number'], 3, '0', STR_PAD_LEFT) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="invalid-feedback">Anda harus memilih RT.</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                            <select class="form-select" id="rw" name="rw" required>
                                                <option value="" disabled {{ old('rw') ? '' : 'selected' }}>Pilih RW...</option>
                                                @if(isset($rwUsers) && $rwUsers->count() > 0)
                                                    @foreach($rwUsers as $rw)
                                                        <option value="{{ $rw['number'] }}" {{ old('rw') == $rw['number'] ? 'selected' : '' }}>
                                                            RW {{ str_pad($rw['number'], 3, '0', STR_PAD_LEFT) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="invalid-feedback">Anda harus memilih RW.</div>
                                            @if((!isset($rtUsers) || $rtUsers->count() == 0) && (!isset($rwUsers) || $rwUsers->count() == 0))
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Belum ada RT/RW yang terdaftar. Silakan hubungi admin.
                                                </small>
                                            @endif
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
                                            <input type="file" class="form-control" id="ktp_photo" name="ktp_photo" accept="image/*" required onchange="previewImage(this, 'ktpPreview')">
                                            <div class="invalid-feedback">Upload foto KTP.</div>
                                            <div class="mt-2" id="ktpPreviewContainer" style="display: none;">
                                                <img id="ktpPreview" src="" alt="Preview KTP" class="img-thumbnail" style="max-height: 200px; width: auto;">
                                            </div>
                                        </div>

                                        <!-- KK -->
                                        <div class="col-md-6 mb-3">
                                            <label for="kk_photo" class="form-label">Foto Kartu Keluarga</label>
                                            <input type="file" class="form-control" id="kk_photo" name="kk_photo" accept="image/*" required onchange="previewImage(this, 'kkPreview')">
                                            <div class="invalid-feedback">Upload foto Kartu Keluarga.</div>
                                            <div class="mt-2" id="kkPreviewContainer" style="display: none;">
                                                <img id="kkPreview" src="" alt="Preview KK" class="img-thumbnail" style="max-height: 200px; width: auto;">
                                            </div>
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

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Image preview function
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const container = document.getElementById(previewId + 'Container');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
            }
        }
    </script>
</body>
</html>