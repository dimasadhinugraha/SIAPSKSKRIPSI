let approveModal, rejectModal;

document.addEventListener('DOMContentLoaded', function () {
    const approveModalEl = document.getElementById('approveModal');
    const rejectModalEl = document.getElementById('rejectModal');

    if (approveModalEl) {
        approveModal = new bootstrap.Modal(approveModalEl);
    }

    if (rejectModalEl) {
        rejectModal = new bootstrap.Modal(rejectModalEl);
    }
});

function openApproveModal() {
    if (approveModal) {
        approveModal.show();
    }
}

function openRejectModal() {
    if (rejectModal) {
        rejectModal.show();
    }
}
