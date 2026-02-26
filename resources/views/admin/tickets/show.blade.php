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
        --surface-3: #e8edf8;
        --border: rgba(0,0,0,0.07);
        --accent-violet: #7c3aed;
        --accent-blue: #3b6ef8;
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

    /* ── Topbar ── */
    .ticket-topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;
    }

    /* Back link — now styled as a button like Edit Ticket */
    .back-link {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 5px 13px; border-radius: 7px; font-size: 0.72rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        text-decoration: none; border: 1px solid var(--border);
        background: var(--surface); color: var(--text-dim);
        transition: background 0.15s, color 0.15s, transform 0.15s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .back-link svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
    .back-link:hover { background: #ede9fe; color: var(--accent-violet); border-color: #ddd6fe; transform: translateY(-1px); }

    .topbar-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }

    .action-btn-top {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 13px; border-radius: 7px; font-size: 0.72rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        text-decoration: none; border: 1px solid transparent;
        cursor: pointer; background: none; transition: opacity 0.15s, transform 0.15s;
    }
    .action-btn-top svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .action-btn-top:hover { opacity: 0.82; transform: translateY(-1px); }
    .action-btn-top.edit { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .action-btn-top.edit:hover { color: #1d4ed8; }

    /* ── Hero ── */
    .ticket-hero {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; padding: 1.75rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.35s ease both;
    }

    .ticket-meta-row {
        display: flex; align-items: center; gap: 0.6rem;
        margin-bottom: 0.85rem; flex-wrap: wrap;
    }

    .ticket-id { font-size: 0.7rem; color: var(--text-muted); letter-spacing: 0.06em; }

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

    .p-badge { display: inline-block; padding: 2px 9px; border-radius: 4px; font-size: 0.63rem; font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase; }
    .p-badge.low      { background: #f0fdf4; color: #166534; }
    .p-badge.medium   { background: #eff6ff; color: #1d4ed8; }
    .p-badge.high     { background: #fffbeb; color: #92400e; }
    .p-badge.critical { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .ticket-title-text {
        font-weight: 800; font-size: 1.45rem;
        letter-spacing: -0.025em; color: var(--text-primary);
        margin: 0 0 1rem;
    }

    .ticket-desc {
        font-size: 0.82rem; color: var(--text-dim);
        line-height: 1.75; white-space: pre-wrap;
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 10px; padding: 1rem 1.1rem;
    }

    .ticket-footer-meta {
        display: flex; gap: 1.5rem; margin-top: 1.25rem; flex-wrap: wrap;
    }

    .meta-item { font-size: 0.72rem; }
    .meta-item .label { color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase; font-size: 0.6rem; margin-bottom: 3px; }
    .meta-item .value { color: var(--text-dim); }
    .meta-item .value.highlight { color: var(--text-primary); font-weight: 600; font-size: 0.8rem; }

    /* ── Body grid ── */
    .ticket-body {
        display: grid; grid-template-columns: 1fr 340px;
        gap: 1.25rem; align-items: start;
    }
    @media (max-width: 900px) { .ticket-body { grid-template-columns: 1fr; } }

    /* ── Panel cards ── */
    .panel-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.4s ease both;
    }

    .panel-header {
        padding: 0.85rem 1.25rem; border-bottom: 1px solid var(--border);
        font-weight: 700; font-size: 0.85rem; color: var(--text-primary);
        display: flex; align-items: center; gap: 0.55rem;
        font-family: 'Inter', sans-serif;
    }

    /* Violet SVG icon box for Comments */
    .ph-icon {
        width: 24px; height: 24px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ph-icon svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .ph-icon.violet { background: #ede9fe; color: var(--accent-violet); }
    .ph-icon.amber  { background: #fffbeb; color: #92400e; }

    .panel-body { padding: 1.1rem 1.25rem; }

    /* ── Comments ── */
    .comment-list { display: flex; flex-direction: column; gap: 0.85rem; }

    .comment-item {
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 10px; padding: 0.9rem 1rem;
    }

    .comment-header { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.5rem; }

    .comment-avatar {
        width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem; font-weight: 700; color: white; flex-shrink: 0;
    }

    .comment-author { font-weight: 600; font-size: 0.78rem; color: var(--text-primary); }
    .comment-time   { font-size: 0.65rem; color: var(--text-muted); margin-left: auto; }
    .comment-body   { font-size: 0.78rem; color: var(--text-dim); line-height: 1.65; }

    .comment-delete {
        display: inline-flex; align-items: center; gap: 3px;
        margin-top: 0.6rem; padding: 2px 9px; border-radius: 5px;
        font-size: 0.65rem; font-family: 'Inter', sans-serif; font-weight: 500;
        background: #fef2f2; color: #b91c1c;
        border: 1px solid #fecaca; cursor: pointer;
        transition: opacity 0.15s;
    }
    .comment-delete:hover { opacity: 0.8; }

    .empty-comments { text-align: center; padding: 1.5rem; color: var(--text-muted); font-size: 0.78rem; }

    /* ── Comment form ── */
    .comment-form-area { padding: 1.1rem 1.25rem; border-top: 1px solid var(--border); }

    .field-textarea {
        width: 100%; background: var(--surface-2);
        border: 1px solid var(--border); border-radius: 8px;
        padding: 0.65rem 0.9rem; color: var(--text-primary);
        font-family: 'Inter', sans-serif; font-size: 0.8rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none; box-sizing: border-box; resize: vertical; min-height: 80px;
        margin-bottom: 0.75rem;
    }
    .field-textarea:focus { border-color: var(--accent-violet); box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }

    .btn-post {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.5rem 1.2rem;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        color: #fff; border: none; border-radius: 7px;
        font-family: 'Inter', sans-serif; font-size: 0.75rem; font-weight: 600;
        cursor: pointer; transition: opacity 0.2s, transform 0.2s;
        box-shadow: 0 4px 12px rgba(124,58,237,0.22);
    }
    .btn-post:hover { opacity: 0.88; transform: translateY(-1px); }

    /* ── Attachments ── */
    .attachment-list { display: flex; flex-direction: column; gap: 0.5rem; }

    .attachment-link {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.55rem 0.8rem; border-radius: 8px;
        background: #eff6ff; border: 1px solid #bfdbfe;
        color: #1d4ed8; font-size: 0.76rem; text-decoration: none;
        transition: background 0.15s;
    }
    .attachment-link:hover { background: #dbeafe; color: #1d4ed8; }
    .attachment-link svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }

    .empty-att { text-align: center; color: var(--text-muted); font-size: 0.75rem; padding: 0.75rem 0; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Delete Confirmation Dialog (del-* avoids Bootstrap conflicts) ── */
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
        background: #fff; border-radius: 16px; padding: 2rem;
        width: 100%; max-width: 380px; margin: 1rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        transform: translateY(16px) scale(0.98);
        transition: transform 0.25s cubic-bezier(.22,1,.36,1), opacity 0.22s ease;
        opacity: 0;
    }
    .del-overlay.active .del-box { transform: translateY(0) scale(1); opacity: 1; }

    .del-heading { font-size: 1rem; font-weight: 700; letter-spacing: -0.02em; color: var(--text-primary); margin-bottom: 0.4rem; }
    .del-desc { font-size: 0.875rem; color: var(--text-dim); line-height: 1.6; margin-bottom: 1.5rem; }

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

    .del-btn-cancel { background: var(--surface-2); color: var(--text-dim); border: 1px solid var(--border); }
    .del-btn-cancel:hover { background: #ede9fe; color: var(--text-primary); }

    .del-btn-confirm { background: #ef4444; color: #fff; box-shadow: 0 4px 14px rgba(239,68,68,0.25); }
    .del-btn-confirm:hover { background: #dc2626; }
</style>

<div class="dash-wrapper">

    <div class="ticket-topbar">
        <a href="{{ route('tickets.index') }}" class="back-link">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Back to Tickets
        </a>
        <div class="topbar-actions">
            @if(in_array(auth()->user()->role, ['staff','admin']))
                <a href="{{ route('tickets.edit', $ticket) }}" class="action-btn-top edit">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit Ticket
                </a>
            @endif
        </div>
    </div>

    <div class="ticket-hero">
        <div class="ticket-meta-row">
            <span class="ticket-id">#{{ $ticket->id }}</span>

            @php $st = $ticket->status; @endphp
            @if($st == 'open')            <span class="s-badge open">Open</span>
            @elseif($st == 'in_progress') <span class="s-badge in-progress">In Progress</span>
            @elseif($st == 'resolved')    <span class="s-badge resolved">Resolved</span>
            @elseif($st == 'closed')      <span class="s-badge closed">Closed</span>
            @endif

            @php $pr = $ticket->priority; @endphp
            @if($pr == 'low')          <span class="p-badge low">Low</span>
            @elseif($pr == 'medium')   <span class="p-badge medium">Medium</span>
            @elseif($pr == 'high')     <span class="p-badge high">High</span>
            @elseif($pr == 'critical') <span class="p-badge critical">Critical</span>
            @endif
        </div>

        <h1 class="ticket-title-text">{{ $ticket->title }}</h1>

        <div class="ticket-desc">{{ $ticket->description }}</div>

        <div class="ticket-footer-meta">
            <div class="meta-item">
                <div class="label">Submitted by</div>
                <div class="value highlight">{{ $ticket->user->name ?? '—' }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Technician</div>
                <div class="value highlight">{{ $ticket->technician->name ?? 'Unassigned' }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Category</div>
                <div class="value">{{ $ticket->category->name ?? '—' }}</div>
            </div>
            <div class="meta-item">
                <div class="label">Created</div>
                <div class="value">{{ $ticket->created_at->format('M d, Y') }}</div>
            </div>
        </div>
    </div>

    <div class="ticket-body">

        {{-- Comments panel --}}
        <div class="panel-card" style="animation-delay:0.1s">
            <div class="panel-header">
                <div class="ph-icon violet">
                    {{-- Chat bubble SVG --}}
                    <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                </div>
                Comments
                <span style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);font-weight:400;">{{ $ticket->comments->count() }}</span>
            </div>

            <div class="panel-body">
                @if($ticket->comments->count())
                    <div class="comment-list">
                        @foreach($ticket->comments as $comment)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <div class="comment-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                                    <span class="comment-author">{{ $comment->user->name }}</span>
                                    <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-body">{{ $comment->body }}</div>
                                @if(auth()->id() === $comment->user_id || in_array(auth()->user()->role, ['admin','staff']))
                                    <button
                                        type="button"
                                        class="comment-delete"
                                        onclick="openDelDialog('{{ route('comments.destroy', $comment) }}')"
                                    >
                                        Delete
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-comments">No comments yet — be the first to reply.</div>
                @endif
            </div>

            @if(in_array(auth()->user()->role, ['user','staff','admin']))
                <div class="comment-form-area">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                        <textarea name="body" class="field-textarea" placeholder="Write a comment…" required></textarea>
                        <button type="submit" class="btn-post">Post Comment</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Attachments panel --}}
        <div class="panel-card" style="animation-delay:0.2s">
            <div class="panel-header">
                <div class="ph-icon amber">
                    {{-- Paperclip SVG --}}
                    <svg viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                </div>
                Attachments
                <span style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);font-weight:400;">{{ $ticket->attachments->count() }}</span>
            </div>
            <div class="panel-body">
                @if($ticket->attachments->count())
                    <div class="attachment-list">
                        @foreach($ticket->attachments as $attachment)
                            <a href="{{ asset('storage/'.$attachment->path) }}" target="_blank" class="attachment-link">
                                <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                {{ $attachment->filename }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="empty-att">No attachments</div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Delete Comment Confirmation Dialog --}}
<div class="del-overlay" id="delOverlay" onclick="handleDelOverlayClick(event)">
    <div class="del-box">
        <div class="del-heading">Delete this comment?</div>
        <div class="del-desc">This comment will be permanently removed and cannot be undone.</div>
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

    function openDelDialog(actionUrl) {
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