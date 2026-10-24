<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Mews\Purifier\Facades\Purifier;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with(['category', 'author']);

        // Status filter
        $status = $request->input('status', 'all');
        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        // Category filter
        $selectedCategory = $request->input('category_id');
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title_bn', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%")
                    ->orWhere('excerpt_bn', 'like', "%{$search}%")
                    ->orWhere('excerpt_en', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $categories = Category::orderBy('name_bn')->get();

        $totalCount = Article::count();
        $publishedCount = Article::where('is_published', true)->count();
        $draftCount = Article::where('is_published', false)->count();

        return view('admin.articles.index', compact(
            'articles',
            'categories',
            'search',
            'status',
            'selectedCategory',
            'totalCount',
            'publishedCount',
            'draftCount'
        ));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name_bn')->get();
        $tags = Tag::orderBy('name_bn')->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateSlug($data['title_bn']);
        $data['author_id'] = auth()->id();

        // Sanitize rich text body with HTMLPurifier
        if (! empty($data['body_bn'])) {
            $data['body_bn'] = Purifier::clean($data['body_bn']);
        }
        if (! empty($data['body_en'])) {
            $data['body_en'] = Purifier::clean($data['body_en']);
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        if ($data['is_published'] ?? false) {
            $data['published_at'] = now();
        }

        $tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        $article = Article::create($data);
        $article->tags()->sync($tagIds);

        return redirect()->route('admin.articles.index')->with('success', 'নিবন্ধ সফলভাবে তৈরি হয়েছে।');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('name_bn')->get();
        $tags = Tag::orderBy('name_bn')->get();
        $article->load('tags');

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['body_bn'])) {
            $data['body_bn'] = Purifier::clean($data['body_bn']);
        }
        if (! empty($data['body_en'])) {
            $data['body_en'] = Purifier::clean($data['body_en']);
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        if (($data['is_published'] ?? false) && ! $article->published_at) {
            $data['published_at'] = now();
        } elseif (! ($data['is_published'] ?? false)) {
            $data['published_at'] = null;
        }

        $tagIds = $data['tag_ids'] ?? [];
        unset($data['tag_ids']);

        $article->update($data);
        $article->tags()->sync($tagIds);

        return redirect()->route('admin.articles.index')->with('success', 'নিবন্ধ সফলভাবে আপডেট হয়েছে।');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->tags()->detach();
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'নিবন্ধ মুছে ফেলা হয়েছে।');
    }

    private function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        if (empty($slug)) {
            $slug = 'article-'.Str::random(8);
        }
        $count = Article::where('slug', 'like', $slug.'%')->count();

        return $count > 0 ? $slug.'-'.($count + 1) : $slug;
    }
}
