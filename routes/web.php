<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\PterodactylController;

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
        return Inertia::render('admin/administration/Users');
    })->name('admin.users');
    Route::get('/invoices', function () {
        return Inertia::render('admin/administration/Invoices');
    })->name('admin.invoices');
});

// API route for server status
Route::get('/api/servers/status', [PterodactylController::class, 'servers'])->middleware(['auth', AdminMiddleware::class]);

// User management API routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::post('/users/{user}/change-code', function ($user) {
        // Dummy response for now
        return response()->json(['code' => request('code')]);
    });
    
    Route::post('/users/{user}/change-role', function ($user) {
        // Dummy response for now
        return response()->json(['role' => request('role')]);
    });
    
    Route::delete('/users/{user}', function ($user) {
        // Dummy response for now
        return response()->json(['success' => true]);
    });
});

require __DIR__.'/account.php';
require __DIR__.'/auth.php';
