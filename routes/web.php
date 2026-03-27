<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailResetController;
use App\Http\Controllers\Auth\SmsResetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/password/email/request',
        [EmailResetController::class, 'showRequestForm'])
        ->name('password.email.request');

    Route::post('/password/email/send',
        [EmailResetController::class, 'sendResetLink'])
        ->name('password.email.send');

    Route::get('/password/email/reset/{token}',
        [EmailResetController::class, 'showResetForm'])
        ->name('password.email.reset');

    Route::post('/password/email/update',
        [EmailResetController::class, 'resetPassword'])
        ->name('password.email.update');

    Route::get('/password/sms/request',
        [SmsResetController::class, 'showRequestForm'])
        ->name('password.sms.request');

    Route::post('/password/sms/send',
        [SmsResetController::class, 'sendOtp'])
        ->name('password.sms.send');

    Route::get('/password/sms/verify',
        [SmsResetController::class, 'showVerifyForm'])
        ->name('password.sms.verify.form');

    Route::post('/password/sms/verify',
        [SmsResetController::class, 'verifyOtp'])
        ->name('password.sms.verify');

    Route::get('/password/sms/new',
        [SmsResetController::class, 'showNewPasswordForm'])
        ->name('password.sms.new');

    Route::post('/password/sms/update',
        [SmsResetController::class, 'resetPassword'])
        ->name('password.sms.update');

    Route::get('/password/choose',
        fn() => view('auth.forgot-password-choose'))
        ->name('password.choose');
});

require __DIR__.'/auth.php';
