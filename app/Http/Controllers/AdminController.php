<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\AuditLog;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Users & Categories
        $users = User::all();
        $categories = Category::all();

        /*
        |--------------------------------------------------------------------------
        | Ticket Statistics (FOR DASHBOARD CARDS)
        |--------------------------------------------------------------------------
        */
        $totalTickets      = Ticket::count();
        $openTickets       = Ticket::where('status', 'open')->count();
        $inProgressTickets = Ticket::where('status', 'in_progress')->count();
        $resolvedTickets   = Ticket::where('status', 'resolved')->count();
        $closedTickets     = Ticket::where('status', 'closed')->count();

        /*
        |--------------------------------------------------------------------------
        | Audit Logs (With Filters)
        |--------------------------------------------------------------------------
        */
        $query = AuditLog::with(['user','ticket']);

        if ($request->filled('role')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        if ($request->filled('ticket_id')) {
            $query->where('ticket_id', $request->ticket_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->orderBy(
            $request->get('sort', 'created_at'),
            $request->get('direction', 'desc')
        )->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Tickets List (Paginated)
        |--------------------------------------------------------------------------
        */
        $tickets = Ticket::with(['user','technician','category'])
                         ->orderBy('created_at','desc')
                         ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */
        return view('admin.dashboard', compact(
            'users',
            'categories',
            'auditLogs',
            'tickets',
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets'
        ));
    }

    public function updateUser(Request $request, User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'role' => 'required|in:user,staff',
        ]);

        $user->update([
            'role' => $validated['role']
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'User role updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                             ->with('error', 'Cannot delete the admin account.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', 'User deleted successfully.');
    }
}