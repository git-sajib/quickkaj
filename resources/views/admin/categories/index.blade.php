@extends('layouts.admin')

@section('page_title', __('ui.manage_categories'))

@section('admin-content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-gray-500">{{ $categories->total() }} {{ app()->getLocale() === 'bn' ? 'টি বিভাগ' : 'categories' }}</p>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ {{ app()->getLocale() === 'bn' ? 'নতুন বিভাগ' : 'New Category' }}</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="table">
        <thead>
            <tr>
                <th>{{ app()->getLocale() === 'bn' ? 'নাম' : 'Name' }}</th>
                <th>Slug</th>
                <th>{{ app()->getLocale() === 'bn' ? 'অভিভাবক' : 'Parent' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'ক্রম' : 'Order' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'কার্যক্রম' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
                <tr>
                    <td class="font-medium text-gray-900">
                        {{ $cat->name_bn }}
                        @if($cat->name_en)<span class="text-gray-400 text-xs ml-1">/ {{ $cat->name_en }}</span>@endif
                    </td>
                    <td class="font-mono text-xs text-gray-500">{{ $cat->slug }}</td>
                    <td class="text-gray-600 text-sm">{{ $cat->parent?->name_bn ?? '—' }}</td>
                    <td class="text-gray-600 text-sm">{{ $cat->order ?? '0' }}</td>
                    <td class="whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-secondary btn-sm">{{ __('ui.edit') }}</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-8 text-gray-400">{{ app()->getLocale() === 'bn' ? 'কোনো বিভাগ নেই।' : 'No categories.' }}</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-gray-100">{{ $categories->links() }}</div>
</div>
@endsection
