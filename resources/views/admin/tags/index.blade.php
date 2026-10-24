@extends('layouts.admin')

@section('page_title', __('ui.manage_tags'))

@section('admin-content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-gray-500">{{ $tags->total() }} {{ app()->getLocale() === 'bn' ? 'টি ট্যাগ' : 'tags' }}</p>
    <a href="{{ route('admin.tags.create') }}" class="btn-primary">+ {{ app()->getLocale() === 'bn' ? 'নতুন ট্যাগ' : 'New Tag' }}</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="table">
        <thead>
            <tr>
                <th>{{ app()->getLocale() === 'bn' ? 'নাম' : 'Name' }}</th>
                <th>Slug</th>
                <th>{{ app()->getLocale() === 'bn' ? 'নিবন্ধ সংখ্যা' : 'Articles' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'কার্যক্রম' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td class="font-medium text-gray-900">
                        {{ $tag->name_bn }}
                        @if($tag->name_en)<span class="text-gray-400 text-xs ml-1">/ {{ $tag->name_en }}</span>@endif
                    </td>
                    <td class="font-mono text-xs text-gray-500">{{ $tag->slug }}</td>
                    <td><span class="badge-blue">{{ $tag->articles_count ?? 0 }}</span></td>
                    <td class="whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn-secondary btn-sm">{{ __('ui.edit') }}</a>
                            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-8 text-gray-400">{{ app()->getLocale() === 'bn' ? 'কোনো ট্যাগ নেই।' : 'No tags.' }}</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-gray-100">{{ $tags->links() }}</div>
</div>
@endsection
