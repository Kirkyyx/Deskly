<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with(['user', 'ticket', 'article']);

        $role = strtolower(auth()->user()->role);

        if ($role === 'staff') {
            $query->whereHas('ticket', fn($q) => $q->where('technician_id', auth()->id()));
        } elseif ($role === 'user') {
            abort(403, 'You are not authorized to view audit logs.');
        }

        // Filters
        if ($request->filled('role')) {
            $query->whereHas('user', fn($q) => $q->where('role', $request->role));
        }

        if ($request->filled('ticket_id') && is_numeric($request->ticket_id)) {
            $query->where('ticket_id', $request->ticket_id);
        }

        if ($request->filled('article_id') && is_numeric($request->article_id)) {
            $query->where('article_id', $request->article_id);
        }

        if ($request->filled('action')) {
            $query->whereRaw('LOWER(action) LIKE ?', ['%' . strtolower($request->action) . '%']);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $allowedSorts = ['created_at', 'action', 'ticket_id', 'user_id', 'article_id'];
        $sort      = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'created_at';
        $direction = in_array($request->get('direction'), ['asc', 'desc']) ? $request->get('direction') : 'desc';

        $auditLogs = $query->orderBy($sort, $direction)->paginate(20)->withQueryString();
        $actions   = AuditLog::select('action')->distinct()->pluck('action');

        return view('admin.audit_logs.index', compact('auditLogs', 'actions'));
    }
}