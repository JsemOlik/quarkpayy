<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return Inertia::render('admin/Dashboard');
    })->name('admin.dashboard');
    Route::get('/users', function () {
        return Inertia::render('admin/Users');
    })->name('admin.users');
    Route::get('/invoices', function () {
        return Inertia::render('admin/Invoices');
    })->name('admin.invoices');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
