<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
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

    public function index()
    {
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'staff') {
            $tickets = Ticket::with(['user', 'technician', 'category'])->get();
        } else {
            $tickets = Ticket::with(['user', 'technician', 'category'])
                             ->where('user_id', auth()->id())
                             ->get();
        }

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'attachment'  => 'nullable|file|max:2048',
            'priority'    => 'required|in:low,medium,high,critical',
        ]);

        $staff = $this->assignStaff();

        $ticket = Ticket::create([
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'category_id'   => $validated['category_id'],
            'user_id'       => auth()->id(),
            'technician_id' => $staff?->id,
            'status'        => 'open',
            'priority'      => $validated['priority'],
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

            $successMessage = 'Ticket created and assigned to an IT staff member.';
        } else {
            AuditLog::log('ticket_unassigned', [
                'status'    => 'warning',
                'ticket_id' => $ticket->id,
                'reason'    => 'No staff available at time of submission',
            ]);

            $successMessage = 'Ticket created but no IT staff are available to assign. Please assign one manually.';
        }

        return redirect()->route('tickets.show', $ticket)
                         ->with('success', $successMessage);
    }

    public function show(Ticket $ticket)
    {
        if (auth()->user()->role === 'user' && $ticket->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $ticket->load(['user', 'technician', 'category', 'comments.user', 'attachments']);

        // Pass staff list with active ticket counts for reassign dropdown (admin only)
        $staffList = collect();
        if (auth()->user()->role === 'admin') {
            $staffList = \App\Models\User::where('role', 'staff')
                ->withCount([
                    'assignedTickets as active_ticket_count' => fn($q) =>
                        $q->whereIn('status', ['open', 'in_progress'])
                ])
                ->orderBy('active_ticket_count', 'asc')
                ->get();
        }

        return view('admin.tickets.show', compact('ticket', 'staffList'));
    }

    public function edit(Ticket $ticket)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403, 'Unauthorized');
        }

        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status'      => 'sometimes|string|in:open,in_progress,resolved,closed',
            'priority'    => 'sometimes|in:low,medium,high,critical',
        ]);

        $ticket->update($validated);

        if (!empty($validated)) {
            AuditLog::log('ticket_updated', [
                'status'    => 'success',
                'ticket_id' => $ticket->id,
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
                         ->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        AuditLog::log('ticket_deleted', [
            'status'    => 'success',
            'ticket_id' => $ticket->id,
        ]);

        $ticket->delete();

        return redirect()->route('tickets.index')
                         ->with('success', 'Ticket deleted successfully.');
    }


    /**
     * Reassign a ticket to a different IT staff member (admin only).
     */
    public function reassign(Request $request, Ticket $ticket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'technician_id' => ['required', 'exists:users,id'],
        ]);

        $newStaff = User::where('id', $request->technician_id)
                        ->where('role', 'staff')
                        ->firstOrFail();

        $oldStaff = $ticket->technician;

        $ticket->update(['technician_id' => $newStaff->id]);

        AuditLog::log('ticket_reassigned', [
            'status'     => 'success',
            'ticket_id'  => $ticket->id,
            'from_staff' => $oldStaff?->name ?? 'Unassigned',
            'to_staff'   => $newStaff->name,
        ]);

        return redirect()->route('tickets.show', $ticket)
                         ->with('success', "Ticket reassigned to {$newStaff->name}.");
    }
}