<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()
            ->latest()
            ->paginate(10);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        // Only show published news
        if (!$news->isPublished()) {
            abort(404);
        }

        // Get related news
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->latest()
            ->take(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}
