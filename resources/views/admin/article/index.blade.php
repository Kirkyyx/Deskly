@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --bg: #f4f6fb; --surface: #ffffff; --surface-2: #f0f3fa;
        --border: rgba(0,0,0,0.07);
        --accent-violet: #7c3aed; --accent-indigo: #6366f1;
        --text-primary: #0f1729; --text-muted: #8a94a6; --text-dim: #4b5568;
    }

    *, *::before, *::after { box-sizing: border-box; }
    body { background-color: var(--bg) !important; font-family: 'Inter', sans-serif; margin: 0; }

    .dash-wrapper {
        padding: 2.5rem 2rem; min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .dash-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;
        animation: fadeUp 0.4s ease both;
    }
    .dash-header-left { display: flex; align-items: center; gap: 1rem; }
    .header-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 16px rgba(124,58,237,0.3); flex-shrink: 0;
    }
    .header-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .page-title { font-weight: 800; font-size: 1.5rem; margin: 0; letter-spacing: -0.03em; color: var(--text-primary); }
    .page-sub   { font-size: 0.68rem; color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.6rem 1.25rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 9px;
        font-size: 0.8125rem; font-weight: 600;
        text-decoration: none; box-shadow: 0 4px 14px rgba(124,58,237,0.28);
        transition: opacity 0.2s, transform 0.2s; font-family: 'Inter', sans-serif;
    }
    .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; }
    .btn-primary svg { width: 14px; height: 14px; stroke: #fff; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

    .filter-bar {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 12px; padding: 0.875rem 1.125rem;
        margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        animation: fadeUp 0.4s 0.08s ease both;
    }
    .filter-search { flex: 1; min-width: 180px; position: relative; }
    .filter-search svg { position: absolute; left: 0.7rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; stroke: var(--text-muted); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .filter-search input {
        width: 100%; padding: 0.55rem 0.75rem 0.55rem 2.1rem;
        border: 1px solid var(--border); border-radius: 8px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        color: var(--text-primary); background: var(--surface-2);
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .filter-search input:focus { border-color: #c4b5fd; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); background: #fff; }
    .filter-search input::placeholder { color: #cbd5e1; }
    .filter-select {
        padding: 0.55rem 2rem 0.55rem 0.7rem;
        border: 1px solid var(--border); border-radius: 8px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        color: var(--text-dim); background: var(--surface-2) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%238a94a6' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 0.6rem center;
        appearance: none; outline: none; cursor: pointer; transition: border-color 0.2s;
    }
    .filter-select:focus { border-color: #c4b5fd; }
    .btn-search {
        padding: 0.55rem 1rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 8px;
        font-size: 0.875rem; font-family: 'Inter', sans-serif;
        cursor: pointer; font-weight: 600; transition: opacity 0.2s;
    }
    .btn-search:hover { opacity: 0.88; }
    .btn-clear { font-size: 0.875rem; font-weight: 600; color: var(--text-muted); text-decoration: none; white-space: nowrap; }
    .btn-clear:hover { color: var(--text-dim); }

    .table-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.4s 0.16s ease both;
    }
    .table-card-header {
        padding: 1rem 1.375rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .table-card-title { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); }
    .count-badge {
        font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--text-muted); background: var(--surface-2);
        border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px;
    }

    table { width: 100%; border-collapse: collapse; font-size: 0.875rem; font-family: 'Inter', sans-serif; }
    thead tr { background: var(--surface-2); border-bottom: 1px solid var(--border); }
    thead th { padding: 0.7rem 1.1rem; font-size: 0.75rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--text-muted); font-weight: 500; text-align: left; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #faf9ff; }
    tbody td { padding: 0.9rem 1.1rem; color: var(--text-dim); vertical-align: middle; }

    .article-title { font-weight: 600; color: var(--text-primary); font-size: 0.875rem; margin-bottom: 0.15rem; }
    .article-excerpt { font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px; }

    .cat-chip {
        display: inline-block; padding: 2px 9px; border-radius: 5px;
        font-size: 0.68rem; background: var(--surface-2);
        border: 1px solid var(--border); color: var(--text-dim);
    }

    .visibility-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 0.7rem; font-weight: 600; padding: 3px 9px; border-radius: 999px; }
    .visibility-badge.public  { background: #ecfdf5; color: #059669; }
    .visibility-badge.private { background: var(--surface-2); color: var(--text-muted); }
    .visibility-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .visibility-badge.public::before  { background: #059669; }
    .visibility-badge.private::before { background: #94a3b8; }

    .status-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 0.7rem; font-weight: 600; padding: 3px 9px; border-radius: 999px; }
    .status-badge.active   { background: #eff6ff; color: #1d4ed8; }
    .status-badge.archived { background: #fef9c3; color: #92400e; }
    .status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .status-badge.active::before   { background: #1d4ed8; }
    .status-badge.archived::before { background: #92400e; }

    .date-text { font-size: 0.75rem; color: var(--text-muted); white-space: nowrap; }

    .action-cell { display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 4px 10px; border-radius: 6px; font-size: 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        text-decoration: none; border: 1px solid #bfdbfe;
        background: #eff6ff; color: #1d4ed8;
        transition: opacity 0.15s, transform 0.15s;
    }
    .btn-edit:hover { opacity: 0.82; transform: translateY(-1px); color: #1d4ed8; }
    .btn-archive {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 4px 10px; border-radius: 6px; font-size: 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        border: 1px solid #fde68a; background: #fef9c3; color: #92400e;
        cursor: pointer; transition: opacity 0.15s, transform 0.15s;
        outline: none;
    }
    .btn-archive.restore { border-color: #bbf7d0; background: #f0fdf4; color: #15803d; }
    .btn-archive:hover { opacity: 0.82; transform: translateY(-1px); }
    .btn-delete {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 4px 10px; border-radius: 6px; font-size: 0.7rem;
        font-family: 'Inter', sans-serif; font-weight: 500;
        border: 1px solid #fecaca; background: #fef2f2; color: #b91c1c;
        cursor: pointer; transition: opacity 0.15s, transform 0.15s;
    }
    .btn-delete:hover { opacity: 0.82; transform: translateY(-1px); }

    .empty-state { padding: 4rem 2rem; text-align: center; }
    .empty-state svg { width: 40px; height: 40px; stroke: #ddd6fe; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; display: block; margin: 0 auto 0.875rem; }
    .empty-state h3 { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.3rem; }
    .empty-state p { font-size: 0.875rem; color: var(--text-muted); }

    .pag-wrap {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.875rem 1.375rem; border-top: 1px solid var(--border);
        flex-wrap: wrap; gap: 0.5rem;
    }
    .pag-info { font-size: 0.75rem; color: var(--text-muted); }
    .pag-links { display: flex; gap: 0.3rem; align-items: center; }
    .pag-btn {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 32px; height: 32px; padding: 0 0.5rem;
        border-radius: 7px; border: 1px solid var(--border);
        background: var(--surface-2); color: var(--text-dim);
        font-size: 0.8125rem; font-weight: 500; text-decoration: none;
        transition: background 0.15s, color 0.15s; font-family: 'Inter', sans-serif;
    }
    .pag-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
    .pag-btn:hover { background: #ede9fe; color: var(--accent-violet); border-color: #ddd6fe; }
    .pag-btn.active { background: var(--accent-violet); border-color: var(--accent-violet); color: #fff; }
    .pag-btn[disabled] { opacity: 0.35; pointer-events: none; }

    /* Delete modal */
    .del-overlay {
        display: none; position: fixed; inset: 0; z-index: 9999;
        background: rgba(15,23,41,0.45); backdrop-filter: blur(3px);
        align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.2s ease;
    }
    .del-overlay.active { opacity: 1; }
    .del-box {
        background: var(--surface); border-radius: 16px; padding: 2rem;
        max-width: 400px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        transform: translateY(10px); transition: transform 0.2s ease;
    }
    .del-overlay.active .del-box { transform: translateY(0); }
    .del-heading { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; }
    .del-desc    { font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem; }
    .del-actions { display: flex; gap: 0.65rem; justify-content: flex-end; }
    .del-cancel {
        padding: 0.55rem 1.1rem; border-radius: 8px;
        background: var(--surface-2); border: 1px solid var(--border);
        color: var(--text-dim); font-size: 0.8125rem; font-weight: 500;
        cursor: pointer; font-family: 'Inter', sans-serif; transition: background 0.15s;
    }
    .del-cancel:hover { background: #e8e8f0; }
    .del-confirm {
        padding: 0.55rem 1.1rem; border-radius: 8px;
        background: #dc2626; border: none; color: #fff;
        font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; font-family: 'Inter', sans-serif; transition: opacity 0.15s;
    }
    .del-confirm:hover { opacity: 0.88; }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="dash-wrapper">

    <div class="dash-header">
        <div class="dash-header-left">
            <div class="header-icon">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            </div>
            <div>
                <div class="page-title">Support Center</div>
                <div class="page-sub">Manage articles &amp; guides</div>
            </div>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Article
        </a>
    </div>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('admin.articles.index') }}" class="filter-bar">
        <div class="filter-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" placeholder="Search articles…" value="{{ request('search') }}">
        </div>
        <select name="category" class="filter-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <select name="visibility" class="filter-select" onchange="this.form.submit()">
            <option value="">All Visibility</option>
            <option value="public"  {{ request('visibility') === 'public'  ? 'selected' : '' }}>Public</option>
            <option value="private" {{ request('visibility') === 'private' ? 'selected' : '' }}>Private</option>
        </select>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
        <button type="submit" class="btn-search">Search</button>
        @if(request()->hasAny(['search','category','visibility','status']))
            <a href="{{ route('admin.articles.index') }}" class="btn-clear">Clear</a>
        @endif
    </form>

    {{-- Table card --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">All Articles</span>
            <span class="count-badge">{{ $articles->total() }} total</span>
        </div>

        @if($articles->isEmpty())
            <div class="empty-state">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                <h3>No articles yet</h3>
                <p>Start building your knowledge base by creating the first article.</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Article</th>
                            <th>Category</th>
                            <th>Visibility</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td style="color:var(--text-muted);font-size:0.75rem;">{{ $article->id }}</td>
                            <td>
                                <div class="article-title">{{ $article->title }}</div>
                                <div class="article-excerpt">{{ Str::limit(strip_tags($article->body), 80) }}</div>
                            </td>
                            <td>
                                @if($article->category)
                                    <span class="cat-chip">{{ $article->category->name }}</span>
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>
                            <td>
                                @if($article->is_public)
                                    <span class="visibility-badge public">Public</span>
                                @else
                                    <span class="visibility-badge private">Private</span>
                                @endif
                            </td>
                            <td>
                                @if($article->status === 'active')
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge archived">Archived</span>
                                @endif
                            </td>
                            <td><span class="date-text">{{ $article->created_at->format('M d, Y') }}</span></td>
                            <td>
                                <div class="action-cell">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn-edit">Edit</a>

                                    {{-- Archive / Restore toggle --}}
                                    <form method="POST" action="{{ route('admin.articles.toggle-status', $article) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-archive {{ $article->status === 'archived' ? 'restore' : '' }}">
                                            {{ $article->status === 'active' ? 'Archive' : 'Restore' }}
                                        </button>
                                    </form>

                                    <button class="btn-delete" onclick="openDel({{ $article->id }}, '{{ addslashes($article->title) }}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($articles->hasPages())
            <div class="pag-wrap">
                <div class="pag-info">Showing {{ $articles->firstItem() }}–{{ $articles->lastItem() }} of {{ $articles->total() }}</div>
                <div class="pag-links">
                    @if($articles->onFirstPage())
                        <span class="pag-btn" disabled><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                    @else
                        <a href="{{ $articles->previousPageUrl() }}" class="pag-btn"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                    @endif
                    @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="pag-btn {{ $page === $articles->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($articles->hasMorePages())
                        <a href="{{ $articles->nextPageUrl() }}" class="pag-btn"><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                    @else
                        <span class="pag-btn" disabled><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                    @endif
                </div>
            </div>
            @endif
        @endif
    </div>

</div>

{{-- Delete modal --}}
<div class="del-overlay" id="delOverlay">
    <div class="del-box">
        <div class="del-heading">Delete Article?</div>
        <div class="del-desc">You're about to delete "<strong id="delTitle"></strong>". This action cannot be undone.</div>
        <div class="del-actions">
            <button class="del-cancel" onclick="closeDel()">Cancel</button>
            <form id="delForm" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="del-confirm">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    const overlay = document.getElementById('delOverlay');

    document.addEventListener('DOMContentLoaded', () => {
        document.body.appendChild(overlay);
    });

    function openDel(id, title) {
        document.getElementById('delTitle').textContent = title;
        document.getElementById('delForm').action = `/admin/articles/${id}`;
        overlay.style.display = 'flex';
        requestAnimationFrame(() => requestAnimationFrame(() => overlay.classList.add('active')));
    }

    function closeDel() {
        overlay.classList.remove('active');
        setTimeout(() => { overlay.style.display = 'none'; }, 200);
    }

    overlay.addEventListener('click', e => { if (e.target === overlay) closeDel(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDel(); });
</script>

@endsection