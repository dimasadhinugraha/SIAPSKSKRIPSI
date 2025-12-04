let html5QrcodeScanner;

function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().catch(error => {
            console.error("Failed to clear html5QrcodeScanner.", error);
        });
    }
    
    // Verify the QR code content
    verifyQrContent(decodedText);
}

function onScanFailure(error) {
    // Handle scan failure - usually not necessary to do anything, as it's called frequently.
}

// Verify QR content function
function verifyQrContent(qrContent) {
    const resultDiv = document.getElementById('verification-result');
    resultDiv.innerHTML = `
        <div class="d-flex justify-content-center align-items-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="ms-2 mb-0">Memverifikasi...</p>
        </div>`;
    resultDiv.classList.remove('d-none');

    // If the content is a full URL to the verification page, just go there.
    if (qrContent.includes('/verify-letter/')) {
        window.location.href = qrContent;
        return;
    }
    
    // If it's another URL, we can also redirect (optional, based on expected QR content)
    if (qrContent.startsWith('http://') || qrContent.startsWith('https://')) {
        window.location.href = qrContent;
        return;
    }

    // Fallback for legacy or other data formats that need API verification
    fetch(verifyContentUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ qr_content: qrContent })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid && data.data && data.data.surat_id) {
             // Redirect to verification result page
            window.location.href = verifyLetterBaseUrl + '/' + data.data.surat_id;
        } else {
             resultDiv.innerHTML = `
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-times-circle me-2"></i>
                    <div>
                        <strong>Verifikasi Gagal:</strong> ${data.message || 'Data tidak valid.'}
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = `
             <div class="alert alert-danger" role="alert">
                Terjadi kesalahan saat menghubungi server.
            </div>
        `;
    });
}


document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('qr-scanner')){
        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-scanner",
            { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                supportedScanTypes: [
                    Html5QrcodeScanType.SCAN_TYPE_CAMERA,
                    Html5QrcodeScanType.SCAN_TYPE_FILE
                ]
            },
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }
    
    const manualForm = document.getElementById('manual-verify-form');
    if(manualForm) {
        manualForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const qrContent = document.getElementById('qr_content').value;
            if (qrContent.trim()) {
                verifyQrContent(qrContent);
            }
        });
    }
});
