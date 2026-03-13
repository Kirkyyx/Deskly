<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Deskly</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            background: #f4f6fb;
        }

        /* ── Layout shell ── */
        .app-shell {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ── Sidebar wrapper (fixed) ── */
        .app-sidebar-wrap {
            width: 240px;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.25s ease;
        }

        /* ── Main content ── */
        .app-main {
            flex: 1;
            min-width: 0;
            margin-left: 240px;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Mobile top bar ── */
        .mobile-topbar {
            display: none;
            position: fixed; top: 0; left: 0; right: 0;
            height: 52px;
            background: #ffffff;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            align-items: center;
            padding: 0 1rem;
            z-index: 200;
            gap: 0.75rem;
        }

        .mobile-toggle {
            background: rgba(99,102,241,0.08);
            border: 1px solid rgba(99,102,241,0.15);
            border-radius: 8px;
            width: 34px; height: 34px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 4px; cursor: pointer; flex-shrink: 0;
        }

        .mobile-toggle span {
            display: block; width: 16px; height: 1.5px;
            background: #6366f1; border-radius: 2px;
            transition: transform 0.2s, opacity 0.2s;
        }

        .mobile-logo {
            font-weight: 900;
            font-size: 1.1rem;
            letter-spacing: -0.05em;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 60%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Sidebar overlay */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 99;
            backdrop-filter: blur(2px);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        .sidebar {
            width: 240px;
            height: 100%;
            background: #ffffff;
            border-right: 1px solid rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(99,102,241,0.06) 0%, transparent 70%);
            pointer-events: none;
            border-radius: 50%;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(139,92,246,0.05) 0%, transparent 70%);
            pointer-events: none;
            border-radius: 50%;
        }

        /* Brand */
        .sidebar-brand {
            padding: 1.375rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 0.625rem;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 34px; height: 34px; min-width: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 60%, #06b6d4 100%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }

        .brand-icon svg {
            width: 16px; height: 16px;
            fill: none; stroke: #fff;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .brand-wordmark {
            font-size: 1.2rem;
            font-weight: 900;
            letter-spacing: -0.05em;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 60%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            background-size: 200% 100%;
            animation: shimmerText 4s linear infinite;
        }

        @keyframes shimmerText {
            0%   { background-position: 0% 0; }
            100% { background-position: 200% 0; }
        }

        /* Nav */
        .sidebar-nav {
            padding: 1rem 0.875rem;
            flex: 1;
            position: relative;
            z-index: 1;
            overflow-y: auto;
        }

        .nav-list {
            list-style: none;
            padding: 0; margin: 0;
            display: flex; flex-direction: column;
            gap: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.575rem 0.75rem;
            border-radius: 10px;
            text-decoration: none;
            color: #64748b;
            font-size: 0.835rem;
            font-weight: 500;
            letter-spacing: -0.005em;
            transition: all 0.18s cubic-bezier(.4,0,.2,1);
            position: relative;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }

        .nav-link:hover {
            background: rgba(99,102,241,0.06);
            color: #4f46e5;
        }

        .nav-link:hover .nav-icon-box {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }

        .nav-link:hover .nav-icon-box svg { stroke: #fff; }

        .nav-link.active {
            background: rgba(99,102,241,0.08);
            color: #4f46e5;
            font-weight: 600;
        }

        .nav-link.active .nav-icon-box {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 60%, #06b6d4 100%);
            box-shadow: 0 4px 14px rgba(99,102,241,0.38);
        }

        .nav-link.active .nav-icon-box svg { stroke: #fff; }

        .nav-link.active::after {
            content: '';
            position: absolute;
            right: 0.625rem; top: 50%;
            transform: translateY(-50%);
            width: 5px; height: 5px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        /* Icon Box */
        .nav-icon-box {
            width: 30px; height: 30px; min-width: 30px;
            border-radius: 8px;
            background: rgba(99,102,241,0.08);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.18s cubic-bezier(.4,0,.2,1);
        }

        .nav-icon-box svg {
            width: 14px; height: 14px;
            fill: none; stroke: #6366f1;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            transition: stroke 0.18s;
        }

        /* Nav section divider */
        .nav-divider {
            height: 1px;
            background: rgba(0,0,0,0.05);
            margin: 0.5rem 0.25rem;
        }

        /* Logout Footer */
        .sidebar-footer {
            padding: 1rem 0.875rem;
            border-top: 1px solid rgba(0,0,0,0.06);
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .sidebar-footer form {
            margin: 0; padding: 0; width: 100%;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 0.875rem;
            border-radius: 10px;
            width: 100%;
            border: 1px solid rgba(239,68,68,0.18);
            background: rgba(239,68,68,0.04);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 0.835rem;
            font-weight: 500;
            color: #f87171;
            letter-spacing: -0.005em;
            transition: all 0.2s cubic-bezier(.4,0,.2,1);
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.09);
            border-color: rgba(239,68,68,0.32);
            color: #ef4444;
            transform: translateX(2px);
        }

        .logout-btn:hover .logout-icon {
            background: rgba(239,68,68,0.14);
            box-shadow: 0 3px 10px rgba(239,68,68,0.2);
        }

        .logout-btn:hover .logout-icon svg { stroke: #ef4444; }

        .logout-icon {
            width: 30px; height: 30px; min-width: 30px;
            border-radius: 8px;
            background: rgba(239,68,68,0.08);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s cubic-bezier(.4,0,.2,1);
        }

        .logout-icon svg {
            width: 14px; height: 14px;
            fill: none; stroke: #f87171;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            transition: stroke 0.2s;
        }

        /* Entrance animations */
        .sidebar-brand,
        .nav-list li {
            animation: slideInLeft 0.35s cubic-bezier(.22,1,.36,1) both;
        }

        .sidebar-brand            { animation-delay: 0.05s; }
        .nav-list li:nth-child(1) { animation-delay: 0.10s; }
        .nav-list li:nth-child(2) { animation-delay: 0.15s; }
        .nav-list li:nth-child(3) { animation-delay: 0.20s; }
        .nav-list li:nth-child(4) { animation-delay: 0.25s; }
        .nav-list li:nth-child(5) { animation-delay: 0.30s; }
        .nav-list li:nth-child(6) { animation-delay: 0.35s; }

        .sidebar-footer {
            animation: slideInLeft 0.35s 0.4s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-12px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .mobile-topbar { display: flex; }
            .app-sidebar-wrap { transform: translateX(-100%); }
            .app-sidebar-wrap.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .app-main { margin-left: 0; padding-top: 52px; }
        }
    </style>
</head>
<body>

<div class="app-shell">

    {{-- Mobile top bar --}}
    <div class="mobile-topbar">
        <button class="mobile-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
            <span></span><span></span><span></span>
        </button>
        <span class="mobile-logo">Deskly</span>
    </div>

    {{-- Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <div class="app-sidebar-wrap" id="appSidebar">
        <aside class="sidebar">

            {{-- Brand --}}
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                </div>
                <div class="brand-wordmark">Deskly</div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">
                <ul class="nav-list">

                    {{-- ======= ADMIN ======= --}}
                    @if(auth()->user()->role === 'admin')

                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                                    </svg>
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.index') }}"
                               class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 010 7.75"/>
                                    </svg>
                                </div>
                                <span>Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('categories.index') }}"
                               class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 6h16M4 12h16M4 18h10"/>
                                    </svg>
                                </div>
                                <span>Categories</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('tickets.index') }}"
                               class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"/>
                                        <path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                        <path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"/>
                                        <path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"/>
                                        <path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"/>
                                        <path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/>
                                        <path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"/>
                                        <path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"/>
                                    </svg>
                                </div>
                                <span>Tickets</span>
                            </a>
                        </li>

                        {{-- Knowledge Base --}}
                        <li>
                            <a href="{{ route('admin.articles.index') }}"
                               class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                                    </svg>
                                </div>
                                <span>Support Center</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('audit-logs.index') }}"
                               class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                </div>
                                <span>Audit Logs</span>
                            </a>
                        </li>

                    {{-- ======= STAFF ======= --}}
                    @elseif(auth()->user()->role === 'staff')

                        <li>
                            <a href="{{ route('staff.dashboard') }}"
                               class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                                    </svg>
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('staff.tickets.index') }}"
                               class="nav-link {{ request()->routeIs('staff.tickets.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"/>
                                        <path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                        <path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"/>
                                        <path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"/>
                                        <path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"/>
                                        <path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/>
                                        <path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"/>
                                        <path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"/>
                                    </svg>
                                </div>
                                <span>My Tickets</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('audit-logs.index') }}"
                               class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                </div>
                                <span>Audit Logs</span>
                            </a>
                        </li>

                    {{-- ======= USER ======= --}}
                    @elseif(auth()->user()->role === 'user')

                        <li>
                            <a href="{{ route('user.dashboard') }}"
                               class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                                    </svg>
                                </div>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('user.tickets.index') }}"
                               class="nav-link {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}">
                                <div class="nav-icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"/>
                                        <path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                        <path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"/>
                                        <path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"/>
                                        <path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"/>
                                        <path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/>
                                        <path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"/>
                                        <path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"/>
                                    </svg>
                                </div>
                                <span>My Tickets</span>
                            </a>
                        </li>

                    @endif
                </ul>
            </nav>

            {{-- Logout --}}
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <div class="logout-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                        </div>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>
    </div>

    {{-- Page Content --}}
    <main class="app-main">
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('appSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    });

    document.querySelectorAll('.app-sidebar-wrap .nav-link, .app-sidebar-wrap a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>