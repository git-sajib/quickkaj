@extends('layouts.admin')

@section('page_title', __('ui.manage_ads'))

@section('admin-content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-gray-500">{{ app()->getLocale() === 'bn' ? 'বিজ্ঞাপন স্লট ব্যবস্থাপনা' : 'Manage Ad Placement Slots' }}</p>
    <a href="{{ route('admin.ad-placements.create') }}" class="btn-primary">+ {{ app()->getLocale() === 'bn' ? 'নতুন স্লট' : 'New Slot' }}</a>
</div>

<div class="space-y-4">
    @forelse($adPlacements as $ad)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="font-bold text-gray-900">{{ $ad->label }}</h3>
                        <span class="badge-gray font-mono text-xs">{{ $ad->slot_key }}</span>
                        @if($ad->is_active)
                            <span class="badge-green">{{ __('ui.active') }}</span>
                        @else
                            <span class="badge-gray">{{ __('ui.inactive') }}</span>
                        @endif
                    </div>
                    @if($ad->html_code)
                        <pre class="bg-gray-50 text-xs text-gray-600 rounded-xl p-3 mt-2 overflow-x-auto whitespace-pre-wrap max-h-24">{{ Str::limit($ad->html_code, 300) }}</pre>
                    @else
                        <p class="text-sm text-gray-400 mt-1">{{ app()->getLocale() === 'bn' ? 'কোনো কোড যোগ করা হয়নি।' : 'No code added yet.' }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('admin.ad-placements.edit', $ad) }}" class="btn-secondary btn-sm">{{ __('ui.edit') }}</a>
                    <form method="POST" action="{{ route('admin.ad-placements.destroy', $ad) }}" onsubmit="return confirm('Delete this slot?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card p-12 text-center">
            <div class="text-4xl mb-3 text-gray-300"><i class="fa-solid fa-bullhorn"></i></div>
            <p class="text-gray-500 text-sm">{{ app()->getLocale() === 'bn' ? 'কোনো বিজ্ঞাপন স্লট নেই।' : 'No ad slots yet. Create one to start showing ads.' }}</p>
            <a href="{{ route('admin.ad-placements.create') }}" class="btn-primary mt-4 inline-flex">+ Create Slot</a>
        </div>
    @endforelse
</div>
@endsection
