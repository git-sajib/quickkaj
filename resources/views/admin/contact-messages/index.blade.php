@extends('layouts.admin')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', $isBn ? 'কন্টাক্ট মেসেজ ইনবক্স' : 'Contact Messages Inbox')

@section('admin-content')
<div class="space-y-6">

    {{-- Top Action & Filter Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        {{-- Status Filter Tabs --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.contact-messages.index', ['status' => 'all', 'search' => request('search')]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ $status === 'all' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'সকল বার্তা' : 'All Messages' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'unread', 'search' => request('search')]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ $status === 'unread' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'অপঠিত' : 'Unread' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'unread' ? 'bg-white/20 text-white' : 'bg-rose-50 text-rose-600' }}">{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'read', 'search' => request('search')]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ $status === 'read' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'পঠিত' : 'Read' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'read' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $readCount }}</span>
            </a>
        </div>

        {{-- Search Input Form --}}
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative">
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="{{ $isBn ? 'নাম, ইমেইল বা বিষয় খুঁজুন...' : 'Search messages...' }}"
                       class="text-xs rounded-xl border-gray-200 pl-8 pr-3 py-1.5 focus:border-blue-500 focus:ring-blue-500 w-52 sm:w-64">
                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs absolute left-2.5 top-2.5 pointer-events-none"></i>
            </div>
            @if($search)
                <a href="{{ route('admin.contact-messages.index', ['status' => $status]) }}"
                   class="btn-secondary btn-sm" title="Clear search">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
            <button type="submit" class="btn-primary btn-sm">{{ $isBn ? 'সার্চ' : 'Search' }}</button>
        </form>
    </div>

    {{-- Messages Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-10"></th>
                        <th>{{ $isBn ? 'প্রেরক' : 'Sender' }}</th>
                        <th>{{ $isBn ? 'বিষয় ও বার্তা' : 'Subject & Message' }}</th>
                        <th>{{ $isBn ? 'তারিখ' : 'Received' }}</th>
                        <th class="text-right">{{ $isBn ? 'কার্যক্রম' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($messages as $msg)
                        <tr class="{{ ! $msg->is_read ? 'bg-rose-50/30 font-medium' : 'hover:bg-gray-50/50' }} transition-colors">
                            {{-- Read/Unread Icon Dot --}}
                            <td class="text-center">
                                @if(! $msg->is_read)
                                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-rose-500" title="{{ $isBn ? 'নতুন বার্তা' : 'Unread' }}"></span>
                                @else
                                    <span class="inline-block w-2 h-2 rounded-full bg-gray-300" title="{{ $isBn ? 'পঠিত' : 'Read' }}"></span>
                                @endif
                            </td>

                            {{-- Sender Info --}}
                            <td class="whitespace-nowrap">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="font-bold text-gray-900 hover:text-blue-600 transition-colors">
                                    {{ $msg->name }}
                                </a>
                                <div class="text-xs text-gray-500">
                                    <a href="mailto:{{ $msg->email }}" class="hover:underline flex items-center gap-1">
                                        <i class="fa-regular fa-envelope text-[10px]"></i>
                                        <span>{{ $msg->email }}</span>
                                    </a>
                                </div>
                            </td>

                            {{-- Subject & Snippet --}}
                            <td class="max-w-md">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="block">
                                    <p class="text-xs font-bold text-gray-900 hover:text-blue-600 transition-colors truncate">
                                        {{ $msg->subject ?: ($isBn ? '(কোনো বিষয় উল্লেখ নেই)' : '(No subject)') }}
                                    </p>
                                    <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">
                                        {{ $msg->message }}
                                    </p>
                                </a>
                            </td>

                            {{-- Received Time --}}
                            <td class="whitespace-nowrap text-xs text-gray-500">
                                <div>{{ $msg->created_at->format('d M Y, h:i A') }}</div>
                                <div class="text-[10px] text-gray-400">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- Action Buttons --}}
                            <td class="whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- View Details --}}
                                    <a href="{{ route('admin.contact-messages.show', $msg) }}"
                                       class="btn-secondary btn-sm" title="{{ $isBn ? 'বিস্তারিত পড়ুন' : 'View' }}">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>

                                    {{-- Toggle Read/Unread --}}
                                    <form method="POST" action="{{ route('admin.contact-messages.toggle-read', $msg) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn-secondary btn-sm"
                                                title="{{ $msg->is_read ? ($isBn ? 'অপঠিত হিসেবে চিহ্নিত করুন' : 'Mark as unread') : ($isBn ? 'পঠিত হিসেবে চিহ্নিত করুন' : 'Mark as read') }}">
                                            <i class="{{ $msg->is_read ? 'fa-solid fa-envelope-open' : 'fa-regular fa-envelope' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.contact-messages.destroy', $msg) }}"
                                          onsubmit="return confirm('{{ $isBn ? "আপনি কি নিশ্চিতভাবে এই বার্তাটি মুছে ফেলতে চান?" : "Are you sure you want to delete this message?" }}')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger btn-sm" title="{{ $isBn ? 'মুছে ফেলুন' : 'Delete' }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-400 text-xs sm:text-sm">
                                <i class="fa-regular fa-folder-open text-2xl text-gray-300 block mb-2"></i>
                                <span>{{ $isBn ? 'কোনো মেসেজ পাওয়া যায়নি।' : 'No messages found.' }}</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($messages->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
