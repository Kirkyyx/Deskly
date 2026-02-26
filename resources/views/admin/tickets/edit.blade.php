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

    .page-wrap {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(124,58,237,0.06) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(59,110,248,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .form-wrap {
        width: 100%;
        max-width: 560px;
        animation: fadeUp 0.4s ease both;
    }

    .page-title {
        margin-bottom: 1.75rem;
    }

    .page-title h2 {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.035em;
        color: var(--text-primary);
        margin: 0 0 0.2rem;
    }

    .page-title p {
        font-size: 0.8125rem;
        color: var(--text-muted);
        margin: 0;
        font-weight: 400;
    }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05), 0 4px 24px rgba(124,58,237,0.06);
    }

    .card-accent {
        height: 3px;
        background: linear-gradient(90deg, var(--accent-violet), #6366f1);
    }

    .form-body {
        padding: 2rem 2rem 1.75rem;
    }

    .card-section-label {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border);
    }

    .ticket-id-badge {
        font-size: 0.65rem; color: var(--text-muted);
        background: var(--surface-2); border: 1px solid var(--border);
        padding: 3px 10px; border-radius: 20px;
        font-weight: 500; letter-spacing: 0.05em;
        text-transform: none;
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
        display: block;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
    }

    .field-input,
    .field-textarea,
    .field-select {
        width: 100%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0.65rem 0.9rem;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        outline: none;
        box-sizing: border-box;
    }

    .field-input:focus,
    .field-textarea:focus,
    .field-select:focus {
        border-color: var(--accent-violet);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        background: #fff;
    }

    .field-input::placeholder,
    .field-textarea::placeholder { color: #b0b8c8; }

    .field-textarea { resize: vertical; min-height: 110px; }
    .field-select option { background: var(--surface); color: var(--text-primary); }

    .form-actions {
        display: flex; gap: 0.65rem;
        margin-top: 1.75rem; padding-top: 1.5rem;
        border-top: 1px solid var(--border); flex-wrap: wrap;
    }

    .btn-submit {
        display: inline-flex; align-items: center;
        padding: 0.625rem 1.4rem;
        background: linear-gradient(135deg, var(--accent-violet), #6366f1);
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
        text-decoration: none;
        transition: background 0.18s, color 0.18s;
    }
    .btn-secondary:hover { background: #ede9fe; color: var(--text-primary); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="page-wrap">
    <div class="form-wrap">

        <div class="page-title">
            <h2>Edit Ticket</h2>
            <p>Modify details for ticket #{{ $ticket->id }}.</p>
        </div>

        <div class="form-card">
            <div class="card-accent"></div>
            <div class="form-body">

                <div class="card-section-label">
                    Ticket Details
                    <span class="ticket-id-badge">#{{ $ticket->id }}</span>
                </div>

                @if($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="field-group">
                        <label class="field-label">Status</label>
                        <select name="status" class="field-select">
                            <option value="open"        @selected($ticket->status === 'open')>Open</option>
                            <option value="in_progress" @selected($ticket->status === 'in_progress')>In Progress</option>
                            <option value="resolved"    @selected($ticket->status === 'resolved')>Resolved</option>
                            <option value="closed"      @selected($ticket->status === 'closed')>Closed</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Title</label>
                        <input type="text" name="title" class="field-input"
                            value="{{ old('title', $ticket->title) }}" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Description</label>
                        <textarea name="description" class="field-textarea" required>{{ old('description', $ticket->description) }}</textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Update Ticket</button>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn-secondary">Back to Ticket</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection