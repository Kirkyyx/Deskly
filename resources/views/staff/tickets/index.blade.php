@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { font-family: 'Inter', sans-serif; box-sizing: border-box; }

    .page-wrap {
        min-height: 100vh;
        background: #f8f9ff;
        padding: 2rem 1.5rem 3rem;
    }

    .page-inner {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Page header ── */
    .page-header {
        margin-bottom: 1.75rem;
        animation: fadeUp 0.5s ease both;
    }
    .page-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.04em;
        margin-bottom: 0.25rem;
    }
    .page-sub {
        font-size: 0.875rem;
        color: #94a3b8;
        font-weight: 400;
    }

    /* ── Filter bar ── */
    .filter-bar {
        background: #ffffff;
        border: 1px solid rgba(226,232,240,0.8);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        box-shadow: 0 2px 8px rgba(99,102,241,0.04);
        animation: fadeUp 0.5s 0.1s ease both;
    }

    .filter-search {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .filter-search svg {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 15px; height: 15px;
        stroke: #94a3b8;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .filter-search input {
        width: 100%;
        padding: 0.55rem 0.75rem 0.55rem 2.25rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 0.875rem;
        color: #0f172a;
        background: #f8fafc;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .filter-search input:focus {
        border-color: #a5b4fc;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.08);
        background: #fff;
    }
    .filter-search input::placeholder { color: #cbd5e1; }

    .filter-select {
        padding: 0.55rem 2rem 0.55rem 0.75rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #475569;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.6rem center;
        appearance: none;
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s ease;
    }
    .filter-select:focus { border-color: #a5b4fc; }

    /* ── Stats strip ── */
    .stats-strip {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        animation: fadeUp 0.5s 0.15s ease both;
    }
    .strip-stat {
        background: #fff;
        border: 1px solid rgba(226,232,240,0.8);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
        min-width: 130px;
        box-shadow: 0 2px 8px rgba(99,102,241,0.04);
    }
    .strip-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .strip-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .strip-icon.indigo { background: #eff0fe; color: #6366f1; }
    .strip-icon.amber  { background: #fffbeb; color: #d97706; }
    .strip-icon.green  { background: #ecfdf5; color: #059669; }
    .strip-icon.red    { background: #fef2f2; color: #dc2626; }
    .strip-val { font-size: 1.375rem; font-weight: 800; color: #0f172a; letter-spacing: -0.04em; line-height: 1; }
    .strip-key { font-size: 0.6875rem; font-weight: 500; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 1px; }

    /* ── Ticket table card ── */
    .table-card {
        background: #ffffff;
        border: 1px solid rgba(226,232,240,0.8);
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(99,102,241,0.05);
        overflow: hidden;
        animation: fadeUp 0.5s 0.2s ease both;
    }

    .table-head {
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-title { font-size: 0.9375rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; }
    .table-count { font-size: 0.75rem; font-weight: 600; color: #94a3b8; background: #f1f5f9; padding: 0.2rem 0.6rem; border-radius: 999px; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 0.75rem 1.25rem;
        text-align: left;
        font-size: 0.6875rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        background: #fafbff;
        border-bottom: 1px solid #f1f5f9;
        white-space: nowrap;
    }
    tbody tr {
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s ease;
        cursor: pointer;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
        color: #0f172a;
        vertical-align: middle;
    }

    /* Ticket ID */
    .ticket-id { font-size: 0.75rem; font-weight: 700; color: #94a3b8; font-variant-numeric: tabular-nums; }

    /* Title + meta */
    .ticket-title { font-weight: 600; color: #0f172a; margin-bottom: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; }
    .ticket-meta  { font-size: 0.75rem; color: #94a3b8; }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.6875rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        white-space: nowrap;
    }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

    .badge-open     { background: #eff0fe; color: #6366f1; }
    .badge-open .badge-dot { background: #6366f1; }
    .badge-progress { background: #fffbeb; color: #d97706; }
    .badge-progress .badge-dot { background: #d97706; }
    .badge-resolved { background: #ecfdf5; color: #059669; }
    .badge-resolved .badge-dot { background: #059669; }
    .badge-closed   { background: #f1f5f9; color: #64748b; }
    .badge-closed .badge-dot { background: #94a3b8; }

    .priority-badge { font-size: 0.6875rem; font-weight: 600; padding: 0.2rem 0.55rem; border-radius: 6px; }
    .priority-high   { background: #fef2f2; color: #dc2626; }
    .priority-medium { background: #fffbeb; color: #d97706; }
    .priority-low    { background: #ecfdf5; color: #059669; }

    /* View btn */
    .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #6366f1;
        text-decoration: none;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        border: 1.5px solid #e0e7ff;
        background: #f5f3ff;
        transition: background 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
    }
    .view-btn:hover { background: #ede9fe; border-color: #c7d2fe; transform: translateY(-1px); }
    .view-btn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    /* Empty state */
    .empty-state {
        padding: 4rem 1.5rem;
        text-align: center;
    }
    .empty-state svg { width: 44px; height: 44px; stroke: #c7d2fe; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; margin: 0 auto 1rem; display: block; }
    .empty-state h3 { font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.375rem; }
    .empty-state p { font-size: 0.875rem; color: #94a3b8; }

    /* Pagination */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .pagination-info { font-size: 0.8125rem; color: #94a3b8; }
    .pagination-links { display: flex; gap: 0.375rem; }
    .page-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #475569;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .page-btn:hover { border-color: #c7d2fe; color: #6366f1; background: #f5f3ff; }
    .page-btn.active { background: #6366f1; border-color: #6366f1; color: #fff; }
    .page-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-wrap">
    <div class="page-inner">

        {{-- Page header --}}
        <div class="page-header">
            <div class="page-title">My Tickets</div>
            <div class="page-sub">Showing all tickets assigned to you</div>
        </div>

        {{-- Stats strip --}}
        <div class="stats-strip">
            <div class="strip-stat">
                <div class="strip-icon indigo">
                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                </div>
                <div>
                    <div class="strip-val">{{ $tickets->total() }}</div>
                    <div class="strip-key">Total</div>
                </div>
            </div>
            <div class="strip-stat">
                <div class="strip-icon amber">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="strip-val">{{ $tickets->where('status', 'in_progress')->count() }}</div>
                    <div class="strip-key">In Progress</div>
                </div>
            </div>
            <div class="strip-stat">
                <div class="strip-icon green">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div>
                    <div class="strip-val">{{ $tickets->where('status', 'resolved')->count() }}</div>
                    <div class="strip-key">Resolved</div>
                </div>
            </div>
            <div class="strip-stat">
                <div class="strip-icon red">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div>
                    <div class="strip-val">{{ $tickets->where('priority', 'high')->count() }}</div>
                    <div class="strip-key">High Priority</div>
                </div>
            </div>
        </div>

        {{-- Filter bar --}}
        <form method="GET" action="{{ route('tickets.index') }}" class="filter-bar">
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
                <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>High</option>
                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Low</option>
            </select>
            <button type="submit" style="padding:0.55rem 1.1rem;background:linear-gradient(135deg,#6366f1,#7c3aed);color:#fff;border:none;border-radius:9px;font-size:0.875rem;font-weight:600;cursor:pointer;transition:opacity 0.2s ease;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                Search
            </button>
            @if(request()->hasAny(['search','status','priority']))
                <a href="{{ route('tickets.index') }}" style="font-size:0.8125rem;font-weight:600;color:#94a3b8;text-decoration:none;white-space:nowrap;">Clear</a>
            @endif
        </form>

        {{-- Table card --}}
        <div class="table-card">
            <div class="table-head">
                <span class="table-title">Assigned Tickets</span>
                <span class="table-count">{{ $tickets->total() }} total</span>
            </div>

            @if($tickets->isEmpty())
                <div class="empty-state">
                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                    <h3>No tickets found</h3>
                    <p>No tickets match your current filters.<br>Try adjusting your search or clear the filters.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ticket</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Last Update</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr onclick="window.location='{{ route('staff.tickets.show', $ticket) }}'" >
                                <td><span class="ticket-id">#{{ $ticket->id }}</span></td>
                                <td>
                                    <div class="ticket-title">{{ $ticket->title }}</div>
                                    <div class="ticket-meta">by {{ $ticket->user->name ?? 'Unknown' }}</div>
                                </td>
                                <td>
                                    <span style="font-size:0.8125rem;color:#475569;font-weight:500;">
                                        {{ $ticket->category->name ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="priority-badge priority-{{ $ticket->priority }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($ticket->status) {
                                            'open'        => 'badge-open',
                                            'in_progress' => 'badge-progress',
                                            'resolved'    => 'badge-resolved',
                                            'closed'      => 'badge-closed',
                                            default       => 'badge-closed',
                                        };
                                        $statusLabel = match($ticket->status) {
                                            'in_progress' => 'In Progress',
                                            default       => ucfirst($ticket->status),
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        <span class="badge-dot"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td style="font-size:0.8125rem;color:#64748b;white-space:nowrap;">
                                    {{ $ticket->created_at->format('M d, Y') }}
                                </td>
                                <td style="font-size:0.8125rem;color:#64748b;white-space:nowrap;">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </td>
                                <td onclick="event.stopPropagation()">
                                    <a href="{{ route('staff.tickets.show', $ticket) }}" class="view-btn">
                                        View
                                        <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($tickets->hasPages())
                <div class="pagination-wrap">
                    <div class="pagination-info">
                        Showing {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }} of {{ $tickets->total() }} tickets
                    </div>
                    <div class="pagination-links">
                        @if($tickets->onFirstPage())
                            <span class="page-btn" style="opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </span>
                        @else
                            <a href="{{ $tickets->previousPageUrl() }}" class="page-btn">
                                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif

                        @foreach($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page === $tickets->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if($tickets->hasMorePages())
                            <a href="{{ $tickets->nextPageUrl() }}" class="page-btn">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @else
                            <span class="page-btn" style="opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection