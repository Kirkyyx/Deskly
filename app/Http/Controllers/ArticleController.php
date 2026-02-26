<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\AuditLog;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('body',  'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility === 'public');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $articles   = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.article.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.article.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['is_public'] = $request->has('is_public') ? 1 : 0;
        $validated['status']    = 'active';

        $article = Article::create($validated);

        AuditLog::log('article_created', [
            'status'     => 'success',
            'article_id' => $article->id,
        ]);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('admin.article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.article.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'body'        => 'sometimes|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['is_public'] = $request->has('is_public') ? 1 : 0;

        $article->update($validated);

        AuditLog::log('article_updated', [
            'status'     => 'success',
            'article_id' => $article->id,
        ]);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article updated successfully.');
    }

    public function toggleStatus(Article $article)
    {
        $newStatus = $article->status === 'active' ? 'archived' : 'active';

        $article->update(['status' => $newStatus]);

        AuditLog::log('article_' . $newStatus, [
            'status'     => 'success',
            'article_id' => $article->id,
        ]);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article ' . ($newStatus === 'archived' ? 'archived' : 'restored') . ' successfully.');
    }

        public function destroy(Article $article)
        {
            $title     = $article->title;
            $articleId = $article->id;

            // Log FIRST before deleting
            AuditLog::log('article_deleted', [
                'status'     => 'success',
                'article_id' => $articleId,
            ]);

            $article->delete();

            return redirect()->route('admin.articles.index')
                            ->with('success', "Article \"{$title}\" deleted.");
        }
}