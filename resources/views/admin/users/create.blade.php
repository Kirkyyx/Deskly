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

    .page-title { margin-bottom: 1.75rem; }
    .page-title h2 {
        font-size: 1.5rem; font-weight: 800;
        letter-spacing: -0.035em; color: var(--text-primary);
        margin: 0 0 0.2rem;
    }
    .page-title p {
        font-size: 0.8125rem; color: var(--text-muted);
        margin: 0; font-weight: 400;
    }

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

    .form-body { padding: 2rem 2rem 1.75rem; }

    .card-section-label {
        font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted); margin-bottom: 1.5rem;
        padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);
    }

    .error-box {
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 10px; padding: 0.875rem 1.1rem; margin-bottom: 1.5rem;
    }
    .error-box li {
        color: #b91c1c; font-size: 0.8rem; font-weight: 500;
        list-style: none; margin-bottom: 3px;
    }
    .error-box li::before { content: '— '; }

    .field-group { margin-bottom: 1.2rem; }

    .field-label {
        display: block; font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.07em; text-transform: uppercase;
        color: var(--text-muted); margin-bottom: 0.4rem;
    }

    .field-input {
        width: 100%; background: var(--surface-2);
        border: 1px solid var(--border); border-radius: 8px;
        padding: 0.65rem 0.9rem; color: var(--text-primary);
        font-family: 'Inter', sans-serif; font-size: 0.875rem;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        outline: none; box-sizing: border-box;
    }
    .field-input:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(59,110,248,0.1);
        background: #fff;
    }
    .field-input::placeholder { color: #b0b8c8; }
    .field-input option { background: var(--surface); }

    /* Staff badge hint */
    .staff-badge-hint {
        display: none;
        margin-top: 0.4rem;
        padding: 0.5rem 0.75rem;
        background: rgba(99,102,241,0.06);
        border: 1px solid rgba(99,102,241,0.15);
        border-radius: 7px;
        font-size: 0.75rem;
        color: #4f46e5;
        font-weight: 500;
        line-height: 1.4;
    }
    .staff-badge-hint .badge-preview {
        font-weight: 700;
        font-family: 'Inter', monospace;
    }

    .form-actions {
        display: flex; gap: 0.65rem;
        margin-top: 1.75rem; padding-top: 1.5rem;
        border-top: 1px solid var(--border);
    }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.4rem;
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

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="page-wrap">
    <div class="form-wrap">

        <div class="page-title">
            <h2>Add User</h2>
            <p>Create a new account and assign a role.</p>
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

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="field-group">
                        <label class="field-label">Name</label>
                        <input type="text" name="name" id="nameInput" class="field-input"
                               value="{{ old('name') }}" required placeholder="Full name">
                        <div class="staff-badge-hint" id="staffBadgeHint">
                            A unique badge will be appended automatically —
                            e.g. <span class="badge-preview" id="badgePreview">Juan dela Cruz (IT Staff #XXXX)</span>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email</label>
                        <input type="email" name="email" class="field-input"
                               value="{{ old('email') }}" required placeholder="email@example.com">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password</label>
                        <input type="password" name="password" class="field-input"
                               required placeholder="••••••••">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Role</label>
                        <select name="role" id="roleSelect" class="field-input" required>
                            <option value="user"  {{ old('role') === 'user'  ? 'selected' : '' }}>User</option>
                            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Create User</button>
                        <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<script>
    const roleSelect   = document.getElementById('roleSelect');
    const nameInput    = document.getElementById('nameInput');
    const badgeHint    = document.getElementById('staffBadgeHint');
    const badgePreview = document.getElementById('badgePreview');

    function updateHint() {
        if (roleSelect.value === 'staff') {
            badgeHint.style.display = 'block';
            const base = nameInput.value.trim() || 'Full Name';
            badgePreview.textContent = base + ' (IT Staff #XXXX)';
        } else {
            badgeHint.style.display = 'none';
        }
    }

    roleSelect.addEventListener('change', updateHint);
    nameInput.addEventListener('input', updateHint);

    // Run on load in case of old() repopulation
    updateHint();
</script>

@endsection