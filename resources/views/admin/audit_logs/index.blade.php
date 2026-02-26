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
        flex-shrink: 0; box-shadow: 0 4px 16px rgba(124,58,237,0.3);
    }
    .header-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .dash-header h2 { font-size: 1.6rem; font-weight: 800; margin: 0; letter-spacing: -0.03em; color: var(--text-primary); }
    .dash-header .subtitle { font-size: 0.68rem; color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px; }

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
    .table-card-header .title { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); }
    .count-badge {
        font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted); background: var(--surface-2);
        border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px;
    }

    .filter-body {
        padding: 1rem 1.5rem;
        display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;
    }
    .filter-body .form-select,
    .filter-body .form-control {
        font-size: 0.78rem; font-family: 'Inter', sans-serif;
        border: 1px solid var(--border); border-radius: 8px;
        padding: 0.45rem 2rem 0.45rem 0.75rem;
        background-color: var(--surface-2); color: var(--text-primary);
        transition: border-color 0.15s, box-shadow 0.15s;
        min-width: 130px; appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a94a6' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 0.65rem center; background-size: 12px;
    }
    .filter-body .form-control { background-image: none; padding-right: 0.75rem; }
    .filter-body .form-select:focus,
    .filter-body .form-control:focus { border-color: #a5b4fc; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); outline: none; }

    .filter-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 0.45rem 1rem; border-radius: 8px;
        font-size: 0.78rem; font-family: 'Inter', sans-serif; font-weight: 600;
        cursor: pointer; border: none; transition: all 0.15s; text-decoration: none;
    }
    .filter-btn.apply { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff; box-shadow: 0 3px 10px rgba(99,102,241,0.3); }
    .filter-btn.apply:hover { opacity: 0.9; transform: translateY(-1px); }
    .filter-btn.reset { background: var(--surface-2); color: var(--text-dim); border: 1px solid var(--border); }
    .filter-btn.reset:hover { background: #ede9fe; color: var(--accent-violet); }

    .dash-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    .dash-table thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    .dash-table thead th { padding: 0.75rem 1.1rem; font-size: 0.6rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--text-muted); font-weight: 500; white-space: nowrap; }
    .dash-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
    .dash-table tbody tr:last-child { border-bottom: none; }
    .dash-table tbody tr:hover { background: #f7f5ff; }
    .dash-table tbody td { padding: 0.85rem 1.1rem; color: var(--text-dim); vertical-align: middle; }
    .dash-table tbody td:first-child { color: var(--text-muted); font-size: 0.75rem; }

    .user-cell { display: flex; align-items: center; gap: 0.45rem; }
    .user-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #3b6ef8);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem; font-weight: 700; color: white; flex-shrink: 0;
    }
    .user-name-text { font-weight: 500; color: var(--text-primary); font-size: 0.82rem; }

    .role-badge { display: inline-block; padding: 2px 9px; border-radius: 4px; font-size: 0.65rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }
    .role-badge.admin { background: #f5f3ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .role-badge.staff { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .role-badge.user  { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

    .ticket-link {
        display: inline-flex; align-items: center; gap: 4px;
        color: var(--accent-blue); font-weight: 500; font-size: 0.78rem;
        text-decoration: none; padding: 2px 8px; border-radius: 5px;
        background: rgba(59,110,248,0.06); border: 1px solid rgba(59,110,248,0.15);
        transition: background 0.15s;
    }
    .ticket-link:hover { background: rgba(59,110,248,0.12); color: var(--accent-blue); }

    .action-chip { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 500; background: var(--surface-2); border: 1px solid var(--border); color: var(--text-dim); }
    .action-chip.login    { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .action-chip.login.failed { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }

    /* Status badge */
    .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 999px; font-size: 0.68rem; font-weight: 600; }
    .status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .status-badge.success { background: #ecfdf5; color: #059669; }
    .status-badge.success::before { background: #059669; }
    .status-badge.failed  { background: #fef2f2; color: #b91c1c; }
    .status-badge.failed::before  { background: #b91c1c; }

    /* Failed attempts badge */
    .attempts-badge {
        display: inline-block; padding: 2px 8px; border-radius: 20px;
        font-size: 0.68rem; font-weight: 700;
        background: #fef9c3; color: #92400e; border: 1px solid #fde68a;
    }
    .attempts-badge.danger { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

    /* IP / device text */
    .ip-text { font-size: 0.72rem; color: var(--text-muted); font-family: monospace; }
    .device-text { font-size: 0.7rem; color: var(--text-muted); max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }

    .date-text { font-size: 0.73rem; color: var(--text-muted); }
    .empty-state { padding: 4rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.82rem; }

    .pagination { padding: 1rem 1.5rem; justify-content: flex-end; margin-bottom: 0; }
    .pagination .page-link { background: var(--surface-2); border-color: var(--border); color: var(--text-dim); font-size: 0.78rem; padding: 5px 12px; border-radius: 6px; margin: 0 2px; font-family: 'Inter', sans-serif; }
    .pagination .page-link:hover { background: #ede9fe; color: var(--accent-violet); }
    .pagination .page-item.active .page-link { background: var(--accent-violet); border-color: var(--accent-violet); color: #fff; }
    .pagination .page-item.disabled .page-link { opacity: 0.4; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .table-card:nth-child(1) { animation-delay: 0.05s; }
    .table-card:nth-child(2) { animation-delay: 0.2s; }
</style>

<div class="dash-wrapper">

    {{-- Header --}}
    <div class="dash-header">
        <div class="dash-header-left">
            <div class="header-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div>
                <h2>Audit Logs</h2>
                <div class="subtitle">Track user actions &amp; login activity</div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="table-card mb-4">
        <div class="table-card-header">
            <span class="title">Filters</span>
        </div>
        <form method="GET" action="{{ route('audit-logs.index') }}">
            <div class="filter-body">

                @if(auth()->user()->role === 'admin')
                    <select name="role" class="form-select" style="max-width:150px;">
                        <option value="">All Roles</option>
                        @foreach(['user','staff','admin'] as $r)
                            <option value="{{ $r }}" @selected(request('role') == $r)>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>

                    <input type="number" name="ticket_id" value="{{ request('ticket_id') }}"
                           placeholder="Ticket ID" class="form-control" style="max-width:120px;">
                @endif

                <select name="action" class="form-select" style="max-width:180px;">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') == $action)>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>

                <select name="status" class="form-select" style="max-width:150px;">
                    <option value="">All Status</option>
                    <option value="success" @selected(request('status') == 'success')>Success</option>
                    <option value="failed"  @selected(request('status') == 'failed')>Failed</option>
                </select>

                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="form-control" style="max-width:150px;">

                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="form-control" style="max-width:150px;">

                <select name="sort" class="form-select" style="max-width:140px;">
                    <option value="created_at" @selected(request('sort') == 'created_at')>Timestamp</option>
                    <option value="user_id"    @selected(request('sort') == 'user_id')>User</option>
                    <option value="ticket_id"  @selected(request('sort') == 'ticket_id')>Ticket</option>
                    <option value="status"     @selected(request('sort') == 'status')>Status</option>
                </select>

                <select name="direction" class="form-select" style="max-width:120px;">
                    <option value="desc" @selected(request('direction') == 'desc')>Newest</option>
                    <option value="asc"  @selected(request('direction') == 'asc')>Oldest</option>
                </select>

                <button type="submit" class="filter-btn apply">Apply</button>
                <a href="{{ route('audit-logs.index') }}" class="filter-btn reset">Reset</a>
            </div>
        </form>
    </div>

    {{-- Audit Logs Table --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="title">All Audit Logs</span>
            <span class="count-badge">{{ $auditLogs->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Ticket</th>
                        <th>IP Address</th>
                        <th>Device</th>
                        <th>Failed Attempts</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>

                            {{-- User --}}
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($log->user->name ?? ($log->email_attempted ?? '?'), 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="user-name-text">
                                            {{ $log->user->name ?? '—' }}
                                        </div>
                                        @if(!$log->user && $log->email_attempted)
                                            <div style="font-size:0.7rem;color:var(--text-muted);">
                                                {{ $log->email_attempted }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td>
                                @php $role = $log->user->role ?? null; @endphp
                                @if($role)
                                    <span class="role-badge {{ $role }}">{{ ucfirst($role) }}</span>
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td>
                                <span class="action-chip {{ $log->action === 'login' ? 'login' : '' }} {{ $log->action === 'login' && $log->status === 'failed' ? 'failed' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="status-badge {{ $log->status ?? 'success' }}">
                                    {{ ucfirst($log->status ?? 'success') }}
                                </span>
                            </td>

                            {{-- Ticket --}}
                            <td>
                                @if($log->ticket)
                                    <a href="{{ route('tickets.show', $log->ticket) }}" class="ticket-link">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                        </svg>
                                        #{{ $log->ticket->id }}
                                    </a>
                                @else
                                    <span style="color:var(--text-muted)">—</span>
                                @endif
                            </td>

                            {{-- IP --}}
                            <td>
                                <span class="ip-text">{{ $log->ip_address ?? '—' }}</span>
                            </td>

                            {{-- Device --}}
                            <td>
                                @if($log->user_agent)
                                    @php
                                        $ua = $log->user_agent;
                                        $browser = 'Unknown';
                                        if (str_contains($ua, 'Edg'))    $browser = 'Edge';
                                        elseif (str_contains($ua, 'Chrome'))  $browser = 'Chrome';
                                        elseif (str_contains($ua, 'Firefox')) $browser = 'Firefox';
                                        elseif (str_contains($ua, 'Safari'))  $browser = 'Safari';
                                        $device = str_contains($ua, 'Mobile') ? 'Mobile' : 'Desktop';
                                    @endphp
                                    <span class="device-text" title="{{ $ua }}">{{ $browser }} · {{ $device }}</span>
                                @else
                                    <span style="color:var(--text-muted)">—</span>
                                @endif
                            </td>

                            {{-- Failed Attempts --}}
                            <td>
                                @if($log->failed_attempts > 0)
                                    <span class="attempts-badge {{ $log->failed_attempts >= 5 ? 'danger' : '' }}">
                                        {{ $log->failed_attempts }}x
                                    </span>
                                @else
                                    <span style="color:var(--text-muted)">—</span>
                                @endif
                            </td>

                            {{-- Timestamp --}}
                            <td>
                                <span class="date-text">{{ optional($log->created_at)->format('M d, Y H:i') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">No audit logs found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($auditLogs->hasPages())
            <div style="border-top: 1px solid var(--border);">
                {{ $auditLogs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

@endsection