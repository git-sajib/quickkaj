@extends('layouts.admin')

@section('page_title', __('ui.edit') . ': ' . $user->name)

@section('admin-content')
<div class="max-w-lg">
    <a href="{{ route('admin.users.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.users') }}</a>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'নাম' : 'Name' }}</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-input bg-gray-50 cursor-not-allowed" value="{{ $user->email }}" disabled>
            <p class="text-xs text-gray-400 mt-1">{{ app()->getLocale() === 'bn' ? 'ইমেইল পরিবর্তন করা যাবে না।' : 'Email cannot be changed.' }}</p>
        </div>

        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'ভূমিকা' : 'Role' }}</label>
            <select name="role" class="form-select @error('role') border-red-400 @enderror">
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
