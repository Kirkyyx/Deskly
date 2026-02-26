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
        --accent-emerald: #10b981;
        --accent-rose: #f43f5e;
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
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;
    }

    .dash-header-left { display: flex; align-items: center; gap: 1rem; }

    .header-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(124,58,237,0.3);
    }

    .header-icon svg {
        width: 20px; height: 20px;
        stroke: #fff; fill: none;
        stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }

    .dash-header h2 {
        font-family: 'Inter', sans-serif; font-weight: 800;
        font-size: 1.6rem; margin: 0; letter-spacing: -0.03em;
        color: var(--text-primary);
    }

    .dash-header .subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 0.68rem; color: var(--text-muted);
        letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px;
    }

    .btn-add {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.55rem 1.2rem;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        color: #fff; border: none; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.78rem; font-weight: 600;
        text-decoration: none; transition: opacity 0.2s, transform 0.2s;
        box-shadow: 0 4px 14px rgba(124,58,237,0.25);
    }
    .btn-add:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; }

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

    .table-card-header .title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.95rem;
        color: var(--text-primary);
    }

    .count-badge {
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted); background: var(--surface-2);
        border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px;
    }

    .dash-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    .dash-table thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    .dash-table thead th {
        padding: 0.75rem 1.1rem; font-size: 0.6rem; letter-spacing: 0.12em;
        text-transform: uppercase; color: var(--text-muted); font-weight: 500;
        font-family: 'Inter', sans-serif;
    }
    .dash-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
    .dash-table tbody tr:last-child { border-bottom: none; }
    .dash-table tbody tr:hover { background: #f7f5ff; }
    .dash-table tbody td { padding: 0.85rem 1.1rem; color: var(--text-dim); vertical-align: middle; font-family: 'Inter', sans-serif; }
    .dash-table tbody td:first-child { color: var(--text-muted); font-size: 0.75rem; }

    .user-cell { display: flex; align-items: center; gap: 0.6rem; }

    .user-avatar {
        width: 30px; height: 30px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem; font-weight: 700; color: white; flex-shrink: 0;
    }

    .user-name-text { color: var(--text-primary); font-size: 0.82rem; font-weight: 600; }
    .user-email-text { color: var(--text-muted); font-size: 0.73rem; }

    .role-badge {
        display: inline-block; padding: 3px 10px; border-radius: 20px;
        font-size: 0.65rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase;
    }
    .role-badge.admin { background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; }
    .role-badge.staff { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .role-badge.user  { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 11px; border-radius: 6px; font-size: 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        text-decoration: none; border: 1px solid transparent;
        cursor: pointer; background: none; transition: opacity 0.15s, transform 0.15s;
    }
    .action-btn:hover { opacity: 0.82; transform: translateY(-1px); }
    .action-btn.edit   { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .action-btn.delete { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .action-btn.edit:hover   { color: #166534; }
    .action-btn.delete:hover { color: #b91c1c; }

    .empty-state { padding: 4rem 2rem; text-align: center; color: var(--text-muted); font-size: 0.82rem; }

    .pagination { padding: 1rem 1.5rem; justify-content: flex-end; margin-bottom: 0; }
    .pagination .page-link {
        background: var(--surface-2); border-color: var(--border);
        color: var(--text-dim); font-size: 0.78rem; padding: 5px 12px;
        border-radius: 6px; margin: 0 2px; font-family: 'Inter', sans-serif;
    }
    .pagination .page-link:hover { background: #ede9fe; color: var(--accent-violet); }
    .pagination .page-item.active .page-link { background: var(--accent-violet); border-color: var(--accent-violet); color: #fff; }
    .pagination .page-item.disabled .page-link { opacity: 0.4; }

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
        background: #fff; border-radius: 18px; padding: 2rem;
        width: 100%; max-width: 400px; margin: 1rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        transform: translateY(16px) scale(0.98);
        transition: transform 0.25s cubic-bezier(.22,1,.36,1), opacity 0.22s ease;
        opacity: 0;
    }
    .del-overlay.active .del-box { transform: translateY(0) scale(1); opacity: 1; }

    .del-heading {
        font-size: 1rem; font-weight: 700;
        letter-spacing: -0.02em; color: var(--text-primary);
        margin-bottom: 0.4rem;
    }

    .del-desc {
        font-size: 0.875rem; color: var(--text-dim);
        line-height: 1.6; margin-bottom: 1.25rem;
    }
    .del-desc strong { color: var(--text-primary); font-weight: 600; }

    .del-warning {
        background: #fffbeb; border: 1px solid #fde68a;
        border-radius: 8px; padding: 0.6rem 0.875rem;
        font-size: 0.775rem; color: #92400e; margin-bottom: 1.5rem;
        font-weight: 500;
    }

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

    .del-btn-cancel {
        background: var(--surface-2); color: var(--text-dim);
        border: 1px solid var(--border);
    }
    .del-btn-cancel:hover { background: #ede9fe; color: var(--text-primary); }

    .del-btn-confirm {
        background: #ef4444; color: #fff;
        box-shadow: 0 4px 14px rgba(239,68,68,0.25);
    }
    .del-btn-confirm:hover { background: #dc2626; }
</style>

<div class="dash-wrapper">

    <div class="dash-header">
        <div class="dash-header-left">
            <div class="header-icon">
                {{-- Users / people SVG icon --}}
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <div>
                <h2>User Management</h2>
                <div class="subtitle">Manage accounts &amp; roles</div>
            </div>
        </div>
        <a href="{{ route('users.create') }}" class="btn-add">
            + Add User
        </a>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <span class="title">All Users</span>
            <span class="count-badge">{{ $users->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="user-name-text">{{ $user->name }}</div>
                                        <div class="user-email-text">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user) }}" class="action-btn edit">Edit</a>
                                <button
                                    type="button"
                                    class="action-btn delete"
                                    onclick="openDelDialog('{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ route('users.destroy', $user) }}')"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">No users found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div style="border-top: 1px solid var(--border);">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<div class="del-overlay" id="delOverlay" onclick="handleDelOverlayClick(event)">
    <div class="del-box">
        <div class="del-heading">Delete this user?</div>
        <div class="del-desc">
            You're about to permanently delete <strong id="del-user-name"></strong>
            (<span id="del-user-email"></span>). This cannot be undone.
        </div>
        <div class="del-warning">
            ⚠️ All tickets and data linked to this account will also be removed.
        </div>
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

    function openDelDialog(name, email, actionUrl) {
        document.getElementById('del-user-name').textContent  = name;
        document.getElementById('del-user-email').textContent = email;
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