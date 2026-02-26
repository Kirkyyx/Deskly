<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    * { font-family:'Inter',sans-serif;box-sizing:border-box;margin:0;padding:0; }
    body { background:#f8f9ff; }

    /* ── Animated Background ── */
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
    .grid-overlay {
        position:absolute;inset:0;
        background-image:linear-gradient(rgba(99,102,241,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(99,102,241,0.04) 1px,transparent 1px);
        background-size:48px 48px;
    }
    .particles { position:absolute;inset:0;pointer-events:none; }
    .particle { position:absolute;width:4px;height:4px;border-radius:50%;background:#6366f1;opacity:0;animation:particleDrift linear infinite; }
    @keyframes particleDrift {
        0%   { opacity:0;transform:translateY(100vh) scale(0); }
        10%  { opacity:0.5; }
        90%  { opacity:0.3; }
        100% { opacity:0;transform:translateY(-20px) scale(1.2); }
    }

    /* ── Layout ── */
    .page-wrap {
        position:relative;z-index:10;
        min-height:100vh;
        display:flex;align-items:center;justify-content:center;
        padding:2rem 1.5rem;
    }

    /* ── Card ── */
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
    }
    @keyframes cardIn {
        from { opacity:0;transform:translateY(32px) scale(0.97); }
        to   { opacity:1;transform:translateY(0) scale(1); }
    }
    .card::before {
        content:'';position:absolute;top:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#6366f1,#8b5cf6,#06b6d4);
        background-size:200% 100%;
        animation:shimmerBar 3s linear infinite;
    }
    @keyframes shimmerBar {
        0%   { background-position:0% 0; }
        100% { background-position:200% 0; }
    }

    /* ── Brand row ── */
    .brand-row { display:flex;align-items:center;gap:0.875rem;margin-bottom:1.75rem;animation:fadeUp 0.5s 0.1s ease both; }
    .brand-wordmark {
        font-size:1.25rem;
        font-weight:900;
        letter-spacing:-0.05em;
        background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 60%,#06b6d4 100%);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
        background-clip:text;
        line-height:1;
    }
    .brand-sub { font-size:0.72rem;font-weight:400;color:#94a3b8;margin-top:2px;letter-spacing:0.01em; }

    /* ── Headings ── */
    .card-title { font-size:1.625rem;font-weight:800;color:#0f172a;letter-spacing:-0.04em;line-height:1.2;margin-bottom:0.375rem;animation:fadeUp 0.5s 0.2s ease both; }
    .card-subtitle { font-size:0.875rem;color:#64748b;font-weight:400;line-height:1.6;margin-bottom:1.75rem;animation:fadeUp 0.5s 0.28s ease both; }

    @keyframes fadeUp {
        from { opacity:0;transform:translateY(10px); }
        to   { opacity:1;transform:translateY(0); }
    }

    /* ── Two-column grid ── */
    .form-grid { display:grid;grid-template-columns:1fr 1fr;gap:0 1rem; }
    @media(max-width:480px) { .form-grid { grid-template-columns:1fr; } }
    .col-span-2 { grid-column:span 2; }
    @media(max-width:480px) { .col-span-2 { grid-column:span 1; } }

    /* ── Form group ── */
    .form-group { margin-bottom:1.125rem;animation:fadeUp 0.5s ease both; }
    .form-group:nth-child(1) { animation-delay:0.32s; }
    .form-group:nth-child(2) { animation-delay:0.38s; }
    .form-group:nth-child(3) { animation-delay:0.44s; }
    .form-group:nth-child(4) { animation-delay:0.50s; }

    .form-label { display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.4rem;letter-spacing:0.005em; }

    .input-wrap { position:relative; }
    .input-icon { position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);pointer-events:none;color:#94a3b8;transition:color 0.2s ease; }
    .input-icon svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }
    .input-wrap:focus-within .input-icon { color:#6366f1; }

    .form-input {
        width:100%;
        padding:0.7rem 0.875rem 0.7rem 2.375rem;
        font-size:0.9rem;font-family:'Inter',sans-serif;font-weight:400;
        color:#0f172a;
        background:#ffffff;
        border:1.5px solid #e2e8f0;
        border-radius:12px;
        outline:none;
        transition:border-color 0.2s ease,box-shadow 0.2s ease,background 0.2s ease;
        -webkit-appearance:none;
        appearance:none;
    }
    .form-input::placeholder { color:#c0c9d6;font-size:0.8125rem; }
    .form-input:hover { border-color:#c7d2fe; }
    .form-input:focus { border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,0.12);background:#fafbff; }
    .form-input.is-valid { border-color:#10b981; }
    .form-input.is-valid:focus { box-shadow:0 0 0 3px rgba(16,185,129,0.12); }

    /* ── Suppress ALL browser-native password controls ── */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    input[type="password"]::-webkit-contacts-auto-fill-button,
    input[type="password"]::-webkit-credentials-auto-fill-button { display:none !important; }
    input::-webkit-password-reveal-icon { display:none !important; }

    /* Eye toggle */
    .has-eye .form-input { padding-right:2.75rem; }
    .eye-toggle { position:absolute;right:0.875rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:0;color:#94a3b8;transition:color 0.2s ease;display:flex;align-items:center;z-index:2; }
    .eye-toggle:hover { color:#6366f1; }
    .eye-toggle svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

    /* Password strength bar */
    .strength-bar-wrap { margin-top:0.5rem;display:none; }
    .strength-bar-wrap.visible { display:block; }
    .strength-track { height:3px;border-radius:999px;background:#e2e8f0;overflow:hidden;margin-bottom:0.3rem; }
    .strength-fill { height:100%;border-radius:999px;width:0%;transition:width 0.4s ease,background 0.4s ease; }
    .strength-label { font-size:0.7rem;font-weight:500;color:#94a3b8;text-align:right; }

    /* Match indicator */
    .match-indicator { font-size:0.75rem;font-weight:500;margin-top:0.375rem;display:none;align-items:center;gap:0.3rem; }
    .match-indicator.visible { display:flex; }
    .match-indicator.match   { color:#10b981; }
    .match-indicator.no-match { color:#f59e0b; }
    .match-indicator svg { width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round; }

    /* Error */
    .input-error { font-size:0.78125rem;color:#ef4444;font-weight:500;margin-top:0.375rem;display:flex;align-items:center;gap:0.3rem; }
    .input-error::before { content:'!';display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;border-radius:50%;background:#ef4444;color:#fff;font-size:0.625rem;font-weight:700;flex-shrink:0; }

    /* ── Terms notice ── */
    .terms-notice { font-size:0.78125rem;color:#94a3b8;line-height:1.55;text-align:center;margin-bottom:1.25rem;animation:fadeUp 0.5s 0.56s ease both; }
    .terms-notice a { color:#6366f1;text-decoration:none;font-weight:500; }
    .terms-notice a:hover { color:#4f46e5;text-decoration:underline; }

    /* ── Submit ── */
    .btn-submit {
        width:100%;
        padding:0.8125rem 1.5rem;
        font-size:0.9375rem;font-weight:600;font-family:'Inter',sans-serif;
        color:#ffffff;
        background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);
        border:none;border-radius:12px;cursor:pointer;
        box-shadow:0 4px 16px rgba(99,102,241,0.35),0 1px 0 rgba(255,255,255,0.2) inset;
        display:flex;align-items:center;justify-content:center;gap:0.5rem;
        transition:transform 0.18s cubic-bezier(.34,1.56,.64,1),box-shadow 0.18s ease;
        letter-spacing:-0.01em;
        position:relative;overflow:hidden;
        animation:fadeUp 0.5s 0.62s ease both;
        margin-bottom:1.25rem;
    }
    .btn-submit::after { content:'';position:absolute;inset:0;border-radius:inherit;background:rgba(255,255,255,0.18);opacity:0;transform:scale(0);transition:transform 0.4s ease,opacity 0.4s ease; }
    .btn-submit:active::after { transform:scale(2.5);opacity:1;transition:0s; }
    .btn-submit:hover { transform:translateY(-2px) scale(1.015);box-shadow:0 8px 28px rgba(99,102,241,0.45),0 1px 0 rgba(255,255,255,0.2) inset; }
    .btn-submit:active { transform:translateY(0) scale(0.99); }
    .btn-submit svg { width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round; }

    /* ── Divider ── */
    .divider { height:1px;background:linear-gradient(90deg,transparent,#e2e8f0 30%,#e2e8f0 70%,transparent);margin:0 0 1.25rem;animation:fadeUp 0.5s 0.68s ease both; }

    /* ── Footer ── */
    .card-footer { text-align:center;font-size:0.8125rem;color:#94a3b8;animation:fadeUp 0.5s 0.72s ease both; }
    .card-footer a { color:#6366f1;font-weight:600;text-decoration:none;transition:color 0.2s ease; }
    .card-footer a:hover { color:#4f46e5; }
</style>

<!-- Animated background -->
<div class="bg-scene">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="grid-overlay"></div>
    <div class="particles" id="particles"></div>
</div>

<div class="page-wrap">
    <div class="card">

        <!-- Brand row -->
        <div class="brand-row">
            <div>
                <div class="brand-wordmark">Deskly</div>
                <div class="brand-sub">Help Desk Ticketing System</div>
            </div>
        </div>

        <h1 class="card-title">Create your account</h1>
        <p class="card-subtitle">Join your team and start managing tickets in minutes.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">

                <!-- Name -->
                <div class="form-group">
                    <label class="form-label" for="name">Full name</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="Jane Smith" required autofocus autocomplete="name"/>
                    </div>
                    @if ($errors->has('name'))
                        <div class="input-error">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required autocomplete="username"/>
                    </div>
                    @if ($errors->has('email'))
                        <div class="input-error">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group col-span-2">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap has-eye">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </span>
                        <input id="password" class="form-input" type="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password"/>
                        <button type="button" class="eye-toggle" id="eyeToggle1">
                            <svg id="eyeIcon1" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="strength-bar-wrap" id="strengthWrap">
                        <div class="strength-track"><div class="strength-fill" id="strengthFill"></div></div>
                        <div class="strength-label" id="strengthLabel"></div>
                    </div>
                    @if ($errors->has('password'))
                        <div class="input-error">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group col-span-2">
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                    <div class="input-wrap has-eye">
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </span>
                        <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" placeholder="Re-enter your password" required autocomplete="new-password"/>
                        <button type="button" class="eye-toggle" id="eyeToggle2">
                            <svg id="eyeIcon2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="match-indicator" id="matchIndicator">
                        <svg viewBox="0 0 12 12" id="matchIcon"></svg>
                        <span id="matchText"></span>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="input-error">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

            </div>

            <p class="terms-notice">
                By creating an account, you agree to our
                <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </p>

            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Create account
            </button>
        </form>

        <div class="divider"></div>

        <p class="card-footer">
            Already have an account?&nbsp;<a href="{{ route('login') }}">Log in instead</a>
        </p>

    </div>
</div>

<script>
    // Particles
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

    // Eye toggles
    function makeEyeToggle(btnId, iconId, inputId) {
        const btn   = document.getElementById(btnId);
        const icon  = document.getElementById(iconId);
        const input = document.getElementById(inputId);
        const open   = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        const closed = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
        btn.addEventListener('click', () => {
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            icon.innerHTML = isPass ? closed : open;
        });
    }
    makeEyeToggle('eyeToggle1','eyeIcon1','password');
    makeEyeToggle('eyeToggle2','eyeIcon2','password_confirmation');

    // Password strength
    const pwInput      = document.getElementById('password');
    const strengthWrap = document.getElementById('strengthWrap');
    const strengthFill = document.getElementById('strengthFill');
    const strengthLbl  = document.getElementById('strengthLabel');

    function getStrength(pw) {
        let score = 0;
        if (pw.length >= 8)  score++;
        if (pw.length >= 12) score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;
        return score;
    }

    const levels = [
        { label:'Too short',  color:'#ef4444', width:'15%' },
        { label:'Weak',       color:'#f97316', width:'30%' },
        { label:'Fair',       color:'#f59e0b', width:'55%' },
        { label:'Good',       color:'#84cc16', width:'75%' },
        { label:'Strong',     color:'#10b981', width:'90%' },
        { label:'Very strong',color:'#06b6d4', width:'100%' },
    ];

    pwInput.addEventListener('input', () => {
        const val = pwInput.value;
        if (!val) { strengthWrap.classList.remove('visible'); return; }
        strengthWrap.classList.add('visible');
        const s = Math.min(getStrength(val), 5);
        const l = levels[s];
        strengthFill.style.width = l.width;
        strengthFill.style.background = l.color;
        strengthLbl.textContent = l.label;
        strengthLbl.style.color = l.color;
    });

    // Password match indicator
    const confirmInput   = document.getElementById('password_confirmation');
    const matchIndicator = document.getElementById('matchIndicator');
    const matchIcon      = document.getElementById('matchIcon');
    const matchText      = document.getElementById('matchText');

    const checkSvg = `<polyline points="2,6 5,9 10,3"/>`;
    const warnSvg  = `<line x1="6" y1="1" x2="6" y2="7"/><circle cx="6" cy="9.5" r="0.5" fill="currentColor"/>`;

    function checkMatch() {
        const pw  = pwInput.value;
        const cpw = confirmInput.value;
        if (!cpw) { matchIndicator.classList.remove('visible','match','no-match'); return; }
        matchIndicator.classList.add('visible');
        if (pw === cpw) {
            matchIndicator.classList.add('match');
            matchIndicator.classList.remove('no-match');
            matchIcon.innerHTML = checkSvg;
            matchText.textContent = 'Passwords match';
            confirmInput.classList.add('is-valid');
        } else {
            matchIndicator.classList.add('no-match');
            matchIndicator.classList.remove('match');
            matchIcon.innerHTML = warnSvg;
            matchText.textContent = 'Passwords do not match';
            confirmInput.classList.remove('is-valid');
        }
    }
    confirmInput.addEventListener('input', checkMatch);
    pwInput.addEventListener('input', checkMatch);
</script>
</x-guest-layout>