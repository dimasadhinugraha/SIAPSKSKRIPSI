<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\LetterRequestController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\NewsManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
});

// Approval routes (for RT/RW)
Route::middleware(['auth', 'verified', 'role:rt,rw'])->prefix('approvals')->name('approvals.')->group(function () {
    Route::get('/', [ApprovalController::class, 'index'])->name('index');
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
});

require __DIR__.'/auth.php';
