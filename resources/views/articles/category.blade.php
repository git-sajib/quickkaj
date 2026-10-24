@extends('layouts.app')

@section('page_title', $category->getName() . ' — ' . __('ui.site_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="section-header">{{ $category->getName() }}</h1>
        @if($category->description_bn || $category->description_en)
            <p class="section-subtitle">{{ app()->getLocale() === 'en' && $category->description_en ? $category->description_en : $category->description_bn }}</p>
        @endif
        <div class="section-divider"></div>
    </div>

    @if($articles->count() === 0)
        <div class="card p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <p class="text-gray-500 font-medium">{{ app()->getLocale() === 'bn' ? 'এই বিভাগে কোনো নিবন্ধ নেই।' : 'No articles in this category.' }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <article class="article-card group">
                    <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}" class="block overflow-hidden rounded-t-xl">
                    @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->getTitle() }}" class="article-img group-hover:scale-105 transition-transform duration-300">
                    @else
                        <x-category-placeholder :category="$category" height="176px" />
                    @endif
                    </a>
                    <div class="card-body">
                        <h2 class="font-bold text-gray-900 text-base group-hover:text-blue-600 transition-colors mb-2 line-clamp-2">
                            <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}">{{ $article->getTitle() }}</a>
                        </h2>
                        <div class="flex justify-between items-center text-xs text-gray-400 mt-3">
                            <span>{{ $article->published_at?->diffForHumans() }}</span>
                            <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}" class="text-blue-600 font-semibold inline-flex items-center gap-1">
                                <span>{{ __('ui.read_more') }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="pagination-container mt-8">{{ $articles->links() }}</div>
    @endif
</div>
@endsection
