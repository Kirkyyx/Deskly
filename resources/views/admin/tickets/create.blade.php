@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --bg: #f4f6fb;
        --surface: #ffffff;
        --surface-2: #f0f3fa;
        --border: rgba(0,0,0,0.07);
        --accent-blue: #3b6ef8;
        --text-primary: #0f1729;
        --text-muted: #8a94a6;
        --text-dim: #4b5568;
    }

    body { background-color: var(--bg) !important; color: var(--text-primary); font-family: 'DM Mono', monospace; }

    .dash-wrapper {
        padding: 2.5rem 2rem; min-height: 100vh;
        background:
            radial-gradient(ellipse 70% 40% at 0% 0%, rgba(59,110,248,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 50% 35% at 100% 100%, rgba(16,185,129,0.05) 0%, transparent 55%),
            var(--bg);
    }

    .dash-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
    .header-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-blue), #6366f1);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; box-shadow: 0 4px 16px rgba(59,110,248,0.22);
    }
    .dash-header h2 {
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800;
        font-size: 1.6rem; margin: 0; letter-spacing: -0.03em; color: var(--text-primary);
    }
    .dash-header .subtitle { font-size: 0.68rem; color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase; margin-top: 2px; }

    .form-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 16px; overflow: hidden; max-width: 640px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        animation: fadeUp 0.4s ease both;
    }

    .form-card-header {
        padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border);
        font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;
        font-size: 0.95rem; color: var(--text-primary);
    }

    .form-body { padding: 1.8rem 1.5rem; }

    .error-box {
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 10px; padding: 1rem 1.2rem; margin-bottom: 1.5rem;
    }
    .error-box ul { margin: 0; padding-left: 1.1rem; }
    .error-box li { color: #b91c1c; font-size: 0.78rem; margin-bottom: 3px; list-style: none; }
    .error-box li::before { content: '— '; }

    .field-group { margin-bottom: 1.3rem; }
    .field-label {
        display: block; font-size: 0.65rem; letter-spacing: 0.1em;
        text-transform: uppercase; color: var(--text-muted);
        margin-bottom: 0.45rem; font-weight: 500;
    }

    .field-input, .field-textarea, .field-select {
        width: 100%; background: var(--surface-2);
        border: 1px solid var(--border); border-radius: 8px;
        padding: 0.65rem 0.9rem; color: var(--text-primary);
        font-family: 'DM Mono', monospace; font-size: 0.82rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none; box-sizing: border-box;
    }
    .field-input:focus, .field-textarea:focus, .field-select:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px rgba(59,110,248,0.1);
    }
    .field-textarea { resize: vertical; min-height: 110px; }
    .field-select option { background: var(--surface); color: var(--text-primary); }

    .file-drop {
        background: var(--surface-2); border: 1.5px dashed rgba(59,110,248,0.3);
        border-radius: 8px; padding: 1.2rem; text-align: center; cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }
    .file-drop:hover { border-color: var(--accent-blue); background: rgba(59,110,248,0.03); }
    .file-drop input[type="file"] { display: none; }
    .file-drop-label { color: var(--text-muted); font-size: 0.75rem; cursor: pointer; display: block; }
    .file-drop-label span { color: var(--accent-blue); }
    .file-name-display { font-size: 0.72rem; color: var(--accent-blue); margin-top: 0.4rem; display: none; }

    .form-actions { display: flex; gap: 0.75rem; margin-top: 1.8rem; padding-top: 1.5rem; border-top: 1px solid var(--border); }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.6rem 1.4rem;
        background: linear-gradient(135deg, var(--accent-blue), #6366f1);
        color: #fff; border: none; border-radius: 8px;
        font-family: 'DM Mono', monospace; font-size: 0.8rem; font-weight: 500;
        cursor: pointer; transition: opacity 0.2s, transform 0.2s;
        box-shadow: 0 4px 14px rgba(59,110,248,0.22);
    }
    .btn-submit:hover { opacity: 0.88; transform: translateY(-1px); }

    .btn-cancel {
        display: inline-flex; align-items: center;
        padding: 0.6rem 1.2rem;
        background: var(--surface-2); color: var(--text-dim);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: 'DM Mono', monospace; font-size: 0.8rem;
        text-decoration: none; transition: background 0.2s, color 0.2s;
    }
    .btn-cancel:hover { background: #e8eeff; color: var(--text-primary); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="dash-wrapper">

    <div class="dash-header">
        <div class="header-icon">&#43;</div>
        <div>
            <h2>Create Ticket</h2>
            <div class="subtitle">Submit a new support request</div>
        </div>
    </div>

    <div class="form-card">
        <div class="form-card-header">Ticket Details</div>
        <div class="form-body">

            @if($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="field-group">
                    <label class="field-label">Title</label>
                    <input type="text" name="title" class="field-input" value="{{ old('title') }}" required placeholder="Brief summary of the issue">
                </div>

                <div class="field-group">
                    <label class="field-label">Description</label>
                    <textarea name="description" class="field-textarea" required placeholder="Describe the issue in detail…">{{ old('description') }}</textarea>
                </div>

                <div class="field-group">
                    <label class="field-label">Category</label>
                    <select name="category_id" class="field-select">
                        <option value="">— Select a category —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">Attachment</label>
                    <div class="file-drop" id="fileDrop">
                        <input type="file" name="attachment" id="fileInput">
                        <label for="fileInput" class="file-drop-label">
                            &#128206; <span>Choose file</span> or drag &amp; drop
                        </label>
                        <div class="file-name-display" id="fileNameDisplay"></div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">&#10003; Submit Ticket</button>
                    <a href="{{ route('tickets.index') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>

        </div>
    </div>

</div>

<script>
    const fileInput = document.getElementById('fileInput');
    const fileDisplay = document.getElementById('fileNameDisplay');
    const fileDrop = document.getElementById('fileDrop');

    fileInput?.addEventListener('change', () => {
        if (fileInput.files.length) {
            fileDisplay.textContent = '📎 ' + fileInput.files[0].name;
            fileDisplay.style.display = 'block';
        }
    });

    ['dragover','dragenter'].forEach(e => fileDrop?.addEventListener(e, ev => { ev.preventDefault(); fileDrop.style.borderColor = 'var(--accent-blue)'; }));
    ['dragleave','drop'].forEach(e => fileDrop?.addEventListener(e, () => fileDrop.style.borderColor = ''));
    fileDrop?.addEventListener('drop', ev => {
        ev.preventDefault();
        if (ev.dataTransfer.files.length) {
            fileInput.files = ev.dataTransfer.files;
            fileDisplay.textContent = '📎 ' + ev.dataTransfer.files[0].name;
            fileDisplay.style.display = 'block';
        }
    });
</script>

@endsection