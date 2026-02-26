<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    * {
        font-family: 'Inter', sans-serif;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body { background: #f8f9ff; }

    /* ── Animated Background ── */
    .bg-scene {
        position: fixed;
        inset: 0;
        overflow: hidden;
        background: #f8f9ff;
        z-index: 0;
    }
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.18;
        animation: blobFloat linear infinite;
    }
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
    .particle {
        position:absolute;width:4px;height:4px;border-radius:50%;background:#6366f1;opacity:0;
        animation:particleDrift linear infinite;
    }
    @keyframes particleDrift {
        0%   { opacity:0;transform:translateY(100vh) scale(0); }
        10%  { opacity:0.5; }
        90%  { opacity:0.3; }
        100% { opacity:0;transform:translateY(-20px) scale(1.2); }
    }

    /* ── Page Layout ── */
    .page-wrap {
        position:relative;z-index:10;
        min-height:100vh;
        display:flex;align-items:center;justify-content:center;
        padding:2rem 1.5rem;
    }

    /* ── Card — identical structure to login.blade ── */
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
        text-align:center;
    }
    @keyframes cardIn {
        from { opacity:0;transform:translateY(32px) scale(0.97); }
        to   { opacity:1;transform:translateY(0) scale(1); }
    }
    /* Shimmer bar — exactly like login.blade ::before */
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
    .brand-row {
        margin-bottom:1.5rem;
        animation:fadeUp 0.5s 0.1s ease both;
    }
    .brand-wordmark {
        font-size:3.75rem;
        font-weight:900;
        letter-spacing:-0.05em;
        /* Use color instead of gradient clip — no descender clipping possible */
        color: #6366f1;
        line-height:1.2;
    }
    .brand-sub {
        font-size:0.72rem;font-weight:400;color:#94a3b8;
        margin-top:3px;letter-spacing:0.01em;
    }

    @keyframes fadeUp {
        from { opacity:0;transform:translateY(10px); }
        to   { opacity:1;transform:translateY(0); }
    }

    /* ── Divider ── */
    .divider {
        height:1px;
        background:linear-gradient(90deg,transparent,#e2e8f0 30%,#e2e8f0 70%,transparent);
        margin:1.75rem 0 1.5rem;
        animation:fadeUp 0.5s 0.3s ease both;
    }

    /* ── Buttons ── */
    .btn-group {
        display:flex;
        flex-direction:column;
        gap:0.75rem;
        animation:fadeUp 0.5s 0.4s ease both;
    }

    .btn {
        width:100%;
        display:flex;align-items:center;justify-content:center;gap:0.5rem;
        padding:0.8125rem 1.5rem;
        font-size:0.9375rem;font-weight:600;font-family:'Inter',sans-serif;
        border-radius:12px;border:none;cursor:pointer;text-decoration:none;
        letter-spacing:-0.01em;white-space:nowrap;
        position:relative;overflow:hidden;
        transition:transform 0.18s cubic-bezier(.34,1.56,.64,1),box-shadow 0.18s ease;
    }
    .btn::after {
        content:'';position:absolute;inset:0;border-radius:inherit;
        background:rgba(255,255,255,0.2);opacity:0;transform:scale(0);
        transition:transform 0.4s ease,opacity 0.4s ease;
    }
    .btn:active::after { transform:scale(2.5);opacity:1;transition:0s; }

    .btn-primary {
        background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%);
        color:#ffffff;
        box-shadow:0 4px 16px rgba(99,102,241,0.35),0 1px 0 rgba(255,255,255,0.2) inset;
    }
    .btn-primary:hover {
        transform:translateY(-2px) scale(1.015);
        box-shadow:0 8px 28px rgba(99,102,241,0.45),0 1px 0 rgba(255,255,255,0.2) inset;
    }
    .btn-primary:active { transform:translateY(0) scale(0.99); }

    .btn-secondary {
        background:#ffffff;color:#374151;
        border:1.5px solid #e2e8f0;
        box-shadow:0 2px 8px rgba(0,0,0,0.06);
    }
    .btn-secondary:hover {
        background:#f8faff;border-color:#c7d2fe;color:#4f46e5;
        transform:translateY(-2px) scale(1.015);
        box-shadow:0 6px 20px rgba(99,102,241,0.15);
    }
    .btn-secondary:active { transform:translateY(0) scale(0.99); }

    .btn svg {
        width:16px;height:16px;stroke:currentColor;fill:none;
        stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;
    }

    /* ── Footer ── */
    .card-footer {
        animation:fadeUp 0.5s 0.52s ease both;
    }
    .footer-name {
        font-size:0.875rem;font-weight:700;color:#374151;
        letter-spacing:-0.01em;margin-bottom:0.2rem;
    }
    .footer-copy {
        font-size:0.72rem;color:#94a3b8;
    }
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

        <!-- Brand -->
        <div class="brand-row">
            <div class="brand-wordmark">Deskly</div>
            <div class="brand-sub">A Web-Based Help Desk Ticketing System</div>
        </div>

        <div class="divider"></div>

        <!-- Buttons -->
        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Log In
            </a>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                <svg viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
                Sign Up
            </a>
        </div>

        <div class="divider"></div>

        <div class="card-footer">
            <div class="footer-name">Kirk Ivan Tijol</div>
            <div class="footer-copy">© {{ date('Y') }} Deskly &nbsp;·&nbsp; All rights reserved</div>
        </div>

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