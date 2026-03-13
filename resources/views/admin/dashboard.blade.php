@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --bg: #f4f6fb;
        --surface: #ffffff;
        --surface-2: #f0f3fa;
        --border: rgba(0,0,0,0.07);
        --accent-blue: #3b6ef8;
        --accent-violet: #7c3aed;
        --accent-amber: #f5a623;
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
        padding: 2.5rem 2rem;
        min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.06) 0%, transparent 55%),
            var(--bg);
    }

    .dash-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .dash-header .header-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(124,58,237,0.3);
    }

    .dash-header .header-icon svg {
        width: 20px; height: 20px;
        stroke: #fff; fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }

    .dash-header h2 {
        font-weight: 800; font-size: 2.2rem;
        line-height: 1.15;
        margin: 0; letter-spacing: -0.02em;
        color: var(--text-primary);
    }

    .dash-header .subtitle {
        font-size: 0.68rem; color: var(--text-muted);
        letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 992px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.09);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        border-radius: 16px 0 0 16px;
    }

    .stat-card.blue::before    { background: var(--accent-blue); }
    .stat-card.amber::before   { background: var(--accent-amber); }
    .stat-card.cyan::before    { background: var(--accent-cyan); }
    .stat-card.green::before   { background: var(--accent-emerald); }

    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-icon svg {
        width: 18px; height: 18px;
        fill: none; stroke-width: 2;
        stroke-linecap: round; stroke-linejoin: round;
    }

    .stat-card.blue  .stat-icon { background: rgba(59,110,248,0.1); }
    .stat-card.blue  .stat-icon svg { stroke: var(--accent-blue); }
    .stat-card.amber .stat-icon { background: rgba(245,166,35,0.12); }
    .stat-card.amber .stat-icon svg { stroke: var(--accent-amber); }
    .stat-card.cyan  .stat-icon { background: rgba(14,165,233,0.1); }
    .stat-card.cyan  .stat-icon svg { stroke: var(--accent-cyan); }
    .stat-card.green .stat-icon { background: rgba(16,185,129,0.1); }
    .stat-card.green .stat-icon svg { stroke: var(--accent-emerald); }

    .stat-label {
        font-size: 0.62rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 0.35rem;
    }

    .stat-value {
        font-weight: 800; font-size: 2.2rem; line-height: 1;
    }

    .stat-card.blue  .stat-value { color: var(--accent-blue); }
    .stat-card.amber .stat-value { color: var(--accent-amber); }
    .stat-card.cyan  .stat-value { color: var(--accent-cyan); }
    .stat-card.green .stat-value { color: var(--accent-emerald); }

    .table-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .table-card-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }

    .table-card-header .title {
        font-weight: 700; font-size: 0.95rem;
        color: var(--text-primary);
    }

    .count-badge {
        font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted); background: var(--surface-2);
        border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px;
    }

    .dash-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }

    .dash-table thead tr {
        background: var(--surface-2);
        border-bottom: 1px solid var(--border);
    }

    .dash-table thead th {
        padding: 0.75rem 1.1rem;
        font-size: 0.6rem; letter-spacing: 0.12em;
        text-transform: uppercase; color: var(--text-muted); font-weight: 500;
    }

    .dash-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }

    .dash-table tbody tr:last-child { border-bottom: none; }
    .dash-table tbody tr:hover { background: #f7f9ff; }

    .dash-table tbody td {
        padding: 0.85rem 1.1rem;
        color: var(--text-dim); vertical-align: middle;
    }

    .dash-table tbody td:first-child { color: var(--text-muted); font-weight: 500; }

    .ticket-title { color: var(--text-primary); font-weight: 600; font-size: 0.82rem; }

    .user-name { display: flex; align-items: center; gap: 0.5rem; }
    .user-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #3b6ef8);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem; font-weight: 700; color: white; flex-shrink: 0;
    }
    .staff-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #3b6ef8);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem; font-weight: 700; color: white; flex-shrink: 0;
    }

    .s-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 0.68rem; font-weight: 500; letter-spacing: 0.03em;
        border: 1px solid transparent;
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

    .p-badge {
        display: inline-block; padding: 2px 9px;
        border-radius: 4px; font-size: 0.65rem;
        font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase;
    }

    .p-badge.low      { background: #f0fdf4; color: #166534; }
    .p-badge.medium   { background: #fffbeb; color: #92400e; }
    .p-badge.high     { background: #fff7ed; color: #c2410c; }
    .p-badge.critical { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .date-text { font-size: 0.73rem; color: var(--text-muted); }

    .empty-state {
        padding: 4rem 2rem; text-align: center;
        color: var(--text-muted); font-size: 0.82rem;
    }

    .pagination { padding: 1rem 1.5rem; justify-content: flex-end; margin-bottom: 0; }
    .pagination .page-link {
        background: var(--surface-2); border-color: var(--border);
        color: var(--text-dim); font-size: 0.78rem; padding: 5px 12px;
        border-radius: 6px; margin: 0 2px; transition: background 0.15s, color 0.15s;
    }
    .pagination .page-link:hover { background: #e8eeff; color: var(--accent-blue); }
    .pagination .page-item.active .page-link { background: var(--accent-blue); border-color: var(--accent-blue); color: #fff; }
    .pagination .page-item.disabled .page-link { opacity: 0.4; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .stat-card { animation: fadeUp 0.4s ease both; }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.12s; }
    .stat-card:nth-child(3) { animation-delay: 0.19s; }
    .stat-card:nth-child(4) { animation-delay: 0.26s; }
    .table-card { animation: fadeUp 0.5s ease 0.3s both; }
</style>

<div class="dash-wrapper">

    {{-- Header --}}
    <div class="dash-header">
        <div class="header-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
        </div>
        <div>
            <h2>Admin Dashboard</h2>
            <div class="subtitle">Welcome back, {{ auth()->user()->name }} &mdash; {{ now()->format('l, F j, Y') }}</div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
            </div>
            <div class="stat-label">Total Tickets</div>
            <div class="stat-value">{{ $totalTickets }}</div>
        </div>

        <div class="stat-card amber">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            </div>
            <div class="stat-label">Open</div>
            <div class="stat-value">{{ $openTickets }}</div>
        </div>

        <div class="stat-card cyan">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-label">In Progress</div>
            <div class="stat-value">{{ $inProgressTickets }}</div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-label">Resolved</div>
            <div class="stat-value">{{ $resolvedTickets }}</div>
        </div>
    </div>

    {{-- Tickets Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="title">All Tickets</span>
            <span class="count-badge">{{ $totalTickets }} total</span>
        </div>

        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>User</th>
                        <th>IT Staff</th>{{-- ← changed from Technician --}}
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>

                            <td><span class="ticket-title">{{ $ticket->title }}</span></td>

                            <td>
                                @if($ticket->user)
                                    <div class="user-name">
                                        <div class="user-avatar">{{ strtoupper(substr($ticket->user->name, 0, 1)) }}</div>
                                        {{ $ticket->user->name }}
                                    </div>
                                @else
                                    <span style="color:var(--text-muted)">—</span>
                                @endif
                            </td>

                            <td>
                                @if($ticket->technician)
                                    <div class="user-name">
                                        <div class="staff-avatar">{{ strtoupper(substr($ticket->technician->name, 0, 1)) }}</div>
                                        {{ $ticket->technician->name }}
                                    </div>
                                @else
                                    <span style="color:var(--text-muted);font-size:0.75rem;font-style:italic;">Unassigned</span>
                                @endif
                            </td>

                            <td>
                                @if($ticket->status == 'open')
                                    <span class="s-badge open">Open</span>
                                @elseif($ticket->status == 'in_progress')
                                    <span class="s-badge in-progress">In Progress</span>
                                @elseif($ticket->status == 'resolved')
                                    <span class="s-badge resolved">Resolved</span>
                                @elseif($ticket->status == 'closed')
                                    <span class="s-badge closed">Closed</span>
                                @endif
                            </td>

                            <td>
                                @if($ticket->priority == 'low')
                                    <span class="p-badge low">Low</span>
                                @elseif($ticket->priority == 'medium')
                                    <span class="p-badge medium">Medium</span>
                                @elseif($ticket->priority == 'high')
                                    <span class="p-badge high">High</span>
                                @elseif($ticket->priority == 'critical')
                                    <span class="p-badge critical">Critical</span>
                                @endif
                            </td>

                            <td><span class="date-text">{{ $ticket->created_at->format('M d, Y') }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">No tickets found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
            <div style="border-top: 1px solid var(--border);">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>

</div>
@endsection