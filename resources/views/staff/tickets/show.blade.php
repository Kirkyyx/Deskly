@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { font-family: 'Inter', sans-serif; box-sizing: border-box; }
    .page-wrap { min-height: 100vh; background: #f8f9ff; padding: 2rem 1.5rem 3rem; }
    .page-inner { max-width: 1100px; margin: 0 auto; }

    .back-link { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.8125rem; color: #6366f1; text-decoration: none; font-weight: 600; margin-bottom: 1.25rem; animation: fadeUp 0.4s ease both; transition: gap 0.2s; }
    .back-link:hover { gap: 0.6rem; color: #4f46e5; }
    .back-link svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    .flash { padding: 0.8rem 1.1rem; border-radius: 10px; font-size: 0.8rem; font-weight: 500; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; animation: fadeUp 0.4s ease both; }
    .flash svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
    .flash-success { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .flash-error   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    .layout-grid { display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; align-items: start; }
    @media (max-width: 860px) { .layout-grid { grid-template-columns: 1fr; } }

    .card { background: #ffffff; border: 1px solid rgba(226,232,240,0.8); border-radius: 16px; box-shadow: 0 2px 12px rgba(99,102,241,0.05); overflow: hidden; margin-bottom: 1.25rem; animation: fadeUp 0.5s ease both; }
    .card-head { padding: 1.125rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; }
    .card-title { font-size: 0.9375rem; font-weight: 700; color: #0f172a; letter-spacing: -0.02em; }
    .card-body { padding: 1.5rem; }

    .ticket-title-text { font-size: 1.3rem; font-weight: 800; color: #0f172a; letter-spacing: -0.03em; line-height: 1.3; margin-bottom: 0.875rem; }
    .ticket-meta-row { display: flex; flex-wrap: wrap; gap: 0.5rem 1.25rem; margin-bottom: 1.25rem; }
    .ticket-meta-item { display: flex; align-items: center; gap: 0.35rem; font-size: 0.8125rem; color: #64748b; }
    .ticket-meta-item svg { width: 13px; height: 13px; stroke: #94a3b8; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
    .ticket-meta-item strong { color: #0f172a; font-weight: 600; }
    .ticket-description { font-size: 0.9rem; color: #334155; line-height: 1.75; background: #fafbff; border: 1px solid #f1f5f9; border-radius: 10px; padding: 1.125rem 1.25rem; }

    .badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.6875rem; font-weight: 600; padding: 0.25rem 0.65rem; border-radius: 999px; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .badge-open     { background: #eff0fe; color: #6366f1; } .badge-open .badge-dot { background: #6366f1; }
    .badge-progress { background: #fffbeb; color: #d97706; } .badge-progress .badge-dot { background: #d97706; }
    .badge-resolved { background: #ecfdf5; color: #059669; } .badge-resolved .badge-dot { background: #059669; }
    .badge-closed   { background: #f1f5f9; color: #64748b; } .badge-closed .badge-dot { background: #94a3b8; }
    .priority-badge { font-size: 0.6875rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 6px; }
    .priority-high   { background: #fef2f2; color: #dc2626; }
    .priority-medium { background: #fffbeb; color: #d97706; }
    .priority-low    { background: #ecfdf5; color: #059669; }
    .priority-critical { background: #fff1f2; color: #be123c; }

    .reply-thread { display: flex; flex-direction: column; }
    .reply-item { display: flex; gap: 0.875rem; padding: 1.125rem 1.5rem; border-bottom: 1px solid #f8fafc; transition: background 0.15s ease; }
    .reply-item:last-child { border-bottom: none; }
    .reply-item.is-staff { background: #fafbff; }
    .reply-item:hover { background: #f8faff; }

    .reply-avatar { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8125rem; font-weight: 800; color: #fff; flex-shrink: 0; margin-top: 2px; }
    .reply-avatar.staff-av { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .reply-avatar.user-av  { background: linear-gradient(135deg, #0ea5e9, #38bdf8); }
    .reply-avatar.admin-av { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .reply-content { flex: 1; min-width: 0; }
    .reply-header { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.4rem; flex-wrap: wrap; }
    .reply-author { font-size: 0.875rem; font-weight: 700; color: #0f172a; }
    .reply-role   { font-size: 0.6875rem; font-weight: 600; padding: 0.15rem 0.45rem; border-radius: 999px; }
    .role-staff   { background: #eff0fe; color: #6366f1; }
    .role-admin   { background: #fffbeb; color: #92400e; }
    .role-user    { background: #f0f9ff; color: #0284c7; }
    .reply-time   { font-size: 0.75rem; color: #94a3b8; margin-left: auto; white-space: nowrap; }
    .reply-text   { font-size: 0.875rem; color: #334155; line-height: 1.7; }

    .replies-empty { padding: 2.5rem 1.5rem; text-align: center; }
    .replies-empty svg { width: 36px; height: 36px; stroke: #c7d2fe; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; margin: 0 auto 0.75rem; display: block; }
    .replies-empty p { font-size: 0.875rem; color: #94a3b8; }

    .reply-form-wrap { padding: 1.25rem 1.5rem; border-top: 1px solid #f1f5f9; }
    .form-label { font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block; }
    textarea.form-field { width: 100%; padding: 0.875rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.875rem; color: #0f172a; background: #fafbff; resize: vertical; min-height: 110px; outline: none; line-height: 1.6; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    textarea.form-field:focus { border-color: #a5b4fc; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); background: #fff; }
    textarea.form-field::placeholder { color: #cbd5e1; }
    .form-row { display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; margin-top: 0.875rem; flex-wrap: wrap; }
    .char-count { font-size: 0.75rem; color: #94a3b8; }
    .submit-btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.625rem 1.25rem; background: linear-gradient(135deg, #6366f1, #7c3aed); color: #fff; border: none; border-radius: 9px; font-size: 0.875rem; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(99,102,241,0.25); transition: box-shadow 0.2s ease, transform 0.2s ease, opacity 0.2s ease; }
    .submit-btn:hover { box-shadow: 0 6px 18px rgba(99,102,241,0.35); transform: translateY(-1px); }
    .submit-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* Sidebar */
    .detail-row { display: flex; align-items: center; justify-content: space-between; padding: 0.7rem 1.5rem; border-bottom: 1px solid #f8fafc; gap: 0.5rem; }
    .detail-row:last-child { border-bottom: none; }
    .detail-key { font-size: 0.72rem; font-weight: 500; color: #94a3b8; white-space: nowrap; }
    .detail-val { font-size: 0.78rem; font-weight: 600; color: #0f172a; text-align: right; }

    .status-form { padding: 1.25rem 1.5rem; border-top: 1px solid #f1f5f9; }
    .status-select { width: 100%; padding: 0.6rem 2.25rem 0.6rem 0.875rem; border: 1.5px solid #e2e8f0; border-radius: 9px; font-size: 0.875rem; font-weight: 500; color: #374151; background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.75rem center; appearance: none; outline: none; cursor: pointer; margin-bottom: 0.875rem; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    .status-select:focus { border-color: #a5b4fc; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
    .update-btn { width: 100%; padding: 0.625rem; background: linear-gradient(135deg, #6366f1, #7c3aed); color: #fff; border: none; border-radius: 9px; font-size: 0.875rem; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(99,102,241,0.2); transition: box-shadow 0.2s ease, transform 0.15s ease; }
    .update-btn:hover { box-shadow: 0 6px 18px rgba(99,102,241,0.32); transform: translateY(-1px); }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-wrap">
    <div class="page-inner">

        <a href="{{ route('staff.tickets.index') }}" class="back-link">
            <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to My Tickets
        </a>

        @if(session('success'))
            <div class="flash flash-success">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="layout-grid">

            {{-- LEFT --}}
            <div>

                {{-- Ticket detail --}}
                <div class="card">
                    <div class="card-head">
                        <span class="card-title">Ticket #{{ $ticket->id }}</span>
                        <div style="display:flex;gap:0.5rem;align-items:center;">
                            <span class="priority-badge priority-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
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
                            <span class="badge {{ $statusClass }}"><span class="badge-dot"></span>{{ $statusLabel }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="ticket-title-text">{{ $ticket->title }}</div>
                        <div class="ticket-meta-row">
                            <div class="ticket-meta-item">
                                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Submitted by <strong>{{ $ticket->user->name ?? 'Unknown' }}</strong>
                            </div>
                            <div class="ticket-meta-item">
                                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $ticket->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                            @if($ticket->category)
                            <div class="ticket-meta-item">
                                <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                                {{ $ticket->category->name }}
                            </div>
                            @endif
                            <div class="ticket-meta-item">
                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Last updated {{ $ticket->updated_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="ticket-description">{{ $ticket->description }}</div>
                    </div>
                </div>

                {{-- Conversation --}}
                <div class="card">
                    <div class="card-head">
                        <span class="card-title">Conversation</span>
                        <span style="font-size:0.75rem;font-weight:600;color:#94a3b8;background:#f1f5f9;padding:0.2rem 0.6rem;border-radius:999px;">
                            {{ $ticket->comments->count() }} {{ Str::plural('reply', $ticket->comments->count()) }}
                        </span>
                    </div>

                    @if($ticket->comments->isEmpty())
                        <div class="replies-empty">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                            <p>No replies yet. Be the first to respond!</p>
                        </div>
                    @else
                        <div class="reply-thread">
                            @foreach($ticket->comments as $comment)
                                @php
                                    $role        = $comment->user->role ?? 'user';
                                    $isStaff     = in_array($role, ['staff', 'admin']);
                                    $isAdmin     = $role === 'admin';
                                    $avatarClass = $isAdmin ? 'admin-av' : ($isStaff ? 'staff-av' : 'user-av');
                                    $roleClass   = $isAdmin ? 'role-admin' : ($isStaff ? 'role-staff' : 'role-user');
                                    $roleLabel   = $isAdmin ? 'Admin' : ($isStaff ? 'IT Staff' : 'User');
                                @endphp
                                <div class="reply-item {{ $isStaff ? 'is-staff' : '' }}">
                                    <div class="reply-avatar {{ $avatarClass }}">
                                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="reply-content">
                                        <div class="reply-header">
                                            <span class="reply-author">{{ $comment->user->name ?? 'Unknown' }}</span>
                                            <span class="reply-role {{ $roleClass }}">{{ $roleLabel }}</span>
                                            <span class="reply-time">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="reply-text">{{ $comment->body }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="reply-form-wrap">
                        <form method="POST" action="{{ route('staff.tickets.reply', $ticket) }}">
                            @csrf
                            <label for="body" class="form-label">Add a Reply</label>
                            <textarea id="body" name="body" class="form-field"
                                placeholder="Type your reply here..."
                                maxlength="2000"
                                oninput="document.getElementById('char-count').textContent = this.value.length"
                                required></textarea>
                            @error('body')
                                <div style="font-size:0.75rem;color:#dc2626;margin-top:0.35rem;">{{ $message }}</div>
                            @enderror
                            <div class="form-row">
                                <span class="char-count"><span id="char-count">0</span> / 2000</span>
                                <button type="submit" class="submit-btn">
                                    <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div>
                <div class="card">
                    <div class="card-head"><span class="card-title">Ticket Details</span></div>
                    <div class="detail-row">
                        <span class="detail-key">Ticket ID</span>
                        <span class="detail-val">#{{ $ticket->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Status</span>
                        <span class="detail-val">
                            <span class="badge {{ $statusClass }}"><span class="badge-dot"></span>{{ $statusLabel }}</span>
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
                        <span class="detail-key">Submitted by</span>
                        <span class="detail-val">{{ $ticket->user->name ?? '—' }}</span>
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

                    {{-- Update status --}}
                    <form class="status-form" method="POST" action="{{ route('staff.tickets.update-status', $ticket) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="status-select">
                            <option value="open"        {{ $ticket->status == 'open'        ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved"    {{ $ticket->status == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                            <option value="closed"      {{ $ticket->status == 'closed'      ? 'selected' : '' }}>Closed</option>
                        </select>
                        <button type="submit" class="update-btn">Update Status</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection