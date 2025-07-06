<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\LetterRequestController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\NewsManagementController;
use App\Http\Controllers\Admin\FamilyMemberApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrVerificationController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FamilyMemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Override default register routes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Verification routes
Route::get('/verification-notice', [VerificationController::class, 'notice'])->name('verification.notice');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Letter Request routes (for verified users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('letter-requests', LetterRequestController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/letter-requests/{letterRequest}/download', [LetterRequestController::class, 'download'])->name('letter-requests.download');

    // Family Members routes (no edit/update allowed)
    Route::resource('family-members', FamilyMemberController::class)->except(['edit', 'update']);
});

// Approval routes (for RT/RW)
Route::middleware(['auth', 'verified', 'role:rt,rw'])->prefix('approvals')->name('approvals.')->group(function () {
    Route::get('/', [ApprovalController::class, 'index'])->name('index');
    Route::get('/history', [ApprovalController::class, 'history'])->name('history');
    Route::get('/{letterRequest}', [ApprovalController::class, 'show'])->name('show');
    Route::patch('/{letterRequest}/approve', [ApprovalController::class, 'approve'])->name('approve');
    Route::patch('/{letterRequest}/reject', [ApprovalController::class, 'reject'])->name('reject');
});

// News routes (public)
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

// QR Code Verification routes (public)
Route::get('/verify-letter/{requestNumber}', [QrVerificationController::class, 'verify'])->name('qr-verification.verify');
Route::get('/scan-qr', [QrVerificationController::class, 'scan'])->name('qr-verification.scan');
Route::post('/verify-qr-content', [QrVerificationController::class, 'verifyQrContent'])->name('qr-verification.verify-content');

// Test PDF route (for development)
Route::get('/test-pdf/{id}', function($id) {
    $letterRequest = \App\Models\LetterRequest::findOrFail($id);
    if (!$letterRequest->letter_file || !file_exists(storage_path('app/public/' . $letterRequest->letter_file))) {
        abort(404, 'PDF file not found');
    }
    return response()->file(storage_path('app/public/' . $letterRequest->letter_file));
})->name('test.pdf');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/user-verification', [UserVerificationController::class, 'index'])->name('user-verification.index');
    Route::get('/user-verification/{user}', [UserVerificationController::class, 'show'])->name('user-verification.show');
    Route::patch('/user-verification/{user}/verify', [UserVerificationController::class, 'verify'])->name('user-verification.verify');
    Route::delete('/user-verification/{user}/reject', [UserVerificationController::class, 'reject'])->name('user-verification.reject');

    // News management
    Route::resource('news', NewsManagementController::class);

    // Family member approvals
    Route::get('/family-member-approvals', [FamilyMemberApprovalController::class, 'index'])->name('family-member-approvals.index');
    Route::get('/family-member-approvals/{familyMember}', [FamilyMemberApprovalController::class, 'show'])->name('family-member-approvals.show');
    Route::patch('/family-member-approvals/{familyMember}/approve', [FamilyMemberApprovalController::class, 'approve'])->name('family-member-approvals.approve');
    Route::patch('/family-member-approvals/{familyMember}/reject', [FamilyMemberApprovalController::class, 'reject'])->name('family-member-approvals.reject');
    Route::post('/family-member-approvals/bulk-approve', [FamilyMemberApprovalController::class, 'bulkApprove'])->name('family-member-approvals.bulk-approve');
    Route::get('/family-member-approvals/{familyMember}/download-document', [FamilyMemberApprovalController::class, 'downloadDocument'])->name('family-member-approvals.download-document');
});

require __DIR__.'/auth.php';
