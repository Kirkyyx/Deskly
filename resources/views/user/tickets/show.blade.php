@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --bg: #f4f6fb; --surface: #ffffff; --surface-2: #f0f3fa;
        --border: rgba(0,0,0,0.07); --accent: #0ea5e9;
        --text-primary: #0f1729; --text-muted: #8a94a6; --text-dim: #4b5568;
    }

    body { background-color: var(--bg) !important; font-family: 'DM Mono', monospace; }

    .dash-wrapper {
        padding: 2.5rem 2rem; min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(14,165,233,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.06) 0%, transparent 55%),
            var(--bg);
    }

    .back-link { display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.78rem; font-weight: 600; color: #0ea5e9; text-decoration: none; margin-bottom: 1.25rem; transition: gap 0.2s; animation: fadeUp 0.4s ease both; }
    .back-link:hover { gap: 0.55rem; color: #0284c7; }
    .back-link svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    .flash { padding: 0.8rem 1.1rem; border-radius: 9px; font-size: 0.8rem; font-weight: 500; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; animation: fadeUp 0.4s ease both; }
    .flash-success { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .flash-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    /* ── Layout ── */
    .layout-grid { display: grid; grid-template-columns: 1fr 280px; gap: 1.5rem; align-items: start; }
    @media (max-width: 860px) { .layout-grid { grid-template-columns: 1fr; } }

    /* ── Card ── */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.05); margin-bottom: 1.25rem; animation: fadeUp 0.5s ease both; }
    .card:nth-child(2) { animation-delay: 0.08s; }
    .card:nth-child(3) { animation-delay: 0.16s; }
    .card-head { padding: 1rem 1.375rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; }
    .card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
    .card-body  { padding: 1.375rem; }

    /* ── Ticket detail ── */
    .ticket-subject { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.2rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.03em; line-height: 1.3; margin-bottom: 0.875rem; }
    .meta-row { display: flex; flex-wrap: wrap; gap: 0.4rem 1rem; margin-bottom: 1.125rem; }
    .meta-item { display: flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; color: var(--text-muted); }
    .meta-item svg { width: 12px; height: 12px; stroke: #94a3b8; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .meta-item strong { color: var(--text-dim); font-weight: 600; }

    .ticket-desc { font-size: 0.83rem; color: #334155; line-height: 1.75; background: var(--surface-2); border: 1px solid var(--border); border-radius: 9px; padding: 1rem 1.125rem; }

    /* Badges */
    .status-badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.62rem; font-weight: 600; padding: 0.22rem 0.6rem; border-radius: 999px; }
    .status-badge .dot { width: 5px; height: 5px; border-radius: 50%; }
    .status-badge.open        { background: #e0f2fe; color: #0284c7; } .status-badge.open .dot { background: #0284c7; }
    .status-badge.in_progress { background: #fffbeb; color: #d97706; } .status-badge.in_progress .dot { background: #d97706; }
    .status-badge.resolved    { background: #ecfdf5; color: #059669; } .status-badge.resolved .dot { background: #059669; }
    .status-badge.closed      { background: #f1f5f9; color: #64748b; } .status-badge.closed .dot { background: #94a3b8; }

    .priority-badge { font-size: 0.62rem; font-weight: 600; padding: 0.22rem 0.55rem; border-radius: 6px; }
    .priority-low      { background: #ecfdf5; color: #059669; }
    .priority-medium   { background: #fffbeb; color: #d97706; }
    .priority-high     { background: #fef2f2; color: #dc2626; }
    .priority-critical { background: #fff1f2; color: #be123c; }

    /* ── Thread ── */
    .thread { display: flex; flex-direction: column; }
    .thread-msg { display: flex; gap: 0.75rem; padding: 1.125rem 1.375rem; border-bottom: 1px solid #f8fafc; transition: background 0.15s; }
    .thread-msg:last-child { border-bottom: none; }
    .thread-msg:hover { background: #fafeff; }
    .thread-msg.is-staff { background: #f0f9ff; }
    .thread-msg.is-staff:hover { background: #e0f2fe38; }

    .msg-avatar { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; color: #fff; flex-shrink: 0; margin-top: 2px; }
    .avatar-user  { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
    .avatar-staff { background: linear-gradient(135deg, #6366f1, #7c3aed); }
    .avatar-admin { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .msg-body { flex: 1; min-width: 0; }
    .msg-header { display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap; margin-bottom: 0.35rem; }
    .msg-author { font-size: 0.82rem; font-weight: 700; color: var(--text-primary); font-family: 'Plus Jakarta Sans', sans-serif; }
    .msg-role { font-size: 0.6rem; font-weight: 600; padding: 0.15rem 0.45rem; border-radius: 999px; }
    .role-you   { background: #e0f2fe; color: #0284c7; }
    .role-staff { background: #ede9fe; color: #5b21b6; }
    .role-admin { background: #fffbeb; color: #92400e; }
    .msg-time  { font-size: 0.68rem; color: var(--text-muted); margin-left: auto; white-space: nowrap; }
    .msg-text  { font-size: 0.82rem; color: #334155; line-height: 1.7; }

    .thread-empty { padding: 2.5rem 1.375rem; text-align: center; }
    .thread-empty svg { width: 32px; height: 32px; stroke: #bae6fd; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; display: block; margin: 0 auto 0.6rem; }
    .thread-empty p { font-size: 0.78rem; color: var(--text-muted); }

    /* ── Reply form ── */
    .reply-wrap { padding: 1.125rem 1.375rem; border-top: 1px solid var(--border); }
    .field-label { display: block; font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; font-weight: 500; }
    .reply-input { width: 100%; background: var(--surface-2); border: 1px solid var(--border); border-radius: 9px; padding: 0.75rem 0.9rem; font-family: 'DM Mono', monospace; font-size: 0.8rem; color: var(--text-primary); resize: vertical; min-height: 90px; outline: none; line-height: 1.65; transition: border-color 0.2s, box-shadow 0.2s; box-sizing: border-box; }
    .reply-input:focus { border-color: #7dd3fc; box-shadow: 0 0 0 3px rgba(14,165,233,0.1); background: #fff; }
    .reply-input::placeholder { color: #cbd5e1; }
    .reply-input:disabled { opacity: 0.5; cursor: not-allowed; background: #f8fafc; }

    .reply-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 0.75rem; flex-wrap: wrap; gap: 0.5rem; }
    .char-count { font-size: 0.68rem; color: var(--text-muted); }
    .btn-reply { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.58rem 1.2rem; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: #fff; border: none; border-radius: 8px; font-family: 'DM Mono', monospace; font-size: 0.78rem; font-weight: 500; cursor: pointer; box-shadow: 0 4px 12px rgba(14,165,233,0.25); transition: opacity 0.2s, transform 0.2s; }
    .btn-reply:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-reply:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }
    .btn-reply svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    .closed-notice { padding: 1rem 1.375rem; border-top: 1px solid var(--border); text-align: center; font-size: 0.78rem; color: var(--text-muted); background: var(--surface-2); }

    /* ── Sidebar ── */
    .detail-row { display: flex; align-items: center; justify-content: space-between; padding: 0.7rem 1.375rem; border-bottom: 1px solid #f8fafc; gap: 0.5rem; }
    .detail-row:last-child { border-bottom: none; }
    .detail-key { font-size: 0.72rem; font-weight: 500; color: var(--text-muted); white-space: nowrap; }
    .detail-val { font-size: 0.78rem; font-weight: 600; color: var(--text-primary); text-align: right; }

    .staff-chip { display: flex; align-items: center; gap: 0.45rem; }
    .staff-chip-av { width: 22px; height: 22px; border-radius: 50%; background: linear-gradient(135deg,#6366f1,#7c3aed); display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: 800; color: #fff; }

    /* Close button */
    .btn-close-ticket { width: 100%; padding: 0.65rem; background: #fef2f2; color: #dc2626; border: 1.5px solid #fecaca; border-radius: 9px; font-family: 'DM Mono', monospace; font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: background 0.15s, transform 0.15s; }
    .btn-close-ticket:hover { background: #fee2e2; transform: translateY(-1px); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="dash-wrapper">

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
            <div class="card">
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
                    <div class="ticket-subject">{{ $ticket->title }}</div>
                    <div class="meta-row">
                        <div class="meta-item">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
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

                    {{-- Attachments --}}
                    @if($ticket->attachments->count())
                    <div style="margin-top:1rem;">
                        <div style="font-size:0.65rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:0.5rem;font-weight:500;">Attachments</div>
                        @foreach($ticket->attachments as $att)
                            <a href="{{ Storage::url($att->file_path) }}" target="_blank" style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.75rem;color:#0284c7;text-decoration:none;background:#f0f9ff;border:1px solid #bae6fd;border-radius:7px;padding:0.3rem 0.65rem;margin:0.2rem;">
                                📎 {{ basename($att->file_path) }}
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Conversation thread --}}
            <div class="card">
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

                {{-- Reply form or closed notice --}}
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
                                <button type="submit" class="btn-reply">
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
            <div class="card" style="animation-delay:0.1s;">
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
            <div class="card" style="animation-delay:0.18s;">
                <div class="card-head"><span class="card-title">Actions</span></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.tickets.close', $ticket) }}" onsubmit="return confirm('Are you sure you want to close this ticket?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-close-ticket">✕ Close this Ticket</button>
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
@endsection