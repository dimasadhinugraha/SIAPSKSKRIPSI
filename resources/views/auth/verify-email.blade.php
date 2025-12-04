@extends('layouts.public-bootstrap')

@section('title', 'Minta Verifikasi Email')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Minta Link Verifikasi Email</h4>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('verify.email.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" name="email" id="email" class="form-control" required placeholder="Masukkan email yang terdaftar">
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('login') }}" class="btn btn-link me-2">Kembali ke Login</a>
                                <button class="btn btn-primary">Kirim Link Verifikasi</button>
                            </div>
                        </form>

                        <hr class="my-3">
                        <p class="small text-muted">Jika Anda mengalami kesulitan menerima email verifikasi, mohon hubungi admin desa atau periksa folder spam. Pastikan juga konfigurasi mail di server sudah benar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
