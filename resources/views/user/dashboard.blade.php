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
        --accent-violet: #7c3aed;
        --accent-indigo: #6366f1;
        --accent-amber: #f59e0b;
        --accent-emerald: #10b981;
        --text-primary: #0f1729;
        --text-muted: #8a94a6;
        --text-dim: #4b5568;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        background-color: var(--bg) !important;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        margin: 0;
    }

    .dash-wrapper {
        padding: 2.5rem 2rem;
        min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    /* ── Hero ── */
    .hero {
        background: linear-gradient(135deg, var(--accent-violet) 0%, var(--accent-indigo) 60%, #4f46e5 100%);
        border-radius: 18px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(124,58,237,0.28), 0 1px 0 rgba(255,255,255,0.12) inset;
        animation: fadeUp 0.5s ease both;
    }
    .hero::before {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 220px; height: 220px; border-radius: 50%;
        background: rgba(255,255,255,0.06); pointer-events: none;
    }
    .hero::after {
        content: '';
        position: absolute; bottom: -70px; right: 130px;
        width: 180px; height: 180px; border-radius: 50%;
        background: rgba(255,255,255,0.04); pointer-events: none;
    }

    .hero-content {
        position: relative; z-index: 1;
        display: flex; align-items: center;
        justify-content: space-between;
        flex-wrap: wrap; gap: 1rem;
    }

    .hero-greeting {
        font-size: 0.68rem; font-weight: 500;
        color: rgba(255,255,255,0.65);
        letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.3rem;
    }
    .hero-name {
        font-size: 1.75rem; font-weight: 800;
        color: #fff; letter-spacing: -0.04em; margin-bottom: 0.4rem;
    }
    .hero-sub { font-size: 0.78rem; color: rgba(255,255,255,0.6); }

    .hero-pill {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
        border-radius: 999px; padding: 0.4rem 1rem;
        font-size: 0.75rem; font-weight: 600; color: #fff;
        backdrop-filter: blur(6px);
    }
    .hero-pill-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #34d399; animation: pulse 2s ease infinite;
    }
    @keyframes pulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(52,211,153,0.4); }
        50%      { box-shadow: 0 0 0 5px rgba(52,211,153,0); }
    }

    .btn-new-ticket {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.65rem 1.4rem;
        background: #fff; color: var(--accent-violet);
        border: none; border-radius: 10px;
        font-size: 0.8rem; font-weight: 600;
        text-decoration: none; cursor: pointer;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        font-family: 'Inter', sans-serif;
    }
    .btn-new-ticket:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: var(--accent-violet);
    }

    /* ── Stat cards ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem; margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 1.25rem 1.375rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        position: relative; overflow: hidden;
        animation: fadeUp 0.5s ease both;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.12s; }
    .stat-card:nth-child(3) { animation-delay: 0.19s; }
    .stat-card:nth-child(4) { animation-delay: 0.26s; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124,58,237,0.1); }

    .stat-card::before {
        content: '';
        position: absolute; left: 0; top: 0; bottom: 0;
        width: 4px; border-radius: 14px 0 0 14px;
    }
    .stat-card.violet::before { background: var(--accent-violet); }
    .stat-card.amber::before  { background: var(--accent-amber); }
    .stat-card.green::before  { background: var(--accent-emerald); }

    .stat-icon {
        width: 34px; height: 34px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 0.875rem;
    }
    .stat-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .stat-icon.violet { background: #ede9fe; color: var(--accent-violet); }
    .stat-icon.amber  { background: #fffbeb; color: #d97706; }
    .stat-icon.green  { background: #ecfdf5; color: #059669; }

    .stat-val { font-size: 2rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.05em; line-height: 1; margin-bottom: 0.25rem; }
    .stat-lbl { font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 500; letter-spacing: 0.08em; }

    /* ── Main grid ── */
    .main-grid { display: grid; grid-template-columns: 1fr 280px; gap: 1.5rem; }
    @media (max-width: 860px) { .main-grid { grid-template-columns: 1fr; } }

    /* ── Card base ── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.5s 0.3s ease both;
        margin-bottom: 1.25rem;
    }

    .card-head {
        padding: 1rem 1.375rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .card-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
    .card-link {
        font-size: 0.72rem; color: var(--accent-violet); font-weight: 600;
        text-decoration: none; transition: color 0.15s;
    }
    .card-link:hover { color: #5b21b6; }

    /* ── Recent ticket rows ── */
    .ticket-row {
        display: flex; align-items: center; gap: 0.875rem;
        padding: 0.875rem 1.375rem;
        border-bottom: 1px solid #f8fafc;
        text-decoration: none; transition: background 0.15s;
    }
    .ticket-row:last-child { border-bottom: none; }
    .ticket-row:hover { background: #faf9ff; }

    .t-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .t-dot.open        { background: var(--accent-violet); }
    .t-dot.in_progress { background: var(--accent-amber); }
    .t-dot.resolved    { background: var(--accent-emerald); }
    .t-dot.closed      { background: #94a3b8; }

    .t-content { flex: 1; min-width: 0; }
    .t-title { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0.15rem; }
    .t-meta  { font-size: 0.7rem; color: var(--text-muted); }

    .t-badge { flex-shrink: 0; font-size: 0.62rem; font-weight: 600; padding: 0.2rem 0.55rem; border-radius: 999px; }
    .t-badge.open        { background: #ede9fe; color: var(--accent-violet); }
    .t-badge.in_progress { background: #fffbeb; color: #d97706; }
    .t-badge.resolved    { background: #ecfdf5; color: #059669; }
    .t-badge.closed      { background: var(--surface-2); color: var(--text-muted); }

    .empty-state { padding: 2.5rem 1.5rem; text-align: center; }
    .empty-state svg { width: 36px; height: 36px; stroke: #ddd6fe; fill: none; stroke-width: 1.5; display: block; margin: 0 auto 0.75rem; }
    .empty-state p { font-size: 0.8rem; color: var(--text-muted); line-height: 1.6; }
    .empty-state a { color: var(--accent-violet); font-weight: 600; text-decoration: none; }

    /* ── Profile card ── */
    .profile-body {
        padding: 1.75rem 1.375rem 1.25rem;
        display: flex; flex-direction: column; align-items: center;
        text-align: center;
    }

    .p-avatar {
        width: 64px; height: 64px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 800; color: #fff;
        box-shadow: 0 6px 20px rgba(124,58,237,0.3);
        margin-bottom: 0.875rem; flex-shrink: 0;
    }

    .p-name  { font-size: 0.9375rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em; margin-bottom: 0.2rem; }
    .p-email { font-size: 0.75rem; color: var(--text-muted); font-weight: 400; margin-bottom: 0.875rem; }

    .p-role-badge {
        display: inline-block;
        background: #ede9fe; color: var(--accent-violet);
        border: 1px solid #ddd6fe;
        border-radius: 999px; padding: 2px 12px;
        font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.04em; text-transform: uppercase;
        margin-bottom: 1.25rem;
    }

    .p-divider { height: 1px; background: var(--border); width: 100%; margin-bottom: 1.25rem; }

    .p-stats {
        display: flex; width: 100%;
        border: 1px solid var(--border);
        border-radius: 10px; overflow: hidden;
    }
    .p-stat { flex: 1; text-align: center; padding: 0.75rem 0.5rem; }
    .p-stat + .p-stat { border-left: 1px solid var(--border); }
    .p-stat-val { font-size: 1.25rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.03em; line-height: 1; }
    .p-stat-key { font-size: 0.6rem; font-weight: 600; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; letter-spacing: 0.06em; }

    /* ── Tips card ── */
    .tip-item {
        display: flex; align-items: flex-start; gap: 0.75rem;
        padding: 0.875rem 1.375rem;
        border-bottom: 1px solid var(--border);
    }
    .tip-item:last-child { border-bottom: none; }

    .tip-icon {
        width: 30px; height: 30px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }
    .tip-icon svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .tip-icon.violet { background: #ede9fe; color: var(--accent-violet); }
    .tip-icon.amber  { background: #fffbeb; color: #d97706; }
    .tip-icon.green  { background: #ecfdf5; color: #059669; }

    .tip-text { font-size: 0.8125rem; color: var(--text-dim); line-height: 1.55; padding-top: 0.15rem; }
    .tip-text strong { color: var(--text-primary); font-weight: 600; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="dash-wrapper">

    {{-- Hero --}}
    <div class="hero">
        <div class="hero-content">
            <div>
                <div class="hero-greeting">{{ now()->format('l, F j') }}</div>
                <div class="hero-name">Hello, {{ auth()->user()->name }}!</div>
                <div class="hero-sub">Track your support requests and stay updated.</div>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.75rem;flex-wrap:wrap;">
                <div class="hero-pill"><div class="hero-pill-dot"></div>Support Portal</div>
                <a href="{{ route('user.tickets.create') }}" class="btn-new-ticket">+ Submit New Ticket</a>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stats-grid">
        <div class="stat-card violet">
            <div class="stat-icon violet">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
            </div>
            <div class="stat-val">{{ $stats['total'] }}</div>
            <div class="stat-lbl">Total Tickets</div>
        </div>
        <div class="stat-card violet">
            <div class="stat-icon violet">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="stat-val">{{ $stats['open'] }}</div>
            <div class="stat-lbl">Open</div>
        </div>
        <div class="stat-card amber">
            <div class="stat-icon amber">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-val">{{ $stats['in_progress'] }}</div>
            <div class="stat-lbl">In Progress</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="stat-val">{{ $stats['resolved'] }}</div>
            <div class="stat-lbl">Resolved</div>
        </div>
    </div>

    {{-- Main grid --}}
    <div class="main-grid">

        {{-- Left: Recent Tickets --}}
        <div>
            <div class="card">
                <div class="card-head">
                    <span class="card-title">Recent Tickets</span>
                    <a href="{{ route('user.tickets.index') }}" class="card-link">View all →</a>
                </div>

                @forelse($recentTickets as $ticket)
                    @php $badgeLabel = $ticket->status === 'in_progress' ? 'In Progress' : ucfirst($ticket->status); @endphp
                    <a href="{{ route('user.tickets.show', $ticket) }}" class="ticket-row">
                        <div class="t-dot {{ $ticket->status }}"></div>
                        <div class="t-content">
                            <div class="t-title">{{ $ticket->title }}</div>
                            <div class="t-meta">
                                #{{ $ticket->id }}
                                @if($ticket->category) · {{ $ticket->category->name }} @endif
                                · {{ $ticket->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <span class="t-badge {{ $ticket->status }}">{{ $badgeLabel }}</span>
                    </a>
                @empty
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                        <p>You haven't submitted any tickets yet.<br><a href="{{ route('user.tickets.create') }}">Submit your first ticket →</a></p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right Sidebar --}}
        <div>

            {{-- Profile --}}
            <div class="card">
                <div class="profile-body">
                    <div class="p-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="p-name">{{ auth()->user()->name }}</div>
                    <div class="p-email">{{ auth()->user()->email }}</div>
                    <div class="p-role-badge">User</div>
                    <div class="p-divider"></div>
                    <div class="p-stats">
                        <div class="p-stat">
                            <div class="p-stat-val">{{ $stats['total'] }}</div>
                            <div class="p-stat-key">Total</div>
                        </div>
                        <div class="p-stat">
                            <div class="p-stat-val">{{ $stats['open'] + $stats['in_progress'] }}</div>
                            <div class="p-stat-key">Active</div>
                        </div>
                        <div class="p-stat">
                            <div class="p-stat-val">{{ $stats['resolved'] }}</div>
                            <div class="p-stat-key">Done</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="card">
                <div class="card-head">
                    <span class="card-title">Tips</span>
                </div>
                <div class="tip-item">
                    <div class="tip-icon violet">
                        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    </div>
                    <div class="tip-text"><strong>Reply promptly</strong> when staff ask for more information to speed up resolution.</div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon amber">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <div class="tip-text"><strong>Be descriptive</strong> when submitting — include steps to reproduce and screenshots if possible.</div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon green">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div class="tip-text"><strong>Close resolved tickets</strong> yourself once your issue is fixed.</div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection