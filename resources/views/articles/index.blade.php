@extends('layouts.app')

@section('page_title', __('ui.articles_title') . ' — ' . __('ui.site_name'))
@section('seo_description', __('ui.articles_subtitle'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">

        {{-- Main --}}
        <div class="lg:col-span-8">
            <div class="mb-8">
                <h1 class="section-header">{{ __('ui.articles_title') }}</h1>
                <p class="section-subtitle">{{ __('ui.articles_subtitle') }}</p>
                <div class="section-divider"></div>
            </div>

            @if($articles->count() === 0)
                <div class="card p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <p class="text-gray-500 font-medium">{{ app()->getLocale() === 'bn' ? 'কোনো নিবন্ধ পাওয়া যায়নি।' : 'No articles found.' }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($articles as $article)
                        <article class="article-card group">
                            {{-- Thumbnail --}}
                            <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}" class="block overflow-hidden rounded-t-xl">
                            @if($article->featured_image)
                                <img src="{{ Storage::url($article->featured_image) }}"
                                     alt="{{ $article->getTitle() }}"
                                     class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <x-category-placeholder :category="$article->category" height="176px" />
                            @endif
                            </a>

                            <div class="card-body">
                                @if($article->category)
                                    <a href="{{ route('articles.category', ['locale' => app()->getLocale(), 'slug' => $article->category->slug]) }}"
                                       class="badge-blue mb-2 inline-block hover:bg-blue-200 transition-colors">
                                        {{ $article->category->getName() }}
                                    </a>
                                @endif

                                <h2 class="font-bold text-gray-900 text-base leading-snug group-hover:text-blue-600 transition-colors mb-2 line-clamp-2">
                                    <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}">
                                        {{ $article->getTitle() }}
                                    </a>
                                </h2>

                                @if($article->excerpt_bn || $article->excerpt_en)
                                    <p class="text-gray-500 text-xs line-clamp-2 mb-3">{{ $article->getExcerpt() }}</p>
                                @endif

                                <div class="flex items-center justify-between text-xs text-gray-400 mt-auto">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $article->published_at?->diffForHumans() }}</span>
                                        @if($article->views > 0)
                                            <span class="flex items-center gap-1">· <i class="fa-regular fa-eye"></i> {{ number_format($article->views) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}"
                                       class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center gap-1">
                                        <span>{{ __('ui.read_more') }}</span>
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pagination-container mt-8">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 mt-10 lg:mt-0 space-y-6">
            {{-- Ad --}}
            @if(isset($sidebarAd) && $sidebarAd)
                <div class="card p-3">{!! $sidebarAd->html_code !!}</div>
            @endif

            {{-- Categories --}}
            @if($categories->count() > 0)
                <div class="card p-5">
                    <h3 class="font-bold text-gray-900 mb-4">{{ __('ui.category') }}</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('articles.category', ['locale' => app()->getLocale(), 'slug' => $cat->slug]) }}"
                                   class="flex items-center justify-between text-sm text-gray-700 hover:text-blue-600 transition-colors py-1">
                                    <span>{{ $cat->getName() }}</span>
                                    @if(isset($cat->articles_count))
                                        <span class="badge-gray">{{ $cat->articles_count }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
