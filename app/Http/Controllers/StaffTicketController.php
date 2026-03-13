<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'category'])
            ->where('technician_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->latest()->paginate(15)->withQueryString();

        return view('staff.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403, 'This ticket is not assigned to you.');
        }

        $ticket->load(['user', 'technician', 'category', 'comments.user', 'attachments']);

        return view('staff.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403, 'This ticket is not assigned to you.');
        }

        $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'body'      => $request->body,
        ]);

        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);

            AuditLog::log('ticket_status_changed', [
                'status'    => 'success',
                'ticket_id' => $ticket->id,
            ]);
        }

        AuditLog::log('ticket_reply_staff', [
            'status'    => 'success',
            'ticket_id' => $ticket->id,
        ]);

        return redirect()->route('staff.tickets.show', $ticket)
                         ->with('success', 'Reply posted successfully.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        if ($ticket->technician_id !== Auth::id()) {
            abort(403, 'This ticket is not assigned to you.');
        }

        $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved,closed'],
        ]);

        $ticket->update(['status' => $request->status]);

        AuditLog::log('ticket_status_changed', [
            'status'    => 'success',
            'ticket_id' => $ticket->id,
        ]);

        $label = ucfirst(str_replace('_', ' ', $request->status));

        return redirect()->route('staff.tickets.show', $ticket)
                         ->with('success', "Ticket status updated to {$label}.");
    }
}