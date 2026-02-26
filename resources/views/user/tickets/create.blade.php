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

    body {
        background-color: var(--bg) !important;
        font-family: 'Inter', sans-serif; margin: 0;
    }

    .page-wrap {
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 3rem 1.5rem;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .form-wrap {
        width: 100%; max-width: 580px;
        animation: fadeUp 0.4s ease both;
    }

    .page-title-block { margin-bottom: 1.75rem; }
    .page-title-block h2 {
        font-size: 1.5rem; font-weight: 800;
        letter-spacing: -0.035em; color: var(--text-primary);
        margin: 0 0 0.2rem;
    }
    .page-title-block p { font-size: 0.8125rem; color: var(--text-muted); margin: 0; }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05), 0 4px 24px rgba(124,58,237,0.06);
    }

    .card-accent {
        height: 3px;
        background: linear-gradient(90deg, var(--accent-violet), var(--accent-indigo));
    }

    .form-body { padding: 2rem 2rem 1.75rem; }

    .section-label {
        font-size: 0.6875rem; font-weight: 600;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--text-muted);
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
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
    .field-textarea { resize: vertical; min-height: 120px; }
    .field-select option { background: var(--surface); color: var(--text-primary); }

    .field-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.35rem; }

    /* File input */
    .file-wrap {
        display: flex; align-items: center; gap: 0.75rem;
        background: var(--surface-2); border: 1px solid var(--border);
        border-radius: 8px; padding: 0.6rem 0.9rem;
        cursor: pointer; transition: border-color 0.18s, background 0.18s;
    }
    .file-wrap:focus-within { border-color: var(--accent-violet); box-shadow: 0 0 0 3px rgba(124,58,237,0.1); background: #fff; }
    .file-wrap svg { width: 15px; height: 15px; stroke: var(--text-muted); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
    .file-wrap input[type="file"] { border: none; background: none; padding: 0; font-size: 0.875rem; font-family: 'Inter', sans-serif; color: var(--text-dim); outline: none; width: 100%; }

    .form-actions {
        display: flex; gap: 0.65rem; margin-top: 1.75rem;
        padding-top: 1.5rem; border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }

    .btn-submit {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.4rem;
        background: linear-gradient(135deg, var(--accent-violet), var(--accent-indigo));
        color: #fff; border: none; border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 0.8125rem; font-weight: 600;
        cursor: pointer; letter-spacing: -0.01em;
        transition: opacity 0.18s, transform 0.18s;
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
            <h2>Create Ticket</h2>
            <p>Submit a new support request and we'll get back to you.</p>
        </div>

        <div class="form-card">
            <div class="card-accent"></div>
            <div class="form-body">

                <div class="section-label">Ticket Details</div>

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

                <form method="POST" action="{{ route('user.tickets.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="field-group">
                        <label class="field-label" for="title">Title</label>
                        <input type="text" name="title" id="title" class="field-input"
                            value="{{ old('title') }}" placeholder="Brief summary of your issue" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="field-select" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="priority">Priority</label>
                        <select name="priority" id="priority" class="field-select" required>
                            <option value="">Select priority</option>
                            <option value="low"      {{ old('priority') == 'low'      ? 'selected' : '' }}>Low — minor issue, low urgency</option>
                            <option value="medium"   {{ old('priority') == 'medium'   ? 'selected' : '' }}>Medium — moderate impact, standard response</option>
                            <option value="high"     {{ old('priority') == 'high'     ? 'selected' : '' }}>High — needs attention soon</option>
                            <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical — blocks work or data loss risk</option>
                        </select>
                        <div class="field-hint">Priority helps staff triage your request faster.</div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="description">Description</label>
                        <textarea name="description" id="description" class="field-textarea"
                            placeholder="Provide details so staff can understand and resolve your issue…" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="attachment">Attachment <span style="font-weight:400;text-transform:none;letter-spacing:0;">(optional)</span></label>
                        <div class="file-wrap">
                            <svg viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                            <input type="file" name="attachment" id="attachment">
                        </div>
                        <div class="field-hint">Supported: jpg, jpeg, png, pdf, doc, docx — max 2MB</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Submit Ticket</button>
                        <a href="{{ route('user.tickets.index') }}" class="btn-secondary">Back to Tickets</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection