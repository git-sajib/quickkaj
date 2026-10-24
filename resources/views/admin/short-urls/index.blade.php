@extends('layouts.admin')

@section('page_title', __('ui.manage_urls'))

@section('admin-content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="table">
        <thead>
            <tr>
                <th>{{ app()->getLocale() === 'bn' ? 'কোড' : 'Code' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'মূল URL' : 'Original URL' }}</th>
                <th>{{ __('ui.clicks') }}</th>
                <th>{{ __('ui.active') }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'তারিখ' : 'Date' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'কার্যক্রম' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($shortUrls as $url)
                <tr>
                    <td><span class="font-mono text-blue-600 font-bold">{{ $url->code }}</span></td>
                    <td class="max-w-xs">
                        <a href="{{ $url->original_url }}" target="_blank" rel="noopener"
                           class="text-gray-700 hover:text-blue-600 truncate block max-w-xs text-xs">
                            {{ $url->original_url }}
                        </a>
                    </td>
                    <td class="font-semibold text-gray-900">{{ number_format($url->clicks) }}</td>
                    <td>
                        <span class="{{ $url->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $url->is_active ? __('ui.active') : __('ui.inactive') }}
                        </span>
                    </td>
                    <td class="text-xs text-gray-400">{{ $url->created_at->format('d M Y') }}</td>
                    <td class="whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.short-urls.toggle', $url) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-secondary btn-sm">
                                    {{ $url->is_active ? (app()->getLocale() === 'bn' ? 'বন্ধ করুন' : 'Disable') : (app()->getLocale() === 'bn' ? 'চালু করুন' : 'Enable') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.short-urls.destroy', $url) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-8 text-gray-400">{{ app()->getLocale() === 'bn' ? 'কোনো URL নেই।' : 'No short URLs.' }}</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-gray-100">{{ $shortUrls->links() }}</div>
</div>
@endsection
