<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // ✅ Fix validation for is_internal
        $validated = $request->validate([
            'ticket_id'   => 'required|exists:tickets,id',
            'body'        => 'required|string|max:1000',
            'is_internal' => 'sometimes|boolean', // validate as boolean
        ]);

        $comment = Comment::create([
            'ticket_id'   => $validated['ticket_id'],
            'user_id'     => auth()->id(),
            'body'        => $validated['body'],
            'is_internal' => $validated['is_internal'] ?? false, // default to false
        ]);

        // 🔑 Log comment creation
        AuditLog::create([
            'user_id'   => auth()->id(),
            'ticket_id' => $validated['ticket_id'],
            'action'    => 'Comment added',
        ]);

        return redirect()->route('tickets.show', $validated['ticket_id'])
                         ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        // Only the author or staff/admin can delete
        if (auth()->id() !== $comment->user_id && !in_array(auth()->user()->role, ['admin','staff'])) {
            abort(403, 'Unauthorized');
        }

        $ticketId = $comment->ticket_id;

        // 🔑 Log deletion before deleting
        AuditLog::create([
            'user_id'   => auth()->id(),
            'ticket_id' => $ticketId,
            'action'    => 'Comment deleted',
        ]);

        $comment->delete();

        return redirect()->route('tickets.show', $ticketId)
                         ->with('success', 'Comment deleted successfully.');
    }
}