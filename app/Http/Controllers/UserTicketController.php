<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class UserTicketController extends Controller
{
    /**
     * Find the staff member with the fewest currently open/in-progress tickets.
     * Returns null if no staff accounts exist.
     */
    private function assignStaff(): ?User
    {
        return User::where('role', 'staff')
            ->withCount([
                'assignedTickets as active_ticket_count' => function ($q) {
                    $q->whereIn('status', ['open', 'in_progress']);
                }
            ])
            ->orderBy('active_ticket_count', 'asc')
            ->first();
    }

    public function index(Request $request)
    {
        $query = Ticket::with(['category', 'itStaff'])
            ->where('user_id', auth()->id());

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

        $tickets = $query->latest()->paginate(10)->withQueryString();

        return view('user.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'priority'    => 'required|in:low,medium,high,critical',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $staff = $this->assignStaff();

        $ticket = Ticket::create([
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'category_id'   => $validated['category_id'],
            'priority'      => $validated['priority'],
            'user_id'       => auth()->id(),
            'technician_id' => $staff?->id,
            'status'        => 'open',
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            Attachment::create([
                'ticket_id'   => $ticket->id,
                'file_path'   => $path,
                'uploaded_by' => auth()->id(),
            ]);
        }

        AuditLog::log('ticket_created', [
            'status'    => 'success',
            'ticket_id' => $ticket->id,
        ]);

        if ($staff) {
            AuditLog::log('ticket_assigned', [
                'status'    => 'success',
                'ticket_id' => $ticket->id,
                'user_id'   => $staff->id,
            ]);

            $successMessage = 'Your ticket has been submitted and assigned to an IT staff member.';
        } else {
            AuditLog::log('ticket_unassigned', [
                'status'    => 'warning',
                'ticket_id' => $ticket->id,
                'reason'    => 'No staff available at time of submission',
            ]);

            $successMessage = 'Your ticket has been submitted. No IT staff are currently available — it will be assigned soon.';
        }

        return redirect()->route('user.tickets.show', $ticket)
                         ->with('success', $successMessage);
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'This ticket does not belong to you.');
        }

        $ticket->load(['category', 'technician', 'comments.user', 'attachments']);

        return view('user.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'This ticket does not belong to you.');
        }

        if (in_array($ticket->status, ['resolved', 'closed'])) {
            return redirect()->route('user.tickets.show', $ticket)
                             ->with('error', 'You cannot reply to a resolved or closed ticket.');
        }

        $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'body'      => $request->body,
        ]);

        AuditLog::log('ticket_reply_user', [
            'status'    => 'success',
            'ticket_id' => $ticket->id,
        ]);

        return redirect()->route('user.tickets.show', $ticket)
                         ->with('success', 'Your reply has been sent.');
    }

    public function close(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'This ticket does not belong to you.');
        }

        if ($ticket->status === 'closed') {
            return redirect()->route('user.tickets.show', $ticket)
                             ->with('error', 'This ticket is already closed.');
        }

        $ticket->update(['status' => 'closed']);

        AuditLog::log('ticket_closed', [
            'status'    => 'success',
            'ticket_id' => $ticket->id,
        ]);

        return redirect()->route('user.tickets.index')
                         ->with('success', 'Your ticket has been closed.');
    }
}