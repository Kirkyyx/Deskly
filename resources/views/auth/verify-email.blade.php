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
        max-width:460px;width:100%;
        box-shadow:0 4px 6px rgba(99,102,241,0.04),0 20px 60px rgba(99,102,241,0.1),0 1px 0 rgba(255,255,255,0.8) inset;
        animation:cardIn 0.7s cubic-bezier(.22,1,.36,1) both;
        position:relative;overflow:hidden;
        text-align:center;
    }
    @keyframes cardIn { from { opacity:0;transform:translateY(32px) scale(0.97); } to { opacity:1;transform:translateY(0) scale(1); } }
    .card::before { content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#6366f1,#8b5cf6,#06b6d4);background-size:200% 100%;animation:shimmerBar 3s linear infinite; }
    @keyframes shimmerBar { 0% { background-position:0% 0; } 100% { background-position:200% 0; } }

    /* Brand — left aligned */
    .brand-row { display:flex;align-items:center;gap:0.875rem;margin-bottom:2rem;text-align:left;animation:fadeUp 0.5s 0.1s ease both; }
    .brand-icon { width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(99,102,241,0.35);flex-shrink:0; }
    .brand-icon svg { width:22px;height:22px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .brand-name { font-size:1rem;font-weight:700;color:#0f172a;letter-spacing:-0.02em; }
    .brand-sub  { font-size:0.75rem;font-weight:400;color:#94a3b8;margin-top:1px; }

    /* ── Email envelope animation ── */
    .envelope-wrap { display:flex;justify-content:center;margin-bottom:1.75rem;animation:fadeUp 0.6s 0.18s ease both; }
    .envelope-outer {
        position:relative;
        width:88px;height:88px;
        border-radius:26px;
        background:linear-gradient(135deg,#eff6ff 0%,#eef2ff 100%);
        border:1.5px solid rgba(99,102,241,0.15);
        display:flex;align-items:center;justify-content:center;
        box-shadow:0 8px 28px rgba(99,102,241,0.12);
    }
    .envelope-outer::before {
        content:'';position:absolute;inset:-10px;border-radius:36px;
        border:2px solid rgba(99,102,241,0.12);
        animation:ringPulse 2.8s ease infinite;
    }
    .envelope-outer::after {
        content:'';position:absolute;inset:-20px;border-radius:44px;
        border:1.5px solid rgba(99,102,241,0.06);
        animation:ringPulse 2.8s ease infinite 0.4s;
    }
    @keyframes ringPulse { 0%,100% { opacity:1;transform:scale(1); } 50% { opacity:0.3;transform:scale(1.06); } }

    .envelope-icon { animation:iconBounce 2s ease infinite; }
    .envelope-icon svg { width:36px;height:36px;stroke:url(#grad);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round; }
    @keyframes iconBounce {
        0%,100% { transform:translateY(0); }
        50%      { transform:translateY(-4px); }
    }

    /* Floating dots around envelope */
    .dot { position:absolute;border-radius:50%;animation:dotFloat ease-in-out infinite; }
    .dot-1 { width:8px;height:8px;background:#6366f1;top:-4px;right:12px;animation-duration:3s;animation-delay:0s;opacity:0.7; }
    .dot-2 { width:5px;height:5px;background:#8b5cf6;bottom:10px;right:-8px;animation-duration:3.5s;animation-delay:-1s;opacity:0.5; }
    .dot-3 { width:6px;height:6px;background:#06b6d4;bottom:-4px;left:16px;animation-duration:4s;animation-delay:-2s;opacity:0.6; }
    @keyframes dotFloat { 0%,100% { transform:translateY(0) scale(1); } 50% { transform:translateY(-6px) scale(1.15); } }

    @keyframes fadeUp { from { opacity:0;transform:translateY(10px); } to { opacity:1;transform:translateY(0); } }

    .card-title { font-size:1.5rem;font-weight:800;color:#0f172a;letter-spacing:-0.04em;line-height:1.2;margin-bottom:0.5rem;animation:fadeUp 0.5s 0.26s ease both; }
    .card-body { font-size:0.9rem;color:#64748b;line-height:1.7;margin-bottom:1.75rem;animation:fadeUp 0.5s 0.34s ease both; }
    .card-body strong { color:#374151;font-weight:600; }

    /* Success alert */
    .success-alert {
        display:flex;align-items:flex-start;gap:0.625rem;
        background:#ecfdf5;border:1px solid #a7f3d0;border-radius:12px;
        padding:0.875rem 1rem;margin-bottom:1.5rem;text-align:left;
        animation:fadeUp 0.4s ease both;
    }
    .success-alert-icon { flex-shrink:0;margin-top:1px; }
    .success-alert-icon svg { width:16px;height:16px;stroke:#059669;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .success-alert p { font-size:0.8125rem;font-weight:500;color:#065f46;line-height:1.55; }

    /* Steps */
    .steps { display:flex;flex-direction:column;gap:0.625rem;margin-bottom:1.75rem;animation:fadeUp 0.5s 0.42s ease both; }
    .step-item { display:flex;align-items:flex-start;gap:0.75rem;text-align:left; }
    .step-num { flex-shrink:0;width:24px;height:24px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:0.6875rem;font-weight:700;color:#fff;margin-top:1px; }
    .step-text { font-size:0.8125rem;color:#475569;line-height:1.55; }

    /* Buttons */
    .btn-primary { width:100%;padding:0.8125rem 1.5rem;font-size:0.9375rem;font-weight:600;font-family:'Inter',sans-serif;color:#ffffff;background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);border:none;border-radius:12px;cursor:pointer;box-shadow:0 4px 16px rgba(99,102,241,0.35),0 1px 0 rgba(255,255,255,0.2) inset;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:transform 0.18s cubic-bezier(.34,1.56,.64,1),box-shadow 0.18s ease;letter-spacing:-0.01em;position:relative;overflow:hidden;animation:fadeUp 0.5s 0.5s ease both; }
    .btn-primary::after { content:'';position:absolute;inset:0;border-radius:inherit;background:rgba(255,255,255,0.18);opacity:0;transform:scale(0);transition:transform 0.4s ease,opacity 0.4s ease; }
    .btn-primary:active::after { transform:scale(2.5);opacity:1;transition:0s; }
    .btn-primary:hover { transform:translateY(-2px) scale(1.015);box-shadow:0 8px 28px rgba(99,102,241,0.45),0 1px 0 rgba(255,255,255,0.2) inset; }
    .btn-primary:active { transform:translateY(0) scale(0.99); }
    .btn-primary svg { width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

    .divider { height:1px;background:linear-gradient(90deg,transparent,#e2e8f0 30%,#e2e8f0 70%,transparent);margin:1.25rem 0;animation:fadeUp 0.5s 0.58s ease both; }

    .btn-logout { width:100%;padding:0.75rem 1.5rem;font-size:0.875rem;font-weight:600;font-family:'Inter',sans-serif;color:#64748b;background:#ffffff;border:1.5px solid #e2e8f0;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:transform 0.18s ease,box-shadow 0.18s ease,border-color 0.18s ease,color 0.18s ease;animation:fadeUp 0.5s 0.64s ease both; }
    .btn-logout:hover { border-color:#fca5a5;color:#ef4444;background:#fff5f5;transform:translateY(-1px);box-shadow:0 4px 14px rgba(239,68,68,0.12); }
    .btn-logout:active { transform:translateY(0); }
    .btn-logout svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

    .resend-note { font-size:0.78125rem;color:#94a3b8;margin-top:1rem;animation:fadeUp 0.5s 0.7s ease both; }
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

        <!-- Animated envelope -->
        <div class="envelope-wrap">
            <div class="envelope-outer">
                <div class="dot dot-1"></div>
                <div class="dot dot-2"></div>
                <div class="dot dot-3"></div>
                <div class="envelope-icon">
                    <svg viewBox="0 0 24 24">
                        <defs>
                            <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#6366f1"/>
                                <stop offset="100%" stop-color="#8b5cf6"/>
                            </linearGradient>
                        </defs>
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
            </div>
        </div>

        <h1 class="card-title">Check your inbox</h1>
        <p class="card-body">
            We sent a verification link to your email address.<br>
            <strong>Click the link in the email</strong> to activate your account.
        </p>

        <!-- Success alert -->
        @if (session('status') == 'verification-link-sent')
            <div class="success-alert">
                <div class="success-alert-icon">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <p>A new verification link has been sent to your email address.</p>
            </div>
        @endif

        <!-- Steps -->
        <div class="steps">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">Open your email app and look for a message from us.</div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">Click the <strong style="color:#374151;font-weight:600;">Verify Email Address</strong> button in the email.</div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">You'll be redirected back here and can start using the system.</div>
            </div>
        </div>

        <!-- Resend -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">
                <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Resend Verification Email
            </button>
        </form>

        <p class="resend-note">Didn't get it? Check your spam folder or request a new link above.</p>

        <div class="divider"></div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Log Out
            </button>
        </form>

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