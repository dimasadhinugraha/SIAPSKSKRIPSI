@extends('layouts.public-bootstrap')

@section('title', 'Scan QR Code Verifikasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="card-title fw-bold">Verifikasi Surat Digital</h2>
                        <p class="text-muted">Scan QR Code yang ada pada surat untuk memverifikasi keaslian dan status surat.</p>
                    </div>

                    <!-- QR Scanner Area -->
                    <div class="mb-4">
                        <div id="qr-scanner" class="mx-auto border rounded-3 p-2" style="width: 100%; max-width: 400px;">
                            <!-- QR Scanner will be initialized here -->
                        </div>
                    </div>

                    <!-- Result Area -->
                    <div id="verification-result" class="mt-4 d-none">
                        <!-- Results will be displayed here -->
                    </div>
                    
                    <hr>

                    <!-- Manual Input Alternative -->
                    <div class="pt-3">
                        <p class="text-center text-muted">Atau masukkan data dari QR Code secara manual:</p>
                        <form id="manual-verify-form">
                            <div class="mb-3">
                                <label for="qr_content" class="form-label visually-hidden">Data QR Code</label>
                                <textarea id="qr_content" name="qr_content" rows="3" class="form-control" placeholder="Paste data QR Code di sini..."></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary">Verifikasi Manual</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    // Pass Laravel data to JavaScript
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const verifyContentUrl = '{{ route("qr-verification.verify-content") }}';
    const verifyLetterBaseUrl = '{{ url("/verify-letter") }}';
</script>
<script src="{{ asset('js/qr-scanner.js') }}"></script>
@endpush