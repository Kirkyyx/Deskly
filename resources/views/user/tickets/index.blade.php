@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --bg: #f4f6fb; --surface: #ffffff; --surface-2: #f0f3fa;
        --border: rgba(0,0,0,0.07);
        --accent-violet: #7c3aed; --accent-indigo: #6366f1;
        --text-primary: #0f1729; --text-muted: #8a94a6; --text-dim: #4b5568;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body { background-color: var(--bg) !important; font-family: 'Inter', sans-serif; margin: 0; }

    .dash-wrapper {
        padding: 2.5rem 2rem; min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    /* ── Header ── */
    .dash-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;
        animation: fadeUp 0.4s ease both;
    }
    .dash-header-left { display: flex; align-items: center; gap: 1rem; }

    .header-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(124,58,237,0.3); flex-shrink: 0;
    }
    .header-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    .page-title { font-weight: 800; font-size: 1.5rem; margin: 0; letter-spacing: -0.03em; color: var(--text-primary); }
    .page-sub   { font-size: 0.68rem; color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 9px;
        font-size: 0.875rem; font-weight: 600;
        text-decoration: none; box-shadow: 0 4px 14px rgba(124,58,237,0.28);
        transition: opacity 0.2s, transform 0.2s; font-family: 'Inter', sans-serif;
    }
    .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; }

    /* ── Filter bar ── */
    .filter-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 12px; padding: 0.875rem 1.125rem;
        margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        animation: fadeUp 0.4s 0.08s ease both;
    }

    .filter-search { flex: 1; min-width: 180px; position: relative; }
    .filter-search svg { position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; stroke: var(--text-muted); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .filter-search input {
        width: 100%; padding: 0.55rem 0.75rem 0.55rem 2.1rem;
        border: 1px solid var(--border); border-radius: 8px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        color: var(--text-primary); background: var(--surface-2);
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .filter-search input:focus { border-color: #c4b5fd; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); background: #fff; }
    .filter-search input::placeholder { color: #cbd5e1; }

    .filter-select {
        padding: 0.55rem 2rem 0.55rem 0.7rem;
        border: 1px solid var(--border); border-radius: 8px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        color: var(--text-dim); background: var(--surface-2) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%238a94a6' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.6rem center;
        appearance: none; outline: none; cursor: pointer; transition: border-color 0.2s;
    }
    .filter-select:focus { border-color: #c4b5fd; }

    .btn-search {
        padding: 0.55rem 1rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 8px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        cursor: pointer; font-weight: 600; transition: opacity 0.2s;
    }
    .btn-search:hover { opacity: 0.88; }

    .btn-clear { font-size: 0.875rem; font-weight: 600; color: var(--text-muted); text-decoration: none; white-space: nowrap; }
    .btn-clear:hover { color: var(--text-dim); }

    /* ── Table card ── */
    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.4s 0.16s ease both;
    }
    .table-card-header {
        padding: 1rem 1.375rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .table-card-title { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); }
    .count-badge {
        font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--text-muted); background: var(--surface-2);
        border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px;
    }

    table { width: 100%; border-collapse: collapse; font-size: 0.875rem; font-family: 'Inter', sans-serif; }
    thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    thead th { padding: 0.7rem 1.1rem; font-size: 0.75rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--text-muted); font-weight: 500; text-align: left; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; cursor: pointer; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #faf9ff; }
    tbody td { padding: 0.9rem 1.1rem; color: var(--text-dim); vertical-align: middle; }

    .ticket-id { font-size: 0.75rem; color: var(--text-muted); font-variant-numeric: tabular-nums; }
    .ticket-title-text { font-weight: 600; color: var(--text-primary); margin-bottom: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px; font-size: 0.875rem; }
    .ticket-cat { font-size: 0.75rem; color: var(--text-muted); }

    .status-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600; padding: 0.22rem 0.55rem; border-radius: 999px; }
    .status-badge .dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .status-badge.open         { background: #ede9fe; color: var(--accent-violet); }
    .status-badge.open .dot    { background: var(--accent-violet); }
    .status-badge.in_progress  { background: #fffbeb; color: #d97706; }
    .status-badge.in_progress .dot { background: #d97706; }
    .status-badge.resolved     { background: #ecfdf5; color: #059669; }
    .status-badge.resolved .dot { background: #059669; }
    .status-badge.closed       { background: #f1f5f9; color: #64748b; }
    .status-badge.closed .dot  { background: #94a3b8; }

    .priority-badge { font-size: 0.75rem; font-weight: 600; padding: 0.2rem 0.5rem; border-radius: 6px; }
    .priority-low      { background: #ecfdf5; color: #059669; }
    .priority-medium   { background: #fffbeb; color: #d97706; }
    .priority-high     { background: #fef2f2; color: #dc2626; }
    .priority-critical { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .view-btn {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-size: 0.75rem; font-weight: 600;
        color: var(--accent-violet); text-decoration: none;
        padding: 0.32rem 0.7rem; border-radius: 7px;
        border: 1px solid #ddd6fe; background: #ede9fe;
        transition: background 0.15s, transform 0.15s;
        font-family: 'Inter', sans-serif;
    }
    .view-btn:hover { background: #ddd6fe; transform: translateY(-1px); color: var(--accent-violet); }

    /* ── Empty state ── */
    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state svg { width: 40px; height: 40px; stroke: #ddd6fe; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; display: block; margin: 0 auto 0.875rem; }
    .empty-state h3 { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.3rem; }
    .empty-state p { font-size: 0.875rem; color: var(--text-muted); }
    .empty-state a { color: var(--accent-violet); font-weight: 600; text-decoration: none; }

    /* ── Pagination ── */
    .pag-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.875rem 1.375rem;
        border-top: 1px solid var(--border);
        flex-wrap: wrap; gap: 0.5rem;
    }
    .pag-info { font-size: 0.75rem; color: var(--text-muted); }
    .pag-links { display: flex; gap: 0.3rem; align-items: center; }
    .pag-btn {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 0.5rem;
        border-radius: 7px; border: 1px solid var(--border);
        background: var(--surface-2); color: var(--text-dim);
        font-size: 0.8125rem; font-weight: 500; text-decoration: none;
        transition: background 0.15s, color 0.15s;
        font-family: 'Inter', sans-serif;
    }
    .pag-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
    .pag-btn:hover { background: #ede9fe; color: var(--accent-violet); border-color: #ddd6fe; }
    .pag-btn.active { background: var(--accent-violet); border-color: var(--accent-violet); color: #fff; }
    .pag-btn[disabled] { opacity: 0.35; pointer-events: none; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="dash-wrapper">

    <div class="dash-header">
        <div class="dash-header-left">
            <div class="header-icon">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
            </div>
            <div>
                <div class="page-title">My Tickets</div>
                <div class="page-sub">All your support requests</div>
            </div>
        </div>
        <a href="{{ route('user.tickets.create') }}" class="btn-primary">+ New Ticket</a>
    </div>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('user.tickets.index') }}" class="filter-bar">
        <div class="filter-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" placeholder="Search tickets…" value="{{ request('search') }}">
        </div>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="open"        {{ request('status') === 'open'        ? 'selected' : '' }}>Open</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="resolved"    {{ request('status') === 'resolved'    ? 'selected' : '' }}>Resolved</option>
            <option value="closed"      {{ request('status') === 'closed'      ? 'selected' : '' }}>Closed</option>
        </select>
        <select name="priority" class="filter-select" onchange="this.form.submit()">
            <option value="">All Priorities</option>
            <option value="low"      {{ request('priority') === 'low'      ? 'selected' : '' }}>Low</option>
            <option value="medium"   {{ request('priority') === 'medium'   ? 'selected' : '' }}>Medium</option>
            <option value="high"     {{ request('priority') === 'high'     ? 'selected' : '' }}>High</option>
            <option value="critical" {{ request('priority') === 'critical' ? 'selected' : '' }}>Critical</option>
        </select>
        <button type="submit" class="btn-search">Search</button>
        @if(request()->hasAny(['search','status','priority']))
            <a href="{{ route('user.tickets.index') }}" class="btn-clear">Clear</a>
        @endif
    </form>

    {{-- Table card --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">Your Requests</span>
            <span class="count-badge">{{ $tickets->total() }} total</span>
        </div>

        @if($tickets->isEmpty())
            <div class="empty-state">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                <h3>No tickets found</h3>
                <p>Nothing matched your filters. Try adjusting or <a href="{{ route('user.tickets.index') }}">clear them</a>.</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        @php
                            $statusLabel = match($ticket->status) {
                                'in_progress' => 'In Progress',
                                default       => ucfirst($ticket->status),
                            };
                        @endphp
                        <tr onclick="window.location='{{ route('user.tickets.show', $ticket) }}'">
                            <td><span class="ticket-id">#{{ $ticket->id }}</span></td>
                            <td>
                                <div class="ticket-title-text">{{ $ticket->title }}</div>
                                <div class="ticket-cat">{{ $ticket->category->name ?? '—' }}</div>
                            </td>
                            <td>
                                <span class="priority-badge priority-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $ticket->status }}">
                                    <span class="dot"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td style="font-size:0.875rem;color:var(--text-dim);">
                                {{ $ticket->technician->name ?? 'Unassigned' }}
                            </td>
                            <td style="font-size:0.75rem;color:var(--text-muted);white-space:nowrap;">
                                {{ $ticket->created_at->format('M d, Y') }}
                            </td>
                            <td onclick="event.stopPropagation()">
                                <a href="{{ route('user.tickets.show', $ticket) }}" class="view-btn">View →</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
            <div class="pag-wrap">
                <div class="pag-info">Showing {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }} of {{ $tickets->total() }}</div>
                <div class="pag-links">
                    @if($tickets->onFirstPage())
                        <span class="pag-btn" disabled><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                    @else
                        <a href="{{ $tickets->previousPageUrl() }}" class="pag-btn"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                    @endif

                    @foreach($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="pag-btn {{ $page === $tickets->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if($tickets->hasMorePages())
                        <a href="{{ $tickets->nextPageUrl() }}" class="pag-btn"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                    @else
                        <span class="pag-btn" disabled><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                    @endif
                </div>
            </div>
            @endif
        @endif
    </div>

</div>

@endsection