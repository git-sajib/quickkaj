@extends('layouts.admin')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', $isBn ? 'বার্তার বিবরণ' : 'Message Details')

@section('admin-content')
<div class="max-w-4xl space-y-6">

    {{-- Top Back Nav & Quick Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.contact-messages.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-gray-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>{{ $isBn ? 'ইনবক্সে ফিরে যান' : 'Back to Inbox' }}</span>
        </a>

        <div class="flex items-center gap-2">
            {{-- Toggle Read/Unread --}}
            <form method="POST" action="{{ route('admin.contact-messages.toggle-read', $contactMessage) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-secondary btn-sm flex items-center gap-1.5">
                    <i class="{{ $contactMessage->is_read ? 'fa-regular fa-envelope' : 'fa-solid fa-envelope-open' }}"></i>
                    <span>{{ $contactMessage->is_read ? ($isBn ? 'অপঠিত করুন' : 'Mark Unread') : ($isBn ? 'পঠিত করুন' : 'Mark Read') }}</span>
                </button>
            </form>

            {{-- Delete --}}
            <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                  onsubmit="return confirm('{{ $isBn ? "আপনি কি নিশ্চিতভাবে এই বার্তাটি মুছে ফেলতে চান?" : "Are you sure you want to delete this message?" }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger btn-sm flex items-center gap-1.5">
                    <i class="fa-regular fa-trash-can"></i>
                    <span>{{ $isBn ? 'মুছে ফেলুন' : 'Delete' }}</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Main Message Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Message Header --}}
        <div class="p-6 bg-gradient-to-r from-gray-50/80 to-white border-b border-gray-100 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 font-extrabold flex items-center justify-center text-lg flex-shrink-0">
                    {{ strtoupper(substr($contactMessage->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 leading-snug">
                        {{ $contactMessage->name }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mt-1">
                        <a href="mailto:{{ $contactMessage->email }}?subject={{ urlencode('Re: ' . ($contactMessage->subject ?: 'Quickkaj Inquiry')) }}"
                           class="text-blue-600 hover:underline flex items-center gap-1 font-semibold">
                            <i class="fa-regular fa-envelope text-[11px]"></i>
                            <span>{{ $contactMessage->email }}</span>
                        </a>
                        @if($contactMessage->ip_address)
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-400">IP: {{ $contactMessage->ip_address }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-right flex sm:flex-col items-center sm:items-end justify-between text-xs text-gray-400">
                <span>{{ $contactMessage->created_at->format('d M Y, h:i A') }}</span>
                <span class="text-[10px] text-gray-400 sm:mt-1">{{ $contactMessage->created_at->diffForHumans() }}</span>
            </div>
        </div>

        {{-- Subject --}}
        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $isBn ? 'বিষয়:' : 'Subject:' }}</span>
                <span class="text-sm font-bold text-gray-900">{{ $contactMessage->subject ?: ($isBn ? '(কোনো বিষয় উল্লেখ নেই)' : '(No subject)') }}</span>
            </div>
            <span class="badge-blue">{{ $isBn ? 'ওয়েবসাইট যোগাযোগ' : 'Contact Form' }}</span>
        </div>

        {{-- Body --}}
        <div class="p-6 sm:p-8">
            <div class="text-sm text-gray-800 leading-relaxed whitespace-pre-line bg-gray-50/40 p-6 rounded-2xl border border-gray-100 font-sans">
{{ $contactMessage->message }}
            </div>
        </div>

        {{-- Reply Action Footer --}}
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500">
                {{ $isBn
                    ? 'প্রেরককে সরাসরি তার ইমেইল ঠিকানায় উত্তর দিতে নিচের বাটনে ক্লিক করুন।'
                    : 'Click reply button to open your email client and reply directly.' }}
            </p>
            <a href="mailto:{{ $contactMessage->email }}?subject={{ urlencode('Re: ' . ($contactMessage->subject ?: 'Quickkaj Inquiry')) }}"
               class="btn-primary text-xs flex items-center gap-2">
                <i class="fa-solid fa-reply"></i>
                <span>{{ $isBn ? 'ইমেইলে উত্তর দিন' : 'Reply via Email' }}</span>
            </a>
        </div>
    </div>

</div>
@endsection
