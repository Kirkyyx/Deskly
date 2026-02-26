@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --bg: #f4f6fb;
        --surface: #ffffff;
        --surface-2: #f0f3fa;
        --border: rgba(0,0,0,0.07);
        --accent-blue: #3b6ef8;
        --accent-violet: #7c3aed;
        --accent-amber: #f59e0b;
        --accent-cyan: #0ea5e9;
        --accent-emerald: #10b981;
        --text-primary: #0f1729;
        --text-muted: #8a94a6;
        --text-dim: #4b5568;
    }

    body {
        background-color: var(--bg) !important;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }

    .dash-wrapper {
        padding: 2.5rem 2rem; min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .dash-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;
    }

    .dash-header-left { display: flex; align-items: center; gap: 1rem; }

    .header-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(124,58,237,0.3);
    }

    .header-icon svg {
        width: 20px; height: 20px;
        stroke: #fff; fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }

    .dash-header h2 {
        font-size: 1.6rem; font-weight: 800;
        margin: 0; letter-spacing: -0.03em; color: var(--text-primary);
    }

    .dash-header .subtitle {
        font-size: 0.68rem; color: var(--text-muted);
        letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px;
    }

    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.4s ease both;
    }

    .table-card-header {
        padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }

    .table-card-header .title {
        font-weight: 700; font-size: 0.95rem; color: var(--text-primary);
    }

    .count-badge {
        font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted); background: var(--surface-2);
        border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px;
    }

    .dash-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    .dash-table thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    .dash-table thead th {
        padding: 0.75rem 1.1rem; font-size: 0.6rem; letter-spacing: 0.12em;
        text-transform: uppercase; color: var(--text-muted); font-weight: 500; white-space: nowrap;
        font-family: 'Inter', sans-serif;
    }
    .dash-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
    .dash-table tbody tr:last-child { border-bottom: none; }
    .dash-table tbody tr:hover { background: #f7f5ff; }
    .dash-table tbody td { padding: 0.85rem 1.1rem; color: var(--text-dim); vertical-align: middle; font-family: 'Inter', sans-serif; }
    .dash-table tbody td:first-child { color: var(--text-muted); font-size: 0.75rem; }

    .ticket-title { color: var(--text-primary); font-size: 0.82rem; font-weight: 600; }

    .cat-chip {
        display: inline-block; padding: 2px 9px; border-radius: 5px;
        font-size: 0.68rem; background: var(--surface-2);
        border: 1px solid var(--border); color: var(--text-dim);
    }

    .s-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.68rem;
        font-weight: 500; border: 1px solid transparent;
    }
    .s-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .s-badge.open         { background: #fef9ec; color: #b45309; border-color: #fde68a; }
    .s-badge.open::before { background: var(--accent-amber); }
    .s-badge.in-progress         { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .s-badge.in-progress::before { background: var(--accent-cyan); }
    .s-badge.resolved         { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .s-badge.resolved::before { background: var(--accent-emerald); }
    .s-badge.closed         { background: #f8fafc; color: #64748b; border-color: #e2e8f0; }
    .s-badge.closed::before { background: #94a3b8; }

    .p-badge { display: inline-block; padding: 2px 9px; border-radius: 4px; font-size: 0.65rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; }
    .p-badge.low      { background: #f0fdf4; color: #166534; }
    .p-badge.medium   { background: #eff6ff; color: #1d4ed8; }
    .p-badge.high     { background: #fffbeb; color: #92400e; }
    .p-badge.critical { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .tech-cell { display: flex; align-items: center; gap: 0.45rem; }
    .tech-avatar {
        width: 22px; height: 22px; border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #3b6ef8);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.58rem; font-weight: 700; color: white; flex-shrink: 0;
    }
    .unassigned { color: var(--text-muted); font-size: 0.75rem; font-style: italic; }
    .date-text { font-size: 0.73rem; color: var(--text-muted); }

    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 11px; border-radius: 6px; font-size: 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        text-decoration: none; border: 1px solid transparent;
        cursor: pointer; background: none; transition: opacity 0.15s, transform 0.15s;
    }
    .action-btn:hover { opacity: 0.82; transform: translateY(-1px); }
    .action-btn.view   { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .action-btn.delete { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .action-btn.view:hover   { color: #1d4ed8; }
    .action-btn.delete:hover { color: #b91c1c; }

    .empty-state { padding: 4rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.82rem; }

    .pagination { padding: 1rem 1.5rem; justify-content: flex-end; margin-bottom: 0; }
    .pagination .page-link {
        background: var(--surface-2); border-color: var(--border);
        color: var(--text-dim); font-size: 0.78rem; padding: 5px 12px;
        border-radius: 6px; margin: 0 2px; font-family: 'Inter', sans-serif;
    }
    .pagination .page-link:hover { background: #ede9fe; color: var(--accent-violet); }
    .pagination .page-item.active .page-link { background: var(--accent-violet); border-color: var(--accent-violet); color: #fff; }
    .pagination .page-item.disabled .page-link { opacity: 0.4; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Delete Confirmation Dialog (del-* avoids Bootstrap 5 conflicts) ── */
    .del-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(15, 23, 41, 0.45);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center; justify-content: center;
        opacity: 0; pointer-events: none;
        transition: opacity 0.22s ease;
    }
    .del-overlay.active { opacity: 1; pointer-events: all; }

    .del-box {
        background: #fff; border-radius: 18px; padding: 2rem;
        width: 100%; max-width: 400px; margin: 1rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        transform: translateY(16px) scale(0.98);
        transition: transform 0.25s cubic-bezier(.22,1,.36,1), opacity 0.22s ease;
        opacity: 0;
    }
    .del-overlay.active .del-box { transform: translateY(0) scale(1); opacity: 1; }

    .del-heading {
        font-size: 1rem; font-weight: 700;
        letter-spacing: -0.02em; color: var(--text-primary);
        margin-bottom: 0.4rem; font-family: 'Inter', sans-serif;
    }

    .del-desc {
        font-size: 0.875rem; color: var(--text-dim);
        line-height: 1.6; margin-bottom: 1.5rem;
        font-family: 'Inter', sans-serif;
    }
    .del-desc strong { color: var(--text-primary); font-weight: 600; }

    .del-actions { display: flex; gap: 0.6rem; }

    .del-btn {
        flex: 1; display: inline-flex; align-items: center; justify-content: center;
        padding: 0.6rem 1rem; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; border: none;
        transition: background 0.18s, transform 0.18s;
        letter-spacing: -0.01em;
    }
    .del-btn:hover { transform: translateY(-1px); }

    .del-btn-cancel {
        background: var(--surface-2); color: var(--text-dim);
        border: 1px solid var(--border);
    }
    .del-btn-cancel:hover { background: #ede9fe; color: var(--text-primary); }

    .del-btn-confirm {
        background: #ef4444; color: #fff;
        box-shadow: 0 4px 14px rgba(239,68,68,0.25);
    }
    .del-btn-confirm:hover { background: #dc2626; }
</style>

<div class="dash-wrapper">

    <div class="dash-header">
        <div class="dash-header-left">
            <div class="header-icon">
                {{-- Ticket / file-text SVG icon --}}
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div>
                <h2>Tickets</h2>
                <div class="subtitle">All support requests</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <span class="title">All Tickets</span>
            <span class="count-badge">{{ method_exists($tickets, 'total') ? $tickets->total() : $tickets->count() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Technician</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td><span class="ticket-title">{{ $ticket->title }}</span></td>
                            <td><span class="cat-chip">{{ $ticket->category->name ?? '—' }}</span></td>
                            <td>
                                @php $st = $ticket->status; @endphp
                                @if($st == 'open')            <span class="s-badge open">Open</span>
                                @elseif($st == 'in_progress') <span class="s-badge in-progress">In Progress</span>
                                @elseif($st == 'resolved')    <span class="s-badge resolved">Resolved</span>
                                @elseif($st == 'closed')      <span class="s-badge closed">Closed</span>
                                @endif
                            </td>
                            <td>
                                @php $pr = $ticket->priority; @endphp
                                @if($pr == 'low')          <span class="p-badge low">Low</span>
                                @elseif($pr == 'medium')   <span class="p-badge medium">Medium</span>
                                @elseif($pr == 'high')     <span class="p-badge high">High</span>
                                @elseif($pr == 'critical') <span class="p-badge critical">Critical</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->technician)
                                    <div class="tech-cell">
                                        <div class="tech-avatar">{{ strtoupper(substr($ticket->technician->name, 0, 1)) }}</div>
                                        {{ $ticket->technician->name }}
                                    </div>
                                @else
                                    <span class="unassigned">Unassigned</span>
                                @endif
                            </td>
                            <td><span class="date-text">{{ $ticket->created_at->format('M d, Y') }}</span></td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket) }}" class="action-btn view">View</a>
                                @if(auth()->user()->role === 'admin')
                                    <button
                                        type="button"
                                        class="action-btn delete"
                                        onclick="openDelDialog('{{ addslashes($ticket->title) }}', '{{ route('tickets.destroy', $ticket) }}')"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8"><div class="empty-state">No tickets found.</div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($tickets, 'hasPages') && $tickets->hasPages())
            <div style="border-top: 1px solid var(--border);">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Delete Confirmation Dialog --}}
<div class="del-overlay" id="delOverlay" onclick="handleDelOverlayClick(event)">
    <div class="del-box">
        <div class="del-heading">Delete this ticket?</div>
        <div class="del-desc">
            You're about to permanently delete <strong id="del-ticket-title"></strong>. This cannot be undone.
        </div>
        <div class="del-actions">
            <button class="del-btn del-btn-cancel" onclick="closeDelDialog()">Cancel</button>
            <button class="del-btn del-btn-confirm" onclick="submitDel()">Yes, Delete</button>
        </div>
    </div>
</div>

<form id="delForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.appendChild(document.getElementById('delOverlay'));
        document.body.appendChild(document.getElementById('delForm'));
    });

    function openDelDialog(title, actionUrl) {
        document.getElementById('del-ticket-title').textContent = title;
        document.getElementById('delForm').action = actionUrl;

        var overlay = document.getElementById('delOverlay');
        overlay.style.display = 'flex';
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                overlay.classList.add('active');
            });
        });
        document.body.style.overflow = 'hidden';
    }

    function closeDelDialog() {
        var overlay = document.getElementById('delOverlay');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        overlay.addEventListener('transitionend', function hide() {
            overlay.style.display = 'none';
            overlay.removeEventListener('transitionend', hide);
        });
    }

    function submitDel() {
        document.getElementById('delForm').submit();
    }

    function handleDelOverlayClick(e) {
        if (e.target === document.getElementById('delOverlay')) closeDelDialog();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDelDialog();
    });
</script>

@endsection