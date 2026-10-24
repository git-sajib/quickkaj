@extends('layouts.app')

@section('page_title', ($article->seo_title ?? $article->getTitle()) . ' — ' . __('ui.site_name'))
@section('seo_description', $article->seo_description ?? $article->getExcerpt())
@section('og_title', $article->getTitle())
@section('og_description', $article->getExcerpt())
@section('og_image', $article->featured_image ? Storage::url($article->featured_image) : asset('images/og-default.jpg'))
@section('og_type', 'article')

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "NewsArticle",
    "headline": "{{ addslashes($article->getTitle()) }}",
    "image": "{{ $article->featured_image ? Storage::url($article->featured_image) : '' }}",
    "datePublished": "{{ $article->published_at?->toIso8601String() }}",
    "dateModified": "{{ $article->updated_at?->toIso8601String() }}",
    "author": { "@@type": "Person", "name": "{{ $article->author?->name ?? 'Quickkaj' }}" },
    "publisher": { "@@type": "Organization", "name": "{{ __('ui.site_name') }}" }
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">

        {{-- Main Article Column --}}
        <div class="lg:col-span-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.home') }}</a>
                <span>/</span>
                <a href="{{ route('articles.index', ['locale' => app()->getLocale()]) }}" class="hover:text-blue-600">{{ __('ui.news') }}</a>
                @if($article->category)
                    <span>/</span>
                    <a href="{{ route('articles.category', ['locale' => app()->getLocale(), 'slug' => $article->category->slug]) }}"
                       class="hover:text-blue-600">{{ $article->category->getName() }}</a>
                @endif
            </nav>

            <article class="card overflow-hidden">

                {{-- Featured Image or Gradient Placeholder --}}
                @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}"
                         alt="{{ $article->getTitle() }}"
                         class="w-full max-h-80 object-cover">
                @else
                    <x-category-placeholder :category="$article->category" height="280px" :show-label="true" />
                @endif

                <div class="p-6 md:p-8">

                    {{-- Tags & Category --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($article->category)
                            <a href="{{ route('articles.category', ['locale' => app()->getLocale(), 'slug' => $article->category->slug]) }}"
                               class="badge-blue">{{ $article->category->getName() }}</a>
                        @endif
                        @if($article->is_featured)
                            <span class="badge-violet">
                                <i class="fa-solid fa-star text-amber-400 mr-1"></i>{{ app()->getLocale() === 'bn' ? 'বিশেষ' : 'Featured' }}
                            </span>
                        @endif
                        @foreach($article->tags as $tag)
                            <span class="badge-gray">{{ $tag->getName() }}</span>
                        @endforeach
                    </div>

                    {{-- Title --}}
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight mb-4">
                        {{ $article->getTitle() }}
                    </h1>

                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-400 pb-5 mb-6 border-b border-gray-100">
                        @if($article->author)
                            <span class="flex items-center gap-1.5 font-medium text-gray-700">
                                <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-xs">
                                    {{ mb_substr($article->author->name, 0, 1) }}
                                </div>
                                {{ $article->author->name }}
                            </span>
                        @endif
                        <span class="inline-flex items-center gap-1">
                            <i class="fa-regular fa-calendar text-gray-400"></i>
                            {{ $article->published_at?->format('d F Y') }}
                        </span>
                        @if($article->views > 0)
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-regular fa-eye text-gray-400"></i>
                                {{ number_format($article->views) }} {{ app()->getLocale() === 'bn' ? 'ভিউ' : 'views' }}
                            </span>
                        @endif
                    </div>

                    {{-- Article Body with mid-content ads injected after every 3rd paragraph --}}
                    <div class="article-body">
                        {!! $article->getBodyWithAds($inlineAdHtml ?? null) !!}
                    </div>

                    {{-- Inline Ad — below content for max CTR --}}
                    @if(!empty($inlineAd))
                        <div class="my-6 p-3 bg-gray-50 rounded-xl text-center border border-gray-100">
                            <p class="text-[10px] text-gray-300 mb-1 uppercase tracking-widest">Advertisement</p>
                            {!! $inlineAd->html_code !!}
                        </div>
                    @endif

                </div>
            </article>

            {{-- Back link --}}
            <div class="mt-6">
                <a href="{{ route('articles.index', ['locale' => app()->getLocale()]) }}"
                   class="btn-secondary">
                    <i class="fa-solid fa-arrow-left mr-1.5"></i>
                    {{ app()->getLocale() === 'bn' ? 'সব নিবন্ধ' : 'All Articles' }}
                </a>
            </div>

        </div>

        {{-- Sidebar --}}
        <aside class="lg:col-span-4 mt-8 lg:mt-0 space-y-6">

            {{-- Related Articles --}}
            @if($relatedArticles->count() > 0)
                <div class="card p-5">
                    <h3 class="font-bold text-gray-900 mb-4">
                        {{ app()->getLocale() === 'bn' ? 'সংশ্লিষ্ট নিবন্ধ' : 'Related Articles' }}
                    </h3>
                    <ul class="space-y-3">
                        @foreach($relatedArticles as $related)
                            <li class="flex gap-3 border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                                @if($related->featured_image)
                                    <img src="{{ Storage::url($related->featured_image) }}"
                                         class="w-14 h-14 object-cover rounded-lg flex-shrink-0" alt="">
                                @else
                                    <x-category-placeholder :category="$related->category" height="56px" />
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('articles.show', ['locale' => app()->getLocale(), 'slug' => $related->slug]) }}"
                                       class="text-sm font-medium text-gray-800 hover:text-blue-600 transition-colors line-clamp-2">
                                        {{ $related->getTitle() }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $related->published_at?->diffForHumans() }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Sidebar Ad (300x250) --}}
            @php $sidebarAdSlot = $sidebarAd ?? $inlineAd ?? null; @endphp
            @if($sidebarAdSlot)
                <div class="card p-3 text-center">
                    <p class="text-[10px] text-gray-300 mb-1 uppercase tracking-widest">Advertisement</p>
                    {!! $sidebarAdSlot->html_code !!}
                </div>
            @endif

        </aside>

    </div>
</div>
@endsection
