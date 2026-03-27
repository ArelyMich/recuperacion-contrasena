<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailResetController;
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
});

require __DIR__.'/auth.php';
