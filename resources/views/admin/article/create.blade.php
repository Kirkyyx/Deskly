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

    .page-wrap {
        min-height: 100vh;
        display: flex; align-items: flex-start; justify-content: center;
        padding: 3rem 1.5rem;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .form-wrap {
        width: 100%; max-width: 680px;
        animation: fadeUp 0.4s ease both;
    }

    .page-title-block { margin-bottom: 1.75rem; }
    .page-title-block h2 { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.035em; color: var(--text-primary); margin: 0 0 0.2rem; }
    .page-title-block p  { font-size: 0.8125rem; color: var(--text-muted); margin: 0; }

    .form-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05), 0 4px 24px rgba(124,58,237,0.06);
    }

    .card-accent { height: 3px; background: linear-gradient(90deg, var(--accent-violet), var(--accent-indigo)); }
    .form-body { padding: 2rem; }

    .section-label {
        font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.1em;
        text-transform: uppercase; color: var(--text-muted);
        padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);
        margin-bottom: 1.5rem;
    }

    .error-box {
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 10px; padding: 0.875rem 1.1rem; margin-bottom: 1.5rem;
    }
    .error-box h4 { font-size: 0.8rem; font-weight: 700; color: #b91c1c; margin: 0 0 0.4rem; }
    .error-box ul { margin: 0; padding-left: 0; list-style: none; }
    .error-box li { color: #b91c1c; font-size: 0.78rem; font-weight: 500; margin-bottom: 3px; }
    .error-box li::before { content: '— '; }

    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 560px) { .field-row { grid-template-columns: 1fr; } }

    .field-group { margin-bottom: 1.2rem; }

    .field-label {
        display: block; font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.07em; text-transform: uppercase;
        color: var(--text-muted); margin-bottom: 0.4rem;
    }

    .field-input, .field-select, .field-textarea {
        width: 100%; background: var(--surface-2);
        border: 1px solid var(--border); border-radius: 8px;
        padding: 0.65rem 0.9rem; color: var(--text-primary);
        font-family: 'Inter', sans-serif; font-size: 0.875rem;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        outline: none;
    }
    .field-input:focus, .field-select:focus, .field-textarea:focus {
        border-color: var(--accent-violet);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        background: #fff;
    }
    .field-input::placeholder, .field-textarea::placeholder { color: #b0b8c8; }
    .field-textarea { resize: vertical; min-height: 200px; line-height: 1.6; }
    .field-select option { background: var(--surface); color: var(--text-primary); }
    .field-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.35rem; line-height: 1.5; }

    /* Toggle switch for is_public */
    .toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.875rem 1rem;
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 10px; margin-bottom: 1.2rem;
    }
    .toggle-info {}
    .toggle-label { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.15rem; }
    .toggle-desc  { font-size: 0.75rem; color: var(--text-muted); }

    .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; flex-shrink: 0; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; cursor: pointer; inset: 0;
        background: #d1d5db; border-radius: 999px;
        transition: background 0.2s;
    }
    .toggle-slider::before {
        content: ''; position: absolute;
        width: 18px; height: 18px; border-radius: 50%;
        background: #fff; left: 3px; top: 3px;
        transition: transform 0.2s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--accent-violet); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }

    .form-actions {
        display: flex; gap: 0.65rem; margin-top: 1.75rem;
        padding-top: 1.5rem; border-top: 1px solid var(--border); flex-wrap: wrap;
    }

    .btn-submit {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.4rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; transition: opacity 0.18s, transform 0.18s;
        box-shadow: 0 4px 14px rgba(124,58,237,0.22);
    }
    .btn-submit:hover { opacity: 0.88; transform: translateY(-1px); }

    .btn-secondary {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.2rem;
        background: var(--surface-2); color: var(--text-dim);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 500;
        text-decoration: none; transition: background 0.18s, color 0.18s;
    }
    .btn-secondary:hover { background: #ede9fe; color: var(--text-primary); }

    @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="page-wrap">
    <div class="form-wrap">

        <div class="page-title-block">
            <h2>New Article</h2>
            <p>Write a new knowledge base article for users and staff.</p>
        </div>

        <div class="form-card">
            <div class="card-accent"></div>
            <div class="form-body">

                <div class="section-label">Article Details</div>

                @if($errors->any())
                    <div class="error-box">
                        <h4>Please fix the following errors:</h4>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.articles.store') }}">
                    @csrf

                    <div class="field-group">
                        <label class="field-label" for="title">Title</label>
                        <input type="text" name="title" id="title" class="field-input"
                            value="{{ old('title') }}" placeholder="e.g. How to reset your password" required>
                    </div>

                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label" for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="field-select">
                                <option value="">No category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group" style="display:flex;flex-direction:column;justify-content:flex-end;">
                            {{-- spacer for alignment --}}
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="body">Body</label>
                        <textarea name="body" id="body" class="field-textarea"
                            placeholder="Write the article content here…" required>{{ old('body') }}</textarea>
                        <div class="field-hint">Plain text is supported. Keep content clear and concise for best readability.</div>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-label">Public Article</div>
                            <div class="toggle-desc">Visible to all users in the self-service portal</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Publish Article</button>
                        <a href="{{ route('admin.articles.index') }}" class="btn-secondary">Cancel</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection