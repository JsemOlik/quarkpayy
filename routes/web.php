<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\PterodactylController;
use App\Models\User;

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
        $users = User::all();
        return Inertia::render('admin/administration/Users', [
            'users' => $users
        ]);
    })->name('admin.users');
    Route::get('/invoices', function () {
        return Inertia::render('admin/administration/Invoices');
    })->name('admin.invoices');

});

// API route for server status
Route::get('/api/servers/status', [PterodactylController::class, 'servers'])->middleware(['auth', AdminMiddleware::class]);

// User management API routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::post('/users/{user}/change-role', function (User $user) {
        $role = request('role');
        
        // Validate the role
        if (!in_array($role, ['admin', 'support', 'user'])) {
            return response()->json(['error' => 'Invalid role'], 422);
        }
        
        $user->role = $role;
        $user->save();
        
        return response()->json(['role' => $role]);
    });
    
    Route::delete('/users/{user}', function (User $user) {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return response()->json(['error' => 'You cannot delete yourself'], 422);
        }
        
        $user->delete();
        return response()->json(['success' => true]);
    });
});

require __DIR__.'/account.php';
require __DIR__.'/auth.php';
