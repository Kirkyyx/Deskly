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

        $staff = User::where('role', 'staff')->inRandomOrder()->first();

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
        }

        return redirect()->route('tickets.show', $ticket)
                         ->with('success', 'Ticket created successfully and assigned to a staff member.');
    }

    public function show(Ticket $ticket)
    {
        if (auth()->user()->role === 'user' && $ticket->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $ticket->load(['user', 'technician', 'category', 'comments.user', 'attachments']);

        return view('admin.tickets.show', compact('ticket'));
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
}