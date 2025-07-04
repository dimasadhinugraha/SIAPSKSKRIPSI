<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan QR Code Verifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Verifikasi Surat Digital</h3>
                        <p class="text-sm text-gray-600">
                            Scan QR Code yang ada pada surat untuk memverifikasi keaslian dan status surat
                        </p>
                    </div>

                    <!-- QR Scanner Area -->
                    <div class="mb-6">
                        <div id="qr-scanner" class="mx-auto" style="width: 100%; max-width: 400px;">
                            <!-- QR Scanner will be initialized here -->
                        </div>
                    </div>

                    <!-- Manual Input Alternative -->
                    <div class="border-t pt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Atau masukkan data QR Code secara manual:</h4>
                        <form id="manual-verify-form" class="space-y-4">
                            @csrf
                            <div>
                                <label for="qr_content" class="block text-sm font-medium text-gray-700">Data QR Code</label>
                                <textarea id="qr_content" name="qr_content" rows="4" 
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Paste data QR Code di sini..."></textarea>
                            </div>
                            <button type="submit" 
                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Verifikasi Manual
                            </button>
                        </form>
                    </div>

                    <!-- Result Area -->
                    <div id="verification-result" class="mt-6 hidden">
                        <!-- Results will be displayed here -->
                    </div>

                    <!-- Instructions -->
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Cara Menggunakan:</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Arahkan kamera ke QR Code pada surat</li>
                            <li>• Pastikan QR Code terlihat jelas dalam frame</li>
                            <li>• Sistem akan otomatis memverifikasi surat</li>
                            <li>• Atau copy-paste data QR Code secara manual</li>
                        </ul>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('dashboard') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5QrcodeScanner;

        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning
            html5QrcodeScanner.clear();
            
            // Verify the QR code content
            verifyQrContent(decodedText);
        }

        function onScanFailure(error) {
            // Handle scan failure - usually not necessary to do anything
        }

        // Initialize QR Scanner
        document.addEventListener('DOMContentLoaded', function() {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-scanner",
                { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                },
                false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });

        // Manual verification form
        document.getElementById('manual-verify-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const qrContent = document.getElementById('qr_content').value;
            if (qrContent.trim()) {
                verifyQrContent(qrContent);
            }
        });

        // Verify QR content function
        function verifyQrContent(qrContent) {
            const resultDiv = document.getElementById('verification-result');
            resultDiv.innerHTML = '<div class="text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div><p class="mt-2 text-sm text-gray-600">Memverifikasi...</p></div>';
            resultDiv.classList.remove('hidden');

            fetch('{{ route("qr-verification.verify-content") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_content: qrContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    // Redirect to verification result page
                    window.location.href = '{{ url("/verify-letter") }}/' + data.data.surat_id;
                } else {
                    resultDiv.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Verifikasi Gagal</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>${data.message}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="text-sm text-red-700">
                            <p>Terjadi kesalahan saat memverifikasi QR Code</p>
                        </div>
                    </div>
                `;
            });
        }
    </script>
</x-app-layout>
