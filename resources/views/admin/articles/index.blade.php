@extends('layouts.admin')

@section('page_title', __('ui.manage_articles'))

@section('admin-content')
@php
    $isBn = app()->getLocale() === 'bn';
@endphp
<div class="space-y-4 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        {{-- Status Filter Tabs --}}
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.articles.index', ['status' => 'all', 'category_id' => request('category_id'), 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? 'all') === 'all' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'সব' : 'All' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? 'all') === 'all' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $totalCount ?? $articles->total() }}</span>
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'published', 'category_id' => request('category_id'), 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? '') === 'published' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'প্রকাশিত' : 'Published' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? '') === 'published' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-600' }}">{{ $publishedCount ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'draft', 'category_id' => request('category_id'), 'search' => request('search')]) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-bold transition-colors {{ ($status ?? '') === 'draft' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'ড্রাফট' : 'Draft' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ ($status ?? '') === 'draft' ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-600' }}">{{ $draftCount ?? 0 }}</span>
            </a>
        </div>

        {{-- Category Filter, Search & Add button --}}
        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="status" value="{{ $status ?? 'all' }}">

                {{-- Category select --}}
                <select name="category_id" onchange="this.form.submit()"
                        class="text-xs rounded-xl border-gray-200 py-1.5 px-3 focus:border-blue-500 focus:ring-blue-500 bg-white">
                    <option value="">{{ $isBn ? 'সকল ক্যাটাগরি' : 'All Categories' }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (string)($selectedCategory ?? '') === (string)$cat->id ? 'selected' : '' }}>
                            {{ $cat->getName() }}
                        </option>
                    @endforeach
                </select>

                {{-- Search box --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="{{ $isBn ? 'নিবন্ধের শিরোনাম খুঁজুন...' : 'Search articles...' }}"
                           class="text-xs rounded-xl border-gray-200 pl-8 pr-3 py-1.5 focus:border-blue-500 focus:ring-blue-500 w-40 sm:w-52">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs absolute left-2.5 top-2.5 pointer-events-none"></i>
                </div>
                @if(!empty($search) || !empty($selectedCategory))
                    <a href="{{ route('admin.articles.index', ['status' => $status ?? 'all']) }}" class="btn-secondary btn-sm" title="Clear">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
                <button type="submit" class="btn-primary btn-sm">{{ $isBn ? 'সার্চ' : 'Search' }}</button>
            </form>
            <a href="{{ route('admin.articles.create') }}" class="btn-primary btn-sm whitespace-nowrap">+ {{ $isBn ? 'নতুন নিবন্ধ' : 'New Article' }}</a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ app()->getLocale() === 'bn' ? 'শিরোনাম' : 'Title' }}</th>
                    <th>{{ __('ui.category') }}</th>
                    <th>{{ __('ui.author') }}</th>
                    <th>{{ __('ui.published') }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'তারিখ' : 'Date' }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'কার্যক্রম' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td class="max-w-xs">
                            <div class="flex items-center gap-2">
                                @if($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" class="w-10 h-8 object-cover rounded-lg flex-shrink-0">
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900 truncate">{{ $article->getTitle() }}</p>
                                    <p class="text-xs text-gray-400">{{ $article->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-600">{{ $article->category?->getName() ?? '—' }}</td>
                        <td class="text-gray-600">{{ $article->author?->name ?? '—' }}</td>
                        <td>
                            <span class="{{ $article->is_published ? 'badge-green' : 'badge-gray' }}">
                                {{ $article->is_published ? __('ui.published') : __('ui.unpublished') }}
                            </span>
                            @if($article->is_featured)
                                <span class="badge-violet ml-1"><i class="fa-solid fa-star text-amber-500"></i></span>
                            @endif
                        </td>
                        <td class="text-gray-400 text-xs whitespace-nowrap">{{ $article->created_at->format('d M Y') }}</td>
                        <td class="whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($article->is_published)
                                    <a href="{{ route('articles.show', ['locale' => 'bn', 'slug' => $article->slug]) }}"
                                       target="_blank" class="text-xs text-blue-500 hover:underline">↗</a>
                                @endif
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn-secondary btn-sm">{{ __('ui.edit') }}</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('{{ app()->getLocale() === "bn" ? "সত্যিই মুছবেন?" : "Are you sure?" }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-gray-400">{{ app()->getLocale() === 'bn' ? 'কোনো নিবন্ধ নেই।' : 'No articles yet.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">{{ $articles->links() }}</div>
</div>
@endsection
