@extends('layouts.admin')

@php
    $isBn = app()->getLocale() === 'bn';
@endphp

@section('page_title', $isBn ? 'জব অ্যালার্ট গ্রাহক তালিকা' : 'Job Alert Subscribers')

@section('admin-content')
<div class="space-y-6">

    {{-- Top Action & Filter Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        {{-- Status Filter Tabs --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.job-alerts.index', ['status' => 'all', 'search' => request('search')]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ $status === 'all' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'সকল গ্রাহক' : 'All Subscribers' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.job-alerts.index', ['status' => 'active', 'search' => request('search')]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ $status === 'active' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'সক্রিয়' : 'Active' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'active' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-600' }}">{{ $activeCount }}</span>
            </a>
            <a href="{{ route('admin.job-alerts.index', ['status' => 'inactive', 'search' => request('search')]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-colors {{ $status === 'inactive' ? 'bg-gray-600 text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                <span>{{ $isBn ? 'নিষ্ক্রিয়' : 'Inactive' }}</span>
                <span class="ml-1 px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'inactive' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">{{ $inactiveCount }}</span>
            </a>
        </div>

        <div class="flex items-center gap-2">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('admin.job-alerts.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="{{ $isBn ? 'ইমেইল বা কি-ওয়ার্ড খুঁজুন...' : 'Search email or keyword...' }}"
                           class="text-xs rounded-xl border-gray-200 pl-8 pr-3 py-1.5 focus:border-blue-500 focus:ring-blue-500 w-48 sm:w-56">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs absolute left-2.5 top-2.5 pointer-events-none"></i>
                </div>
                @if($search)
                    <a href="{{ route('admin.job-alerts.index', ['status' => $status]) }}"
                       class="btn-secondary btn-sm" title="Clear">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
                <button type="submit" class="btn-primary btn-sm">{{ $isBn ? 'সার্চ' : 'Search' }}</button>
            </form>

            {{-- CSV Export Button --}}
            <a href="{{ route('admin.job-alerts.export') }}"
               class="btn-secondary btn-sm flex items-center gap-1.5 text-xs whitespace-nowrap"
               title="{{ $isBn ? 'CSV হিসেবে এক্সপোর্ট করুন' : 'Export CSV' }}">
                <i class="fa-solid fa-file-csv text-emerald-600"></i>
                <span>{{ $isBn ? 'CSV এক্সপোর্ট' : 'Export' }}</span>
            </a>
        </div>
    </div>

    {{-- Subscribers Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ $isBn ? 'ইমেইল' : 'Email Address' }}</th>
                        <th>{{ $isBn ? 'পছন্দের বিষয়/লোকেশন' : 'Keyword / Location' }}</th>
                        <th>{{ $isBn ? 'স্ট্যাটাস' : 'Status' }}</th>
                        <th>{{ $isBn ? 'যুক্ত হয়েছেন' : 'Subscribed' }}</th>
                        <th class="text-right">{{ $isBn ? 'কার্যক্রম' : 'Actions' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($subscribers as $sub)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="whitespace-nowrap font-bold text-gray-900">
                                <a href="mailto:{{ $sub->email }}" class="text-blue-600 hover:underline flex items-center gap-1.5">
                                    <i class="fa-regular fa-envelope text-gray-400 text-xs"></i>
                                    <span>{{ $sub->email }}</span>
                                </a>
                            </td>
                            <td class="text-xs text-gray-600">
                                @if($sub->keyword || $sub->location)
                                    <div class="flex flex-wrap items-center gap-1">
                                        @if($sub->keyword)
                                            <span class="badge-blue">{{ $sub->keyword }}</span>
                                        @endif
                                        @if($sub->location)
                                            <span class="badge-gray">{{ $sub->location }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-[11px]">{{ $isBn ? 'সকল চাকরি' : 'All Jobs' }}</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="{{ $sub->is_active ? 'badge-green' : 'badge-gray' }}">
                                    {{ $sub->is_active ? ($isBn ? 'সক্রিয়' : 'Active') : ($isBn ? 'নিষ্ক্রিয়' : 'Inactive') }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap text-xs text-gray-400">
                                <div>{{ $sub->created_at->format('d M Y') }}</div>
                                <div class="text-[10px]">{{ $sub->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Toggle Active/Inactive --}}
                                    <form method="POST" action="{{ route('admin.job-alerts.toggle', $sub) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="btn-secondary btn-sm"
                                                title="{{ $sub->is_active ? ($isBn ? 'নিষ্ক্রিয় করুন' : 'Deactivate') : ($isBn ? 'সক্রিয় করুন' : 'Activate') }}">
                                            <i class="{{ $sub->is_active ? 'fa-solid fa-user-xmark text-amber-600' : 'fa-solid fa-user-check text-emerald-600' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.job-alerts.destroy', $sub) }}"
                                          onsubmit="return confirm('{{ $isBn ? "আপনি কি নিশ্চিতভাবে এই গ্রাহককে মুছে ফেলতে চান?" : "Are you sure you want to delete this subscriber?" }}')"
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
                                <i class="fa-regular fa-bell-slash text-2xl text-gray-300 block mb-2"></i>
                                <span>{{ $isBn ? 'কোনো সাবস্ক্রাইবার পাওয়া যায়নি।' : 'No subscribers found.' }}</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscribers->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
