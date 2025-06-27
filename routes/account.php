<?php

use App\Http\Controllers\Account\PasswordController;
use App\Http\Controllers\Account\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('account', '/account/profile');

    Route::get('account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('account/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('account/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('account/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('account/appearance', function () {
        return Inertia::render('account/Appearance');
    })->name('appearance');

    Route::get('account/credits', function () {
        return Inertia::render('account/Credits');
    })->name('credits');

    Route::get('account/affiliate', function () {
        return Inertia::render('account/Affiliate');
    })->name('affiliate');
});
