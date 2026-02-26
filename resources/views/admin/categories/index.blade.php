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
        --accent-violet: #7c3aed;
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
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.06) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(59,110,248,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .dash-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }

    .dash-header-left { display: flex; align-items: center; gap: 1rem; }

    .header-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(124,58,237,0.22);
        font-size: 1.1rem; flex-shrink: 0;
    }

    .dash-header h2 {
        font-size: 1.6rem; font-weight: 800;
        margin: 0; letter-spacing: -0.03em; color: var(--text-primary);
    }

    .dash-header .subtitle {
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
        box-shadow: 0 4px 14px rgba(124,58,237,0.22);
    }
    .btn-add:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; }

    .success-toast {
        display: flex; align-items: center; gap: 0.75rem;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 10px; padding: 0.8rem 1.1rem;
        margin-bottom: 1.5rem; font-size: 0.8rem; color: #166534;
        font-weight: 500;
        animation: fadeUp 0.3s ease both;
    }

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
        font-weight: 700; font-size: 0.95rem; color: var(--text-primary);
    }

    .count-badge {
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
    .dash-table tbody td { padding: 0.9rem 1.1rem; color: var(--text-dim); vertical-align: middle; font-family: 'Inter', sans-serif; }
    .dash-table tbody td:first-child { color: var(--text-muted); font-size: 0.75rem; }

    .category-cell { display: flex; align-items: center; gap: 0.7rem; }

    /* Initial letter avatar — replaces the ■ icon */
    .category-initial {
        width: 28px; height: 28px; border-radius: 7px;
        background: #ede9fe; border: 1px solid #ddd6fe;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700;
        color: var(--accent-violet);
        flex-shrink: 0;
        font-family: 'Inter', sans-serif;
        text-transform: uppercase;
    }

    .category-name {
        color: var(--text-primary);
        font-size: 0.83rem; font-weight: 600;
    }

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
        background: #fff; border-radius: 16px; padding: 2rem;
        width: 100%; max-width: 380px; margin: 1rem;
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
        line-height: 1.6; margin-bottom: 1.5rem;
    }
    .del-desc strong { color: var(--text-primary); font-weight: 600; }

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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
            </div>
            <div>
                <h2>Categories</h2>
                <div class="subtitle">Manage ticket categories</div>
            </div>
        </div>
        <a href="{{ route('categories.create') }}" class="btn-add">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="success-toast">{{ session('success') }}</div>
    @endif

    <div class="table-card">
        <div class="table-card-header">
            <span class="title">All Categories</span>
            <span class="count-badge">
                {{ ($categories instanceof \Illuminate\Pagination\LengthAwarePaginator) ? $categories->total() : $categories->count() }} total
            </span>
        </div>

        <div class="table-responsive">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <div class="category-cell">
                                    {{-- First letter of category name instead of ■ --}}
                                    <div class="category-initial">{{ substr($category->name, 0, 1) }}</div>
                                    <span class="category-name">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="action-btn edit">Edit</a>
                                <button
                                    type="button"
                                    class="action-btn delete"
                                    onclick="openDelDialog('{{ addslashes($category->name) }}', '{{ route('categories.destroy', $category) }}')"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">No categories found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator && $categories->hasPages())
            <div style="border-top: 1px solid var(--border);">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Delete Confirmation Dialog --}}
<div class="del-overlay" id="delOverlay" onclick="handleDelOverlayClick(event)">
    <div class="del-box">
        <div class="del-heading">Delete this category?</div>
        <div class="del-desc">
            You're about to delete <strong id="del-cat-name"></strong>. This cannot be undone.
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

    function openDelDialog(name, actionUrl) {
        document.getElementById('del-cat-name').textContent = name;
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