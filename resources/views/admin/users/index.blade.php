@extends('layouts.admin')

@section('page_title', __('ui.users'))

@section('admin-content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="table">
        <thead>
            <tr>
                <th>{{ app()->getLocale() === 'bn' ? 'নাম' : 'Name' }}</th>
                <th>Email</th>
                <th>{{ app()->getLocale() === 'bn' ? 'ভূমিকা' : 'Role' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'নিবন্ধন তারিখ' : 'Registered' }}</th>
                <th>{{ app()->getLocale() === 'bn' ? 'কার্যক্রম' : 'Actions' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="text-gray-600 text-sm">{{ $user->email }}</td>
                    <td>
                        @php $roleColors = ['admin' => 'badge-violet', 'editor' => 'badge-blue', 'user' => 'badge-gray']; @endphp
                        <span class="{{ $roleColors[$user->role] ?? 'badge-gray' }}">{{ $user->role }}</span>
                    </td>
                    <td class="text-xs text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @if($user->id !== auth()->id())
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary btn-sm">{{ __('ui.edit') }}</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger btn-sm">{{ __('ui.delete') }}</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">{{ app()->getLocale() === 'bn' ? '(আপনি)' : '(You)' }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-8 text-gray-400">{{ app()->getLocale() === 'bn' ? 'কোনো ব্যবহারকারী নেই।' : 'No users.' }}</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-gray-100">{{ $users->links() }}</div>
</div>
@endsection
