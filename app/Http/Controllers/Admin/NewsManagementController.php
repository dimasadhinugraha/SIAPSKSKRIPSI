<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsManagementController extends Controller
{
    // Middleware will be applied via routes

    public function index()
    {
        $news = News::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistics
        $stats = [
            'total' => News::count(),
            'published' => News::where('status', 'published')->count(),
            'draft' => News::where('status', 'draft')->count(),
            'today' => News::whereDate('created_at', today())->count(),
        ];

        return view('admin.news.index', compact('news', 'stats'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|in:news,announcement,event',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $featuredImagePath = $request->file('featured_image')->store('news', 'public');
        }

        $news = News::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status,
            'featured_image' => $featuredImagePath,
            'author_id' => auth()->id(),
            'published_at' => $request->status === 'published'
                ? ($request->published_at ? $request->published_at : now())
                : null,
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dibuat.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|in:news,announcement,event',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $featuredImagePath = $news->featured_image;
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $featuredImagePath = $request->file('featured_image')->store('news', 'public');
        }

        $news->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status,
            'featured_image' => $featuredImagePath,
            'published_at' => $request->status === 'published'
                ? ($request->published_at ? $request->published_at : ($news->published_at ?? now()))
                : null,
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
