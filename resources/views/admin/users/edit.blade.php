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
        --danger: #ef4444;
        --danger-light: #fef2f2;
        --danger-border: #fecaca;
        --text-primary: #0f1729;
        --text-muted: #8a94a6;
        --text-dim: #4b5568;
    }

    body {
        background-color: var(--bg) !important;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }

    .page-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(59,110,248,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.06) 0%, transparent 55%),
            var(--bg);
    }

    .form-wrap {
        width: 100%;
        max-width: 480px;
        animation: fadeUp 0.4s ease both;
    }

    /* Page title */
    .page-title {
        margin-bottom: 1.75rem;
    }

    .page-title h2 {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.035em;
        color: var(--text-primary);
        margin: 0 0 0.2rem;
    }

    .page-title p {
        font-size: 0.8125rem;
        color: var(--text-muted);
        margin: 0;
        font-weight: 400;
    }

    /* Card */
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05), 0 4px 24px rgba(59,110,248,0.06);
    }

    .card-accent {
        height: 3px;
        background: linear-gradient(90deg, var(--accent-blue), #6366f1);
    }

    .form-body {
        padding: 2rem 2rem 1.75rem;
    }

    .card-section-label {
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
    }

    /* Error */
    .error-box {
        background: var(--danger-light);
        border: 1px solid var(--danger-border);
        border-radius: 10px;
        padding: 0.875rem 1.1rem;
        margin-bottom: 1.5rem;
    }
    .error-box li {
        color: #b91c1c;
        font-size: 0.8rem;
        font-weight: 500;
        list-style: none;
        margin-bottom: 3px;
    }
    .error-box li::before { content: '— '; }

    /* Fields */
    .field-group { margin-bottom: 1.2rem; }

    .field-label {
        display: block;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
    }

    .field-input {
        width: 100%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0.65rem 0.9rem;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        outline: none;
        box-sizing: border-box;
    }

    .field-input:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(59,110,248,0.1);
        background: #fff;
    }

    .field-input:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .field-input option { background: var(--surface); }

    .readonly-note {
        font-size: 0.6875rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
        font-weight: 400;
    }

    /* Actions */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.65rem;
        margin-top: 1.75rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
    }

    .actions-left { display: flex; gap: 0.65rem; }

    .btn-submit {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.4rem;
        background: linear-gradient(135deg, var(--accent-blue), #6366f1);
        color: #fff; border: none; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; letter-spacing: -0.01em;
        transition: opacity 0.18s, transform 0.18s;
        box-shadow: 0 4px 14px rgba(59,110,248,0.25);
    }
    .btn-submit:hover { opacity: 0.88; transform: translateY(-1px); }

    .btn-cancel {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.2rem;
        background: var(--surface-2); color: var(--text-dim);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 500;
        text-decoration: none;
        transition: background 0.18s, color 0.18s;
    }
    .btn-cancel:hover { background: #e8eeff; color: var(--text-primary); }

    .btn-delete {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.2rem;
        background: var(--danger-light); color: var(--danger);
        border: 1px solid var(--danger-border); border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 500;
        cursor: pointer;
        transition: background 0.18s, transform 0.18s;
    }
    .btn-delete:hover { background: #fee2e2; transform: translateY(-1px); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Delete Confirmation Dialog (del-* to avoid Bootstrap conflicts) ── */
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
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        width: 100%; max-width: 380px;
        margin: 1rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
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
    .del-btn-cancel:hover { background: #e8eeff; color: var(--text-primary); }

    .del-btn-confirm {
        background: var(--danger); color: #fff;
        box-shadow: 0 4px 14px rgba(239,68,68,0.25);
    }
    .del-btn-confirm:hover { background: #dc2626; }
</style>

<div class="page-wrap">
    <div class="form-wrap">

        <div class="page-title">
            <h2>Edit User Role</h2>
            <p>Update the access level for this account.</p>
        </div>

        <div class="form-card">
            <div class="card-accent"></div>
            <div class="form-body">

                <div class="card-section-label">Account Details</div>

                @if($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="field-group">
                        <label class="field-label">Name</label>
                        <input type="text" class="field-input" value="{{ $user->name }}" disabled>
                        <div class="readonly-note">Read-only — cannot be changed here.</div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email</label>
                        <input type="email" class="field-input" value="{{ $user->email }}" disabled>
                        <div class="readonly-note">Read-only — cannot be changed here.</div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Role</label>
                        <select name="role" class="field-input" required>
                            <option value="user"  @if($user->role === 'user')  selected @endif>User</option>
                            <option value="staff" @if($user->role === 'staff') selected @endif>Staff</option>
                            <option value="admin" @if($user->role === 'admin') selected @endif>Admin</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <div class="actions-left">
                            <button type="submit" class="btn-submit">Update Role</button>
                            <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
                        </div>
                        <button type="button" class="btn-delete" onclick="openDelDialog()">Delete User</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

{{-- Delete Confirmation Dialog --}}
<div class="del-overlay" id="delOverlay" onclick="handleDelOverlayClick(event)">
    <div class="del-box">
        <div class="del-heading">Delete this user?</div>
        <div class="del-desc">
            You're about to permanently delete <strong>{{ $user->name }}</strong>
            ({{ $user->email }}). This cannot be undone.
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

<form id="delForm" action="{{ route('users.destroy', $user) }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.appendChild(document.getElementById('delOverlay'));
        document.body.appendChild(document.getElementById('delForm'));
    });

    function openDelDialog() {
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