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

    body {
        background-color: var(--bg) !important;
        font-family: 'Inter', sans-serif; margin: 0;
    }

    .page-wrap {
        min-height: 100vh;
        padding: 3rem 1.5rem;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .inner { max-width: 960px; margin: 0 auto; }

    /* Back link */
    .back-link {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.78rem; font-weight: 600; color: var(--accent-violet);
        text-decoration: none; margin-bottom: 1.5rem;
        transition: gap 0.2s, color 0.2s;
        animation: fadeUp 0.3s ease both;
    }
    .back-link:hover { gap: 0.55rem; color: #5b21b6; }
    .back-link svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    /* Flash */
    .flash { padding: 0.8rem 1.1rem; border-radius: 10px; font-size: 0.8rem; font-weight: 500; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; animation: fadeUp 0.4s ease both; }
    .flash-success { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .flash-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    /* Layout */
    .layout-grid { display: grid; grid-template-columns: 1fr 270px; gap: 1.5rem; align-items: start; }
    @media (max-width: 860px) { .layout-grid { grid-template-columns: 1fr; } }

    /* Card */
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05), 0 4px 24px rgba(124,58,237,0.06);
        margin-bottom: 1.25rem;
        animation: fadeUp 0.45s ease both;
    }
    .form-card:nth-child(2) { animation-delay: 0.08s; }
    .form-card:nth-child(3) { animation-delay: 0.16s; }

    .card-accent {
        height: 3px;
        background: linear-gradient(90deg, var(--accent-violet), var(--accent-indigo));
    }

    .card-head {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
    }
    .card-title { font-size: 0.875rem; font-weight: 700; color: var(--text-primary); }
    .card-body  { padding: 1.5rem; }

    .section-label {
        font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted);
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
        margin-bottom: 1.25rem;
    }

    /* Ticket header */
    .ticket-title-block { margin-bottom: 1.25rem; }
    .ticket-subject {
        font-size: 1.2rem; font-weight: 800;
        letter-spacing: -0.03em; color: var(--text-primary);
        line-height: 1.3; margin-bottom: 0.75rem;
    }
    .meta-row { display: flex; flex-wrap: wrap; gap: 0.35rem 0.9rem; }
    .meta-item {
        display: flex; align-items: center; gap: 0.3rem;
        font-size: 0.75rem; color: var(--text-muted);
    }
    .meta-item svg { width: 12px; height: 12px; stroke: #b0b8c8; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    .ticket-desc {
        font-size: 0.85rem; color: #334155; line-height: 1.75;
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 10px; padding: 1rem 1.125rem;
        margin-top: 1.25rem;
    }

    /* Badges */
    .status-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.62rem; font-weight: 600; padding: 0.22rem 0.6rem; border-radius: 999px; }
    .status-badge .dot { width: 5px; height: 5px; border-radius: 50%; }
    .status-badge.open        { background: #ede9fe; color: #5b21b6; } .status-badge.open .dot { background: #7c3aed; }
    .status-badge.in_progress { background: #fffbeb; color: #d97706; } .status-badge.in_progress .dot { background: #d97706; }
    .status-badge.resolved    { background: #ecfdf5; color: #059669; } .status-badge.resolved .dot { background: #059669; }
    .status-badge.closed      { background: #f1f5f9; color: #64748b; } .status-badge.closed .dot { background: #94a3b8; }

    .priority-badge { font-size: 0.62rem; font-weight: 600; padding: 0.22rem 0.55rem; border-radius: 6px; }
    .priority-low      { background: #ecfdf5; color: #059669; }
    .priority-medium   { background: #fffbeb; color: #d97706; }
    .priority-high     { background: #fef2f2; color: #dc2626; }
    .priority-critical { background: #fff1f2; color: #be123c; }

    /* Attachments */
    .att-link {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.75rem; color: var(--accent-violet);
        text-decoration: none;
        background: #f5f3ff; border: 1px solid #ddd6fe;
        border-radius: 7px; padding: 0.3rem 0.65rem; margin: 0.2rem;
        transition: background 0.15s;
    }
    .att-link:hover { background: #ede9fe; }

    /* Thread */
    .thread { display: flex; flex-direction: column; }
    .thread-msg {
        display: flex; gap: 0.75rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }
    .thread-msg:last-child { border-bottom: none; }
    .thread-msg:hover { background: #fafbff; }
    .thread-msg.is-staff { background: #f5f3ff; }
    .thread-msg.is-staff:hover { background: #ede9fe40; }

    .msg-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem; font-weight: 800; color: #fff;
        flex-shrink: 0; margin-top: 2px;
    }
    .avatar-user  { background: linear-gradient(135deg, #7c3aed, #6366f1); }
    .avatar-staff { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .avatar-admin { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .msg-body { flex: 1; min-width: 0; }
    .msg-header { display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap; margin-bottom: 0.35rem; }
    .msg-author { font-size: 0.82rem; font-weight: 700; color: var(--text-primary); }
    .msg-role { font-size: 0.6rem; font-weight: 600; padding: 0.15rem 0.45rem; border-radius: 999px; }
    .role-you   { background: #ede9fe; color: #5b21b6; }
    .role-staff { background: #e0e7ff; color: #4338ca; }
    .role-admin { background: #fffbeb; color: #92400e; }
    .msg-time  { font-size: 0.68rem; color: var(--text-muted); margin-left: auto; white-space: nowrap; }
    .msg-text  { font-size: 0.83rem; color: #334155; line-height: 1.7; }

    .thread-empty { padding: 2.5rem 1.5rem; text-align: center; }
    .thread-empty svg { width: 32px; height: 32px; stroke: #c4b5fd; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; display: block; margin: 0 auto 0.6rem; }
    .thread-empty p { font-size: 0.78rem; color: var(--text-muted); }

    /* Reply form */
    .reply-wrap { padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); }
    .field-label {
        display: block; font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.07em; text-transform: uppercase;
        color: var(--text-muted); margin-bottom: 0.4rem;
    }
    .reply-input {
        width: 100%; background: var(--surface-2);
        border: 1px solid var(--border); border-radius: 8px;
        padding: 0.65rem 0.9rem;
        font-family: 'Inter', sans-serif; font-size: 0.875rem;
        color: var(--text-primary); resize: vertical; min-height: 95px;
        outline: none; line-height: 1.65;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    }
    .reply-input:focus {
        border-color: var(--accent-violet);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        background: #fff;
    }
    .reply-input::placeholder { color: #b0b8c8; }

    .reply-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 0.75rem; flex-wrap: wrap; gap: 0.5rem; }
    .char-count { font-size: 0.68rem; color: var(--text-muted); }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.625rem 1.4rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; letter-spacing: -0.01em;
        transition: opacity 0.18s, transform 0.18s;
        box-shadow: 0 4px 14px rgba(124,58,237,0.22);
    }
    .btn-submit:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-submit svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    .closed-notice {
        padding: 1rem 1.5rem; border-top: 1px solid var(--border);
        text-align: center; font-size: 0.78rem; color: var(--text-muted);
        background: var(--surface-2);
    }

    /* Sidebar details */
    .detail-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.7rem 1.5rem; border-bottom: 1px solid #f8fafc; gap: 0.5rem;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-key { font-size: 0.72rem; font-weight: 500; color: var(--text-muted); white-space: nowrap; }
    .detail-val { font-size: 0.78rem; font-weight: 600; color: var(--text-primary); text-align: right; }

    .staff-chip { display: flex; align-items: center; gap: 0.45rem; }
    .staff-chip-av {
        width: 22px; height: 22px; border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #6366f1);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem; font-weight: 800; color: #fff;
    }

    /* Close button */
    .btn-danger {
        width: 100%; padding: 0.625rem;
        background: #fef2f2; color: #dc2626;
        border: 1.5px solid #fecaca; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; transition: background 0.15s, transform 0.15s;
    }
    .btn-danger:hover { background: #fee2e2; transform: translateY(-1px); }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-wrap">
<div class="inner">

    <a href="{{ route('user.tickets.index') }}" class="back-link">
        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to My Tickets
    </a>

    @if(session('success'))
        <div class="flash flash-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">⚠ {{ session('error') }}</div>
    @endif

    <div class="layout-grid">

        {{-- ── LEFT ── --}}
        <div>

            {{-- Ticket detail --}}
            <div class="form-card">
                <div class="card-accent"></div>
                <div class="card-head">
                    <span class="card-title">Ticket #{{ $ticket->id }}</span>
                    <div style="display:flex;gap:0.4rem;align-items:center;flex-wrap:wrap;">
                        <span class="priority-badge priority-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
                        @php
                            $statusLabel = match($ticket->status) {
                                'in_progress' => 'In Progress',
                                default       => ucfirst($ticket->status),
                            };
                        @endphp
                        <span class="status-badge {{ $ticket->status }}">
                            <span class="dot"></span>{{ $statusLabel }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="section-label">Ticket Details</div>
                    <div class="ticket-subject">{{ $ticket->title }}</div>
                    <div class="meta-row">
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Submitted {{ $ticket->created_at->format('M d, Y \a\t g:i A') }}
                        </div>
                        @if($ticket->category)
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                            {{ $ticket->category->name }}
                        </div>
                        @endif
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Updated {{ $ticket->updated_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="ticket-desc">{{ $ticket->description }}</div>

                    @if($ticket->attachments->count())
                    <div style="margin-top:1rem;">
                        <div style="font-size:0.6875rem;letter-spacing:0.07em;text-transform:uppercase;color:var(--text-muted);margin-bottom:0.5rem;font-weight:600;">Attachments</div>
                        @foreach($ticket->attachments as $att)
                            <a href="{{ Storage::url($att->file_path) }}" target="_blank" class="att-link">
                                📎 {{ basename($att->file_path) }}
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Conversation thread --}}
            <div class="form-card">
                <div class="card-accent"></div>
                <div class="card-head">
                    <span class="card-title">Conversation</span>
                    <span style="font-size:0.65rem;color:var(--text-muted);background:var(--surface-2);border:1px solid var(--border);padding:3px 10px;border-radius:20px;">
                        {{ $ticket->comments->count() }} {{ Str::plural('reply', $ticket->comments->count()) }}
                    </span>
                </div>

                <div class="thread">
                    @forelse($ticket->comments as $comment)
                        @php
                            $isMe    = $comment->user_id === auth()->id();
                            $isStaff = in_array($comment->user->role ?? '', ['staff','admin']);
                            $isAdmin = ($comment->user->role ?? '') === 'admin';
                            $avatarClass = $isAdmin ? 'avatar-admin' : ($isStaff ? 'avatar-staff' : 'avatar-user');
                            $roleClass   = $isAdmin ? 'role-admin' : ($isStaff ? 'role-staff' : 'role-you');
                            $roleLabel   = $isAdmin ? 'Admin' : ($isStaff ? 'Support' : 'You');
                        @endphp
                        <div class="thread-msg {{ $isStaff ? 'is-staff' : '' }}">
                            <div class="msg-avatar {{ $avatarClass }}">
                                {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="msg-body">
                                <div class="msg-header">
                                    <span class="msg-author">{{ $isMe ? 'You' : ($comment->user->name ?? 'Unknown') }}</span>
                                    <span class="msg-role {{ $roleClass }}">{{ $roleLabel }}</span>
                                    <span class="msg-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="msg-text">{{ $comment->body }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="thread-empty">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                            <p>No replies yet. A staff member will respond soon.</p>
                        </div>
                    @endforelse
                </div>

                @if(in_array($ticket->status, ['resolved', 'closed']))
                    <div class="closed-notice">
                        This ticket is {{ $ticket->status }}. You can no longer add replies.
                    </div>
                @else
                    <div class="reply-wrap">
                        <form method="POST" action="{{ route('user.tickets.reply', $ticket) }}">
                            @csrf
                            <label class="field-label" for="reply-body">Add a Reply</label>
                            <textarea
                                id="reply-body"
                                name="body"
                                class="reply-input"
                                placeholder="Type your message here…"
                                maxlength="1000"
                                oninput="document.getElementById('char-count').textContent = this.value.length"
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <div style="font-size:0.75rem;color:#dc2626;margin-top:0.35rem;">{{ $message }}</div>
                            @enderror
                            <div class="reply-footer">
                                <span class="char-count"><span id="char-count">0</span> / 1000</span>
                                <button type="submit" class="btn-submit">
                                    <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

        </div>

        {{-- ── RIGHT SIDEBAR ── --}}
        <div>

            {{-- Ticket info --}}
            <div class="form-card" style="animation-delay:0.1s;">
                <div class="card-accent"></div>
                <div class="card-head"><span class="card-title">Details</span></div>
                <div class="detail-row">
                    <span class="detail-key">Ticket ID</span>
                    <span class="detail-val">#{{ $ticket->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span class="detail-val">
                        <span class="status-badge {{ $ticket->status }}"><span class="dot"></span>{{ $statusLabel }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Priority</span>
                    <span class="detail-val">
                        <span class="priority-badge priority-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Category</span>
                    <span class="detail-val">{{ $ticket->category->name ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Assigned To</span>
                    <span class="detail-val">
                        @if($ticket->technician)
                            <div class="staff-chip">
                                <div class="staff-chip-av">{{ strtoupper(substr($ticket->technician->name, 0, 1)) }}</div>
                                {{ $ticket->technician->name }}
                            </div>
                        @else
                            <span style="color:var(--text-muted);">Unassigned</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Opened</span>
                    <span class="detail-val">{{ $ticket->created_at->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Last Update</span>
                    <span class="detail-val">{{ $ticket->updated_at->diffForHumans() }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Replies</span>
                    <span class="detail-val">{{ $ticket->comments->count() }}</span>
                </div>
            </div>

            {{-- Close ticket --}}
            @if(!in_array($ticket->status, ['closed']))
            <div class="form-card" style="animation-delay:0.18s;">
                <div class="card-accent"></div>
                <div class="card-head"><span class="card-title">Actions</span></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.tickets.close', $ticket) }}" onsubmit="return confirm('Are you sure you want to close this ticket?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-danger">✕ Close this Ticket</button>
                    </form>
                    <div style="font-size:0.68rem;color:var(--text-muted);margin-top:0.6rem;line-height:1.5;">
                        Close this ticket if your issue has been resolved. This cannot be undone.
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
</div>

@endsection