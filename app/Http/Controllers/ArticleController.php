<?php

namespace App\Http\Controllers;

use App\Models\AdPlacement;
use App\Models\Article;
use App\Models\Category;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(string $locale): View
    {
        $articles = Article::published()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::withCount(['articles' => fn ($q) => $q->published()])
            ->orderBy('order')
            ->get();

        $sidebarAd = AdPlacement::getSlot('sidebar-top');

        return view('articles.index', compact('articles', 'categories', 'sidebarAd'));
    }

    public function show(string $locale, string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        $article->increment('views');

        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        $inlineAd = AdPlacement::getSlot('article-inline');
        $inlineAdHtml = $inlineAd?->html_code;

        return view('articles.show', compact('article', 'relatedArticles', 'inlineAd', 'inlineAdHtml'));
    }

    public function category(string $locale, string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['author'])
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('articles.category', compact('category', 'articles'));
    }
}
