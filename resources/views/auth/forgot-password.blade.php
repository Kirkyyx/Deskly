<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    * { font-family:'Inter',sans-serif;box-sizing:border-box;margin:0;padding:0; }
    body { background:#f8f9ff; }

    .bg-scene { position:fixed;inset:0;overflow:hidden;background:#f8f9ff;z-index:0; }
    .blob { position:absolute;border-radius:50%;filter:blur(80px);opacity:0.18;animation:blobFloat linear infinite; }
    .blob-1 { width:600px;height:600px;background:radial-gradient(circle,#6366f1,#a5b4fc);top:-200px;left:-150px;animation-duration:18s; }
    .blob-2 { width:500px;height:500px;background:radial-gradient(circle,#8b5cf6,#c4b5fd);bottom:-180px;right:-120px;animation-duration:22s;animation-delay:-6s; }
    .blob-3 { width:350px;height:350px;background:radial-gradient(circle,#06b6d4,#67e8f9);top:40%;left:55%;animation-duration:26s;animation-delay:-12s; }
    @keyframes blobFloat {
        0%   { transform:translate(0,0) scale(1); }
        25%  { transform:translate(30px,-40px) scale(1.05); }
        50%  { transform:translate(-20px,50px) scale(0.97); }
        75%  { transform:translate(50px,20px) scale(1.03); }
        100% { transform:translate(0,0) scale(1); }
    }
    .grid-overlay { position:absolute;inset:0;background-image:linear-gradient(rgba(99,102,241,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(99,102,241,0.04) 1px,transparent 1px);background-size:48px 48px; }
    .particles { position:absolute;inset:0;pointer-events:none; }
    .particle { position:absolute;border-radius:50%;background:#6366f1;opacity:0;animation:particleDrift linear infinite; }
    @keyframes particleDrift {
        0%   { opacity:0;transform:translateY(100vh) scale(0); }
        10%  { opacity:0.5; }
        90%  { opacity:0.3; }
        100% { opacity:0;transform:translateY(-20px) scale(1.2); }
    }

    .page-wrap { position:relative;z-index:10;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.5rem; }

    .card {
        background:rgba(255,255,255,0.88);
        backdrop-filter:blur(24px) saturate(180%);
        -webkit-backdrop-filter:blur(24px) saturate(180%);
        border:1px solid rgba(255,255,255,0.9);
        border-radius:24px;
        padding:2.75rem 3rem;
        max-width:440px;width:100%;
        box-shadow:0 4px 6px rgba(99,102,241,0.04),0 20px 60px rgba(99,102,241,0.1),0 1px 0 rgba(255,255,255,0.8) inset;
        animation:cardIn 0.7s cubic-bezier(.22,1,.36,1) both;
        position:relative;overflow:hidden;
    }
    @keyframes cardIn { from { opacity:0;transform:translateY(32px) scale(0.97); } to { opacity:1;transform:translateY(0) scale(1); } }
    .card::before { content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#6366f1,#8b5cf6,#06b6d4);background-size:200% 100%;animation:shimmerBar 3s linear infinite; }
    @keyframes shimmerBar { 0% { background-position:0% 0; } 100% { background-position:200% 0; } }

    /* Brand */
    .brand-row { display:flex;align-items:center;gap:0.875rem;margin-bottom:1.75rem;animation:fadeUp 0.5s 0.1s ease both; }
    .brand-icon { width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(99,102,241,0.35);flex-shrink:0; }
    .brand-icon svg { width:22px;height:22px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .brand-name { font-size:1rem;font-weight:700;color:#0f172a;letter-spacing:-0.02em; }
    .brand-sub  { font-size:0.75rem;font-weight:400;color:#94a3b8;margin-top:1px; }

    /* Page icon */
    .page-icon-wrap { display:flex;justify-content:center;margin-bottom:1.5rem;animation:fadeUp 0.5s 0.15s ease both; }
    .page-icon {
        width:64px;height:64px;border-radius:20px;
        background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);
        display:flex;align-items:center;justify-content:center;
        box-shadow:0 8px 28px rgba(99,102,241,0.35);
        position:relative;
    }
    .page-icon svg { width:28px;height:28px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .page-icon::after { content:'';position:absolute;inset:-7px;border-radius:27px;border:2px solid rgba(99,102,241,0.2);animation:ringPulse 2.5s ease infinite; }
    @keyframes ringPulse { 0%,100% { opacity:1;transform:scale(1); } 50% { opacity:0.35;transform:scale(1.07); } }

    @keyframes fadeUp { from { opacity:0;transform:translateY(10px); } to { opacity:1;transform:translateY(0); } }

    .card-title { font-size:1.5rem;font-weight:800;color:#0f172a;letter-spacing:-0.04em;line-height:1.2;margin-bottom:0.375rem;text-align:center;animation:fadeUp 0.5s 0.22s ease both; }
    .card-subtitle { font-size:0.875rem;color:#64748b;font-weight:400;line-height:1.65;margin-bottom:1.75rem;text-align:center;animation:fadeUp 0.5s 0.3s ease both; }

    /* Session status */
    .session-status { font-size:0.8125rem;font-weight:500;color:#059669;background:#ecfdf5;border:1px solid #a7f3d0;border-radius:10px;padding:0.625rem 0.875rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem; }
    .session-status svg { width:15px;height:15px;stroke:#059669;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0; }

    /* Form */
    .form-group { margin-bottom:1.25rem;animation:fadeUp 0.5s 0.38s ease both; }
    .form-label { display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.4rem;letter-spacing:0.005em; }
    .input-wrap { position:relative; }
    .input-icon { position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);pointer-events:none;color:#94a3b8;transition:color 0.2s ease; }
    .input-icon svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .input-wrap:focus-within .input-icon { color:#6366f1; }

    .form-input { width:100%;padding:0.7rem 0.875rem 0.7rem 2.375rem;font-size:0.9rem;font-family:'Inter',sans-serif;font-weight:400;color:#0f172a;background:#ffffff;border:1.5px solid #e2e8f0;border-radius:12px;outline:none;transition:border-color 0.2s ease,box-shadow 0.2s ease,background 0.2s ease;-webkit-appearance:none; }
    .form-input::placeholder { color:#c0c9d6;font-size:0.8125rem; }
    .form-input:hover { border-color:#c7d2fe; }
    .form-input:focus { border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,0.12);background:#fafbff; }

    .input-error { font-size:0.78125rem;color:#ef4444;font-weight:500;margin-top:0.375rem;display:flex;align-items:center;gap:0.3rem; }
    .input-error::before { content:'!';display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;border-radius:50%;background:#ef4444;color:#fff;font-size:0.625rem;font-weight:700;flex-shrink:0; }

    /* Info box */
    .info-box { display:flex;align-items:flex-start;gap:0.625rem;background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:0.875rem 1rem;margin-bottom:1.5rem;animation:fadeUp 0.5s 0.44s ease both; }
    .info-box-icon { flex-shrink:0; }
    .info-box-icon svg { width:15px;height:15px;stroke:#3b82f6;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .info-box p { font-size:0.8rem;color:#1e40af;line-height:1.55; }

    /* Submit */
    .btn-submit { width:100%;padding:0.8125rem 1.5rem;font-size:0.9375rem;font-weight:600;font-family:'Inter',sans-serif;color:#ffffff;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);border:none;border-radius:12px;cursor:pointer;box-shadow:0 4px 16px rgba(99,102,241,0.35),0 1px 0 rgba(255,255,255,0.2) inset;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:transform 0.18s cubic-bezier(.34,1.56,.64,1),box-shadow 0.18s ease;letter-spacing:-0.01em;position:relative;overflow:hidden;animation:fadeUp 0.5s 0.5s ease both; }
    .btn-submit::after { content:'';position:absolute;inset:0;border-radius:inherit;background:rgba(255,255,255,0.18);opacity:0;transform:scale(0);transition:transform 0.4s ease,opacity 0.4s ease; }
    .btn-submit:active::after { transform:scale(2.5);opacity:1;transition:0s; }
    .btn-submit:hover { transform:translateY(-2px) scale(1.015);box-shadow:0 8px 28px rgba(99,102,241,0.45),0 1px 0 rgba(255,255,255,0.2) inset; }
    .btn-submit:active { transform:translateY(0) scale(0.99); }
    .btn-submit svg { width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

    .divider { height:1px;background:linear-gradient(90deg,transparent,#e2e8f0 30%,#e2e8f0 70%,transparent);margin:1.5rem 0 1.25rem;animation:fadeUp 0.5s 0.58s ease both; }
    .card-footer { text-align:center;font-size:0.8125rem;color:#94a3b8;animation:fadeUp 0.5s 0.64s ease both; }
    .card-footer a { color:#6366f1;font-weight:600;text-decoration:none;transition:color 0.2s ease; }
    .card-footer a:hover { color:#4f46e5; }
</style>

<div class="bg-scene">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="grid-overlay"></div>
    <div class="particles" id="particles"></div>
</div>

<div class="page-wrap">
    <div class="card">

        <div class="brand-row">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
            </div>
            <div>
                <div class="brand-name">Ticketing System</div>
                <div class="brand-sub">Support &amp; Issue Tracking</div>
            </div>
        </div>

        <!-- Hero icon -->
        <div class="page-icon-wrap">
            <div class="page-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
            </div>
        </div>

        <h1 class="card-title">Forgot your password?</h1>
        <p class="card-subtitle">No worries — enter your email and we'll send you a reset link right away.</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="session-status">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('status') }}
            </div>
        @endif

        <!-- Info hint -->
        <div class="info-box">
            <div class="info-box-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <p>We'll email you a secure link to reset your password. The link expires after 60 minutes.</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <div class="input-wrap">
                    <span class="input-icon">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <input
                        id="email"
                        class="form-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>
                @if ($errors->has('email'))
                    <div class="input-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Send Reset Link
            </button>
        </form>

        <div class="divider"></div>

        <p class="card-footer">
            Remember your password? &nbsp;<a href="{{ route('login') }}">Back to login</a>
        </p>

    </div>
</div>

<script>
    const container = document.getElementById('particles');
    const colors = ['#6366f1','#8b5cf6','#06b6d4','#a5b4fc'];
    for (let i = 0; i < 28; i++) {
        const p = document.createElement('div');
        p.className = 'particle';
        p.style.left = Math.random() * 100 + '%';
        p.style.width = p.style.height = (Math.random() * 3 + 2) + 'px';
        p.style.background = colors[Math.floor(Math.random() * colors.length)];
        p.style.animationDuration = (Math.random() * 14 + 10) + 's';
        p.style.animationDelay = (Math.random() * -20) + 's';
        container.appendChild(p);
    }
</script>
</x-guest-layout>