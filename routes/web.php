<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\PterodactylController;
use App\Models\User;
use App\Models\Ticket;

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
    Route::get('/users/{user}/edit', function (App\Models\User $user) {
        return Inertia::render('admin/administration/EditUser', [
            'user' => $user
        ]);
    })->name('admin.users.edit');
    Route::put('/users/{user}', function (App\Models\User $user) {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,support,user',
            'password' => 'nullable|string|min:8',
        ]);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        return redirect()->route('admin.users');
    })->name('admin.users.update');
    Route::get('/tickets', function () {
        $tickets = Ticket::with('user')->latest()->get();
        $userRole = auth()->user()->role;
        return Inertia::render('admin/administration/Tickets', [
            'tickets' => $tickets,
            'userRole' => $userRole,
        ]);
    })->name('admin.tickets');
    Route::post('/tickets', function () {
        $data = request()->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:technical,gameplay,player_report,other',
            'description' => 'nullable|string',
        ]);
        $ticket = \App\Models\Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $data['subject'],
            'priority' => $data['priority'],
            'category' => $data['category'],
            'status' => 'open',
        ]);
        if (!empty($data['description'])) {
            \App\Models\TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'message' => $data['description'],
            ]);
        }
        return redirect()->route('admin.tickets');
    })->name('admin.tickets.store');
    Route::post('/tickets/mass-complete', [\App\Http\Controllers\TicketController::class, 'massComplete'])->name('admin.tickets.massComplete');
    Route::post('/tickets/mass-delete', [\App\Http\Controllers\TicketController::class, 'massDelete'])->name('admin.tickets.massDelete');
});

// Add /invoices route for authenticated users (not just admins)
Route::middleware(['auth'])->get('/invoices', function () {
    return Inertia::render('Invoices');
})->name('invoices');

// Ticket detail, reply, and participant management routes (for both users and admins)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/tickets/{id}', [\App\Http\Controllers\TicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('/admin/tickets/{id}/reply', [\App\Http\Controllers\TicketController::class, 'reply'])->name('admin.tickets.reply');
    Route::patch('/admin/tickets/{id}/status', [\App\Http\Controllers\TicketController::class, 'updateStatus'])->name('admin.tickets.status');
    Route::patch('/admin/tickets/{id}/priority', [\App\Http\Controllers\TicketController::class, 'updatePriority'])->name('admin.tickets.priority');
    Route::post('/admin/tickets/{id}/participants', [\App\Http\Controllers\TicketController::class, 'addParticipant'])->name('admin.tickets.addParticipant');
    Route::delete('/admin/tickets/{id}/participants', [\App\Http\Controllers\TicketController::class, 'removeParticipant'])->name('admin.tickets.removeParticipant');
    Route::delete('/admin/tickets/{id}', [\App\Http\Controllers\TicketController::class, 'destroy'])->name('admin.tickets.destroy');
    Route::get('/tickets/create', function () {
        return Inertia::render('account/TicketsCreate');
    })->name('tickets.create');
    Route::get('/tickets/{id}', [\App\Http\Controllers\TicketController::class, 'show'])->name('tickets.reply');
    Route::get('/api/my-tickets', function () {
        $user = auth()->user();
        $tickets = \App\Models\Ticket::where('user_id', $user->id)
            ->orderByDesc('id')
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'priority' => $ticket->priority,
                    'category' => $ticket->category,
                    'created' => $ticket->created_at->format('Y-m-d'),
                ];
            });
        return response()->json($tickets);
    });
    Route::post('/api/my-tickets', function () {
        $user = auth()->user();
        $data = request()->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:technical,gameplay,player_report,other',
            'description' => 'required|string',
        ]);
        $ticket = \App\Models\Ticket::create([
            'user_id' => $user->id,
            'subject' => $data['subject'],
            'priority' => $data['priority'],
            'category' => $data['category'],
            'status' => 'open',
        ]);
        $ticket->messages()->create([
            'user_id' => $user->id,
            'message' => $data['description'],
        ]);
        return response()->json(['success' => true]);
    });
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
