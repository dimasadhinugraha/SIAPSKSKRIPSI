@extends('layouts.app-bootstrap')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-fluid">
        <!-- Profile Header -->
        <div class="card bg-success bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ auth()->user()->biodata && auth()->user()->biodata->profile_photo ? Storage::url(auth()->user()->biodata->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}"
                             alt="Profile" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover; border: 2px solid white;">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h1 class="h4 mb-0">{{ auth()->user()->name }}</h1>
                        <div class="d-flex flex-column text-white-75 small">
                            <span class="mb-1"><i class="fas fa-envelope fa-fw me-2"></i>{{ auth()->user()->email ?? '-' }}</span>
                            <span><i class="fas fa-map-marker-alt fa-fw me-2"></i>{{ auth()->user()->biodata->rt_rw ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-success fs-6">{{ auth()->user()->role_label }}</span>
                        @if(auth()->user()->is_verified)
                            <span class="badge bg-light text-primary fs-6 ms-2">✓ Terverifikasi</span>
                        @else
                            <span class="badge bg-warning text-dark fs-6 ms-2">Menunggu Verifikasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Biodata Cards -->
        <div class="row">
            <!-- Profile Photo Upload -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-camera fa-fw me-2 text-primary"></i>
                        <h5 class="mb-0">Foto Profil</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <img src="{{ auth()->user()->biodata && auth()->user()->biodata->profile_photo ? Storage::url(auth()->user()->biodata->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random&size=200' }}"
                                 alt="Profile" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #dee2e6;">
                        </div>
                        
                        <form action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data" id="uploadPhotoForm">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(event)">
                                <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB</small>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-2"></i>Upload Foto
                                </button>
                                @if(auth()->user()->biodata && auth()->user()->biodata->profile_photo)
                                <button type="button" class="btn btn-outline-danger" onclick="deletePhoto()">
                                    <i class="fas fa-trash me-2"></i>Hapus Foto
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-user fa-fw me-2 text-primary"></i>
                        <h5 class="mb-0">Informasi Personal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 text-muted">NIK</div>
                            <div class="col-sm-7 font-monospace">{{ auth()->user()->nik ?? '-' }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Nama Lengkap</div>
                            <div class="col-sm-7">{{ auth()->user()->name }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Email</div>
                            <div class="col-sm-7">{{ auth()->user()->email ?? '-' }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Nomor Telepon</div>
                            <div class="col-sm-7">{{ auth()->user()->biodata->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-home fa-fw me-2 text-success"></i>
                        <h5 class="mb-0">Informasi Alamat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5 text-muted">RT/RW</div>
                            <div class="col-sm-7">{{ auth()->user()->biodata->rt_rw ?? '-' }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Alamat Lengkap</div>
                            <div class="col-sm-7">{{ auth()->user()->biodata->address ?? 'Belum diisi' }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Desa</div>
                            <div class="col-sm-7">{{ config('app.village_name', 'Ciasmara') }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Kecamatan</div>
                            <div class="col-sm-7">{{ config('app.district_name', 'Pamijahan') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-shield-alt fa-fw me-2 text-purple"></i>
                        <h5 class="mb-0">Informasi Akun</h5>
                    </div>
                    <div class="card-body">
                         <div class="row">
                            <div class="col-sm-5 text-muted">Role/Peran</div>
                            <div class="col-sm-7">{{ auth()->user()->role_label }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Status Verifikasi</div>
                            <div class="col-sm-7">
                                @if(auth()->user()->is_verified)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Tanggal Bergabung</div>
                            <div class="col-sm-7">{{ auth()->user()->created_at->format('d F Y') }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-5 text-muted">Terakhir Diperbarui</div>
                            <div class="col-sm-7">{{ auth()->user()->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Statistics -->
             <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-chart-bar fa-fw me-2 text-info"></i>
                        <h5 class="mb-0">Statistik Aktivitas</h5>
                    </div>
                    <div class="card-body">
                         @php
                            $letterRequests = auth()->user()->letterRequests()->count();
                            $familyMembers = auth()->user()->familyMembers()->count();
                        @endphp
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h2 fw-bold text-primary">{{ $letterRequests }}</div>
                                    <div class="text-muted small">Pengajuan Surat</div>
                                </div>
                            </div>
                             <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h2 fw-bold text-success">{{ $familyMembers }}</div>
                                    <div class="text-muted small">Anggota Keluarga</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Note -->
        <div class="alert alert-info mt-4">
            <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Penting</h4>
            <p>
                Data profil ini bersifat read-only dan tidak dapat diubah oleh user.
                Jika ada kesalahan data atau perlu perubahan, silakan hubungi administrator desa.
            </p>
        </div>
    </div>

    <!-- Delete Photo Form -->
    <form id="deletePhotoForm" action="{{ route('profile.delete-photo') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.querySelector('.rounded-circle.mb-3');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function deletePhoto() {
            if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
                document.getElementById('deletePhotoForm').submit();
            }
        }
    </script>
    @endpush
@endsection