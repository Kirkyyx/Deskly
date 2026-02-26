@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900;1,14..32,400&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { font-family: 'Inter', sans-serif; box-sizing: border-box; }

    /* ── Page shell ── */
    .dash-wrap {
        min-height: 100vh;
        background: #f8f9ff;
        padding: 2rem 1.5rem 3rem;
        position: relative;
        overflow: hidden;
    }

    /* Subtle background geometry */
    .dash-wrap::before {
        content: '';
        position: fixed;
        top: -300px; right: -300px;
        width: 700px; height: 700px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99,102,241,0.07), transparent 70%);
        pointer-events: none;
        z-index: 0;
    }
    .dash-wrap::after {
        content: '';
        position: fixed;
        bottom: -200px; left: -200px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(139,92,246,0.06), transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .dash-inner {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ── Hero header bar ── */
    .hero-bar {
        background: linear-gradient(135deg, #6366f1 0%, #7c3aed 50%, #4f46e5 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(99,102,241,0.3), 0 1px 0 rgba(255,255,255,0.15) inset;
        animation: slideDown 0.6s cubic-bezier(.22,1,.36,1) both;
    }
    .hero-bar::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .hero-bar::after {
        content: '';
        position: absolute;
        bottom: -80px; right: 120px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }

    .hero-content { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; position: relative; z-index: 1; }

    .hero-left {}
    .hero-greeting {
        font-size: 0.8125rem;
        font-weight: 500;
        color: rgba(255,255,255,0.7);
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 0.375rem;
    }
    .hero-name {
        font-size: 1.875rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.04em;
        line-height: 1.15;
        margin-bottom: 0.5rem;
    }
    .hero-sub {
        font-size: 0.875rem;
        color: rgba(255,255,255,0.65);
        font-weight: 400;
        line-height: 1.5;
    }

    .hero-right { display: flex; gap: 1rem; flex-wrap: wrap; }

    /* Status pill */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 999px;
        padding: 0.4rem 0.875rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #ffffff;
        backdrop-filter: blur(8px);
    }
    .status-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #34d399;
        animation: pulse 2s ease infinite;
        flex-shrink: 0;
    }
    @keyframes pulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(52,211,153,0.4); }
        50%      { box-shadow: 0 0 0 5px rgba(52,211,153,0); }
    }

    /* ── Stat cards row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid rgba(226,232,240,0.8);
        border-radius: 16px;
        padding: 1.375rem 1.5rem;
        box-shadow: 0 2px 12px rgba(99,102,241,0.05), 0 1px 0 rgba(255,255,255,0.8) inset;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        animation: fadeUp 0.5s ease both;
        position: relative;
        overflow: hidden;
    }
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.18s; }
    .stat-card:nth-child(3) { animation-delay: 0.26s; }
    .stat-card:nth-child(4) { animation-delay: 0.34s; }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 28px rgba(99,102,241,0.12);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        border-radius: 16px 16px 0 0;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .stat-card:hover::after { opacity: 1; }
    .stat-card.accent-indigo::after { background: linear-gradient(90deg,#6366f1,#8b5cf6); }
    .stat-card.accent-amber::after  { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
    .stat-card.accent-green::after  { background: linear-gradient(90deg,#10b981,#34d399); }
    .stat-card.accent-red::after    { background: linear-gradient(90deg,#ef4444,#f87171); }

    .stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
    .stat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .stat-icon.indigo { background: #eff0fe; color: #6366f1; }
    .stat-icon.amber  { background: #fffbeb; color: #d97706; }
    .stat-icon.green  { background: #ecfdf5; color: #059669; }
    .stat-icon.red    { background: #fef2f2; color: #dc2626; }

    .stat-badge { font-size: 0.6875rem; font-weight: 600; padding: 0.2rem 0.5rem; border-radius: 999px; }
    .stat-badge.up   { background: #ecfdf5; color: #059669; }
    .stat-badge.down { background: #fef2f2; color: #dc2626; }
    .stat-badge.neutral { background: #f1f5f9; color: #64748b; }

    .stat-value { font-size: 2rem; font-weight: 800; color: #0f172a; letter-spacing: -0.04em; line-height: 1; margin-bottom: 0.25rem; }
    .stat-label { font-size: 0.8125rem; font-weight: 500; color: #64748b; }

    /* ── Main grid ── */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem;
    }
    @media (max-width: 900px) { .main-grid { grid-template-columns: 1fr; } }

    /* ── Card base ── */
    .card {
        background: #ffffff;
        border: 1px solid rgba(226,232,240,0.8);
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(99,102,241,0.05);
        overflow: hidden;
        animation: fadeUp 0.5s 0.4s ease both;
    }
    .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
    }
    .card-title { font-size: 0.9375rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; }
    .card-body  { padding: 1.5rem; }

    /* ── Quick Actions ── */
    .actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1.25rem;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.18s cubic-bezier(.34,1.56,.64,1), box-shadow 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        position: relative;
        overflow: hidden;
    }
    .action-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(99,102,241,0.04), transparent);
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .action-btn:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 24px rgba(99,102,241,0.14); border-color: #c7d2fe; }
    .action-btn:hover::before { opacity: 1; }
    .action-btn:active { transform: translateY(0) scale(0.99); }

    .action-btn.primary {
        background: linear-gradient(135deg,#6366f1,#7c3aed);
        border-color: transparent;
        box-shadow: 0 4px 16px rgba(99,102,241,0.3);
    }
    .action-btn.primary:hover { box-shadow: 0 8px 28px rgba(99,102,241,0.4); border-color: transparent; }
    .action-btn.primary .action-icon { background: rgba(255,255,255,0.2); color: #fff; }
    .action-btn.primary .action-label { color: #ffffff; }
    .action-btn.primary .action-desc  { color: rgba(255,255,255,0.7); }

    .action-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: #eff0fe;
        color: #6366f1;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .action-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .action-label { font-size: 0.875rem; font-weight: 700; color: #0f172a; letter-spacing: -0.01em; }
    .action-desc  { font-size: 0.75rem; font-weight: 400; color: #94a3b8; line-height: 1.4; }

    /* Arrow indicator */
    .action-arrow {
        position: absolute;
        top: 1rem; right: 1rem;
        width: 20px; height: 20px;
        color: #c7d2fe;
        opacity: 0;
        transform: translateX(-4px);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    .action-btn:hover .action-arrow { opacity: 1; transform: translateX(0); }
    .action-btn.primary .action-arrow { color: rgba(255,255,255,0.6); }
    .action-arrow svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* ── Recent Activity ── */
    .activity-list { display: flex; flex-direction: column; }
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        padding: 0.875rem 1.5rem;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s ease;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: #fafbff; }

    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
    }
    .activity-dot.open     { background: #6366f1; }
    .activity-dot.progress { background: #f59e0b; }
    .activity-dot.resolved { background: #10b981; }
    .activity-dot.closed   { background: #94a3b8; }

    .activity-content { flex: 1; min-width: 0; }
    .activity-title { font-size: 0.875rem; font-weight: 600; color: #0f172a; margin-bottom: 0.2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .activity-meta  { font-size: 0.75rem; color: #94a3b8; font-weight: 400; }

    .activity-badge {
        flex-shrink: 0;
        font-size: 0.6875rem; font-weight: 600;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
    }
    .badge-open     { background: #eff0fe; color: #6366f1; }
    .badge-progress { background: #fffbeb; color: #d97706; }
    .badge-resolved { background: #ecfdf5; color: #059669; }
    .badge-closed   { background: #f1f5f9; color: #64748b; }

    /* Empty state */
    .empty-state { padding: 2.5rem 1.5rem; text-align: center; }
    .empty-state svg { width: 40px; height: 40px; stroke: #c7d2fe; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; margin: 0 auto 0.875rem; display: block; }
    .empty-state p { font-size: 0.875rem; color: #94a3b8; }

    /* ── Sidebar card: Profile ── */
    .profile-card { animation: fadeUp 0.5s 0.48s ease both; }
    .profile-body { padding: 1.5rem; text-align: center; }
    .avatar {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg,#6366f1,#8b5cf6);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.625rem; font-weight: 800; color: #fff;
        box-shadow: 0 6px 20px rgba(99,102,241,0.35);
        letter-spacing: -0.02em;
    }
    .profile-name  { font-size: 1rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; margin-bottom: 0.2rem; }
    .profile-role  { font-size: 0.8125rem; color: #94a3b8; font-weight: 400; margin-bottom: 1.25rem; }
    .profile-divider { height: 1px; background: #f1f5f9; margin: 0 -1.5rem 1.25rem; }
    .profile-stat-row { display: flex; gap: 0; }
    .profile-stat { flex: 1; text-align: center; padding: 0.625rem 0; }
    .profile-stat + .profile-stat { border-left: 1px solid #f1f5f9; }
    .profile-stat-val { font-size: 1.25rem; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; }
    .profile-stat-key { font-size: 0.6875rem; font-weight: 500; color: #94a3b8; margin-top: 1px; text-transform: uppercase; letter-spacing: 0.04em; }

    /* ── Sidebar card: Tips ── */
    .tip-card { animation: fadeUp 0.5s 0.56s ease both; margin-top: 1.25rem; }
    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.875rem 1.5rem;
        border-bottom: 1px solid #f8fafc;
    }
    .tip-item:last-child { border-bottom: none; }
    .tip-icon {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .tip-icon svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .tip-icon.indigo { background: #eff0fe; color: #6366f1; }
    .tip-icon.amber  { background: #fffbeb; color: #d97706; }
    .tip-icon.green  { background: #ecfdf5; color: #059669; }
    .tip-text { font-size: 0.8125rem; color: #475569; line-height: 1.55; font-weight: 400; }
    .tip-text strong { color: #0f172a; font-weight: 600; }

    /* ── View all link ── */
    .view-all {
        font-size: 0.8125rem; font-weight: 600; color: #6366f1;
        text-decoration: none;
        display: flex; align-items: center; gap: 0.3rem;
        transition: gap 0.2s ease, color 0.2s ease;
    }
    .view-all:hover { color: #4f46e5; gap: 0.5rem; }
    .view-all svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    @keyframes slideDown { from { opacity:0;transform:translateY(-20px); } to { opacity:1;transform:translateY(0); } }
    @keyframes fadeUp    { from { opacity:0;transform:translateY(14px); } to { opacity:1;transform:translateY(0); } }
</style>

<div class="dash-wrap">
    <div class="dash-inner">

        {{-- ── Hero bar ── --}}
        <div class="hero-bar">
            <div class="hero-content">
                <div class="hero-left">
                    <div class="hero-greeting">{{ now()->format('l, F j') }}</div>
                    <div class="hero-name">Welcome back, {{ auth()->user()->name }}! 👋</div>
                    <div class="hero-sub">Here's what's happening with your assigned tickets today.</div>
                </div>
                <div class="hero-right">
                    <div class="status-pill">
                        <div class="status-dot"></div>
                        Online &amp; Active
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Stat cards ── --}}
        <div class="stats-row">
            <div class="stat-card accent-indigo">
                <div class="stat-header">
                    <div class="stat-icon indigo">
                        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                    </div>
                    <span class="stat-badge neutral">Total</span>
                </div>
                <div class="stat-value">—</div>
                <div class="stat-label">Assigned Tickets</div>
            </div>

            <div class="stat-card accent-amber">
                <div class="stat-header">
                    <div class="stat-icon amber">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <span class="stat-badge neutral">Pending</span>
                </div>
                <div class="stat-value">—</div>
                <div class="stat-label">In Progress</div>
            </div>

            <div class="stat-card accent-green">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span class="stat-badge up">Done</span>
                </div>
                <div class="stat-value">—</div>
                <div class="stat-label">Resolved</div>
            </div>

            <div class="stat-card accent-red">
                <div class="stat-header">
                    <div class="stat-icon red">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <span class="stat-badge down">Urgent</span>
                </div>
                <div class="stat-value">—</div>
                <div class="stat-label">High Priority</div>
            </div>
        </div>

        {{-- ── Main grid ── --}}
        <div class="main-grid">

            {{-- LEFT: Actions + Activity --}}
            <div style="display:flex;flex-direction:column;gap:1.25rem;">

                {{-- Quick Actions --}}
                <div class="card">
                    <div class="card-head">
                        <span class="card-title">Quick Actions</span>
                    </div>
                    <div class="card-body">
                        <div class="actions-grid">

                            <a href="{{ route('tickets.index') }}" class="action-btn primary">
                                <div class="action-arrow"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></div>
                                <div class="action-icon">
                                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
                                </div>
                                <div>
                                    <div class="action-label">View Tickets</div>
                                    <div class="action-desc">Browse all assigned tickets</div>
                                </div>
                            </a>

                            <a href="{{ route('audit-logs.index') }}" class="action-btn">
                                <div class="action-arrow"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></div>
                                <div class="action-icon">
                                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                </div>
                                <div>
                                    <div class="action-label">Audit Logs</div>
                                    <div class="action-desc">Review system activity</div>
                                </div>
                            </a>

                            <a href="{{ route('tickets.index') }}?status=open" class="action-btn">
                                <div class="action-arrow"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></div>
                                <div class="action-icon" style="background:#fffbeb;color:#d97706;">
                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </div>
                                <div>
                                    <div class="action-label">Open Tickets</div>
                                    <div class="action-desc">Tickets awaiting action</div>
                                </div>
                            </a>

                            <a href="{{ route('tickets.index') }}?priority=high" class="action-btn">
                                <div class="action-arrow"><svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></div>
                                <div class="action-icon" style="background:#fef2f2;color:#dc2626;">
                                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                </div>
                                <div>
                                    <div class="action-label">High Priority</div>
                                    <div class="action-desc">Urgent tickets first</div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="card">
                    <div class="card-head">
                        <span class="card-title">Recent Ticket Activity</span>
                        <a href="{{ route('tickets.index') }}" class="view-all">
                            View all
                            <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>

                    {{--
                        Replace this empty state with a @foreach loop over your recent tickets.
                        Example:
                        @forelse($recentTickets as $ticket)
                            <div class="activity-item">
                                <div class="activity-dot {{ $ticket->status }}"></div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $ticket->title }}</div>
                                    <div class="activity-meta">{{ $ticket->updated_at->diffForHumans() }} · #{{ $ticket->id }}</div>
                                </div>
                                <span class="activity-badge badge-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span>
                            </div>
                        @empty
                    --}}
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/></svg>
                        <p>No recent ticket activity.<br>Head to <a href="{{ route('tickets.index') }}" style="color:#6366f1;font-weight:600;text-decoration:none;">your tickets</a> to get started.</p>
                    </div>
                    {{-- @endforelse --}}

                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div>

                {{-- Profile card --}}
                <div class="card profile-card">
                    <div class="profile-body">
                        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-role">Staff Member</div>
                        <div class="profile-divider"></div>
                        <div class="profile-stat-row">
                            <div class="profile-stat">
                                <div class="profile-stat-val">—</div>
                                <div class="profile-stat-key">Assigned</div>
                            </div>
                            <div class="profile-stat">
                                <div class="profile-stat-val">—</div>
                                <div class="profile-stat-key">Resolved</div>
                            </div>
                            <div class="profile-stat">
                                <div class="profile-stat-val">—</div>
                                <div class="profile-stat-key">Pending</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tips card --}}
                <div class="card tip-card">
                    <div class="card-head">
                        <span class="card-title">Staff Tips</span>
                    </div>
                    <div class="activity-list">
                        <div class="tip-item">
                            <div class="tip-icon indigo">
                                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </div>
                            <div class="tip-text"><strong>Respond within 24h</strong> to keep your response rate healthy.</div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-icon amber">
                                <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </div>
                            <div class="tip-text"><strong>Prioritise high-urgency</strong> tickets — they're flagged in red.</div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-icon green">
                                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </div>
                            <div class="tip-text"><strong>Update ticket status</strong> as you work so users stay informed.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection